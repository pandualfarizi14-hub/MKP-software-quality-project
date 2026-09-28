<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Dual-OCR (VeryHub + PaddleOCR) & Scoring Risiko (API scraper) - lihat Rental PRD.md bagian 3 & 4
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_findings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('verification_document_id')->constrained('verification_documents')->cascadeOnDelete();
            $table->enum('ocr_provider', ['veryhub', 'paddleocr']);
            $table->enum('ocr_data_source', ['fallback', 'live'])->default('fallback');
            $table->json('extracted_data')->nullable();
            $table->json('reconciled_data')->nullable();
            $table->boolean('has_discrepancy')->default(false);
            $table->unsignedTinyInteger('risk_score')->nullable();
            $table->enum('risk_data_source', ['fallback', 'live'])->nullable();
            $table->foreignUuid('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_findings');
    }
};
