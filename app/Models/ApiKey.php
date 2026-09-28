<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

// Scope hanya data tenant & kendaraan - TIDAK ADA scope untuk data staff.
// Lihat Rental PRD.md bagian 3 & Decision Log #9.
class ApiKey extends Model
{
    use HasUuids;

    protected $fillable = ['tenant_id', 'name', 'scopes', 'last_used_at', 'revoked_at'];

    protected $casts = [
        'scopes' => 'array',
        'last_used_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
