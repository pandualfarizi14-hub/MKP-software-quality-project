<?php

namespace App\Repositories\Contracts;

// Kontrak untuk pemanggilan API OCR (VeryHub / PaddleOCR).
// Implementasi: Fallback\MockOcrProvider (default) atau Live\VeryHubOcrProvider / Live\PaddleOcrProvider.
// Pemilihan implementasi lewat binding di AppServiceProvider berdasarkan env OCR_MODE.
// Lihat Sprint-Plan-8-Minggu.md - Prinsip Pengerjaan Modul Bergantung API Eksternal (Pola Fallback).
interface OcrProviderInterface
{
    /**
     * @param  string  $documentPath  path file dokumen (KTP/SIM) yang akan diproses
     * @return array{name: ?string, nik: ?string, date_of_birth: ?string, gender: ?string, address: ?string, confidence: ?float, raw: array}
     */
    public function extract(string $documentPath): array;
}
