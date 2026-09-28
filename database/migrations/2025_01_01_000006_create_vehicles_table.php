<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Sesuai ERD-Database-Fase0-1.md - foto kendaraan lewat media library (bukan tabel terpisah)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('slug');
            $table->string('type');
            $table->string('plate_number');
            $table->enum('status', ['tersedia', 'disewa', 'servis'])->default('tersedia');
            $table->decimal('price_per_day', 12, 2)->nullable();
            $table->decimal('price_per_week', 12, 2)->nullable();
            $table->decimal('price_per_month', 12, 2)->nullable();
            $table->string('gps_tracker_ref')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'plate_number']);
            $table->unique(['tenant_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
