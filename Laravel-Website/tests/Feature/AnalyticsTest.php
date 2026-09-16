<?php

namespace Tests\Feature;

use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    public function test_analytics_is_not_emitted_without_a_measurement_id(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('googletagmanager.com', false);
    }

    public function test_analytics_is_not_emitted_outside_production(): void
    {
        config()->set('analytics.measurement_id', 'G-TEST123456');

        $this->get('/')
            ->assertOk()
            ->assertDontSee('googletagmanager.com', false)
            ->assertDontSee('G-TEST123456');
    }

    public function test_analytics_is_emitted_in_production_when_configured(): void
    {
        config()->set('analytics.measurement_id', 'G-TEST123456');

        $this->app->detectEnvironment(fn () => 'production');

        try {
            $this->get('/')
                ->assertOk()
                ->assertSee('https://www.googletagmanager.com/gtag/js?id=G-TEST123456', false)
                ->assertSee("gtag('config', 'G-TEST123456'", false);
        } finally {
            $this->app->detectEnvironment(fn () => 'testing');
        }
    }

    public function test_consent_mode_defaults_to_denied_until_opted_in(): void
    {
        config()->set('analytics.measurement_id', 'G-TEST123456');

        $this->app->detectEnvironment(fn () => 'production');

        try {
            $this->get('/')
                ->assertOk()
                ->assertSee("analytics_storage: 'denied'", false)
                ->assertSee("ad_storage: 'denied'", false);
        } finally {
            $this->app->detectEnvironment(fn () => 'testing');
        }
    }

    public function test_content_security_policy_allows_google_analytics_hosts(): void
    {
        $csp = $this->get('/')->headers->get('Content-Security-Policy');

        $this->assertStringContainsString('https://www.googletagmanager.com', (string) $csp);
        $this->assertStringContainsString('https://www.google-analytics.com', (string) $csp);
        $this->assertStringContainsString('https://*.google-analytics.com', (string) $csp);
        $this->assertStringContainsString('https://*.analytics.google.com', (string) $csp);
    }

    public function test_content_security_policy_keeps_alpine_functional(): void
    {
        $csp = $this->get('/')->headers->get('Content-Security-Policy');

        $this->assertNotNull($csp);
        $this->assertStringContainsString("'unsafe-inline'", (string) $csp);
        $this->assertStringContainsString("'unsafe-eval'", (string) $csp);
        $this->assertStringContainsString("script-src 'self'", (string) $csp);
    }
}
