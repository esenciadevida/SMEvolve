<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Apply baseline HTTP security headers on every response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        if (app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000');
        }

        $response->headers->remove('X-Powered-By');

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; "
            ."script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com; "
            ."style-src 'self' 'unsafe-inline'; "
            ."img-src 'self' data: https://www.googletagmanager.com https://www.google-analytics.com; "
            ."font-src 'self'; "
            ."connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://*.analytics.google.com; "
            ."object-src 'none'; "
            ."base-uri 'self'; "
            ."form-action 'self'; "
            ."frame-ancestors 'self'; "
            ."frame-src 'self' https://www.google.com https://www.google.com.ng https://maps.google.com"
        );

        return $response;
    }
}
