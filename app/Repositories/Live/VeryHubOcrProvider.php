<?php

namespace App\Repositories\Live;

use App\Repositories\Contracts\OcrProviderInterface;
use Illuminate\Support\Facades\Http;

// Diaktifkan saat OCR_MODE=live. Menunggu kredensial OCR_VERYHUB_KEY - lihat Rental PRD.md bagian 10.
class VeryHubOcrProvider implements OcrProviderInterface
{
    public function extract(string $documentPath): array
    {
        // TODO: panggil API VeryHub sesuai dokumentasi resmi begitu kredensial tersedia.
        // $response = Http::withToken(config('services.veryhub.key'))->post(...);
        throw new \RuntimeException('VeryHubOcrProvider belum diimplementasikan - menunggu kredensial API.');
    }
}
