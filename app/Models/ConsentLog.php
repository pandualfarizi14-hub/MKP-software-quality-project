<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

// Consent sebelum data KTP dikirim ke API scraper eksternal - lihat Rental PRD.md bagian 6
class ConsentLog extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['customer_id', 'purpose', 'consented_by', 'consented_at'];

    protected $casts = [
        'consented_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function consentedBy()
    {
        return $this->belongsTo(User::class, 'consented_by');
    }
}
