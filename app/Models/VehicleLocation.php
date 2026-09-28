<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class VehicleLocation extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['vehicle_id', 'latitude', 'longitude', 'data_source', 'recorded_at'];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
