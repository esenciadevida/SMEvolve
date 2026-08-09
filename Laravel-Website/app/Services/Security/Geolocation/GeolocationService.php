<?php

namespace App\Services\Security\Geolocation;

use Illuminate\Support\Facades\Log;

/**
 * Resolves an approximate location through the configured provider. Disabled
 * by default. Failures, timeouts and slow providers must never block
 * authentication or audit logging: any exception is caught and logged, and
 * null is returned.
 */
class GeolocationService
{
    public function __construct(private readonly GeolocationProviderInterface $provider) {}

    /**
     * Returns a short human-readable approximate location string, or null when
     * geolocation is disabled or the location cannot be determined.
     */
    public function approximateLocation(?string $ip): ?string
    {
        if (! (bool) config('admin.geolocation.enabled', false)) {
            return null;
        }

        if ($ip === null || $ip === '') {
            return null;
        }

        try {
            $location = $this->provider->locate($ip);
        } catch (\Throwable $e) {
            Log::warning('Geolocation provider failed: '.$e->getMessage());

            return null;
        }

        if (! is_array($location)) {
            return null;
        }

        $parts = array_values(array_filter(array_map(
            fn ($value) => is_string($value) ? trim($value) : '',
            $location
        )));

        return $parts === [] ? null : implode(', ', $parts);
    }
}
