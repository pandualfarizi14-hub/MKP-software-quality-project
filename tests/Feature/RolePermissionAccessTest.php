<?php

namespace Tests\Feature;

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Models\Tenant;
use App\Models\User;
use App\Services\RoleBuilderService;
use App\Services\RolePermissionService;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class RolePermissionAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_a_tenant_owner_instead_of_a_superadmin(): void
    {
        $this->seed([PermissionSeeder::class, RoleSeeder::class]);

        Livewire::test(Register::class)
            ->set('tenant_name', 'Rental Yanfa')
            ->set('name', 'Yanfa Owner')
            ->set('email', 'owner@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasNoErrors()
            ->assertRedirect(route('login'));

        $tenant = Tenant::where('name', 'Rental Yanfa')->firstOrFail();
        $user = User::where('email', 'owner@example.com')->firstOrFail();

        $this->assertSame($tenant->id, $user->tenant_id);
        $this->assertFalse($user->isSuperadmin());

        setPermissionsTeamId($tenant->id);
        $this->assertTrue($user->hasRole(RolePermissionService::TENANT_OWNER_ROLE));
        $this->assertTrue($user->can(RolePermissionService::ACCESS_TENANT_DASHBOARD));
        $this->assertFalse($user->can(RolePermissionService::ACCESS_SUPERADMIN));
    }

    public function test_dashboard_routes_are_separated_by_permission(): void
    {
        config()->set('services.superadmin', [
            'name' => 'Platform Admin',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
        ]);
        $this->seed([PermissionSeeder::class, RoleSeeder::class]);

        $superadmin = User::where('email', 'admin@example.com')->firstOrFail();

        $tenant = Tenant::create([
            'name' => 'Tenant Access Test',
            'email' => 'tenant@example.com',
            'status' => 'active',
        ]);
        $owner = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Tenant Owner',
            'email' => 'tenant@example.com',
            'password' => Hash::make('password123'),
        ]);
        $roleService = app(RolePermissionService::class);
        $tenantRoles = $roleService->ensureTenantRoles($tenant);
        $roleService->assignTenantRole($owner, $tenant, $tenantRoles['owner']);

        $this->actingAs($superadmin)
            ->get('/superadmin/dashboard')
            ->assertOk();
        $this->get('/tenant/dashboard')->assertForbidden();

        $this->actingAs($owner)
            ->get('/tenant/dashboard')
            ->assertOk();
        $this->get('/superadmin/dashboard')->assertForbidden();
    }

    public function test_login_redirects_users_to_their_authorized_dashboard(): void
    {
        config()->set('services.superadmin', [
            'name' => 'Platform Admin',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
        ]);
        $this->seed([PermissionSeeder::class, RoleSeeder::class]);
        $this->withSession([]);

        Livewire::test(Login::class)
            ->set('email', 'admin@example.com')
            ->set('password', 'admin-password')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('superadmin.dashboard'));

        auth()->logout();

        $tenant = Tenant::create([
            'name' => 'Tenant Login Test',
            'email' => 'owner@example.com',
            'status' => 'active',
        ]);
        $owner = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Tenant Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password123'),
        ]);
        $roleService = app(RolePermissionService::class);
        $tenantRoles = $roleService->ensureTenantRoles($tenant);
        $roleService->assignTenantRole($owner, $tenant, $tenantRoles['owner']);

        Livewire::test(Login::class)
            ->set('email', 'owner@example.com')
            ->set('password', 'password123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('tenant.dashboard'));
    }

    public function test_role_builder_creates_uuid_role_inside_the_tenant(): void
    {
        $this->seed(PermissionSeeder::class);
        $tenant = Tenant::create([
            'name' => 'Tenant Role Builder',
            'email' => 'roles@example.com',
            'status' => 'active',
        ]);

        $role = app(RoleBuilderService::class)->createRole(
            $tenant,
            'Operator',
            ['vehicle.view']
        );

        $this->assertSame($tenant->id, $role->tenant_id);
        $this->assertMatchesRegularExpression('/^[0-9a-f-]{36}$/', $role->id);

        setPermissionsTeamId($tenant->id);
        $this->assertTrue($role->hasPermissionTo('vehicle.view'));
        setPermissionsTeamId(null);
    }

    public function test_database_seeder_is_idempotent(): void
    {
        config()->set('services.superadmin', [
            'name' => 'Platform Admin',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
        ]);

        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('permissions', 35);
        $this->assertDatabaseCount('roles', 1);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('roles', [
            'tenant_id' => null,
            'name' => RolePermissionService::SUPERADMIN_ROLE,
        ]);
        $this->assertDatabaseHas('users', [
            'tenant_id' => null,
            'email' => 'admin@example.com',
        ]);
    }
}
