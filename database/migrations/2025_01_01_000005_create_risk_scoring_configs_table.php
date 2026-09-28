<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Konfigurasi global untuk Verifikasi & Scoring Risiko, dikelola Superadmin.
// Sesuai wireframe 05-superadmin-risk-scoring-config.html.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_scoring_configs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key'); // mis. "score_threshold_review"
            $table->string('value');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_scoring_configs');
    }
};
