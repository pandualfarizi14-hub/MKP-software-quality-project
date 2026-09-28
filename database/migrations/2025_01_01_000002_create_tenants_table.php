<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Sesuai Rental PRD.md bagian 3 (Manajemen Tenant) & ERD-Database-Fase0-1.md
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique(); // spatie/laravel-sluggable
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignUuid('subscription_plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
