<?php

use Illuminate\Support\Facades\Route;

// API Publik untuk tenant (data tenant & kendaraan saja - TIDAK ADA endpoint data staff).
// Autentikasi via laravel/sanctum (api_keys) - lihat Rental PRD.md bagian 3, 4, 9.
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\Api\BookingApiController::class, 'index']);
    Route::get('/vehicles', [\App\Http\Controllers\Api\VehicleApiController::class, 'index']);
    Route::get('/reports', [\App\Http\Controllers\Api\ReportApiController::class, 'index']);
});
