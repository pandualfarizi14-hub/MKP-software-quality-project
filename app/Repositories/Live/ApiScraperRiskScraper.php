<?php

namespace App\Repositories\Live;

use App\Repositories\Contracts\RiskScraperInterface;

// Diaktifkan saat SCRAPER_MODE=live. Menunggu contoh format request/response dari klien
// - lihat Rental PRD.md bagian 10, Item Terbuka #1.
class ApiScraperRiskScraper implements RiskScraperInterface
{
    public function check(array $customerData): array
    {
        // TODO: sesuaikan dengan format API scraper asli begitu contoh diberikan.
        throw new \RuntimeException('ApiScraperRiskScraper belum diimplementasikan - menunggu format API dari klien.');
    }
}
