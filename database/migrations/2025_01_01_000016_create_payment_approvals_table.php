<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Approval wajib dari role berbeda dari yang input payment - divalidasi di app/Services/PaymentService.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_approvals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignUuid('approved_by')->constrained('users')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('approved_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_approvals');
    }
};
