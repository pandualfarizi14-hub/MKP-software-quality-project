<div class="min-h-screen bg-[#f4f6f8] font-sans text-[#172033]">

    <x-tenant-sidebar active="customer" />

    <main class="ml-56 min-h-screen">

        {{-- HEADER --}}
        <header class="border-b border-[#e5e8ed] bg-white px-6 py-4">
            <a href="{{ route('tenant.customers.index') }}" class="text-[11px] text-[#2878ff] hover:underline">
                ← Kembali ke daftar customer
            </a>
            <h1 class="mt-1 text-lg font-bold leading-tight">
                Verifikasi Customer — {{ $customer->name }}
            </h1>
            <p class="text-xs text-[#7f8998]">
                @if ($sudahDiverifikasi)
                    Diverifikasi {{ $customer->verified_at?->translatedFormat('d M Y, H:i') }} WIB · OCR: VeryHub + PaddleOCR (paralel)
                @else
                    Belum diverifikasi · unggah KTP untuk memulai proses verifikasi
                @endif
            </p>
        </header>

        <div class="p-6">

            @if (session('success'))
                <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

                {{-- LEFT COLUMN --}}
                <div class="space-y-5 lg:col-span-2">

                    {{-- 1. UPLOAD DOKUMEN --}}
                    <div class="rounded-lg border border-[#e1e5ea] bg-white p-5">
                        <h2 class="mb-4 text-xs font-bold">1. Upload Dokumen</h2>

                        @if ($sudahDiverifikasi)
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="flex h-36 items-center justify-center overflow-hidden rounded-md border border-[#d8dee6] bg-[#eef1f5]">
                                        @if ($document->hasMedia('ktp'))
                                            <img src="{{ $document->getFirstMediaUrl('ktp') }}" class="h-full w-full object-cover" alt="Foto KTP">
                                        @else
                                            <span class="px-2 text-center text-[11px] text-[#9aa5b1]">Tidak ada pratinjau file</span>
                                        @endif
                                    </div>
                                    <p class="mt-1.5 text-[11px] text-[#8b95a3]">Foto KTP</p>
                                </div>

                                <div>
                                    <div class="flex h-36 items-center justify-center overflow-hidden rounded-md border border-[#d8dee6] bg-[#eef1f5]">
                                        @if ($document->hasMedia('selfie'))
                                            <img src="{{ $document->getFirstMediaUrl('selfie') }}" class="h-full w-full object-cover" alt="Selfie">
                                        @else
                                            <span class="px-2 text-center text-[11px] text-[#9aa5b1]">Tidak ada selfie</span>
                                        @endif
                                    </div>
                                    <p class="mt-1.5 text-[11px] text-[#8b95a3]">Selfie (opsional)</p>
                                </div>
                            </div>

                            @if ($consentLog)
                                <div class="mt-4 flex items-start gap-2 rounded-md bg-[#f4f6f8] px-3 py-2.5">
                                    <span class="mt-0.5 text-[#2878ff]">✓</span>
                                    <div class="text-[11px] leading-relaxed text-[#68758c]">
                                        <span class="text-[#172033]">
                                            Customer menyetujui data pribadinya diproses untuk keperluan verifikasi identitas dan penilaian risiko sewa.
                                        </span>
                                        <div class="mt-0.5">
                                            Disetujui: {{ $consentLog->consented_at->translatedFormat('d M Y, H:i') }} WIB
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <form wire:submit="simpanVerifikasi" class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1.5 block cursor-pointer">
                                            <div class="flex h-36 flex-col items-center justify-center gap-1 rounded-md border-2 border-dashed border-[#c7cfda] bg-[#f8fafc] p-2 text-center hover:border-[#2878ff]">
                                                @if ($ktpFile)
                                                    <img src="{{ $ktpFile->temporaryUrl() }}" class="h-full w-full rounded-md object-cover">
                                                @else
                                                    <span class="text-lg">📄</span>
                                                    <span class="text-[11px] text-[#8b95a3]">Klik untuk unggah foto KTP</span>
                                                @endif
                                            </div>
                                            <input type="file" wire:model="ktpFile" accept="image/*" class="hidden">
                                        </label>
                                        <p class="mt-1.5 text-[11px] text-[#8b95a3]">Foto KTP</p>
                                        @error('ktpFile') <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="mb-1.5 block cursor-pointer">
                                            <div class="flex h-36 flex-col items-center justify-center gap-1 rounded-md border-2 border-dashed border-[#c7cfda] bg-[#f8fafc] p-2 text-center hover:border-[#2878ff]">
                                                @if ($selfieFile)
                                                    <img src="{{ $selfieFile->temporaryUrl() }}" class="h-full w-full rounded-md object-cover">
                                                @else
                                                    <span class="text-lg">🤳</span>
                                                    <span class="text-[11px] text-[#8b95a3]">Klik untuk unggah selfie</span>
                                                @endif
                                            </div>
                                            <input type="file" wire:model="selfieFile" accept="image/*" class="hidden">
                                        </label>
                                        <p class="mt-1.5 text-[11px] text-[#8b95a3]">Selfie (opsional)</p>
                                        @error('selfieFile') <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <label class="flex items-start gap-2 rounded-md bg-[#f4f6f8] px-3 py-2.5 text-[11px] text-[#68758c]">
                                    <input type="checkbox" wire:model="consent" class="mt-0.5">
                                    <span>Customer menyetujui data pribadinya diproses untuk keperluan verifikasi identitas dan penilaian risiko sewa.</span>
                                </label>
                                @error('consent') <p class="text-[11px] text-rose-600">{{ $message }}</p> @enderror

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="simpanVerifikasi"
                                    class="w-full rounded-md bg-[#172338] px-4 py-2.5 text-xs font-semibold text-white disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="simpanVerifikasi">Verifikasi Sekarang</span>
                                    <span wire:loading wire:target="simpanVerifikasi">Memproses OCR & skor risiko...</span>
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($sudahDiverifikasi)

                        {{-- 2. HASIL OCR --}}
                        <div class="rounded-lg border border-[#e1e5ea] bg-white p-5">
                            <div class="mb-4 flex items-center justify-between gap-2">
                                <h2 class="text-xs font-bold">2. Hasil OCR — Dua Provider Berjalan Paralel</h2>

                                @if ($providersAgree)
                                    <span class="shrink-0 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">
                                        ✓ Kedua provider sejalan
                                    </span>
                                @else
                                    <span class="shrink-0 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-medium text-amber-700">
                                        ⚠ Perlu review manual
                                    </span>
                                @endif
                            </div>

                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div class="rounded-md border border-[#e8ebef] p-3">
                                    <div class="mb-1 flex items-center justify-between">
                                        <span class="text-[11px] font-semibold">VeryHub</span>
                                        <span class="text-[11px] font-medium text-emerald-600">{{ $veryHub->confidence ?? '—' }}%</span>
                                    </div>
                                    <div class="text-[11px] text-[#68758c]">
                                        NIK: {{ $veryHub->extracted_data['nik'] ?? '—' }}
                                    </div>
                                </div>

                                <div class="rounded-md border border-[#e8ebef] p-3">
                                    <div class="mb-1 flex items-center justify-between">
                                        <span class="text-[11px] font-semibold">PaddleOCR</span>
                                        <span class="text-[11px] font-medium text-emerald-600">{{ $paddleOcr->confidence ?? '—' }}%</span>
                                    </div>
                                    <div class="text-[11px] text-[#68758c]">
                                        NIK: {{ $paddleOcr->extracted_data['nik'] ?? '—' }}
                                    </div>
                                </div>
                            </div>

                            <p class="mb-4 text-[11px] leading-relaxed text-[#8b95a3]">
                                @if ($providersAgree)
                                    Hasil kedua provider sama persis untuk semua field — dipakai otomatis dengan keyakinan tinggi tanpa perlu review manual. Field di bawah adalah hasil rekonsiliasi final.
                                @else
                                    Ditemukan perbedaan antar provider OCR untuk sebagian field. Mohon periksa kembali dokumen asli sebelum menyimpan data ini.
                                @endif
                            </p>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="mb-1 text-[11px] text-[#8b95a3]">Nama Lengkap</div>
                                    <div class="rounded-md border border-[#e8ebef] px-3 py-2 text-xs">{{ $reconciled['name'] ?? '—' }}</div>
                                </div>
                                <div>
                                    <div class="mb-1 text-[11px] text-[#8b95a3]">NIK</div>
                                    <div class="rounded-md border border-[#e8ebef] px-3 py-2 text-xs">{{ $reconciled['nik'] ?? '—' }}</div>
                                </div>
                                <div>
                                    <div class="mb-1 text-[11px] text-[#8b95a3]">Tanggal Lahir</div>
                                    <div class="rounded-md border border-[#e8ebef] px-3 py-2 text-xs">
                                        {{ !empty($reconciled['date_of_birth']) ? \Illuminate\Support\Carbon::parse($reconciled['date_of_birth'])->translatedFormat('d-m-Y') : '—' }}
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-1 text-[11px] text-[#8b95a3]">Jenis Kelamin</div>
                                    <div class="rounded-md border border-[#e8ebef] px-3 py-2 text-xs">{{ $reconciled['gender'] ?? '—' }}</div>
                                </div>
                                <div class="col-span-2">
                                    <div class="mb-1 text-[11px] text-[#8b95a3]">Alamat</div>
                                    <div class="rounded-md border border-[#e8ebef] px-3 py-2 text-xs">{{ $reconciled['address'] ?? '—' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. DETAIL TEMUAN SCRAPER --}}
                        <div class="rounded-lg border border-[#e1e5ea] bg-white p-5">
                            <h2 class="text-xs font-bold">3. Detail Temuan Scraper</h2>
                            <p class="mb-1 text-[11px] text-[#8b95a3]">Hasil pencocokan data KTP ke sumber eksternal</p>

                            @forelse ($riskFindings as $finding)
                                @php
                                    $sevDot = match ($finding['severity'] ?? '') {
                                        'tinggi' => 'bg-rose-500',
                                        'sedang' => 'bg-amber-500',
                                        default => 'bg-amber-400',
                                    };
                                    $sevBadge = match ($finding['severity'] ?? '') {
                                        'tinggi' => 'bg-rose-50 text-rose-600',
                                        default => 'bg-amber-50 text-amber-700',
                                    };
                                @endphp

                                <div class="flex items-start justify-between gap-3 border-t border-[#edf0f3] py-3">
                                    <div class="flex items-start gap-2">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full {{ $sevDot }}"></span>
                                        <div>
                                            <div class="text-xs font-semibold text-[#172033]">{{ $finding['source'] }}</div>
                                            <div class="mt-0.5 text-[11px] text-[#8b95a3]">{{ $finding['description'] }}</div>
                                            <div class="mt-0.5 text-[10px] uppercase tracking-wide text-[#b0b8c2]">
                                                Severity: {{ ucfirst($finding['severity'] ?? '-') }}
                                            </div>
                                        </div>
                                    </div>
                                    <span class="shrink-0 rounded-full px-2 py-0.5 text-[11px] font-medium {{ $sevBadge }}">
                                        {{ $finding['point'] }} poin
                                    </span>
                                </div>
                            @empty
                                <div class="border-t border-[#edf0f3] py-6 text-center text-[11px] text-[#8b95a3]">
                                    Tidak ditemukan catatan negatif dari sumber eksternal.
                                </div>
                            @endforelse
                        </div>

                    @endif
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-5">

                    <div class="rounded-lg border border-[#e1e5ea] bg-white p-6 text-center">
                        @if ($sudahDiverifikasi)
                            @php
                                $scoreColor = match (true) {
                                    str_contains($scoreBadge['classes'], 'rose') => 'text-rose-600',
                                    str_contains($scoreBadge['classes'], 'amber') => 'text-amber-500',
                                    default => 'text-emerald-600',
                                };
                            @endphp

                            <div class="text-3xl font-bold {{ $scoreColor }}">{{ $customer->risk_score }}</div>
                            <div class="text-[11px] text-[#8b95a3]">/ 100</div>

                            <span class="mt-3 inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-medium {{ $scoreBadge['classes'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $scoreBadge['dot'] }}"></span>
                                {{ $scoreBadge['label'] }}
                            </span>

                            <p class="mt-3 text-[11px] leading-relaxed text-[#8b95a3]">
                                Skor mulai 100, dikurangi bertahap berdasarkan bobot temuan aktif.
                            </p>
                        @else
                            <div class="text-3xl font-bold text-[#c3cad3]">—</div>
                            <div class="text-[11px] text-[#8b95a3]">/ 100</div>
                            <p class="mt-3 text-[11px] leading-relaxed text-[#8b95a3]">
                                Skor risiko akan muncul setelah dokumen KTP diunggah & diverifikasi.
                            </p>
                        @endif
                    </div>

                    <div class="rounded-lg border border-[#e1e5ea] bg-white p-5">
                        <h2 class="mb-3 text-xs font-bold">Kebijakan Diterapkan</h2>

                        <dl class="space-y-2.5 text-[11px]">
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-[#8b95a3]">Deposit</dt>
                                <dd class="font-semibold {{ $policy['deposit'] === '—' ? 'text-[#8b95a3]' : 'text-rose-600' }}">
                                    {{ $policy['deposit'] }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="shrink-0 text-[#8b95a3]">Dokumen wajib</dt>
                                <dd class="text-right font-medium text-[#172033]">{{ $policy['dokumen_wajib'] }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-[#8b95a3]">Maks durasi sewa</dt>
                                <dd class="font-medium text-[#172033]">{{ $policy['maks_durasi'] }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-[#8b95a3]">Approval booking</dt>
                                <dd class="font-medium text-[#172033]">{{ $policy['approval'] }}</dd>
                            </div>
                        </dl>

                        @if ($policy['warning'])
                            <div class="mt-3 rounded-md bg-rose-50 px-3 py-2.5 text-[11px] leading-relaxed text-rose-700">
                                <strong>Perhatian:</strong> {{ $policy['warning'] }}
                            </div>
                        @endif
                    </div>

                    @if ($sudahDiverifikasi)
                        <button
                            wire:click="simpanSebagaiCustomer"
                            class="w-full rounded-md bg-[#172338] px-4 py-2.5 text-xs font-semibold text-white hover:bg-[#22314d]"
                        >
                            Simpan sebagai Customer
                        </button>

                        <button
                            wire:click="verifikasiUlang"
                            wire:confirm="Yakin ingin menghapus hasil verifikasi ini dan mengulang dari awal?"
                            class="w-full rounded-md border border-[#e1e5ea] bg-white px-4 py-2.5 text-xs font-medium text-[#475467] hover:bg-[#f8fafc]"
                        >
                            Verifikasi Ulang
                        </button>
                    @endif

                </div>

            </div>
        </div>
    </main>
</div>
