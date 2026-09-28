<?php

namespace App\Http\Livewire\Tenant;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Vehicle;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $tenantId = auth()->user()->tenant_id;

        if (! $tenantId) {
            return view('livewire.tenant.dashboard', [
                'totalVehicles' => 0,
                'rentedVehicles' => 0,
                'activeBookings' => 0,
                'pendingPayments' => 0,
                'serviceVehicles' => 0,
                'ongoingBookings' => collect(),
            ]);
        }

        $totalVehicles = Vehicle::where('tenant_id', $tenantId)
            ->count();

        $rentedVehicles = Vehicle::where('tenant_id', $tenantId)
            ->where('status', 'disewa')
            ->count();

        $activeBookings = Booking::where('tenant_id', $tenantId)
            ->where('status', 'aktif')
            ->count();

        $pendingPayments = Payment::where('status', 'pending')
            ->whereHas('booking', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })
            ->count();

        $serviceVehicles = Vehicle::where('tenant_id', $tenantId)
            ->where('status', 'servis')
            ->count();

        $ongoingBookings = Booking::with([
                'customer',
                'vehicle',
            ])
            ->where('tenant_id', $tenantId)
            ->where('status', 'aktif')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.tenant.dashboard', [
            'totalVehicles' => $totalVehicles,
            'rentedVehicles' => $rentedVehicles,
            'activeBookings' => $activeBookings,
            'pendingPayments' => $pendingPayments,
            'serviceVehicles' => $serviceVehicles,
            'ongoingBookings' => $ongoingBookings,
        ]);
    }
}