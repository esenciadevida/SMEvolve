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

    public function test_hsts_is_not_emitted_outside_production(): void
    {
        $this->get('/')
            ->assertHeaderMissing('Strict-Transport-Security');
    }
}
