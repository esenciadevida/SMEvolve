<?php

namespace Tests\Unit\Ai;

use App\Services\AI\AiConfigService;
use Tests\TestCase;

class AiConfigServiceTest extends TestCase
{
    public function test_model_falls_back_to_config_when_not_overridden(): void
    {
        config()->set('ai.groq.model', 'env-default');

        $this->assertSame('env-default', app(AiConfigService::class)->model());
    }

    public function test_model_returns_database_override(): void
    {
        $service = app(AiConfigService::class);
        $service->set('groq.model', 'db-model');

        $this->assertSame('db-model', $service->model());
    }

    public function test_max_output_tokens_and_temperature_roundtrip(): void
    {
        config()->set('ai.groq.max_output_tokens', 512);
        config()->set('ai.groq.temperature', 0.2);

        $service = app(AiConfigService::class);

        $this->assertSame(512, $service->maxOutputTokens());
        $this->assertSame(0.2, $service->temperature());

        $service->set('groq.max_output_tokens', 2048);
        $service->set('groq.temperature', 0.9);

        $this->assertSame(2048, $service->maxOutputTokens());
        $this->assertSame(0.9, $service->temperature());
    }

    public function test_enabled_falls_back_to_config(): void
    {
        config()->set('ai.enabled', true);

        $this->assertTrue(app(AiConfigService::class)->enabled());

        config()->set('ai.enabled', false);

        $this->assertFalse(app(AiConfigService::class)->enabled());
    }

    public function test_enabled_respects_database_override(): void
    {
        $service = app(AiConfigService::class);

        $service->set('enabled', false);

        $this->assertFalse($service->enabled());
        $this->assertFalse($service->featureEnabled('assistant'));

        $service->set('enabled', true);

        $this->assertTrue($service->enabled());
    }
}
