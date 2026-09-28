<?php

namespace App\Repositories\Contracts;

// Kontrak untuk API scraper risiko. Format request/response final menunggu contoh dari klien
// (lihat Rental PRD.md bagian 10 - Item Terbuka #1). Interface ini didesain generik dulu
// supaya tidak perlu menunggu detail API untuk mulai coding.
interface RiskScraperInterface
{
    /**
     * @param  array  $customerData  data customer hasil verifikasi identitas (NIK, nama, dll)
     * @return array{score: int, findings: array}
     */
    public function check(array $customerData): array;
}
