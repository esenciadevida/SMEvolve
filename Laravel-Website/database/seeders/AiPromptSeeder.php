<?php

namespace Database\Seeders;

use App\Models\AiPrompt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AiPromptSeeder extends Seeder
{
    private const PROMPTS = [
        ['key' => 'global', 'name' => 'Global AI Rules', 'description' => 'Conduct and safety rules shared by every AI feature.'],
        ['key' => 'business', 'name' => 'Business Context', 'description' => 'Core SMEvolve positioning and contact information.'],
        ['key' => 'website_assistant', 'name' => 'Website Assistant', 'description' => 'Instructions for the public website chat assistant.'],
        ['key' => 'quote_assistant', 'name' => 'Quote Wizard AI', 'description' => 'Structured analysis engine for the Quote Wizard.'],
    ];

    public function run(): void
    {
        foreach (self::PROMPTS as $data) {
            $prompt = AiPrompt::firstOrCreate(
                ['key' => $data['key']],
                $data
            );

            $content = $this->bundledContent($data['key']);

            if ($content === '') {
                continue;
            }

            $version = $prompt->versions()->firstOrCreate(
                ['version' => '1.0'],
                [
                    'content' => $content,
                    'status' => 'active',
                    'created_by' => 'system',
                    'activated_by' => 'system',
                    'activated_at' => now(),
                ]
            );

            if ($prompt->active_version_id === null) {
                $prompt->forceFill(['active_version_id' => $version->id])->save();
            }
        }
    }

    private function bundledContent(string $key): string
    {
        $path = resource_path("prompts/ai/{$key}.md");

        if (! File::exists($path)) {
            return '';
        }

        return (string) File::get($path);
    }
}
