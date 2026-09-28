<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// API Publik - scope hanya data tenant & kendaraan, TIDAK ADA scope untuk data staff.
// Dikelola lewat laravel/sanctum - lihat Rental PRD.md bagian 3 & 9 (Decision Log #9).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->json('scopes'); // mis. ["read:bookings","read:vehicles"] - tidak ada "read:staff"
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
