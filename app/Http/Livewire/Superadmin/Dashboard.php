<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Vehicle;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $activeTenants = Tenant::where('status', 'active')->count();

        $pendingPayments = Payment::where('status', 'pending')->count();

        $totalVehicles = Vehicle::count();

        $recentTenants = Tenant::with('subscriptionPlan')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.superadmin.dashboard', [
            'activeTenants' => $activeTenants,
            'pendingPayments' => $pendingPayments,
            'totalVehicles' => $totalVehicles,
            'recentTenants' => $recentTenants,
        ]);
    }
}