<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Lightweight, read-only system health checks for the Admin Portal dashboard.
 * Checks never throw; failures are reported as degraded/unavailable states.
 */
class SystemHealthService
{
    public const STATUS_OK = 'operational';
    public const STATUS_WARNING = 'warning';
    public const STATUS_UNAVAILABLE = 'unavailable';
    public const STATUS_NOT_CONFIGURED = 'not_configured';

    /**
     * @return array<int, array{key: string, label: string, status: string, message: string}>
     */
    public function check(): array
    {
        return [
            $this->application(),
            $this->database(),
            $this->cache(),
            $this->storage(),
            $this->mail(),
            $this->ai(),
            $this->search(),
        ];
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function application(): array
    {
        $key = (string) config('app.key');

        if ($key === '' || str_starts_with($key, 'base64:')) {
            return $this->result('app', 'Application', self::STATUS_UNAVAILABLE, 'APP_KEY is missing or invalid.');
        }

        return $this->result('app', 'Application', self::STATUS_OK, 'Application is configured.');
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function database(): array
    {
        try {
            DB::select('select 1');
        } catch (\Throwable $e) {
            return $this->result('database', 'Database', self::STATUS_UNAVAILABLE, 'Database connection failed.');
        }

        return $this->result('database', 'Database', self::STATUS_OK, 'Database connection is available.');
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function cache(): array
    {
        try {
            Cache::put('health-check', now()->timestamp, 60);
            Cache::get('health-check');
        } catch (\Throwable $e) {
            return $this->result('cache', 'Cache', self::STATUS_UNAVAILABLE, 'Cache store is not writable.');
        }

        return $this->result('cache', 'Cache', self::STATUS_OK, 'Cache store is working.');
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function storage(): array
    {
        $paths = [storage_path(), public_path('storage')];

        foreach ($paths as $path) {
            if (! is_dir($path) || ! is_writable($path)) {
                return $this->result('storage', 'Storage', self::STATUS_WARNING, 'A storage path is not writable.');
            }
        }

        return $this->result('storage', 'Storage', self::STATUS_OK, 'Storage paths are writable.');
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function mail(): array
    {
        $mailer = (string) config('mail.default');

        if ($mailer === 'log' || $mailer === 'array') {
            return $this->result('mail', 'Email', self::STATUS_WARNING, 'Mailer is in log mode; real deliveries are disabled.');
        }

        if ($mailer === 'smtp') {
            $username = (string) config('mail.mailers.smtp.username', '');
            $password = (string) config('mail.mailers.smtp.password', '');

            if ($username === '' || $password === '') {
                return $this->result('mail', 'Email', self::STATUS_NOT_CONFIGURED, 'SMTP credentials are missing; transactional emails will fail.');
            }

            return $this->result('mail', 'Email', self::STATUS_OK, 'SMTP mailer is configured.');
        }

        return $this->result('mail', 'Email', self::STATUS_NOT_CONFIGURED, 'Mailer default is not SMTP or log mode.');
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function ai(): array
    {
        $enabled = (bool) config('ai.enabled');
        $configured = (bool) config('ai.groq.api_key');

        if (! $enabled) {
            return $this->result('ai', 'AI Service', self::STATUS_NOT_CONFIGURED, 'AI features are disabled in configuration.');
        }

        if (! $configured) {
            return $this->result('ai', 'AI Service', self::STATUS_NOT_CONFIGURED, 'AI provider key is not configured.');
        }

        return $this->result('ai', 'AI Service', self::STATUS_OK, 'AI service is enabled and configured.');
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function search(): array
    {
        try {
            DB::table('knowledge_items')->select('id')->limit(1)->exists();
        } catch (\Throwable $e) {
            return $this->result('search', 'Search', self::STATUS_UNAVAILABLE, 'Search index query failed.');
        }

        return $this->result('search', 'Search', self::STATUS_OK, 'Search resources are queryable.');
    }

    /**
     * @return array{key: string, label: string, status: string, message: string}
     */
    private function result(string $key, string $label, string $status, string $message): array
    {
        return ['key' => $key, 'label' => $label, 'status' => $status, 'message' => $message];
    }
}
