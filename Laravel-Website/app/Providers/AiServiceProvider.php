<?php

namespace App\Providers;

use App\Services\AI\AIProviderInterface;
use App\Services\AI\Providers\GroqProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AIProviderInterface::class, function () {
            $provider = config('ai.provider', 'groq');

            return match ($provider) {
                'groq' => new GroqProvider,
                default => new GroqProvider,
            };
        });
    }

    public function boot(): void
    {
        RateLimiter::for('ai:conversations', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.create_conversation', 10)
        )->by($this->limiterKey($job)));

        RateLimiter::for('ai:messages', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.send_message', 10)
        )->by($this->limiterKey($job)));

        RateLimiter::for('ai:quotes', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.quote_analyze', 5)
        )->by($this->limiterKey($job)));

        RateLimiter::for('quote:ai', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.quote_ai_assist', 8)
        )->by($this->quoteClientKey($job)));

        RateLimiter::for('quote:steps', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.quote_steps', 30)
        )->by($this->quoteClientKey($job)));

        RateLimiter::for('quote:submit', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.quote_submit', 3)
        )->by($this->quoteClientKey($job)));

        RateLimiter::for('ai:quote-sessions', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.quote_sessions', 10)
        )->by($job->ip() ?? 'unknown'));

        RateLimiter::for('ai:quote-answers', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.quote_answers', 30)
        )->by($job->ip() ?? 'unknown'));

        RateLimiter::for('ai:quote-submit', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.quote_submit_api', 3)
        )->by($job->ip() ?? 'unknown'));

        RateLimiter::for('ai:handoffs', fn ($job) => Limit::perMinutes(
            (int) config('ai.rate_limits.decay_minutes', 1),
            (int) config('ai.rate_limits.handoffs', 3)
        )->by($job->ip() ?? 'unknown'));
    }

    private function limiterKey($job): string
    {
        if (method_exists($job, 'session')) {
            $session = $job->session();
            if ($session !== null && $session->has('ai_session_id')) {
                return 'session:'.$session->get('ai_session_id');
            }
        }

        return $job->ip() ?? 'unknown';
    }

    private function quoteClientKey($job): string
    {
        if (method_exists($job, 'input')) {
            $clientId = $job->input('session_id');
            if (is_string($clientId) && $clientId !== '') {
                return 'quote:'.substr($clientId, 0, 40);
            }
        }

        return 'quote:'.$job->ip() ?? 'unknown';
    }
}
