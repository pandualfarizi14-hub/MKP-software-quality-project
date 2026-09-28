<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;

class RolePermissionService
{
    public const SUPERADMIN_ROLE = 'Superadmin';

    public const TENANT_OWNER_ROLE = 'Pemilik Tenant';

    public const TENANT_STAFF_ROLE = 'Staff';

    public const ACCESS_SUPERADMIN = 'access-superadmin';

    public const ACCESS_TENANT_DASHBOARD = 'access-tenant-dashboard';

    public function ensureSuperadminRole(): Role
    {
        setPermissionsTeamId(null);

        try {
            $role = Role::firstOrCreate([
                'tenant_id' => null,
                'name' => self::SUPERADMIN_ROLE,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions(
                Permission::where('name', '!=', self::ACCESS_TENANT_DASHBOARD)->get()
            );

            return $role;
        } finally {
            setPermissionsTeamId(null);
        }
    }

    /** @return array{owner: Role, staff: Role} */
    public function ensureTenantRoles(Tenant $tenant): array
    {
        setPermissionsTeamId($tenant->id);

        try {
            $owner = Role::firstOrCreate([
                'tenant_id' => $tenant->id,
                'name' => self::TENANT_OWNER_ROLE,
                'guard_name' => 'web',
            ]);
            $owner->syncPermissions(
                Permission::where('name', '!=', self::ACCESS_SUPERADMIN)->get()
            );

            $staff = Role::firstOrCreate([
                'tenant_id' => $tenant->id,
                'name' => self::TENANT_STAFF_ROLE,
                'guard_name' => 'web',
            ]);
            $staff->syncPermissions([
                self::ACCESS_TENANT_DASHBOARD,
                'vehicle.view',
                'customer.view',
                'customer.create',
                'booking.view',
                'booking.create',
            ]);

            return ['owner' => $owner, 'staff' => $staff];
        } finally {
            setPermissionsTeamId(null);
        }
    }

    public function assignTenantRole(User $user, Tenant $tenant, Role|string $role): void
    {
        setPermissionsTeamId($tenant->id);

        try {
            $user->assignRole($role);
        } finally {
            setPermissionsTeamId(null);
        }
    }
}
