<?php

namespace App\Repositories\Contracts;

// Kontrak untuk data/API GPS milik tenant (bukan RentAll/Centrental yang membangun infrastrukturnya).
// Format akses per tenant menunggu konfirmasi (lihat Rental PRD.md bagian 10 - Item Terbuka #2).
interface GpsProviderInterface
{
    /**
     * @return array{latitude: float, longitude: float, recorded_at: string}|null
     */
    public function getCurrentLocation(string $gpsTrackerRef): ?array;

    public function triggerEmergencyAlert(string $gpsTrackerRef): bool;
}
