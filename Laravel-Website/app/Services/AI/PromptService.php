<?php

namespace App\Services\AI;

use App\Models\AiPrompt;
use App\Models\AiPromptVersion;
use Illuminate\Support\Facades\File;

class PromptService
{
    public function systemPrompt(string $feature): string
    {
        $parts = [
            $this->content('global'),
            $this->content('business'),
            $this->content($feature),
        ];

        return implode("\n\n---\n\n", array_filter($parts));
    }

    /**
     * Returns the active prompt version content for a key, falling back to the
     * bundled markdown file when nothing is active in the database.
     */
    public function content(string $key): string
    {
        $version = $this->activeVersion($key);

        if ($version !== null) {
            return $version->content;
        }

        return $this->fallbackContent($key);
    }

    public function activeVersion(string $key): ?AiPromptVersion
    {
        $prompt = AiPrompt::where('key', $key)->with('activeVersion')->first();

        return $prompt?->activeVersion;
    }

    public function prompt(string $key): ?AiPrompt
    {
        return AiPrompt::where('key', $key)->with('activeVersion')->first();
    }

    public function fallbackContent(string $key): string
    {
        $path = resource_path("prompts/ai/{$key}.md");

        if (! File::exists($path)) {
            return '';
        }

        return (string) File::get($path);
    }
}
