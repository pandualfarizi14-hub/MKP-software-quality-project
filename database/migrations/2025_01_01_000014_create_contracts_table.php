<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// PDF kontrak, tanda tangan, & foto kondisi lewat media library (collection: contract_pdf, signature,
// condition_before, condition_after) - lihat ERD-Database-Fase0-1.md
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('booking_id')->unique()->constrained('bookings')->cascadeOnDelete();
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
