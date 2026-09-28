<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BookingStatusLog extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['booking_id', 'old_status', 'new_status', 'changed_by', 'changed_at'];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
