<?php

use Illuminate\Support\Facades\Route;

// Struktur route mengikuti wireframe (01-login s.d. 19-modal-tambah-paket) - lihat Rental PRD.md.
// Komponen Livewire aktual ada di app/Http/Livewire, view di resources/views/livewire.

Route::get('/', \App\Http\Livewire\Public\Pricing::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', \App\Http\Livewire\Auth\Register::class)->name('register');
});

Route::middleware('auth')->group(function () {

    // Superadmin Platform
    Route::prefix('superadmin')
        ->name('superadmin.')
        ->group(function () {
            Route::get('/dashboard', \App\Http\Livewire\Superadmin\Dashboard::class)
                ->name('dashboard');
        });

    // Tenant (Pemilik Tenant & Staff)
    Route::prefix('tenant')
        ->name('tenant.')
        ->group(function () {
            Route::get('/dashboard', \App\Http\Livewire\Tenant\Dashboard::class)
                ->name('dashboard');

            // 08-tenant-customers-list.html & 09-tenant-customer-verify.html
            Route::get('/customers', \App\Http\Livewire\Tenant\Customers\Index::class)
                ->name('customers.index');

            Route::get('/customers/{customer}/verify', \App\Http\Livewire\Tenant\Customers\Verify::class)
                ->name('customers.verify');
        });
});