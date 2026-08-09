<?php

namespace App\Services\Security\Geolocation;

/**
 * Default provider: geolocation is disabled unless an explicit provider is
 * configured, so no external request is ever made and location stays unknown.
 */
class NullGeolocationProvider implements GeolocationProviderInterface
{
    public function locate(string $ip): ?array
    {
        return null;
    }
}
