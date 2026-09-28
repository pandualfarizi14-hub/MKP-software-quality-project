<?php

namespace App\Repositories\Live;

use App\Repositories\Contracts\GpsProviderInterface;

// Diaktifkan saat GPS_MODE=live. Menunggu format akses data GPS per tenant
// - lihat Rental PRD.md bagian 10, Item Terbuka #2.
class TenantGpsProvider implements GpsProviderInterface
{
    public function getCurrentLocation(string $gpsTrackerRef): ?array
    {
        // TODO: sambungkan ke API/data GPS milik tenant begitu formatnya dikonfirmasi.
        throw new \RuntimeException('TenantGpsProvider belum diimplementasikan - menunggu format data dari tenant.');
    }

    public function triggerEmergencyAlert(string $gpsTrackerRef): bool
    {
        throw new \RuntimeException('TenantGpsProvider belum diimplementasikan - menunggu format data dari tenant.');
    }
}
