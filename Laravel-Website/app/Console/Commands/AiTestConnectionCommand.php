<?php

namespace App\Console\Commands;

use App\Services\AI\AiConfigService;
use App\Services\AI\AIException;
use App\Services\AI\AIProviderInterface;
use Illuminate\Console\Command;

class AiTestConnectionCommand extends Command
{
    protected $signature = 'ai:test
                            {model? : Override the provider model to test (defaults to the configured model)}';

    protected $description = 'Send a minimal request to the AI provider and report connectivity and model support';

    public function handle(AIProviderInterface $provider, AiConfigService $config): int
    {
        $model = $this->argument('model') ?? $config->model();

        if (is_string($model) && $model !== '') {
            $options['model'] = $model;
        }

        $this->line('Provider: '.$provider->name());

        if (! $provider->isConfigured()) {
            $this->error('The AI provider API key is not configured.');

            return self::FAILURE;
        }

        $this->line('Model: '.($options['model'] ?? $model));

        try {
            $response = $provider->generate([
                ['role' => 'system', 'content' => 'You are a brief assistant.'],
                ['role' => 'user', 'content' => 'Say hello in one short sentence.'],
            ], array_merge($options ?? [], ['max_output_tokens' => 64, 'temperature' => 0]));
        } catch (AIException $e) {
            $this->error('Connection failed: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->info('OK: '.trim($response->content));
        $this->line('Model responded: '.$response->model);
        $this->line('Tokens: '.$response->inputTokens.' in / '.$response->outputTokens.' out');

        return self::SUCCESS;
    }
}
