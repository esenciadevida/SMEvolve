<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_are_present(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_hsts_is_emitted_in_production_only(): void
    {
        app()->detectEnvironment(fn () => 'production');

        $this->get('/')
            ->assertHeader('Strict-Transport-Security', 'max-age=31536000');
    }

    public function test_x_powered_by_header_is_removed(): void
    {
        $this->get('/')
            ->assertHeaderMissing('X-Powered-By');
    }

    public function test_hsts_is_not_emitted_outside_production(): void
    {
        $this->get('/')
            ->assertHeaderMissing('Strict-Transport-Security');
    }

    public function test_noindex_header_is_set_on_api_and_admin_paths(): void
    {
        $this->get('/api/v1/ai/status')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');

        $this->get('/admin/login')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_noindex_header_is_not_set_on_public_pages(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag');
    }
}
