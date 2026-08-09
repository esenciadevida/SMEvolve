<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::anonymousComponentPath(resource_path('views/emails'), 'emails');

        RateLimiter::for('contact', fn ($job) => Limit::perMinute(5)->by($job->ip() ?? 'unknown'));
        RateLimiter::for('public-search', fn ($job) => Limit::perMinute((int) config('website.search.rate_limit', 10))->by($job->ip() ?? 'unknown'));
    }
}
