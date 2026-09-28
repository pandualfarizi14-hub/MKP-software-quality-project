<?php

namespace App\Services;

use App\Jobs\ProcessOcrVerificationJob;
use App\Jobs\ProcessRiskScoringJob;
use App\Models\Customer;
use App\Models\User;
use App\Models\VerificationDocument;

// Verifikasi Identitas (dual-OCR) & Scoring Risiko - lihat Rental PRD.md bagian 4.
class VerificationService
{
    public function submitDocument(VerificationDocument $document): void
    {
        // dispatchSync supaya hasil OCR langsung tersedia untuk halaman verify (tidak
        // menunggu worker queue) - kalau Horizon/queue worker sudah jalan, job ini tetap
        // aman dipanggil sinkron karena logikanya idempotent per dokumen.
        ProcessOcrVerificationJob::dispatchSync($document);
    }

    public function requestRiskCheck(Customer $customer, User $consentedBy): void
    {
        // Consent WAJIB dicatat sebelum data dikirim ke API scraper - lihat Rental PRD.md bagian 6.
        $customer->consentLogs()->create([
            'purpose' => 'Verifikasi risiko via API scraper',
            'consented_by' => $consentedBy->id,
            'consented_at' => now(),
        ]);

        ProcessRiskScoringJob::dispatchSync($customer);
    }

    /**
     * Hapus jejak verifikasi sebelumnya (dokumen, temuan OCR, & snapshot risiko di customer)
     * supaya staff bisa mengulang proses upload dari awal ("Verifikasi Ulang" di wireframe 09).
     */
    public function resetVerification(Customer $customer): void
    {
        foreach ($customer->verificationDocuments as $document) {
            $document->findings()->delete();
            $document->clearMediaCollection('ktp');
            $document->clearMediaCollection('selfie');
            $document->delete();
        }

        $customer->update([
            'status_verifikasi' => RiskPolicyService::STATUS_BELUM,
            'risk_score' => null,
            'risk_findings' => null,
            'verified_at' => null,
        ]);
    }
}
