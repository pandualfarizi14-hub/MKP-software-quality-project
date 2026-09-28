<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function create(User $user): bool
    {
        return $user->can('payment.create');
    }

    // approve TIDAK BOLEH oleh user yang sama dengan created_by - lihat PaymentService::approve()
    public function approve(User $user, Payment $payment): bool
    {
        return $user->can('payment.approve') && $user->id !== $payment->created_by;
    }
}
