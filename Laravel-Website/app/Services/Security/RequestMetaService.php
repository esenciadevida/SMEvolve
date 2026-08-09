<?php

namespace App\Services\Security;

use App\Services\Security\Geolocation\GeolocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Derives anonymous request metadata (browser, OS, device type) from the
 * User-Agent string and captures the remote IP. No external request is made
 * for this data; approximate location is only resolved through the optional,
 * disabled-by-default GeolocationService.
 */
class RequestMetaService
{
    public function __construct(private readonly GeolocationService $geolocation) {}

    /**
     * @return array{ip: ?string, ip_hash: ?string, user_agent: ?string, browser: ?string, os: ?string, device_type: ?string, is_mobile: bool, location: ?string}
     */
    public function capture(Request $request): array
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        return [
            'ip' => is_string($ip) && $ip !== '' ? $ip : null,
            'ip_hash' => $this->ipHash($ip),
            'user_agent' => is_string($userAgent) ? mb_substr($userAgent, 0, 255) : null,
            'browser' => $this->browser($userAgent),
            'os' => $this->operatingSystem($userAgent),
            'device_type' => $this->deviceType($userAgent),
            'is_mobile' => $this->isMobile($userAgent),
            'location' => $this->geolocation->approximateLocation($ip),
        ];
    }

    /**
     * One-way hash used only for anonymous traffic analytics. Raw IPs are
     * never stored for analytics purposes.
     */
    public function ipHash(?string $ip): ?string
    {
        if ($ip === null || $ip === '') {
            return null;
        }

        return substr(hash_hmac('sha256', $ip, (string) config('app.key')), 0, 32);
    }

    public function browser(?string $userAgent): ?string
    {
        if ($userAgent === null || $userAgent === '') {
            return null;
        }

        if (stripos($userAgent, 'edg/') !== false) {
            return 'Edge';
        }
        if (stripos($userAgent, 'opr/') !== false || stripos($userAgent, 'opera') !== false) {
            return 'Opera';
        }
        if (stripos($userAgent, 'chrome') !== false && stripos($userAgent, 'chromium') === false) {
            return 'Chrome';
        }
        if (stripos($userAgent, 'firefox') !== false) {
            return 'Firefox';
        }
        if (stripos($userAgent, 'safari') !== false) {
            return 'Safari';
        }
        if (stripos($userAgent, 'msie') !== false || stripos($userAgent, 'trident') !== false) {
            return 'Internet Explorer';
        }

        return 'Other';
    }

    public function operatingSystem(?string $userAgent): ?string
    {
        if ($userAgent === null || $userAgent === '') {
            return null;
        }

        if (preg_match('/windows nt/i', $userAgent)) {
            return 'Windows';
        }
        if (preg_match('/android/i', $userAgent)) {
            return 'Android';
        }
        if (preg_match('/(iphone|ipad|ipod)/i', $userAgent)) {
            return 'iOS';
        }
        if (preg_match('/mac os x/i', $userAgent)) {
            return 'macOS';
        }
        if (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        }

        return 'Other';
    }

    public function deviceType(?string $userAgent): ?string
    {
        if ($userAgent === null || $userAgent === '') {
            return null;
        }

        if (preg_match('/(tablet|ipad|kindle|silk|playbook)/i', $userAgent)) {
            return 'tablet';
        }
        if (preg_match('/mobi/i', $userAgent)) {
            return 'mobile';
        }
        if (preg_match('/(smarttv|tv)/i', $userAgent)) {
            return 'tv';
        }

        return 'desktop';
    }

    public function isMobile(?string $userAgent): bool
    {
        return $this->deviceType($userAgent) === 'mobile' || $this->deviceType($userAgent) === 'tablet';
    }

    /**
     * New unique identifier used to separate the traffic pipeline from a
     * visitor session; used when no first-party visitor cookie exists.
     */
    public function newVisitorId(): string
    {
        return Str::lower(Str::random(32));
    }
}
