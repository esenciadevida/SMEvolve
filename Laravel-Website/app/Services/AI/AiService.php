<?php

namespace App\Services\AI;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class AiService
{
    public function __construct(
        private readonly AIProviderInterface $provider,
        private readonly PromptService $promptService,
        private readonly KnowledgeService $knowledgeService,
        private readonly ConversationService $conversationService,
        private readonly AiUsageService $usageService,
        private readonly AiConfigService $configService,
    ) {}

    public function provider(): AIProviderInterface
    {
        return $this->provider;
    }

    public function isAvailable(string $feature = 'assistant'): bool
    {
        return $this->configService->featureEnabled($feature) && $this->provider->isConfigured();
    }

    /**
     * Process a visitor message inside an existing conversation and persist the
     * assistant reply.
     *
     * @param  array<string, mixed>  $options
     * @return array{content: string, usage: AiUsage}
     *
     * @throws AIException
     */
    public function chat(Conversation $conversation, string $message, string $feature = 'assistant', array $options = []): array
    {
        if (! $this->configService->featureEnabled($feature)) {
            throw AIException::featureDisabled($feature);
        }

        if (! $this->provider->isConfigured()) {
            throw AIException::notConfigured();
        }

        if (mb_strlen($message) > (int) config('ai.limits.max_message_length')) {
            throw new AIException('That message is too long. Please shorten it and try again.');
        }

        $this->conversationService->appendMessage($conversation, Message::ROLE_USER, $message);

        $systemPrompt = $this->promptService->systemPrompt($feature);
        $knowledge = $this->knowledgeService->contextFor($message);

        $messages = [
            ['role' => 'system', 'content' => trim($systemPrompt."\n\nKNOWLEDGE CONTEXT\n\n{$knowledge}")],
        ];

        $messages = [
            ...$messages,
            ...$this->conversationService
                ->contextMessages($conversation, (int) config('ai.limits.max_context_messages'))
                ->all(),
        ];

        $started = microtime(true);

        try {
            $response = $this->provider->generate($messages, $options);
        } catch (AIException $e) {
            $this->recordFailure($conversation, 'chat', $e, $started);
            Log::warning('[AI] chat failed', ['conversation' => $conversation->id, 'error' => $e->getMessage()]);
            throw $e;
        }

        $responseTimeMs = (int) round((microtime(true) - $started) * 1000);

        $assistantMessage = $this->conversationService->appendMessage($conversation, Message::ROLE_ASSISTANT, $response->content, [
            'provider' => $response->provider,
            'model' => $response->model,
            'token_input' => $response->inputTokens,
            'token_output' => $response->outputTokens,
            'response_time_ms' => $responseTimeMs,
            'request_id' => $response->requestId,
            'status' => 'stored',
        ]);

        $this->conversationService->markActive($conversation);

        $usage = $this->usageService->record([
            'request_id' => $response->requestId ?? null,
            'conversation_id' => $conversation->id,
            'message_id' => $assistantMessage->id,
            'endpoint' => 'chat',
            'provider' => $response->provider,
            'model' => $response->model,
            'input_tokens' => $response->inputTokens,
            'output_tokens' => $response->outputTokens,
            'total_tokens' => $response->totalTokens(),
            'response_time_ms' => $responseTimeMs,
            'status' => 'success',
        ]);

        return [
            'content' => $response->content,
            'usage' => $usage,
        ];
    }

    /**
     * Run a raw generation request (used by the Quote Wizard engine).
     *
     * @param  array<string, mixed>  $options
     *
     * @throws AIException
     */
    public function generate(string $feature, string $userPrompt, array $options = []): AIResponse
    {
        if (! $this->configService->featureEnabled($feature)) {
            throw AIException::featureDisabled($feature);
        }

        if (! $this->provider->isConfigured()) {
            throw AIException::notConfigured();
        }

        $systemPrompt = $this->promptService->systemPrompt($feature);

        $messages = [
            ['role' => 'system', 'content' => trim($systemPrompt."\n\nKNOWLEDGE CONTEXT\n\n".$this->knowledgeService->contextFor($userPrompt))],
            ['role' => 'user', 'content' => $userPrompt],
        ];

        $started = microtime(true);

        try {
            $response = $this->provider->generate($messages, $options);
        } catch (AIException $e) {
            $this->recordFailure(null, $feature, $e, $started);
            throw $e;
        }

        $responseTimeMs = (int) round((microtime(true) - $started) * 1000);

        $this->usageService->record([
            'request_id' => $response->requestId ?? null,
            'endpoint' => $feature,
            'provider' => $response->provider,
            'model' => $response->model,
            'input_tokens' => $response->inputTokens,
            'output_tokens' => $response->outputTokens,
            'total_tokens' => $response->totalTokens(),
            'response_time_ms' => $responseTimeMs,
            'status' => 'success',
        ]);

        return $response;
    }

    private function recordFailure(?Conversation $conversation, string $endpoint, AIException $e, float $started): void
    {
        $this->usageService->record([
            'conversation_id' => $conversation?->id,
            'endpoint' => $endpoint,
            'provider' => $this->provider->name(),
            'response_time_ms' => (int) round((microtime(true) - $started) * 1000),
            'status' => 'error',
            'error_type' => $e instanceof AIProviderException ? ($e->errorType ?? 'provider_error') : 'ai_error',
        ]);
    }
}
