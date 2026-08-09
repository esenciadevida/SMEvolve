<?php

namespace App\Http\Middleware;

use App\Services\Analytics\PageViewTrackingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    public function __construct(private readonly PageViewTrackingService $tracker) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        try {
            $this->tracker->ensureVisitorCookie($request, $response);

            if (! $this->tracker->shouldSkip($request)) {
                $this->tracker->record($request);
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return $response;
    }
}
