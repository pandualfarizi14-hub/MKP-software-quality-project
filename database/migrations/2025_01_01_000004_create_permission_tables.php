<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration ini dipublish dari paket spatie/laravel-permission
// (php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider")
// lalu disesuaikan: kolom team_id (tenant_id) diaktifkan karena config('permission.teams') = true.
// Ini yang membuat role-builder custom per tenant (wireframe 07-tenant-staff-roles) terisolasi
// tanpa perlu bangun sistem RBAC dari nol. Lihat Environment-Setup-Guide.md bagian 4.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete(); // team_foreign_key
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->foreignUuid('permission_id')->constrained()->cascadeOnDelete();
            $table->uuidMorphs('model');
            $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete();
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->foreignUuid('role_id')->constrained()->cascadeOnDelete();
            $table->uuidMorphs('model');
            $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete();
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->foreignUuid('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('role_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};
