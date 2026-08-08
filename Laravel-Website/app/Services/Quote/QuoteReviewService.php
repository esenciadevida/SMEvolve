<?php

namespace App\Services\Quote;

use App\Exceptions\Quote\InvalidStepException;
use App\Models\QuoteSession;

class QuoteReviewService
{
    public function __construct(
        private readonly QuoteAnswerService $answerService,
        private readonly QuoteRequirementService $requirementService,
        private readonly QuoteFlowService $flowService,
    ) {}

    /**
     * Build the review dataset strictly from server-side data.
     *
     * @return array<string, mixed>
     */
    public function build(QuoteSession $session): array
    {
        $answers = $this->answerService->answersFor($session);
        $requirements = $this->requirementService->requirementsFor($session)
            ->where('status', 'confirmed')
            ->pluck('name')
            ->values()
            ->all();

        return [
            'project_type' => $this->label('project_types', $answers['project_type'] ?? null),
            'project_description' => $answers['project_description'] ?? null,
            'business_name' => $answers['business_name'] ?? null,
            'industry' => $this->industryLabel($answers),
            'business_description' => $answers['business_description'] ?? null,
            'requirements' => $requirements,
            'additional_features' => $answers['additional_features'] ?? null,
            'existing_assets' => $this->labels('existing_assets', $this->split($answers['existing_assets'] ?? null)),
            'project_stage' => $this->label('project_stages', $answers['project_stage'] ?? null),
            'timeline' => $this->label('timelines', $answers['timeline'] ?? null),
            'budget_range' => $this->label('budget_ranges', $answers['budget_range'] ?? null),
            'additional_information' => $answers['additional_information'] ?? null,
            'contact_name' => $answers['full_name'] ?? null,
            'contact_email' => $answers['email'] ?? null,
            'contact_phone' => $answers['phone'] ?? null,
            'company_name' => $answers['company_name'] ?? null,
            'preferred_contact_method' => $this->label('contact_methods', $answers['preferred_contact_method'] ?? null),
            'answers' => $answers,
        ];
    }

    /**
     * Validate that a session has everything required for submission.
     *
     * @return array<int, string>
     */
    public function missingFields(QuoteSession $session): array
    {
        $answers = $this->answerService->answersFor($session);
        $required = config('quote.minimum_submission_fields', []);
        $missing = [];

        foreach ($required as $field) {
            if (! isset($answers[$field]) || trim((string) $answers[$field]) === '') {
                $missing[] = $field;
            }
        }

        return $missing;
    }

    public function isReady(QuoteSession $session): bool
    {
        return $this->missingFields($session) === [];
    }

    /**
     * Ensure a requested step key is a valid, accessible step.
     *
     * @throws InvalidStepException
     */
    public function assertStepAccessible(QuoteSession $session, string $stepKey): void
    {
        if (! $this->flowService->canAccessStep($session, $stepKey)) {
            throw new InvalidStepException('That step is not available.');
        }
    }

    private function split(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /**
     * @param  array<string, string>  $answers
     */
    private function industryLabel(array $answers): ?string
    {
        $industry = $answers['industry'] ?? null;
        $other = trim((string) ($answers['industry_other'] ?? ''));

        if ($industry === 'other' && $other !== '') {
            return $other;
        }

        return $this->label('industries', $industry);
    }

    private function label(string $catalog, ?string $key): ?string
    {
        if ($key === null || $key === '') {
            return null;
        }

        foreach (config("quote.{$catalog}", []) as $option) {
            if (($option['key'] ?? null) === $key) {
                return $option['label'];
            }
        }

        return $key;
    }

    private function labels(string $catalog, array $keys): array
    {
        return array_values(array_filter(array_map(fn (?string $key) => $this->label($catalog, $key), $keys)));
    }
}
