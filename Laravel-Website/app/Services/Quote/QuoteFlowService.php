<?php

namespace App\Services\Quote;

use App\Models\QuoteSession;

class QuoteFlowService
{
    /**
     * All wizard steps in configured order.
     *
     * @return array<int, array<string, mixed>>
     */
    public function steps(): array
    {
        return config('quote.steps', []);
    }

    public function stepCount(): int
    {
        return count($this->steps());
    }

    /**
     * Find a step definition by key.
     *
     * @return array<string, mixed>|null
     */
    public function findStep(string $key): ?array
    {
        foreach ($this->steps() as $step) {
            if (($step['key'] ?? null) === $key) {
                return $step;
            }
        }

        return null;
    }

    /**
     * Whether a given step key exists in the configured flow.
     */
    public function hasStep(string $key): bool
    {
        return $this->findStep($key) !== null;
    }

    /**
     * The numeric position (1-based) of a step key.
     */
    public function stepNumber(string $key): int
    {
        foreach (array_values($this->steps()) as $index => $step) {
            if (($step['key'] ?? null) === $key) {
                return $index + 1;
            }
        }

        return 0;
    }

    public function nextStep(string $key): ?string
    {
        $steps = array_values(array_map(fn ($step) => $step['key'], $this->steps()));
        $position = array_search($key, $steps, true);

        if ($position === false) {
            return null;
        }

        return $steps[$position + 1] ?? null;
    }

    public function previousStep(string $key): ?string
    {
        $steps = array_values(array_map(fn ($step) => $step['key'], $this->steps()));
        $position = array_search($key, $steps, true);

        if ($position === false || $position === 0) {
            return null;
        }

        return $steps[$position - 1];
    }

    /**
     * The first step key.
     */
    public function firstStep(): string
    {
        $steps = $this->steps();

        return $steps[0]['key'] ?? 'project_type';
    }

    /**
     * The final step key.
     */
    public function lastStep(): string
    {
        $steps = array_values($this->steps());

        return $steps[array_key_last($steps)]['key'] ?? 'contact_information';
    }

    /**
     * Whether the user may access a step. Any configured step is technically
     * accessible; guardrail validation of "required steps cannot be bypassed"
     * is enforced at the review/submission stage via the review service.
     */
    public function canAccessStep(QuoteSession $session, string $stepKey): bool
    {
        return $this->hasStep($stepKey)
            && ! $session->isExpired()
            && ! in_array($session->status, [QuoteSession::STATUS_SUBMITTED], true);
    }

    /**
     * Resolve the questions for a step, filtering out conditional questions
     * whose conditions are not met based on the current answers. Incoming
     * (not yet persisted) answers may be merged via $extraAnswers so that
     * same-step conditional questions evaluate correctly.
     *
     * @param  array<int, array<string, mixed>>  $extraAnswers
     * @return array<int, array<string, mixed>>
     */
    public function questionsForStep(array $step, QuoteSession $session, array $extraAnswers = []): array
    {
        $answers = $session->answers()
            ->pluck('answer', 'question_key')
            ->all();

        $answers = array_merge($answers, $extraAnswers);

        return array_values(array_filter(
            $step['questions'] ?? [],
            fn (array $question) => $this->shouldShowQuestion($question, $answers)
        ));
    }

    /**
     * Evaluate a question's `show_when` rule against the current answers.
     *
     * @param  array<string, string>  $answers
     */
    public function shouldShowQuestion(array $question, array $answers): bool
    {
        $rule = $question['show_when'] ?? null;

        if (! is_array($rule) || ! isset($rule['field'])) {
            return true;
        }

        $field = $rule['field'];
        $actual = $answers[$field] ?? null;

        if (isset($rule['value'])) {
            return (string) $actual === (string) $rule['value'];
        }

        if (isset($rule['contains'])) {
            $selected = is_array($actual) ? $actual : ($actual !== null ? [$actual] : []);
            $contains = is_array($rule['contains']) ? $rule['contains'] : [$rule['contains']];

            return count(array_intersect($selected, $contains)) > 0;
        }

        return true;
    }
}
