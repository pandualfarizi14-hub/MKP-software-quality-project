@props(['active' => ''])

{{-- Sidebar navigasi tenant - dipakai bersama di seluruh halaman /tenant/*.
     Warna & struktur mengikuti wireframe (07 s.d. 13) & livewire/tenant/dashboard.blade.php. --}}
@php
    $navItems = [
        ['key' => 'ringkasan', 'label' => 'Ringkasan', 'icon' => '▦', 'href' => route('tenant.dashboard')],
        ['key' => 'customer', 'label' => 'Customer', 'icon' => '👤', 'href' => route('tenant.customers.index')],
        ['key' => 'kendaraan', 'label' => 'Kendaraan', 'icon' => '🚗', 'href' => '#'],
        ['key' => 'peta', 'label' => 'Peta Armada', 'icon' => '📍', 'href' => '#'],
        ['key' => 'booking', 'label' => 'Booking & Kontrak', 'icon' => '📄', 'href' => '#'],
        ['key' => 'pembayaran', 'label' => 'Pembayaran', 'icon' => '💳', 'href' => '#'],
    ];

    $settingsItems = [
        ['key' => 'staff', 'label' => 'Staff & Role', 'icon' => '👥', 'href' => '#'],
        ['key' => 'pengaturan', 'label' => 'Pengaturan', 'icon' => '⚙️', 'href' => '#'],
    ];
@endphp

<aside class="fixed inset-y-0 left-0 z-30 flex w-56 flex-col bg-[#172338] text-white">

    <div class="flex items-center gap-2 px-4 py-4 border-b border-white/10">
        <div class="flex h-7 w-7 items-center justify-center rounded-md bg-[#2878ff] text-xs font-bold">
            ↗
        </div>
        <span class="text-sm font-bold">RentAll</span>
    </div>

    <div class="px-4 py-3 border-b border-white/10">
        <div class="text-xs font-medium text-white truncate">
            {{ auth()->user()->tenant?->name ?? 'Tenant' }}
        </div>
        <div class="mt-1 flex items-center gap-1.5 text-[11px] text-[#7f8ba0]">
            <span class="rounded bg-[#273b67] px-1.5 py-0.5 text-[10px] font-semibold text-[#91a9e8]">
                TENANT
            </span>
            Bandung, Jabar
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-2.5 py-3">
        <div class="mb-2 px-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#68758c]">
            Menu
        </div>

        @foreach ($navItems as $nav)
            <a href="{{ $nav['href'] }}"
                @class([
                    'flex items-center gap-2 rounded-md px-2.5 py-2 mb-1 text-xs',
                    'bg-[#30415d] text-white font-medium' => $active === $nav['key'],
                    'text-[#c0c8d5] hover:bg-white/5' => $active !== $nav['key'],
                ])>
                <span class="w-4 text-center">{{ $nav['icon'] }}</span>
                {{ $nav['label'] }}
            </a>
        @endforeach

        <div class="mb-2 mt-5 px-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#68758c]">
            Pengaturan
        </div>

        @foreach ($settingsItems as $nav)
            <a href="{{ $nav['href'] }}"
                @class([
                    'flex items-center gap-2 rounded-md px-2.5 py-2 mb-1 text-xs',
                    'bg-[#30415d] text-white font-medium' => $active === $nav['key'],
                    'text-[#c0c8d5] hover:bg-white/5' => $active !== $nav['key'],
                ])>
                <span class="w-4 text-center">{{ $nav['icon'] }}</span>
                {{ $nav['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="flex items-center gap-2 border-t border-white/10 px-3.5 py-3">
        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-[#f3b53f] text-[10px] font-bold text-[#172033]">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div class="min-w-0">
            <div class="truncate text-xs text-white">{{ auth()->user()->name }}</div>
            <div class="text-[10px] text-[#7f8ba0]">Pemilik Tenant</div>
        </div>
    </div>

</aside>
