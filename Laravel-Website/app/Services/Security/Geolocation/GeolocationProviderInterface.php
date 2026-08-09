<?php

namespace App\Services\Security\Geolocation;

/**
 * Provider-agnostic interface for resolving an approximate geographic
 * location from an IP address. Providers must return null (never throw) when
 * a location cannot be determined, and must only ever provide approximate,
 * coarse location data - never exact GPS coordinates.
 */
interface GeolocationProviderInterface
{
    /**
     * @return array{country?: string, region?: string, city?: string}|null
     */
    public function locate(string $ip): ?array;
}
