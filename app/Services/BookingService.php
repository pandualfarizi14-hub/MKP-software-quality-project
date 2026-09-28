<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Carbon;

// Booking & Reservasi - cek ketersediaan, validasi bentrok jadwal, kalkulasi harga.
// Lihat Rental PRD.md bagian 4 & ERD-Database-Fase0-1.md (index komposit vehicle_id+start_date+end_date).
class BookingService
{
    public function isVehicleAvailable(Vehicle $vehicle, Carbon $start, Carbon $end): bool
    {
        return ! Booking::where('vehicle_id', $vehicle->id)
            ->whereIn('status', ['pending', 'aktif'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)->where('end_date', '>=', $end);
                    });
            })
            ->exists();
    }

    public function calculatePrice(Vehicle $vehicle, Carbon $start, Carbon $end): float
    {
        $days = $start->diffInDays($end) ?: 1;

        // TODO: terapkan ketentuan harga per minggu/bulan bila durasi memenuhi.
        return $days * (float) $vehicle->price_per_day;
    }
}
