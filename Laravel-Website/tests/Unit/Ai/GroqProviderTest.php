<?php

namespace Tests\Unit\Ai;

use App\Services\AI\AiConfigService;
use App\Services\AI\AIProviderException;
use App\Services\AI\Providers\GroqProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GroqProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('ai.groq.api_key', 'test-key');
    }

    public function test_is_configured_returns_false_without_api_key(): void
    {
        config()->set('ai.groq.api_key', null);

        $this->assertFalse(app(GroqProvider::class)->isConfigured());
    }

    public function test_generate_returns_ai_response(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'id' => 'chatcmpl-abc',
                'model' => 'llama-3.3-70b-versatile',
                'choices' => [
                    ['message' => ['role' => 'assistant', 'content' => 'Hello!']],
                ],
                'usage' => [
                    'prompt_tokens' => 10,
                    'completion_tokens' => 5,
                    'total_tokens' => 15,
                ],
            ], 200),
        ]);

        $response = app(GroqProvider::class)->generate([
            ['role' => 'user', 'content' => 'Hi'],
        ]);

        $this->assertSame('Hello!', $response->content);
        $this->assertSame('groq', $response->provider);
        $this->assertSame(10, $response->inputTokens);
        $this->assertSame(5, $response->outputTokens);
        $this->assertSame(15, $response->totalTokens());
    }

    public function test_generate_sends_expected_payload(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'id' => 'chatcmpl-abc',
                'model' => config('ai.groq.model'),
                'choices' => [['message' => ['role' => 'assistant', 'content' => 'ok']]],
                'usage' => ['prompt_tokens' => 1, 'completion_tokens' => 1],
            ], 200),
        ]);

        app(GroqProvider::class)->generate([
            ['role' => 'user', 'content' => 'Hello'],
        ], ['temperature' => 0.5, 'max_output_tokens' => 200]);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.groq.com/openai/v1/chat/completions'
                && $request->data()['model'] === config('ai.groq.model')
                && $request->data()['temperature'] === 0.5
                && $request->data()['max_tokens'] === 200
                && $request->data()['messages'][0]['content'] === 'Hello'
                && str_contains($request->header('Authorization')[0], 'Bearer test-key');
        });
    }

    public function test_generate_throws_on_provider_error(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'error' => ['message' => 'Rate limit exceeded'],
            ], 429),
        ]);

        $this->expectException(AIProviderException::class);

        app(GroqProvider::class)->generate([['role' => 'user', 'content' => 'Hi']]);
    }

    public function test_generate_throws_on_empty_response(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'id' => 'x',
                'model' => 'm',
                'choices' => [['message' => ['role' => 'assistant', 'content' => '  ']]],
                'usage' => [],
            ], 200),
        ]);

        $this->expectException(AIProviderException::class);

        app(GroqProvider::class)->generate([['role' => 'user', 'content' => 'Hi']]);
    }

    public function test_generate_uses_database_model_override(): void
    {
        config()->set('ai.groq.model', 'env-model');

        app(AiConfigService::class)->set('groq.model', 'db-model');

        Http::fake([
            'api.groq.com/*' => Http::response([
                'model' => 'db-model',
                'choices' => [['message' => ['role' => 'assistant', 'content' => 'ok']]],
                'usage' => ['prompt_tokens' => 1, 'completion_tokens' => 1],
            ], 200),
        ]);

        app(GroqProvider::class)->generate([['role' => 'user', 'content' => 'Hi']]);

        Http::assertSent(fn ($request) => $request->data()['model'] === 'db-model');
    }
}
