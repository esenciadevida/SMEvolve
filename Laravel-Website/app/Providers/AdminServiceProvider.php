<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Services\Admin\AdminAnalyticsService;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdminDashboardService;
use App\Services\Admin\AdministratorService;
use App\Services\Admin\AdminQuoteService;
use App\Services\Admin\SiteSettingsService;
use App\Services\Search\AdminAuditLogSearchProvider;
use App\Services\Search\AdministratorSearchProvider;
use App\Services\Search\KnowledgeItemSearchProvider;
use App\Services\Search\PortfolioProjectSearchProvider;
use App\Services\Search\QuoteSearchProvider;
use App\Services\Search\SearchResourceRegistry;
use App\Services\Search\SearchService;
use App\Services\Search\SiteSettingSearchProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SiteSettingsService::class);
        $this->app->singleton(AdminAuditService::class);
        $this->app->singleton(AdminAnalyticsService::class);
        $this->app->singleton(AdminDashboardService::class);
        $this->app->singleton(AdminQuoteService::class);
        $this->app->singleton(AdministratorService::class);
        $this->app->singleton(SearchService::class);

        $this->app->singleton(SearchResourceRegistry::class, function () {
            $registry = new SearchResourceRegistry;

            $registry->register(new QuoteSearchProvider);
            $registry->register(new AdministratorSearchProvider);
            $registry->register(new SiteSettingSearchProvider);
            $registry->register(new KnowledgeItemSearchProvider);
            $registry->register(new AdminAuditLogSearchProvider);
            $registry->register(new PortfolioProjectSearchProvider);

            return $registry;
        });
    }

    public function boot(): void
    {
        $this->bootSettingsIntoConfig();
        $this->bootGates();
        $this->bootRateLimiters();
    }

    /**
     * Persisted site settings override the matching config values so public
     * website components read the administrator-controlled values.
     */
    private function bootSettingsIntoConfig(): void
    {
        app(SiteSettingsService::class)->loadIntoConfig();
    }

    private function bootGates(): void
    {
        Gate::define('admin.dashboard', fn (Administrator $administrator) => $administrator->hasPermission('dashboard.view'));
        Gate::define('admin.settings.view', fn (Administrator $administrator) => $administrator->hasPermission('settings.view'));
        Gate::define('admin.settings.update', fn (Administrator $administrator) => $administrator->hasPermission('settings.update'));
        Gate::define('admin.quotes.view', fn (Administrator $administrator) => $administrator->hasPermission('quotes.view'));
        Gate::define('admin.quotes.search', fn (Administrator $administrator) => $administrator->hasPermission('quotes.search'));
        Gate::define('admin.quotes.updateStatus', fn (Administrator $administrator) => $administrator->hasPermission('quotes.update_status'));
        Gate::define('admin.portfolio.view', fn (Administrator $administrator) => $administrator->hasPermission('portfolio.view'));
        Gate::define('admin.portfolio.create', fn (Administrator $administrator) => $administrator->hasPermission('portfolio.create'));
        Gate::define('admin.portfolio.update', fn (Administrator $administrator) => $administrator->hasPermission('portfolio.update'));
        Gate::define('admin.portfolio.publish', fn (Administrator $administrator) => $administrator->hasPermission('portfolio.publish'));
        Gate::define('admin.portfolio.delete', fn (Administrator $administrator) => $administrator->hasPermission('portfolio.delete'));
        Gate::define('admin.chatbot.view', fn (Administrator $administrator) => $administrator->hasPermission('chatbot.view'));
        Gate::define('admin.chatbot.update', fn (Administrator $administrator) => $administrator->hasPermission('chatbot.update'));
        Gate::define('admin.ai.view', fn (Administrator $administrator) => $administrator->hasPermission('ai.view'));
        Gate::define('admin.ai.update', fn (Administrator $administrator) => $administrator->hasPermission('ai.update'));
        Gate::define('admin.administrators.view', fn (Administrator $administrator) => $administrator->hasPermission('administrators.view'));
        Gate::define('admin.administrators.create', fn (Administrator $administrator) => $administrator->hasPermission('administrators.create'));
        Gate::define('admin.administrators.update', fn (Administrator $administrator) => $administrator->hasPermission('administrators.update'));
        Gate::define('admin.administrators.disable', fn (Administrator $administrator) => $administrator->hasPermission('administrators.disable'));
        Gate::define('admin.administrators.changeRole', fn (Administrator $administrator) => $administrator->hasPermission('administrators.change_role'));
        Gate::define('admin.roles.view', fn (Administrator $administrator) => $administrator->hasPermission('administrators.view'));
        Gate::define('admin.roles.create', fn (Administrator $administrator) => $administrator->hasPermission('administrators.update'));
        Gate::define('admin.roles.update', fn (Administrator $administrator) => $administrator->hasPermission('administrators.update'));
        Gate::define('admin.roles.delete', fn (Administrator $administrator) => $administrator->hasPermission('administrators.update'));
        Gate::define('admin.audit.view', fn (Administrator $administrator) => $administrator->hasPermission('audit.view'));
        Gate::define('admin.profile.update', fn (Administrator $administrator) => $administrator->hasPermission('profile.update'));
        Gate::define('admin.security.password', fn (Administrator $administrator) => $administrator->hasPermission('security.password_update'));
    }

    private function bootRateLimiters(): void
    {
        RateLimiter::for('admin:login', fn ($job) => Limit::perMinutes(
            15,
            (int) config('admin.login_rate_limit', 5)
        )->by($job->ip() ?? 'unknown'));

        RateLimiter::for('admin:search', fn ($job) => Limit::perMinute(
            (int) config('admin.search_rate_limit', 30)
        )->by($job->user()?->id ?? $job->ip() ?? 'unknown'));
    }
}
