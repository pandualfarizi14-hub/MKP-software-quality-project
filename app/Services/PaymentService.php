<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Validation\ValidationException;

// Pembayaran Manual dengan approval berlapis wajib - lihat Rental PRD.md bagian 4.
class PaymentService
{
    public function approve(Payment $payment, User $approver, ?string $notes = null): void
    {
        if ($payment->created_by === $approver->id) {
            throw ValidationException::withMessages([
                'approver' => 'Approval wajib dilakukan oleh user/role yang berbeda dari yang input pembayaran.',
            ]);
        }

        $payment->approval()->create([
            'approved_by' => $approver->id,
            'notes' => $notes,
            'approved_at' => now(),
        ]);

        $payment->update(['status' => 'approved']);
    }
}
