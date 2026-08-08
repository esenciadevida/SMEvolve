<?php

namespace App\Services\Quote;

use App\Models\QuoteSession;

class QuoteStepValidator
{
    public function __construct(private readonly QuoteRequirementService $requirementService) {}

    /**
     * Build Laravel validation rules for the questions of a step.
     *
     * @param  array<string, mixed>  $step
     * @param  array<int, array<string, mixed>>  $questions  Already filtered by show_when.
     * @return array<string, array<int, string>>
     */
    public function rules(array $step, array $questions, QuoteSession $session): array
    {
        $rules = [];

        foreach ($questions as $question) {
            $key = (string) $question['key'];
            $type = (string) ($question['type'] ?? 'text');
            $required = (bool) ($question['required'] ?? false);

            $fieldRules = [];

            if ($required) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            if ($type === 'multiple_choice') {
                $fieldRules[] = 'array';
                $fieldRules[] = 'max:20';
                $fieldRules[] = $this->inRule($question, $session);
            } elseif ($type === 'single_choice') {
                $fieldRules[] = 'string';
                $fieldRules[] = $this->inRule($question, $session);
            } elseif ($type === 'email') {
                $fieldRules[] = 'email';
                $fieldRules[] = 'max:190';
            } elseif ($type === 'url') {
                $fieldRules[] = 'url';
                $fieldRules[] = 'max:'.(int) ($question['max'] ?? 300);
            } elseif ($type === 'phone') {
                $fieldRules[] = 'string';
                $fieldRules[] = 'max:'.(int) ($question['max'] ?? 30);
                $fieldRules[] = 'regex:/^[0-9+\-\s()]{6,30}$/';
            } else {
                $fieldRules[] = 'string';
                $fieldRules[] = 'max:'.(int) ($question['max'] ?? 2000);
            }

            $rules[$key] = $fieldRules;
        }

        return $rules;
    }

    /**
     * @param  array<string, mixed>  $question
     */
    private function inRule(array $question, QuoteSession $session): string
    {
        $source = $question['options_source'] ?? null;

        if ($source === 'features') {
            $projectType = (string) ($session->project_type
                ?? $session->answers()->where('question_key', 'project_type')->value('answer')
                ?? 'website');

            $allowed = collect($this->requirementService->optionsForProjectType($projectType))
                ->pluck('key')
                ->push('other')
                ->unique()
                ->values()
                ->all();
        } else {
            $allowed = collect(config("quote.{$source}", []))
                ->pluck('key')
                ->values()
                ->all();
        }

        if ($allowed === []) {
            return 'string';
        }

        return 'in:'.implode(',', $allowed);
    }
}
