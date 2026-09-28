<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

// Hasil dual-OCR (VeryHub + PaddleOCR) & scoring risiko (API scraper) - lihat Rental PRD.md
class VerificationFinding extends Model
{
    use HasUuids;

    protected $fillable = [
        'verification_document_id', 'ocr_provider', 'ocr_data_source', 'confidence',
        'extracted_data', 'reconciled_data', 'has_discrepancy',
        'risk_score', 'risk_data_source', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'extracted_data' => 'array',
        'reconciled_data' => 'array',
        'has_discrepancy' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function document()
    {
        return $this->belongsTo(VerificationDocument::class, 'verification_document_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
