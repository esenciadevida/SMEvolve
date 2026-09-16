<?php

namespace Tests\Unit\Ai;

use App\Services\AI\AIProviderInterface;
use App\Services\AI\Providers\GroqProvider;
use Tests\TestCase;

class AiServiceProviderTest extends TestCase
{
    public function test_groq_provider_is_bound_by_default(): void
    {
        config()->set('ai.provider', 'groq');

        $this->assertInstanceOf(GroqProvider::class, app(AIProviderInterface::class));
    }

    public function test_unknown_provider_fails_loudly(): void
    {
        $this->expectException(\RuntimeException::class);

        config()->set('ai.provider', 'openai');

        app(AIProviderInterface::class);
    }
}
