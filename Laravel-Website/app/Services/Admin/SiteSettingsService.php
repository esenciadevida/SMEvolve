<?php

namespace App\Services\Admin;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class SiteSettingsService
{
    private const CACHE_KEY = 'site_settings:all';

    public function get(string $key, mixed $default = null): mixed
    {
        $row = SiteSetting::where('key', $key)->first();

        if ($row === null) {
            return $default;
        }

        return $this->decode($row->value, $row->type);
    }

    public function set(string $key, mixed $value, ?string $updatedBy = null): SiteSetting
    {
        $row = SiteSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $this->encode($value),
                'type' => $this->typeFor($value),
                'updated_by' => $updatedBy,
            ]
        );

        $this->refresh();

        return $row;
    }

    public function forget(string $key): void
    {
        SiteSetting::where('key', $key)->delete();
        $this->refresh();
    }

    /**
     * All persisted settings keyed by setting key, loaded through the cache.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            if (! Schema::hasTable('site_settings')) {
                return [];
            }

            return SiteSetting::orderBy('key')->get()
                ->mapWithKeys(fn (SiteSetting $row) => [$row->key => $this->decode($row->value, $row->type)])
                ->all();
        });
    }

    /**
     * Merge persisted settings into the Laravel config repository so public
     * website components automatically read the administrator-edited values.
     */
    public function loadIntoConfig(): void
    {
        foreach ($this->all() as $key => $value) {
            Config::set($key, $value);
        }
    }

    public function refresh(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function delete(string $key): void
    {
        SiteSetting::where('key', $key)->delete();
        $this->refresh();
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

    private function encode(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return json_encode($value) ?: null;
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
