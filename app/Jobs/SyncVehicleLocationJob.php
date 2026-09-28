<?php

namespace App\Jobs;

use App\Models\Vehicle;
use App\Repositories\Contracts\GpsProviderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// Tracking Armada (GPS) - dipanggil berkala (lihat routes/console.php untuk penjadwalan).
class SyncVehicleLocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Vehicle $vehicle)
    {
    }

    public function handle(GpsProviderInterface $gps): void
    {
        if (! $this->vehicle->gps_tracker_ref) {
            return;
        }

        $location = $gps->getCurrentLocation($this->vehicle->gps_tracker_ref);

        if ($location) {
            $this->vehicle->locations()->create([
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
                'data_source' => config('services.gps.mode', 'mock'),
                'recorded_at' => $location['recorded_at'],
            ]);
        }
    }
}
