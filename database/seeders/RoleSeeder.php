<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use App\Services\RolePermissionService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class RoleSeeder extends Seeder
{
    public function run(RolePermissionService $roles): void
    {
        $superadminRole = $roles->ensureSuperadminRole();

        Tenant::query()->each(fn (Tenant $tenant) => $roles->ensureTenantRoles($tenant));

        $email = config('services.superadmin.email');
        $password = config('services.superadmin.password');

        if (! $email || ! $password) {
            $this->command?->warn('Superadmin user dilewati. Isi SUPERADMIN_EMAIL dan SUPERADMIN_PASSWORD untuk membuatnya.');

            return;
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'tenant_id' => null,
                'name' => config('services.superadmin.name', 'Superadmin'),
                'password' => Hash::make($password),
            ]
        );

        if (! $user->isSuperadmin()) {
            throw new RuntimeException('SUPERADMIN_EMAIL sudah digunakan oleh user tenant.');
        }

        setPermissionsTeamId(null);
        $user->assignRole($superadminRole);
    }
}
