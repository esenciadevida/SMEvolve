<?php

namespace Tests\Unit\Ai;

use App\Models\AiPrompt;
use Database\Seeders\AiPromptSeeder;
use Tests\TestCase;

class AiPromptSeederTest extends TestCase
{
    public function test_seeder_creates_all_prompt_profiles_with_active_versions(): void
    {
        $this->seed(AiPromptSeeder::class);

        $keys = [
            'global',
            'business',
            'website_assistant',
            'quote_assistant',
            'quote_feature_suggestions',
            'quote_description_assistance',
        ];

        foreach ($keys as $key) {
            $prompt = AiPrompt::where('key', $key)->first();
            $this->assertNotNull($prompt, "Prompt \"{$key}\" was not seeded.");
            $this->assertNotNull($prompt->activeVersion, "Prompt \"{$key}\" has no active version.");
        }
    }
}
