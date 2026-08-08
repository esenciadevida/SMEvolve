<?php

namespace App\Services\AI;

use App\Models\AiConfiguration;
use Illuminate\Support\Facades\Cache;

class AiConfigService
{
    private const CACHE_TTL = 300;

    public function get(string $key, mixed $default = null): mixed
    {
        $row = $this->row($key);

        if ($row === null) {
            return $default;
        }

        return $this->decode($row->value, $row->type);
    }

    public function set(string $key, mixed $value, ?string $updatedBy = null): AiConfiguration
    {
        $row = AiConfiguration::updateOrCreate(
            ['key' => $key],
            [
                'value' => $this->encode($value),
                'type' => $this->typeFor($value),
                'updated_by' => $updatedBy,
            ]
        );

        $this->forget($key);

        return $row;
    }

    public function forget(string $key): void
    {
        Cache::forget($this->cacheKey($key));
    }

    public function assistantEnabled(): bool
    {
        return $this->featureEnabled('assistant');
    }

    public function quoteEnabled(): bool
    {
        return $this->featureEnabled('quote');
    }

    public function featureEnabled(string $feature): bool
    {
        if (! (bool) config('ai.enabled')) {
            return false;
        }

        $fallback = (bool) config("ai.{$feature}.enabled", true);

        return (bool) $this->get("{$feature}.enabled", $fallback);
    }

    public function welcomeMessage(): string
    {
        return (string) $this->get(
            'assistant.welcome_message',
            config('ai.assistant.welcome_message')
        );
    }

    public function availabilityMessage(): string
    {
        return (string) $this->get(
            'assistant.availability_message',
            config('ai.assistant.availability_message')
        );
    }

    /**
     * All public configuration values decoded and keyed by configuration key.
     *
     * @return array<string, mixed>
     */
    public function allPublic(): array
    {
        return AiConfiguration::where('is_public', true)
            ->orderBy('key')
            ->get()
            ->mapWithKeys(fn (AiConfiguration $row) => [$row->key => $this->decode($row->value, $row->type)])
            ->all();
    }

    private function row(string $key): ?AiConfiguration
    {
        return Cache::remember($this->cacheKey($key), self::CACHE_TTL, fn () => AiConfiguration::where('key', $key)->first());
    }

    private function cacheKey(string $key): string
    {
        return "ai_configuration:{$key}";
    }

    private function decode(?string $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }

    private function encode(mixed $value): string
    {
        if (is_array($value)) {
            return json_encode($value) ?: '';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return (string) $value;
    }

    private function typeFor(mixed $value): string
    {
        if (is_bool($value)) {
            return 'boolean';
        }

        if (is_int($value)) {
            return 'integer';
        }

        if (is_float($value)) {
            return 'float';
        }

        if (is_array($value)) {
            return 'json';
        }

        return 'string';
    }
}
