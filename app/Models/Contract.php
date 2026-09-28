<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// PDF, tanda tangan, foto kondisi via media library:
// collection 'contract_pdf', 'signature', 'condition_before', 'condition_after'
class Contract extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    protected $fillable = ['booking_id', 'signed_at', 'returned_at'];

    protected $casts = [
        'signed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
