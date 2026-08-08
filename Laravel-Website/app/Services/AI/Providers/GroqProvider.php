<?php

namespace App\Services\AI\Providers;

use App\Services\AI\AIProviderException;
use App\Services\AI\AIProviderInterface;
use App\Services\AI\AIResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class GroqProvider implements AIProviderInterface
{
    public function name(): string
    {
        return 'groq';
    }

    public function isConfigured(): bool
    {
        $key = config('ai.groq.api_key');

        return is_string($key) && $key !== '' && $key !== 'REPLACE_WITH_GROQ_API_KEY';
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $messages
     * @param  array<string, mixed>  $options
     */
    public function generate(array $messages, array $options = []): AIResponse
    {
        if (! $this->isConfigured()) {
            throw AIProviderException::invalidResponse('The Groq API key is not configured.');
        }

        $payload = [
            'model' => $options['model'] ?? config('ai.groq.model'),
            'messages' => $messages,
            'temperature' => (float) ($options['temperature'] ?? config('ai.groq.temperature')),
            'max_tokens' => (int) ($options['max_output_tokens'] ?? config('ai.groq.max_output_tokens')),
        ];

        try {
            $response = Http::timeout((int) config('ai.groq.timeout'))
                ->withToken((string) config('ai.groq.api_key'))
                ->acceptJson()
                ->asJson()
                ->post(rtrim((string) config('ai.groq.base_url'), '/').'/chat/completions', $payload);
        } catch (ConnectionException $e) {
            throw AIProviderException::network('Could not reach the Groq API: '.$e->getMessage());
        }

        if ($response->clientError() || $response->serverError()) {
            $message = data_get($response->json(), 'error.message', 'Groq API returned an error.');

            throw AIProviderException::fromResponse((string) $message, $response->status());
        }

        $data = $response->json();

        $content = data_get($data, 'choices.0.message.content');
        if (! is_string($content) || trim($content) === '') {
            throw AIProviderException::invalidResponse('The Groq API returned an empty response.');
        }

        $content = trim($content);

        $usage = data_get($data, 'usage', []);

        return new AIResponse(
            content: $content,
            provider: $this->name(),
            model: (string) data_get($data, 'model', config('ai.groq.model')),
            inputTokens: (int) data_get($usage, 'prompt_tokens', 0),
            outputTokens: (int) data_get($usage, 'completion_tokens', 0),
            requestId: data_get($data, 'id') ? (string) data_get($data, 'id') : null,
        );
    }
}
