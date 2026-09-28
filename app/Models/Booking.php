<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'customer_id', 'vehicle_id', 'start_date', 'end_date',
        'total_price', 'status', 'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function statusLogs()
    {
        return $this->hasMany(BookingStatusLog::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
