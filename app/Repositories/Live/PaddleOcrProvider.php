<?php

namespace App\Repositories\Live;

use App\Repositories\Contracts\OcrProviderInterface;

// Diaktifkan saat OCR_MODE=live. Menunggu kredensial OCR_PADDLEOCR_KEY - lihat Rental PRD.md bagian 10.
class PaddleOcrProvider implements OcrProviderInterface
{
    public function extract(string $documentPath): array
    {
        // TODO: panggil API PaddleOCR sesuai dokumentasi resmi begitu kredensial tersedia.
        throw new \RuntimeException('PaddleOcrProvider belum diimplementasikan - menunggu kredensial API.');
    }
}
