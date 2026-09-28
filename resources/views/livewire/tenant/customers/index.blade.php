<div class="min-h-screen bg-[#f4f6f8] font-sans text-[#172033]">

    <x-tenant-sidebar active="customer" />

    <main class="ml-56 min-h-screen">

        {{-- HEADER --}}
        <header class="flex items-center justify-between border-b border-[#e5e8ed] bg-white px-6 py-4">
            <div>
                <h1 class="text-lg font-bold leading-tight">Customer</h1>
                <p class="text-xs text-[#7f8998]">{{ number_format($totalCustomers) }} customer terdaftar</p>
            </div>

            <button
                wire:click="bukaTambahCustomer"
                class="rounded-md bg-[#172338] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#22314d]"
            >
                + Tambah Customer
            </button>
        </header>

        <div class="p-6">

            @if (session('success'))
                <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- KPI --}}
            <div class="mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
                <div class="rounded-lg border border-[#e1e5ea] bg-white p-4">
                    <div class="mb-1.5 text-[11px] text-[#7f8998]">Low Risk</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ $lowRiskCount }}</div>
                </div>

                <div class="rounded-lg border border-[#e1e5ea] bg-white p-4">
                    <div class="mb-1.5 text-[11px] text-[#7f8998]">Medium Risk</div>
                    <div class="text-2xl font-bold text-amber-500">{{ $mediumRiskCount }}</div>
                </div>

                <div class="rounded-lg border border-[#e1e5ea] bg-white p-4">
                    <div class="mb-1.5 text-[11px] text-[#7f8998]">High Risk</div>
                    <div class="text-2xl font-bold text-rose-600">{{ $highRiskCount }}</div>
                </div>

                <div class="rounded-lg border border-[#e1e5ea] bg-white p-4">
                    <div class="mb-1.5 text-[11px] text-[#7f8998]">Blacklist</div>
                    <div class="text-2xl font-bold text-rose-800">{{ $blacklistCount }}</div>
                </div>
            </div>

            {{-- SEARCH & FILTER --}}
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#9aa5b1]">
                        🔍
                    </span>
                    <input
                        type="text"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Cari nama atau NIK..."
                        class="w-full rounded-md border border-[#e1e5ea] bg-white py-2 pl-9 pr-3 text-xs placeholder:text-[#a3adba] focus:border-[#2878ff] focus:outline-none focus:ring-1 focus:ring-[#2878ff]"
                    >
                </div>

                <select
                    wire:model.live="risk"
                    class="rounded-md border border-[#e1e5ea] bg-white px-3 py-2 text-xs text-[#475467] focus:border-[#2878ff] focus:outline-none focus:ring-1 focus:ring-[#2878ff]"
                >
                    <option value="semua">Semua level risiko</option>
                    <option value="low">Low Risk</option>
                    <option value="medium">Medium Risk</option>
                    <option value="high">High Risk</option>
                    <option value="blacklist">Blacklist</option>
                </select>
            </div>

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-lg border border-[#e1e5ea] bg-white">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-[#e8ebef] text-[#68758c]">
                            <th class="px-4 py-3 font-normal">Customer</th>
                            <th class="px-4 py-3 font-normal">NIK</th>
                            <th class="px-4 py-3 font-normal">Skor Risiko</th>
                            <th class="px-4 py-3 font-normal">Status Verifikasi</th>
                            <th class="px-4 py-3 font-normal">Riwayat Sewa</th>
                            <th class="px-4 py-3 font-normal"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($customers as $customer)
                            @php
                                $badge = $customer->statusBadge();
                                $band = $customer->riskBand();
                                $dotColor = match ($band) {
                                    'low' => 'bg-emerald-500',
                                    'medium' => 'bg-amber-500',
                                    'high' => 'bg-rose-500',
                                    default => 'bg-slate-300',
                                };
                            @endphp

                            <tr class="border-b border-[#edf0f3] last:border-0 hover:bg-[#f8fafc]">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-[#172033]">{{ $customer->name }}</div>
                                    <div class="text-[11px] text-[#8b95a3]">{{ $customer->phone ?? '—' }}</div>
                                </td>

                                <td class="px-4 py-3 text-[#68758c]">
                                    {{ $customer->masked_nik ?? '—' }}
                                </td>

                                <td class="px-4 py-3">
                                    @if ($customer->risk_score !== null)
                                        <span class="inline-flex items-center gap-1.5 font-medium">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $dotColor }}"></span>
                                            {{ $customer->risk_score }}
                                        </span>
                                    @else
                                        <span class="text-[#c3cad3]">—</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2 py-0.5 text-[11px] font-medium {{ $badge['classes'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-[#68758c]">
                                    {{ $customer->bookings_count }}x
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('tenant.customers.verify', $customer) }}" class="font-medium text-[#2878ff] hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-[#8b95a3]">
                                    Belum ada customer yang cocok dengan pencarian/filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>

        </div>
    </main>

    {{-- MODAL TAMBAH CUSTOMER --}}
    @if ($showTambahModal)
        <div
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 p-4"
            wire:click.self="tutupTambahCustomer"
        >
            <div class="w-full max-w-md rounded-lg bg-white p-5 shadow-xl">
                <h2 class="mb-4 text-sm font-bold">Tambah Customer</h2>

                <form wire:submit="simpanCustomer" class="space-y-3">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#475467]">Nama Lengkap</label>
                        <input
                            type="text"
                            wire:model="newName"
                            class="w-full rounded-md border border-[#e1e5ea] px-3 py-2 text-xs focus:border-[#2878ff] focus:outline-none focus:ring-1 focus:ring-[#2878ff]"
                        >
                        @error('newName') <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#475467]">Nomor Telepon</label>
                        <input
                            type="text"
                            wire:model="newPhone"
                            class="w-full rounded-md border border-[#e1e5ea] px-3 py-2 text-xs focus:border-[#2878ff] focus:outline-none focus:ring-1 focus:ring-[#2878ff]"
                        >
                        @error('newPhone') <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#475467]">Alamat</label>
                        <textarea
                            wire:model="newAddress"
                            rows="2"
                            class="w-full rounded-md border border-[#e1e5ea] px-3 py-2 text-xs focus:border-[#2878ff] focus:outline-none focus:ring-1 focus:ring-[#2878ff]"
                        ></textarea>
                        @error('newAddress') <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <p class="text-[11px] leading-relaxed text-[#8b95a3]">
                        Setelah disimpan, kamu akan diarahkan ke halaman verifikasi identitas untuk mengunggah KTP customer ini.
                    </p>

                    <div class="flex justify-end gap-2 pt-2">
                        <button
                            type="button"
                            wire:click="tutupTambahCustomer"
                            class="rounded-md border border-[#e1e5ea] px-3 py-2 text-xs text-[#475467]"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="rounded-md bg-[#172338] px-4 py-2 text-xs font-semibold text-white disabled:opacity-60"
                            wire:loading.attr="disabled"
                            wire:target="simpanCustomer"
                        >
                            <span wire:loading.remove wire:target="simpanCustomer">Simpan & Lanjut Verifikasi</span>
                            <span wire:loading wire:target="simpanCustomer">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
