<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;

// Manajemen Tenant - lihat Rental PRD.md bagian 4.
class TenantService
{
    public function createTenant(array $data): Tenant
    {
        $tenant = Tenant::create($data);

        // Akun Pemilik Tenant otomatis dibuat saat tenant baru dibuat.
        User::create([
            'tenant_id' => $tenant->id,
            'name' => $data['owner_name'] ?? $data['name'].' Owner',
            'email' => $data['owner_email'] ?? $data['email'],
            'password' => bcrypt(str()->random(16)), // TODO: kirim link set password, bukan random tanpa notifikasi
        ]);

        return $tenant;
    }
}
