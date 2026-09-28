<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Seeder Minggu 1 - lihat Environment-Setup-Guide.md bagian 7.
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            DemoTenantSeeder::class,
        ]);
    }
}
