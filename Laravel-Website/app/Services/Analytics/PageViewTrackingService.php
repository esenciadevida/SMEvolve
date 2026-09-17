<?php

namespace App\Services\Analytics;

use App\Models\PageView;
use App\Services\Security\RequestMetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Privacy-conscious, anonymous server-side page view tracking.
 *
 * - Raw IP addresses are never stored; a visitor is identified either by a
 *   first-party random cookie or a one-way hash of the remote address.
 * - Bot signatures are filtered out before recording.
 * - Each visitor/path combination is deduplicated briefly and per-visitor
 *   volume is capped so aggressive clients cannot bloat the table.
 * - Recorded rows contain only aggregated, anonymised data used by the
 *   Admin Portal analytics (never for security/audit purposes).
 */
class PageViewTrackingService
{
    public const VISITOR_COOKIE = 'smevolve_visitor';

    public function __construct(private readonly RequestMetaService $meta) {}

    /**
     * Determine whether a request is a bot or otherwise unsuitable for
     * tracking. Called by the middleware before any storage happens.
     */
    public function shouldSkip(Request $request): bool
    {
        if (! (bool) config('admin.tracking.enabled', true)) {
            return true;
        }

        if (! $request->isMethod('GET')) {
            return true;
        }

        if ($request->isXmlHttpRequest() || $request->ajax() || $request->prefetch()) {
            return true;
        }

        $path = $request->path();

        foreach ((array) config('admin.tracking.exclude_paths', []) as $prefix) {
            if ($path === $prefix || str_starts_with($path, trim($prefix, '/').'/')) {
                return true;
            }
        }

        if ($this->isBot($request->userAgent())) {
            return true;
        }

        return false;
    }

    /**
     * Record a page view, respecting deduplication and rate caps.
     */
    public function record(Request $request): void
    {
        $visitorId = $this->visitorId($request);

        if ($visitorId === null || ! $this->allowRecording($visitorId)) {
            return;
        }

        $dedupeKey = 'pageview:dedupe:'.$visitorId.':'.$request->path().':'.now()->format('YmdHi');
        $dedupeSeconds = max(1, (int) config('admin.tracking.dedupe_seconds', 60));

        if (Cache::has($dedupeKey)) {
            return;
        }

        Cache::put($dedupeKey, true, now()->addSeconds($dedupeSeconds));

        $meta = $this->meta->capture($request);
        $referer = $request->headers->get('referer');

        PageView::create([
            'visitor_id' => $visitorId,
            'path' => '/'.ltrim($request->path(), '/'),
            'page_title' => $this->pageTitle($request),
            'referer_host' => $referer !== null && $referer !== '' ? parse_url($referer, PHP_URL_HOST) : null,
            'browser' => $meta['browser'],
            'os' => $meta['os'],
            'device_type' => $meta['device_type'],
            'locale' => $request->getLocale(),
            'is_mobile' => $meta['is_mobile'],
            'viewed_at' => now(),
        ]);
    }

    private function visitorId(Request $request): ?string
    {
        $cookie = $request->cookie(self::VISITOR_COOKIE);

        if (is_string($cookie) && preg_match('/^[a-f0-9]{32}$/', $cookie) === 1) {
            return $cookie;
        }

        $ip = $request->ip();

        if ($ip === null || $ip === '') {
            return null;
        }

        return $this->meta->ipHash($ip) ?? $this->meta->newVisitorId();
    }

    private function allowRecording(string $visitorId): bool
    {
        $key = 'pageview:rate:'.$visitorId.':'.now()->format('YmdHi');
        $max = max(1, (int) config('admin.tracking.max_per_minute_per_visitor', 30));
        $current = (int) Cache::get($key, 0);

        if ($current >= $max) {
            return false;
        }

        Cache::put($key, $current + 1, now()->addMinute());

        return true;
    }

    private function isBot(?string $userAgent): bool
    {
        if ($userAgent === null || $userAgent === '') {
            return true;
        }

        foreach ((array) config('admin.tracking.bot_signatures', []) as $signature) {
            if (stripos($userAgent, (string) $signature) !== false) {
                return true;
            }
        }

        return false;
    }

    private function pageTitle(Request $request): ?string
    {
        $title = $request->attributes->get('page_title');

        return is_string($title) && $title !== '' ? mb_substr($title, 0, 255) : null;
    }

    /**
     * Set a first-party anonymous visitor cookie (random identifier) when the
     * visitor does not already have one.
     */
    public function ensureVisitorCookie(Request $request, Response $response): void
    {
        $cookie = $request->cookie(self::VISITOR_COOKIE);

        if (is_string($cookie) && preg_match('/^[a-f0-9]{32}$/', $cookie) === 1) {
            return;
        }

        $response->withCookie(
            cookie()->forever(self::VISITOR_COOKIE, Str::lower(Str::random(32)), '/', null, false, true, false, 'Lax')
        );
    }
}
