<?php

namespace App\Repositories\Fallback;

use App\Repositories\Contracts\GpsProviderInterface;

class MockGpsProvider implements GpsProviderInterface
{
    public function getCurrentLocation(string $gpsTrackerRef): ?array
    {
        return [
            'latitude' => -6.9147,
            'longitude' => 107.6098,
            'recorded_at' => now()->toIso8601String(),
        ];
    }

    public function triggerEmergencyAlert(string $gpsTrackerRef): bool
    {
        return true;
    }
}
