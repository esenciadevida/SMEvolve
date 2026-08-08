<?php

namespace App\Services\Quote;

use App\Exceptions\Quote\InvalidStepException;
use App\Models\QuoteSession;

class QuoteWizardService
{
    public function __construct(
        private readonly QuoteSessionService $sessionService,
        private readonly QuoteFlowService $flowService,
        private readonly QuoteAnswerService $answerService,
        private readonly QuoteRequirementService $requirementService,
        private readonly QuoteReviewService $reviewService,
        private readonly QuoteStepValidator $validator,
    ) {}

    /**
     * Start a new quote session.
     */
    public function start(?string $sessionId = null): QuoteSession
    {
        return $this->sessionService->create($sessionId);
    }

    /**
     * The most recent active session for a client, if any.
     */
    public function latestActiveFor(string $sessionId): ?QuoteSession
    {
        return $this->sessionService->latestActiveFor($sessionId);
    }

    public function firstStep(): string
    {
        return $this->flowService->firstStep();
    }

    public function lastStep(): string
    {
        return $this->flowService->lastStep();
    }

    public function nextStep(string $key): ?string
    {
        return $this->flowService->nextStep($key);
    }

    public function previousStep(string $key): ?string
    {
        return $this->flowService->previousStep($key);
    }

    public function steps(): array
    {
        return $this->flowService->steps();
    }

    public function stepCount(): int
    {
        return $this->flowService->stepCount();
    }

    /**
     * Prepared data required to render a step.
     *
     * @return array<string, mixed>
     *
     * @throws InvalidStepException
     */
    public function step(QuoteSession $session, string $stepKey): array
    {
        $this->reviewService->assertStepAccessible($session, $stepKey);

        $step = $this->flowService->findStep($stepKey);
        $answers = $this->answerService->answersFor($session);

        $questions = array_map(
            fn (array $question) => $question + ['options' => $this->optionsForQuestion($question, $session)],
            $this->flowService->questionsForStep($step, $session)
        );

        return [
            'session' => $session,
            'step' => $step,
            'step_key' => $stepKey,
            'step_number' => $this->flowService->stepNumber($stepKey),
            'total_steps' => $this->flowService->stepCount(),
            'steps' => $this->flowService->steps(),
            'questions' => $questions,
            'answers' => $answers,
            'previous_step' => $this->flowService->previousStep($stepKey),
            'next_step' => $this->flowService->nextStep($stepKey),
            'is_first_step' => $stepKey === $this->flowService->firstStep(),
            'is_review_step' => $stepKey === 'review',
            'review' => $stepKey === 'review' ? $this->reviewService->build($session) : null,
            'missing_fields' => $this->reviewService->missingFields($session),
            'is_ready' => $this->reviewService->isReady($session),
        ];
    }

    /**
     * Resolve the selectable options for a question from config or the
     * requirements catalog.
     *
     * @param  array<string, mixed>  $question
     * @return array<int, array{key: string, label: string, category?: string}>
     */
    private function optionsForQuestion(array $question, QuoteSession $session): array
    {
        $source = $question['options_source'] ?? null;

        if ($source === 'features') {
            $projectType = (string) ($session->project_type ?? $this->projectTypeFromAnswers($session));

            return $this->requirementService->optionsForProjectType($projectType);
        }

        return collect(config("quote.{$source}", []))
            ->map(fn (array $option) => [
                'key' => (string) ($option['key'] ?? ''),
                'label' => (string) ($option['label'] ?? ''),
                'category' => $option['category'] ?? null,
            ])
            ->values()
            ->all();
    }

    private function projectTypeFromAnswers(QuoteSession $session): ?string
    {
        return $session->answers()
            ->where('question_key', 'project_type')
            ->value('answer');
    }

    /**
     * Laravel validation rules for the questions on a step, evaluated against
     * the incoming input so conditional questions resolve correctly.
     *
     * @param  array<string, mixed>  $input
     * @return array<string, array<int, string>>
     *
     * @throws InvalidStepException
     */
    public function validationRulesFor(QuoteSession $session, string $stepKey, array $input): array
    {
        $this->reviewService->assertStepAccessible($session, $stepKey);

        $step = $this->flowService->findStep($stepKey);

        return $this->validator->rules(
            $step,
            $this->flowService->questionsForStep($step, $session, $input),
            $session,
        );
    }

    /**
     * Save the answers posted for a step and return the prepared next step data.
     *
     * @param  array<string, mixed>  $input
     * @return array<string, mixed>
     *
     * @throws InvalidStepException
     */
    public function storeStep(QuoteSession $session, string $stepKey, array $input): array
    {
        $this->reviewService->assertStepAccessible($session, $stepKey);

        $step = $this->flowService->findStep($stepKey);
        $questions = $this->flowService->questionsForStep($step, $session, $input);

        $answers = [];

        foreach ($questions as $question) {
            $key = $question['key'];

            if (($question['type'] ?? null) === 'multiple_choice' && isset($input[$key])) {
                $answers[$key] = $this->normalizeMultipleChoice($input[$key]);

                continue;
            }

            if (! array_key_exists($key, $input)) {
                continue;
            }

            $value = $input[$key];

            if ($value === null || (is_string($value) && trim($value) === '')) {
                continue;
            }

            $answers[$key] = $value;
        }

        $this->answerService->saveMany($session, $answers);

        if (in_array($stepKey, ['project_type', 'project_requirements'], true)) {
            $this->syncRequirements($session, $answers);
        }

        if (in_array($stepKey, ['project_type', 'project_requirements'], true)) {
            $this->answerService->removeInvalidDependentAnswers($session);
        }

        $this->sessionService->touch($session);

        if (in_array($stepKey, ['project_type', 'project_description', 'business_information', 'project_requirements'], true)) {
            $this->sessionService->touchConversation($session);
        }

        if ($stepKey === $this->flowService->lastStep()) {
            $this->sessionService->markReview($session);
        }

        $session->refresh();

        return $this->step($session, $stepKey);
    }

    /**
     * Confirm the selected feature requirements whenever the project type or
     * requirements step is saved.
     *
     * @param  array<string, mixed>  $answers
     */
    private function syncRequirements(QuoteSession $session, array $answers): void
    {
        if (isset($answers['required_features']) && is_array($answers['required_features'])) {
            $this->requirementService->confirmMany($session, $answers['required_features']);
        }
    }

    /**
     * @return array<int, string>
     */
    private function normalizeMultipleChoice(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map('strval', $value)));
        }

        return array_values(array_filter(array_map('trim', explode(',', (string) $value))));
    }
}
