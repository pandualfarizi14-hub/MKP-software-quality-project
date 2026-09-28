<?php

namespace App\Repositories\Fallback;

use App\Repositories\Contracts\OcrProviderInterface;

// Implementasi fallback (mock) - aktif secara default (OCR_MODE=mock).
// Lihat Sprint-Plan-8-Minggu.md - Pola Fallback.
//
// NIK/tanggal lahir/jenis kelamin/alamat dibuat deterministik dari path dokumen
// supaya tampilan demo (09-tenant-customer-verify.html) tidak selalu identik untuk
// setiap customer selama OCR_MODE masih "mock". Saat OCR_MODE=live, provider asli
// (Live\VeryHubOcrProvider / Live\PaddleOcrProvider) yang dipakai, bukan kelas ini.
class MockOcrProvider implements OcrProviderInterface
{
    public function extract(string $documentPath): array
    {
        $seed = crc32($documentPath ?: 'fallback-seed');
        $randomizer = new \Random\Randomizer(new \Random\Engine\Mt19937($seed));

        $nik = sprintf(
            '32%02d%02d%04d%04d',
            $randomizer->getInt(1, 32),
            $randomizer->getInt(1, 12),
            $randomizer->getInt(1970, 2005),
            $randomizer->getInt(1, 9999)
        );

        $birthYear = (int) substr($nik, 8, 4);

        return [
            'name' => null, // diisi dari nama customer terkait oleh VerificationService/Livewire
            'nik' => $nik,
            'date_of_birth' => sprintf('%04d-%02d-%02d', $birthYear, $randomizer->getInt(1, 12), $randomizer->getInt(1, 28)),
            'gender' => $randomizer->getInt(0, 1) === 0 ? 'Laki-laki' : 'Perempuan',
            'address' => null, // diisi dari alamat customer bila tersedia
            'confidence' => round($randomizer->getInt(9200, 9800) / 100, 2),
            'raw' => ['source' => 'fallback', 'document_path' => $documentPath],
        ];
    }
}
