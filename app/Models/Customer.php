<?php

namespace App\Models;

use App\Services\RiskPolicyService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Lihat wireframe 08-tenant-customers-list.html (daftar) & 09-tenant-customer-verify.html (verifikasi).
class Customer extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'name', 'phone', 'address',
        'nik', 'date_of_birth', 'gender',
        'status_verifikasi', 'risk_score', 'risk_findings', 'verified_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'risk_findings' => 'array',
        'verified_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function verificationDocuments()
    {
        return $this->hasMany(VerificationDocument::class)->latest();
    }

    public function latestVerificationDocument()
    {
        return $this->hasOne(VerificationDocument::class)->latestOfMany();
    }

    public function consentLogs()
    {
        return $this->hasMany(ConsentLog::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // "3273••••8021" - NIK ditampilkan tersamar di daftar customer.
    public function getMaskedNikAttribute(): ?string
    {
        if (! $this->nik || strlen($this->nik) < 8) {
            return $this->nik;
        }

        return substr($this->nik, 0, 4).'••••'.substr($this->nik, -4);
    }

    public function riskBand(): ?string
    {
        return RiskPolicyService::band($this->risk_score);
    }

    public function statusBadge(): array
    {
        return RiskPolicyService::statusBadge($this->status_verifikasi ?? RiskPolicyService::STATUS_BELUM);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('nik', 'like', "%{$term}%");
        });
    }

    public function scopeRiskFilter(Builder $query, ?string $filter): Builder
    {
        return match ($filter) {
            'low' => $query->where('risk_score', '>=', 80),
            'medium' => $query->whereBetween('risk_score', [50, 79]),
            'high' => $query->where('status_verifikasi', RiskPolicyService::STATUS_PERLU_PERHATIAN),
            'blacklist' => $query->where('status_verifikasi', RiskPolicyService::STATUS_BLACKLIST),
            default => $query,
        };
    }
}
