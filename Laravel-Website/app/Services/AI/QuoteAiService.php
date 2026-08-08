<?php

namespace App\Services\AI;

use App\Models\QuoteAIInteraction;
use App\Models\QuoteSession;
use App\Services\Quote\QuoteRequirementService;
use Illuminate\Support\Arr;

class QuoteAiService
{
    public function __construct(private readonly AiService $aiService) {}

    /**
     * Whether the quote AI assist features are available right now.
     */
    public function isAvailable(): bool
    {
        return $this->aiService->isAvailable('quote_feature_suggestions')
            && $this->aiService->isAvailable('quote_description_assistance');
    }

    /**
     * Analyze a quote session and persist the structured recommendation.
     *
     * @return array<string, mixed>
     *
     * @throws AIException
     */
    public function analyze(QuoteSession $session): array
    {
        $analysis = $this->parseJson(
            $this->aiService->generate('quote_assistant', $this->buildPrompt($session), [
                'temperature' => 0.2,
                'max_output_tokens' => 700,
            ])->content
        );

        $analysis = $this->normalize($analysis);

        $session->forceFill([
            'status' => QuoteSession::STATUS_COMPLETED,
            'completed_at' => now(),
            'project_type' => $analysis['project_type'],
            'industry' => $analysis['industry'],
            'recommended_service' => $analysis['recommended_service'],
            'recommended_package' => $analysis['recommended_package'],
            'complexity' => $analysis['complexity'],
            'lead_score' => $analysis['lead_score'],
            'ai_summary' => $analysis['summary'],
        ])->save();

        return $analysis;
    }

    public function buildPrompt(QuoteSession $session): string
    {
        $answers = $session->answers()
            ->orderBy('id')
            ->get()
            ->map(fn ($answer) => "Q: {$answer->question}\nA: {$answer->answer}")
            ->implode("\n");

        return "Analyse the following Quote Wizard answers for an SMEvolve proposal.\n\n{$answers}\n\nRespond with the required JSON only.";
    }

    /**
     * Suggest relevant features for the visitor's project. Suggestions are
     * always advisory and never auto-confirmed.
     *
     * @return array<int, array{key: string, reason: string}>
     *
     * @throws AIException
     */
    public function suggestFeatures(QuoteSession $session): array
    {
        $context = app(QuoteContextBuilder::class)->build($session, [
            'available_features' => $this->availableFeatures($session),
        ]);

        $response = $this->aiService->generate('quote_feature_suggestions', json_encode($context), [
            'temperature' => 0.3,
            'max_output_tokens' => 400,
        ]);

        $data = $this->parseJson($response->content);
        $suggestions = collect(Arr::get($data, 'suggestions', []))
            ->filter(fn ($item) => is_array($item) && isset($item['key']))
            ->map(fn ($item) => [
                'key' => mb_substr((string) $item['key'], 0, 80),
                'reason' => mb_substr((string) ($item['reason'] ?? ''), 0, 140),
            ])
            ->take(5)
            ->values()
            ->all();

        $this->recordInteraction($session, 'feature_suggestions', 'quote_feature_suggestions', 400);

        return $suggestions;
    }

    /**
     * Improve the visitor's project description.
     *
     * @return array{description: string, questions: array<int, string>}
     *
     * @throws AIException
     */
    public function improveDescription(QuoteSession $session): array
    {
        $context = app(QuoteContextBuilder::class)->build($session);

        $response = $this->aiService->generate('quote_description_assistance', json_encode($context), [
            'temperature' => 0.4,
            'max_output_tokens' => 500,
        ]);

        $data = $this->parseJson($response->content);

        $this->recordInteraction($session, 'description_assistance', 'quote_description_assistance', 500);

        return [
            'description' => mb_substr((string) Arr::get($data, 'description', ''), 0, 800),
            'questions' => collect(Arr::get($data, 'questions', []))
                ->filter()
                ->take(3)
                ->map(fn ($question) => mb_substr((string) $question, 0, 200))
                ->values()
                ->all(),
        ];
    }

    /**
     * @return array<int, string>
     */
    private function availableFeatures(QuoteSession $session): array
    {
        $projectType = (string) ($session->project_type
            ?? $session->answers()->where('question_key', 'project_type')->value('answer')
            ?? 'website');

        $features = app(QuoteRequirementService::class)->optionsForProjectType($projectType);

        return collect($features)->pluck('key')->values()->all();
    }

    private function recordInteraction(QuoteSession $session, string $operation, string $promptVersion, int $maxOutputTokens): void
    {
        try {
            QuoteAIInteraction::create([
                'quote_session_id' => $session->id,
                'operation' => $operation,
                'status' => QuoteAIInteraction::STATUS_COMPLETED,
                'prompt_version' => $promptVersion,
                'input_tokens' => null,
                'output_tokens' => $maxOutputTokens,
                'completed_at' => now(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function parseJson(string $content): array
    {
        $content = trim($content);

        if (str_starts_with($content, '{')) {
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        if (preg_match('/\{.*\}/s', $content, $matches)) {
            $decoded = json_decode($matches[0], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        throw new AIException('The AI could not produce a valid quote analysis. Please try again.');
    }

    /**
     * @param  array<string, mixed>  $analysis
     * @return array<string, mixed>
     */
    private function normalize(array $analysis): array
    {
        $complexity = strtolower((string) Arr::get($analysis, 'complexity', 'medium'));
        $complexity = in_array($complexity, ['low', 'medium', 'high'], true) ? $complexity : 'medium';

        $leadScore = (int) Arr::get($analysis, 'lead_score', 50);
        $leadScore = max(1, min(100, $leadScore));

        return [
            'project_type' => mb_substr((string) Arr::get($analysis, 'project_type', 'General project'), 0, 60),
            'industry' => mb_substr((string) Arr::get($analysis, 'industry', 'General'), 0, 120),
            'requirements' => collect(Arr::get($analysis, 'requirements', []))
                ->filter()
                ->take(12)
                ->values()
                ->all(),
            'recommended_service' => mb_substr((string) Arr::get($analysis, 'recommended_service', ''), 0, 160),
            'recommended_package' => mb_substr((string) (Arr::get($analysis, 'recommended_package') ?? ''), 0, 160),
            'complexity' => $complexity,
            'lead_score' => $leadScore,
            'summary' => mb_substr((string) Arr::get($analysis, 'summary', ''), 0, 1000),
        ];
    }
}
