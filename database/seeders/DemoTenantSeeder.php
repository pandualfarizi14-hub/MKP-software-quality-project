<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\VerificationService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

// 1 tenant dummy, role default (Pemilik Tenant, Staff), beberapa kendaraan dummy,
// & beberapa customer contoh (08-tenant-customers-list.html / 09-tenant-customer-verify.html).
// Guest login credentials TIDAK dihardcode di sini - lihat .env.example (GUEST_LOGIN_EMAIL/PASSWORD).
class DemoTenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create([
            'name' => 'Tenant Demo',
            'email' => 'demo@example.com',
            'status' => 'active',
        ]);

        setPermissionsTeamId($tenant->id);

        $ownerRole = Role::firstOrCreate(['name' => 'Pemilik Tenant', 'guard_name' => 'web', 'tenant_id' => $tenant->id]);
        $ownerRole->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $staffRole = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web', 'tenant_id' => $tenant->id]);
        $staffRole->syncPermissions(['vehicle.view', 'customer.view', 'customer.create', 'booking.view', 'booking.create']);

        $owner = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Demo Owner',
            'email' => config('services.guest_login.email', env('GUEST_LOGIN_EMAIL', 'guest@example.com')),
            'password' => bcrypt(env('GUEST_LOGIN_PASSWORD', 'change-me-locally')),
        ]);
        $owner->assignRole($ownerRole);

        foreach (['Motor', 'Mobil', 'Motor'] as $i => $type) {
            Vehicle::create([
                'tenant_id' => $tenant->id,
                'type' => $type,
                'plate_number' => 'D 1234 A'.$i,
                'status' => 'tersedia',
                'price_per_day' => 100000,
            ]);
        }

        $this->seedCustomers($tenant, $owner);
    }

    /**
     * Contoh data customer - mengikuti nama-nama pada wireframe
     * 08-tenant-customers-list.html. Skor risiko & status dihasilkan lewat
     * pipeline verifikasi asli (VerificationService), bukan di-hardcode,
     * supaya konsisten dengan alur "Tambah Customer" -> "Verifikasi" yang
     * dipakai staff sungguhan.
     */
    private function seedCustomers(Tenant $tenant, User $owner): void
    {
        $customers = [
            ['name' => 'Rina Wulandari', 'phone' => '081234550021', 'verify' => true],
            ['name' => 'Ahmad Fauzan', 'phone' => '081234550058', 'verify' => true],
            ['name' => 'Fajar Nugroho', 'phone' => '081234550143', 'verify' => true],
            ['name' => 'Hendra Wijaya', 'phone' => '081234550205', 'verify' => true],
            ['name' => 'Dewi Anggraini', 'phone' => '081234550063', 'verify' => true],
            ['name' => 'Siti Rahmawati', 'phone' => '081234550099', 'verify' => false],
        ];

        $verificationService = app(VerificationService::class);

        foreach ($customers as $data) {
            $customer = Customer::create([
                'tenant_id' => $tenant->id,
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]);

            if (! $data['verify']) {
                continue; // biarkan berstatus "Belum Verifikasi" sebagai contoh
            }

            $document = $customer->verificationDocuments()->create(['document_type' => 'ktp']);

            $verificationService->submitDocument($document);
            $verificationService->requestRiskCheck($customer->fresh(), $owner);
        }
    }
}
