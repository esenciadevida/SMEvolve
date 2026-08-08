<?php

namespace App\Services\AI;

use App\Models\QuoteSession;

class QuoteContextBuilder
{
    /**
     * Build the minimal, safe AI context for a quote operation. Personal
     * contact details, internal identifiers and sensitive metadata are
     * deliberately excluded.
     *
     * @param  array<string, mixed>  $additional
     * @return array<string, mixed>
     */
    public function build(QuoteSession $session, array $additional = []): array
    {
        $answers = $session->answers()
            ->orderBy('id')
            ->get()
            ->mapWithKeys(fn ($answer) => [$answer->question_key => $answer->answer]);

        $context = [
            'project_type' => $session->project_type ?? $answers->get('project_type'),
            'description' => $session->description ?? $answers->get('project_description'),
            'business_name' => $answers->get('business_name'),
            'industry' => $session->industry ?? $answers->get('industry'),
            'timeline' => $answers->get('timeline'),
            'budget_range' => $answers->get('budget_range'),
            'confirmed_requirements' => $this->confirmedRequirements($session),
        ];

        return array_values(array_filter(
            array_merge($context, $additional),
            fn ($value) => $value !== null && $value !== ''
        ));
    }

    /**
     * @return array<int, string>
     */
    private function confirmedRequirements(QuoteSession $session): array
    {
        return $session->sessionRequirements()
            ->whereIn('status', ['confirmed', 'selected'])
            ->whereHas('quoteRequirement')
            ->with('quoteRequirement')
            ->get()
            ->pluck('quoteRequirement.key')
            ->all();
    }
}
