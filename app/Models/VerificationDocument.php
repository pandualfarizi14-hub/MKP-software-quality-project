<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// File fisik KTP & selfie via media library (collection: 'ktp' & 'selfie').
// Lihat wireframe 09-tenant-customer-verify.html bagian "1. Upload Dokumen".
class VerificationDocument extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    protected $fillable = ['customer_id', 'document_type'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ktp')->singleFile();
        $this->addMediaCollection('selfie')->singleFile();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function findings()
    {
        return $this->hasMany(VerificationFinding::class);
    }
}
