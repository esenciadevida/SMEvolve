<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Emit X-Robots-Tag: noindex, nofollow on paths that should never be indexed
 * even if they are accidentally discovered by crawlers. This is defence-in-
 * depth — the primary mechanism is robots.txt Disallow and auth protection.
 */
class Noindex
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $response instanceof Response) {
            return $response;
        }

        $path = $request->path();

        if (str_starts_with($path, 'api/') || str_starts_with($path, 'admin/') || str_starts_with($path, 'storage/')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        return $response;
    }
}
