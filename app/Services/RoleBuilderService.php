<?php

namespace App\Services;

use App\Models\Tenant;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Role-builder custom per tenant - sesuai wireframe 07-tenant-staff-roles & 16-modal-buat-role.
// Memakai fitur "teams" dari spatie/laravel-permission (lihat config/permission.php).
class RoleBuilderService
{
    public function createRole(Tenant $tenant, string $name, array $permissionNames): Role
    {
        setPermissionsTeamId($tenant->id);

        $role = Role::create(['name' => $name, 'guard_name' => 'web', 'tenant_id' => $tenant->id]);
        $role->syncPermissions(Permission::whereIn('name', $permissionNames)->get());

        return $role;
    }

    public function addStaff(Tenant $tenant, array $staffData, string $roleName): void
    {
        setPermissionsTeamId($tenant->id);

        $staff = $tenant->users()->create($staffData);
        $staff->assignRole($roleName);
    }
}
