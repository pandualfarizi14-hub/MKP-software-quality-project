<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

// Otorisasi per permission (role-builder) - lihat Rental PRD.md bagian 4 & Testing-Checklist-E2E.md bagian 3.
class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $user->tenant_id === $booking->tenant_id && $user->can('booking.view');
    }

    public function create(User $user): bool
    {
        return $user->can('booking.create');
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->tenant_id === $booking->tenant_id && $user->can('booking.update');
    }
}
