<?php

namespace App\Console;

use App\Jobs\SyncVehicleLocationJob;
use App\Models\Vehicle;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Task Scheduler bawaan Laravel - satu baris cron di server:
// * * * * * php artisan schedule:run >> /dev/null 2>&1
// Lihat Rental PRD.md bagian 5.1 & Environment-Setup-Guide.md bagian 8.
class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Sinkronisasi posisi GPS kendaraan yang sedang disewa
        $schedule->call(function () {
            Vehicle::where('status', 'disewa')->whereNotNull('gps_tracker_ref')->each(
                fn (Vehicle $vehicle) => SyncVehicleLocationJob::dispatch($vehicle)
            );
        })->everyFiveMinutes();

        // Cek tenant yang langganannya jatuh tempo -> auto-suspend
        $schedule->call(function () {
            // TODO: implementasikan pengecekan jatuh tempo paket langganan tenant.
        })->daily();

        // Tandai booking yang overdue (belum dikembalikan setelah end_date)
        $schedule->call(function () {
            // TODO: implementasikan penandaan booking overdue.
        })->daily();

        // Bersihkan job queue yang gagal secara berkala
        $schedule->command('queue:prune-failed --hours=48')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
