<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

// Permission dasar per modul - detail lengkap menunggu Item Terbuka #3 di Rental PRD.md.
class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = ['tenant', 'vehicle', 'customer', 'verification', 'booking', 'contract', 'payment', 'dashboard'];
        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$module}.{$action}", 'guard_name' => 'web']);
            }
        }

        Permission::firstOrCreate(['name' => 'payment.approve', 'guard_name' => 'web']);
    }
}
