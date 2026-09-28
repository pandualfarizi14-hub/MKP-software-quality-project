<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Menyimpan skor keyakinan (confidence) masing-masing provider OCR
// (VeryHub / PaddleOCR) - dipakai di 09-tenant-customer-verify.html bagian "Hasil OCR".
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('verification_findings', function (Blueprint $table) {
            $table->decimal('confidence', 5, 2)->nullable()->after('ocr_provider');
        });
    }

    public function down(): void
    {
        Schema::table('verification_findings', function (Blueprint $table) {
            $table->dropColumn('confidence');
        });
    }
};
