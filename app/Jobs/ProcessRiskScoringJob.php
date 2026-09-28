<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Repositories\Contracts\RiskScraperInterface;
use App\Services\RiskPolicyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// Verifikasi & Scoring Risiko via API scraper - human review wajib, tidak auto-block.
// Lihat Rental PRD.md bagian 4 & 6. Skor & status hasil scraper disimpan sebagai
// snapshot di profil customer supaya daftar customer (08-tenant-customers-list.html)
// dan panel risiko di halaman verify (09-tenant-customer-verify.html) bisa langsung
// dibaca tanpa query ulang ke sumber eksternal setiap saat.
class ProcessRiskScoringJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Customer $customer)
    {
    }

    public function handle(RiskScraperInterface $scraper): void
    {
        // Consent log harus sudah tercatat sebelum job ini dijalankan - lihat ConsentLog model
        // & VerificationService::requestRiskCheck().
        $result = $scraper->check($this->customer->only(['name', 'phone']));

        $score = (int) $result['score'];
        $status = RiskPolicyService::statusFromScore($score);

        // Human review tetap wajib untuk kasus "perlu_perhatian"/"blacklist" - staff meninjau
        // lewat tombol "Simpan sebagai Customer" / "Verifikasi Ulang" di halaman verify,
        // sistem tidak pernah menolak booking secara otomatis tanpa keterlibatan manusia.
        $this->customer->update([
            'risk_score' => $score,
            'risk_findings' => $result['findings'],
            'status_verifikasi' => $status,
            'verified_at' => now(),
        ]);
    }
}
