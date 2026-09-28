<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Menambahkan kolom "snapshot" hasil verifikasi identitas & skor risiko ke customers,
// supaya halaman daftar customer (08-tenant-customers-list.html) tidak perlu join berat
// ke verification_findings setiap kali menampilkan tabel. Audit trail lengkap tetap
// tersimpan di verification_documents / verification_findings.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('nik', 32)->nullable()->after('address');
            $table->date('date_of_birth')->nullable()->after('nik');
            $table->string('gender')->nullable()->after('date_of_birth');

            $table->string('status_verifikasi')
                ->default('belum_verifikasi')
                ->after('gender'); // belum_verifikasi | terverifikasi | perlu_perhatian | blacklist

            $table->unsignedTinyInteger('risk_score')->nullable()->after('status_verifikasi');
            $table->json('risk_findings')->nullable()->after('risk_score');
            $table->timestamp('verified_at')->nullable()->after('risk_findings');

            $table->index('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['status_verifikasi']);
            $table->dropColumn([
                'nik', 'date_of_birth', 'gender', 'status_verifikasi',
                'risk_score', 'risk_findings', 'verified_at',
            ]);
        });
    }
};
