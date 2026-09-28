<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// API Publik - scope hanya data booking milik tenant pemilik API key. Lihat Rental PRD.md bagian 3 & 9.
class BookingApiController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user()->tenant; // token Sanctum di-scope ke tenant

        return $tenant->bookings()->with(['vehicle', 'customer'])->paginate();
    }
}
