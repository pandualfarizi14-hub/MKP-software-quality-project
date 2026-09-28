<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// Foto kendaraan: collection 'vehicle_photos' via spatie/laravel-medialibrary
class Vehicle extends Model implements HasMedia
{
    use HasUuids, SoftDeletes, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'tenant_id', 'type', 'plate_number', 'status',
        'price_per_day', 'price_per_week', 'price_per_month', 'gps_tracker_ref',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('plate_number')->saveSlugsTo('slug');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function locations()
    {
        return $this->hasMany(VehicleLocation::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function latestLocation()
    {
        return $this->hasOne(VehicleLocation::class)->latestOfMany('recorded_at');
    }
}
