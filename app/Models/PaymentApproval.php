<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

// approved_by WAJIB beda user dari payments.created_by - divalidasi di PaymentService
class PaymentApproval extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['payment_id', 'approved_by', 'notes', 'approved_at'];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
