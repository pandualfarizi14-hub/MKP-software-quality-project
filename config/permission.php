<?php

// Konfigurasi spatie/laravel-permission. 'teams' diaktifkan supaya role-builder custom
// per tenant (wireframe 07-tenant-staff-roles) terisolasi antar tenant.
// Lihat Environment-Setup-Guide.md bagian 4 & ERD-Database-Fase0-1.md bagian 2.
return [
    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],

    'teams' => true,
    'team_foreign_key' => 'tenant_id',

    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],
];
