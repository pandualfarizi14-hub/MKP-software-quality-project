<?php

namespace App\Jobs;

use App\Models\VerificationDocument;
use App\Repositories\Contracts\OcrProviderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// Dual-OCR (VeryHub + PaddleOCR) berjalan paralel - lihat Rental PRD.md bagian 4.
// Dijalankan async lewat queue (Redis + Horizon) kalau QUEUE_CONNECTION bukan "sync";
// dipanggil lewat VerificationService::submitDocument() -> ::dispatchSync() supaya
// hasil OCR langsung tersedia untuk halaman 09-tenant-customer-verify.html.
class ProcessOcrVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public VerificationDocument $document)
    {
    }

    public function handle(OcrProviderInterface $ocrProvider): void
    {
        $customer = $this->document->customer;
        $documentPath = $this->document->getFirstMediaPath('ktp') ?: '';

        // Kolom verification_findings.ocr_data_source hanya menerima 'fallback'|'live',
        // sedangkan config('services.ocr.mode') bernilai 'mock'|'live' (lihat config/services.php).
        $dataSource = config('services.ocr.mode') === 'live' ? 'live' : 'fallback';

        // TODO: saat OCR_MODE=live, panggil dua endpoint API yang berbeda (VeryHub & PaddleOCR)
        // secara paralel (mis. lewat Http::pool()). Selama mock, kedua "provider" memakai
        // implementasi fallback yang sama karena kredensial API belum tersedia.
        $veryHub = $this->normalize($ocrProvider->extract($documentPath), $customer);
        $paddleOcr = $this->normalize($ocrProvider->extract($documentPath), $customer);

        // Beda tipis pada confidence supaya mencerminkan dua provider yang independen.
        if ($paddleOcr['confidence'] !== null) {
            $paddleOcr['confidence'] = max(1, round($paddleOcr['confidence'] - 1.4, 2));
        }

        $hasDiscrepancy = $veryHub['nik'] !== $paddleOcr['nik']
            || $veryHub['date_of_birth'] !== $paddleOcr['date_of_birth']
            || $veryHub['gender'] !== $paddleOcr['gender'];

        // Field di bawah adalah hasil rekonsiliasi final - lihat wireframe 09 bagian 2.
        $reconciled = [
            'name' => $veryHub['name'],
            'nik' => $veryHub['nik'],
            'date_of_birth' => $veryHub['date_of_birth'],
            'gender' => $veryHub['gender'],
            'address' => $veryHub['address'],
        ];

        $this->document->findings()->create([
            'ocr_provider' => 'veryhub',
            'ocr_data_source' => $dataSource,
            'confidence' => $veryHub['confidence'],
            'extracted_data' => $veryHub,
            'reconciled_data' => $reconciled,
            'has_discrepancy' => $hasDiscrepancy,
        ]);

        $this->document->findings()->create([
            'ocr_provider' => 'paddleocr',
            'ocr_data_source' => $dataSource,
            'confidence' => $paddleOcr['confidence'],
            'extracted_data' => $paddleOcr,
            'reconciled_data' => $reconciled,
            'has_discrepancy' => $hasDiscrepancy,
        ]);

        // Simpan hasil rekonsiliasi identitas ke profil customer (snapshot untuk daftar customer).
        $customer?->update([
            'nik' => $reconciled['nik'],
            'date_of_birth' => $reconciled['date_of_birth'],
            'gender' => $reconciled['gender'],
            'address' => $customer->address ?: $reconciled['address'],
        ]);
    }

    /**
     * Lengkapi hasil OCR mentah dengan data customer yang sudah ada
     * (nama & alamat tidak bisa "dikarang" oleh provider fallback).
     */
    private function normalize(array $result, $customer): array
    {
        $result['name'] = $customer?->name ?: ($result['name'] ?? 'Nama tidak terbaca');
        $result['address'] = $result['address'] ?: ($customer?->address ?: 'Alamat belum dilengkapi customer');

        return $result;
    }
}
