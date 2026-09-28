<?php

namespace App\Repositories\Fallback;

use App\Repositories\Contracts\RiskScraperInterface;

// Implementasi fallback (mock) - aktif secara default (SCRAPER_MODE=mock).
// Format request/response API scraper asli belum tersedia dari klien
// (lihat RiskScraperInterface & Rental PRD.md bagian 10 - Item Terbuka #1),
// jadi kelas ini men-generate temuan contoh yang deterministik per customer
// (nama+telepon) supaya tampilan 09-tenant-customer-verify.html bervariasi
// realistis selama demo, tanpa efek samping ke random generator global lain.
class MockRiskScraper implements RiskScraperInterface
{
    private array $findingPool = [
        [
            'source' => 'Bank Nusantara Sejahtera',
            'description' => 'Tunggakan kartu kredit aktif sejak Feb 2026, belum lunas.',
            'severity' => 'tinggi',
            'point' => -30,
        ],
        [
            'source' => 'AplikasiBayarNanti (Paylater)',
            'description' => 'Cicilan belum dibayar > 3 bulan, nominal Rp3.240.000.',
            'severity' => 'sedang',
            'point' => -15,
        ],
        [
            'source' => 'PinjolCepat.id',
            'description' => 'Pinjaman aktif, status pembayaran lancar sejauh ini.',
            'severity' => 'rendah',
            'point' => -8,
        ],
        [
            'source' => 'Marketplace Terverifikasi',
            'description' => 'Riwayat transaksi baik, tidak ada keluhan tercatat.',
            'severity' => 'rendah',
            'point' => -2,
        ],
    ];

    public function check(array $customerData): array
    {
        $seed = crc32(($customerData['name'] ?? 'guest').'|'.($customerData['phone'] ?? ''));
        $randomizer = new \Random\Randomizer(new \Random\Engine\Mt19937($seed));

        $count = $randomizer->getInt(0, 3);
        $keys = $count > 0 ? $randomizer->pickArrayKeys($this->findingPool, $count) : [];

        $findings = array_values(array_map(fn ($key) => $this->findingPool[$key], $keys));

        $deduction = array_sum(array_column($findings, 'point'));
        $score = max(5, min(100, 100 + $deduction));

        return [
            'score' => $score,
            'findings' => $findings,
            'source' => 'fallback',
        ];
    }
}
