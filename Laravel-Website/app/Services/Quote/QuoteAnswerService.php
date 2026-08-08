<?php

namespace App\Services\Quote;

use App\Models\QuoteSession;

class QuoteAnswerService
{
    /**
     * Save a single answer for a session, keyed by question_key.
     *
     * @param  array<string, mixed>  $data
     */
    public function save(QuoteSession $session, array $data): void
    {
        $question = $data['question'] ?? null;
        $answer = $data['answer'];
        $type = $data['answer_type'] ?? 'text';

        if (is_array($answer)) {
            $answer = implode(',', array_values(array_filter($answer, 'strlen')));
            $type = $type === 'text' ? 'select' : $type;
        }

        $session->answers()->updateOrCreate(
            ['question_key' => $data['question_key']],
            [
                'question' => is_string($question) ? mb_substr($question, 0, 255) : null,
                'answer' => $answer,
                'answer_type' => $type,
                'source' => $data['source'] ?? 'user',
                'confirmed_at' => now(),
            ]
        );

        $this->syncSessionField($session, $data['question_key'], $answer);
    }

    /**
     * Persist a batch of answers (one per question key) in a single operation.
     *
     * @param  array<string, mixed>  $answers
     */
    public function saveMany(QuoteSession $session, array $answers): void
    {
        foreach ($answers as $questionKey => $answer) {
            if ($answer === null || (is_string($answer) && trim($answer) === '')) {
                continue;
            }

            $this->save($session, [
                'question_key' => $questionKey,
                'question' => null,
                'answer' => $answer,
                'answer_type' => $this->answerTypeFor($session, $questionKey),
                'source' => 'user',
            ]);
        }

        $session->forceFill([
            'status' => $session->status === QuoteSession::STATUS_SUBMITTED
                ? $session->status
                : QuoteSession::STATUS_IN_PROGRESS,
            'current_step' => max(1, $session->answers()->count()),
            'last_activity_at' => now(),
        ])->save();
    }

    /**
     * Remove answers whose conditional questions are no longer applicable.
     */
    public function removeInvalidDependentAnswers(QuoteSession $session): void
    {
        $steps = config('quote.steps', []);
        $answers = $session->answers()->pluck('answer', 'question_key')->all();
        $flow = app(QuoteFlowService::class);

        $conditionalKeys = [];

        foreach ($steps as $step) {
            foreach ($step['questions'] ?? [] as $question) {
                if (isset($question['show_when'])) {
                    $conditionalKeys[$question['key']] = $question;
                }
            }
        }

        foreach ($conditionalKeys as $key => $question) {
            if (! array_key_exists($key, $answers)) {
                continue;
            }

            if (! $flow->shouldShowQuestion($question, $answers)) {
                $session->answers()->where('question_key', $key)->delete();
            }
        }
    }

    /**
     * Answers keyed by question_key for a session.
     *
     * @return array<string, string>
     */
    public function answersFor(QuoteSession $session): array
    {
        return $session->answers()->pluck('answer', 'question_key')->all();
    }

    private function answerTypeFor(QuoteSession $session, string $questionKey): string
    {
        foreach (config('quote.steps', []) as $step) {
            foreach ($step['questions'] ?? [] as $question) {
                if (($question['key'] ?? null) === $questionKey) {
                    return match ($question['type'] ?? 'text') {
                        'single_choice' => 'select',
                        'multiple_choice' => 'select',
                        default => 'text',
                    };
                }
            }
        }

        return 'text';
    }

    /**
     * Map well-known answers onto quote session columns so the session remains
     * queryable without reading every answer record.
     */
    private function syncSessionField(QuoteSession $session, string $questionKey, string|array $answer): void
    {
        $mapped = [
            'project_type' => 'project_type',
            'business_name' => 'business_name',
            'company_name' => 'business_name',
            'industry' => 'industry',
            'project_description' => 'description',
            'budget_range' => 'budget_range',
            'timeline' => 'timeline',
            'full_name' => 'contact_name',
            'email' => 'contact_email',
            'phone' => 'contact_phone',
            'preferred_contact_method' => 'preferred_contact_method',
        ];

        if (! isset($mapped[$questionKey])) {
            return;
        }

        $value = is_array($answer) ? implode(',', $answer) : (string) $answer;

        $session->forceFill([
            $mapped[$questionKey] => $value,
        ])->save();
    }
}
