<?php

namespace Tests\Unit\Ai;

use App\Services\AI\PromptService;
use Tests\TestCase;

class PromptServiceTest extends TestCase
{
    public function test_system_prompt_combines_global_business_and_feature_layers(): void
    {
        $prompt = app(PromptService::class);

        $system = $prompt->systemPrompt('website_assistant');

        $this->assertStringContainsString('Global AI Assistant Rules', $system);
        $this->assertStringContainsString('SMEvolve Business Context', $system);
        $this->assertStringContainsString('Website Assistant Instructions', $system);
    }

    public function test_fallback_content_loads_bundled_markdown_when_not_seeded(): void
    {
        $prompt = app(PromptService::class);

        $content = $prompt->content('global');

        $this->assertNotSame('', $content);
        $this->assertStringContainsString('SMEvolve', $content);
    }

    public function test_fallback_content_returns_empty_for_unknown_key(): void
    {
        $prompt = app(PromptService::class);

        $this->assertSame('', $prompt->content('does_not_exist'));
    }

    public function test_quote_assistant_prompt_requires_json_output(): void
    {
        $prompt = app(PromptService::class);

        $content = $prompt->content('quote_assistant');

        $this->assertStringContainsString('JSON', $content);
        $this->assertStringContainsString('recommended_service', $content);
    }
}
