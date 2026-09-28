<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// Generate laporan (Dashboard Admin) via maatwebsite/excel - dijalankan async.
class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $tenantId, public string $reportType)
    {
    }

    public function handle(): void
    {
        // TODO: build laporan via maatwebsite/excel sesuai $reportType, simpan/kirim hasilnya.
    }
}
