<?php

namespace App\Services;

// Aturan turunan skor risiko -> band, status verifikasi, dan kebijakan booking.
// Ambang batas mengikuti contoh data di wireframe 08 (list) & 09 (verify):
//   - skor >= 80           -> band "low"    (hijau)
//   - 50 <= skor < 80      -> band "medium" (kuning)
//   - 30 <= skor < 50      -> band "high"   (merah) -> status "perlu_perhatian"
//   - skor < 30            -> band "high"   (merah) -> status "blacklist"
// Catatan: threshold ini adalah aturan bisnis awal (belum dikonfirmasi klien),
// sebaiknya nanti dipindah ke tabel risk_scoring_configs (lihat RiskScoringConfig model)
// supaya bisa diatur Superadmin tanpa perlu deploy ulang kode.
class RiskPolicyService
{
    public const BAND_LOW = 'low';

    public const BAND_MEDIUM = 'medium';

    public const BAND_HIGH = 'high';

    public const STATUS_BELUM = 'belum_verifikasi';

    public const STATUS_TERVERIFIKASI = 'terverifikasi';

    public const STATUS_PERLU_PERHATIAN = 'perlu_perhatian';

    public const STATUS_BLACKLIST = 'blacklist';

    public static function band(?int $score): ?string
    {
        if ($score === null) {
            return null;
        }

        return match (true) {
            $score >= 80 => self::BAND_LOW,
            $score >= 50 => self::BAND_MEDIUM,
            default => self::BAND_HIGH,
        };
    }

    public static function statusFromScore(?int $score): string
    {
        if ($score === null) {
            return self::STATUS_BELUM;
        }

        return match (true) {
            $score < 30 => self::STATUS_BLACKLIST,
            $score < 50 => self::STATUS_PERLU_PERHATIAN,
            default => self::STATUS_TERVERIFIKASI,
        };
    }

    /**
     * Label & warna badge status verifikasi (dipakai di tabel customer & halaman verify).
     *
     * @return array{label: string, classes: string, dot: string}
     */
    public static function statusBadge(string $status): array
    {
        return match ($status) {
            self::STATUS_TERVERIFIKASI => [
                'label' => 'Terverifikasi',
                'classes' => 'bg-emerald-50 text-emerald-700',
                'dot' => 'bg-emerald-500',
            ],
            self::STATUS_PERLU_PERHATIAN => [
                'label' => 'Perlu Perhatian',
                'classes' => 'bg-amber-50 text-amber-700',
                'dot' => 'bg-amber-500',
            ],
            self::STATUS_BLACKLIST => [
                'label' => 'Blacklist',
                'classes' => 'bg-rose-50 text-rose-700',
                'dot' => 'bg-rose-500',
            ],
            default => [
                'label' => 'Belum Verifikasi',
                'classes' => 'bg-slate-100 text-slate-500',
                'dot' => 'bg-slate-400',
            ],
        };
    }

    /**
     * Badge skor risiko besar di halaman verify ("● High Risk").
     *
     * @return array{label: string, classes: string, dot: string}
     */
    public static function scoreBadge(?int $score, string $status): array
    {
        if ($status === self::STATUS_BLACKLIST) {
            return ['label' => 'Blacklist', 'classes' => 'bg-rose-50 text-rose-700', 'dot' => 'bg-rose-500'];
        }

        return match (self::band($score)) {
            self::BAND_LOW => ['label' => 'Low Risk', 'classes' => 'bg-emerald-50 text-emerald-700', 'dot' => 'bg-emerald-500'],
            self::BAND_MEDIUM => ['label' => 'Medium Risk', 'classes' => 'bg-amber-50 text-amber-700', 'dot' => 'bg-amber-500'],
            self::BAND_HIGH => ['label' => 'High Risk', 'classes' => 'bg-rose-50 text-rose-700', 'dot' => 'bg-rose-500'],
            default => ['label' => 'Belum Dinilai', 'classes' => 'bg-slate-100 text-slate-500', 'dot' => 'bg-slate-400'],
        };
    }

    /**
     * Kebijakan booking yang berlaku untuk band risiko tertentu
     * ("Kebijakan Diterapkan" di wireframe 09-tenant-customer-verify.html).
     *
     * @return array{deposit: string, dokumen_wajib: string, maks_durasi: string, approval: string, warning: ?string}
     */
    public static function policy(string $status): array
    {
        return match ($status) {
            self::STATUS_BLACKLIST => [
                'deposit' => '—',
                'dokumen_wajib' => '—',
                'maks_durasi' => '—',
                'approval' => 'Ditolak otomatis',
                'warning' => 'Customer ini masuk daftar blacklist. Booking baru tidak dapat diproses.',
            ],
            self::STATUS_PERLU_PERHATIAN => [
                'deposit' => '2.0x harga sewa',
                'dokumen_wajib' => 'KTP asli dibutuhkan, SIM, KK',
                'maks_durasi' => '3 hari',
                'approval' => 'Pemilik Tenant',
                'warning' => 'Booking untuk customer ini butuh persetujuan Pemilik Tenant sebelum bisa dilanjutkan.',
            ],
            self::STATUS_TERVERIFIKASI => [
                'deposit' => '1.0x harga sewa',
                'dokumen_wajib' => 'KTP asli',
                'maks_durasi' => '14 hari',
                'approval' => 'Staff (otomatis)',
                'warning' => null,
            ],
            default => [
                'deposit' => 'Belum ditentukan',
                'dokumen_wajib' => 'KTP asli',
                'maks_durasi' => '—',
                'approval' => 'Menunggu verifikasi',
                'warning' => 'Selesaikan verifikasi identitas untuk mengaktifkan kebijakan booking customer ini.',
            ],
        };
    }
}
