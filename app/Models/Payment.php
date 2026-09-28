<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// Bukti bayar via media library (collection: 'payment_proof')
class Payment extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    protected $fillable = ['booking_id', 'amount', 'method', 'status', 'created_by'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approval()
    {
        return $this->hasOne(PaymentApproval::class);
    }
}
