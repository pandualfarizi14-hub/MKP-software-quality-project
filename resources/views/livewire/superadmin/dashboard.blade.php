<div style="
    min-height: 100vh;
    background: #f4f6f8;
    color: #172033;
    font-family: Arial, Helvetica, sans-serif;
">
    <div style="
        display: flex;
        min-height: 100vh;
    ">

        {{-- SIDEBAR --}}
        <aside style="
            width: 158px;
            background: #172338;
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        ">

            {{-- BRAND --}}
            <div style="
                height: 62px;
                display: flex;
                align-items: center;
                gap: 9px;
                padding: 0 15px;
                border-bottom: 1px solid rgba(255,255,255,.06);
                box-sizing: border-box;
            ">
                <div style="
                    width: 24px;
                    height: 24px;
                    background: #2f6fed;
                    border-radius: 5px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 13px;
                    font-weight: bold;
                ">
                    +
                </div>

                <div style="
                    font-size: 12px;
                    font-weight: 700;
                ">
                    RentAll
                </div>
            </div>

            {{-- ROLE --}}
            <div style="
                padding: 13px 14px 5px;
                font-size: 7px;
                color: #6f7e97;
                text-transform: uppercase;
                letter-spacing: .5px;
            ">
                PLATFORM
            </div>

            {{-- MENU --}}
            <nav style="
                padding: 0 8px;
                font-size: 9px;
            ">

                <a href="{{ route('superadmin.dashboard') }}" style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 9px;
                    margin-bottom: 2px;
                    border-radius: 6px;
                    color: #ffffff;
                    background: #2b3a51;
                    text-decoration: none;
                ">
                    <span>■</span>
                    <span>Ringkasan</span>
                </a>

                <a href="#" style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 9px;
                    margin-bottom: 2px;
                    border-radius: 6px;
                    color: #c4ccda;
                    text-decoration: none;
                ">
                    <span>□</span>
                    <span>Kelola Tenant</span>
                </a>

                <a href="#" style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 9px;
                    margin-bottom: 2px;
                    border-radius: 6px;
                    color: #c4ccda;
                    text-decoration: none;
                ">
                    <span>▣</span>
                    <span>Paket Langganan</span>
                </a>

                <a href="#" style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 9px;
                    margin-bottom: 2px;
                    border-radius: 6px;
                    color: #c4ccda;
                    text-decoration: none;
                ">
                    <span>◉</span>
                    <span>Kebijakan Risiko & Scoring</span>
                </a>

                <a href="#" style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 9px;
                    margin-bottom: 2px;
                    border-radius: 6px;
                    color: #c4ccda;
                    text-decoration: none;
                ">
                    <span>▣</span>
                    <span>Provider OCR & Tracker</span>
                </a>

                <a href="#" style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 9px;
                    border-radius: 6px;
                    color: #c4ccda;
                    text-decoration: none;
                ">
                    <span>▤</span>
                    <span>Log Audit</span>
                </a>

            </nav>

            {{-- USER --}}
            <div style="
                margin-top: auto;
                border-top: 1px solid rgba(255,255,255,.06);
                padding: 12px;
                display: flex;
                align-items: center;
                gap: 8px;
            ">
                <div style="
                    width: 23px;
                    height: 23px;
                    border-radius: 50%;
                    background: #286be8;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 8px;
                    font-weight: bold;
                ">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>

                <div>
                    <div style="
                        font-size: 8px;
                        font-weight: 600;
                    ">
                        {{ auth()->user()->name }}
                    </div>

                    <div style="
                        font-size: 7px;
                        color: #8793a8;
                        margin-top: 2px;
                    ">
                        Superadmin
                    </div>
                </div>
            </div>

        </aside>


        {{-- MAIN --}}
        <main style="
            flex: 1;
            min-width: 0;
        ">

            {{-- TOPBAR --}}
            <header style="
                height: 43px;
                background: #ffffff;
                border-bottom: 1px solid #e2e6eb;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 18px;
                box-sizing: border-box;
            ">

                <div>
                    <div style="
                        font-size: 12px;
                        font-weight: 700;
                    ">
                        Ringkasan Platform
                    </div>

                    <div style="
                        font-size: 8px;
                        color: #8993a3;
                        margin-top: 2px;
                    ">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>

                <div style="
                    display: flex;
                    align-items: center;
                    gap: 10px;
                ">

                    <div style="
                        width: 163px;
                        height: 24px;
                        border: 1px solid #dce1e7;
                        border-radius: 6px;
                        color: #9aa2ae;
                        font-size: 8px;
                        display: flex;
                        align-items: center;
                        padding: 0 9px;
                        box-sizing: border-box;
                    ">
                        <span style="margin-right: 6px;">⌕</span>
                        Cari tenant, invoice...
                    </div>

                    <div style="
                        width: 25px;
                        height: 25px;
                        border: 1px solid #dce1e7;
                        border-radius: 6px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 11px;
                    ">
                        ♧
                    </div>

                </div>

            </header>


            {{-- CONTENT --}}
            <div style="
                padding: 21px;
            ">

                {{-- KPI --}}
                <div style="
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 12px;
                    margin-bottom: 14px;
                ">

                    {{-- TENANT AKTIF --}}
                    <div style="
                        background: #ffffff;
                        border: 1px solid #e1e5ea;
                        border-radius: 8px;
                        padding: 14px;
                        min-height: 70px;
                        box-sizing: border-box;
                    ">
                        <div style="
                            font-size: 8px;
                            color: #7c8796;
                        ">
                            Tenant Aktif
                        </div>

                        <div style="
                            margin-top: 7px;
                            font-size: 20px;
                            font-weight: 700;
                        ">
                            {{ number_format($activeTenants, 0, ',', '.') }}
                        </div>
                    </div>


                    {{-- REVENUE --}}
                    <div style="
                        background: #ffffff;
                        border: 1px solid #e1e5ea;
                        border-radius: 8px;
                        padding: 14px;
                        min-height: 70px;
                        box-sizing: border-box;
                    ">
                        <div style="
                            font-size: 8px;
                            color: #7c8796;
                        ">
                            Pendapatan Langganan
                        </div>

                        <div style="
                            margin-top: 7px;
                            font-size: 20px;
                            font-weight: 700;
                        ">
                            Rp0
                        </div>

                        <div style="
                            font-size: 7px;
                            color: #8b95a3;
                            margin-top: 3px;
                        ">
                            Belum ada data pembayaran subscription
                        </div>
                    </div>


                    {{-- PAYMENT --}}
                    <div style="
                        background: #ffffff;
                        border: 1px solid #e1e5ea;
                        border-radius: 8px;
                        padding: 14px;
                        min-height: 70px;
                        box-sizing: border-box;
                    ">
                        <div style="
                            font-size: 8px;
                            color: #7c8796;
                        ">
                            Menunggu Konfirmasi Bayar
                        </div>

                        <div style="
                            margin-top: 7px;
                            font-size: 20px;
                            font-weight: 700;
                        ">
                            {{ number_format($pendingPayments, 0, ',', '.') }}
                        </div>

                        <div style="
                            font-size: 7px;
                            color: #8b95a3;
                            margin-top: 3px;
                        ">
                            Pembayaran dengan status pending
                        </div>
                    </div>


                    {{-- VEHICLES --}}
                    <div style="
                        background: #ffffff;
                        border: 1px solid #e1e5ea;
                        border-radius: 8px;
                        padding: 14px;
                        min-height: 70px;
                        box-sizing: border-box;
                    ">
                        <div style="
                            font-size: 8px;
                            color: #7c8796;
                        ">
                            Total Kendaraan Terpantau
                        </div>

                        <div style="
                            margin-top: 7px;
                            font-size: 20px;
                            font-weight: 700;
                        ">
                            {{ number_format($totalVehicles, 0, ',', '.') }}
                        </div>
                    </div>

                </div>


                {{-- MIDDLE --}}
                <div style="
                    display: grid;
                    grid-template-columns: 2fr 1fr;
                    gap: 14px;
                    margin-bottom: 14px;
                ">

                    {{-- LOCATION --}}
                    <div style="
                        background: #ffffff;
                        border: 1px solid #e1e5ea;
                        border-radius: 8px;
                        overflow: hidden;
                    ">

                        <div style="
                            height: 45px;
                            padding: 10px 13px;
                            box-sizing: border-box;
                            border-bottom: 1px solid #e5e8ec;
                        ">
                            <div style="
                                font-size: 9px;
                                font-weight: 700;
                            ">
                                Sebaran Lokasi Tenant
                            </div>

                            <div style="
                                font-size: 7px;
                                color: #8b95a3;
                                margin-top: 2px;
                            ">
                                Data lokasi tenant belum tersedia pada schema
                            </div>
                        </div>

                        <div style="
                            height: 183px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            background: #f8f9fb;
                            color: #8b95a3;
                            font-size: 9px;
                            text-align: center;
                            padding: 20px;
                            box-sizing: border-box;
                        ">
                            Lokasi tenant belum dapat ditampilkan karena
                            tabel tenant belum memiliki data lokasi.
                        </div>

                    </div>


                    {{-- PAYMENT LIST --}}
                    <div style="
                        background: #ffffff;
                        border: 1px solid #e1e5ea;
                        border-radius: 8px;
                        overflow: hidden;
                    ">

                        <div style="
                            height: 45px;
                            padding: 10px 13px;
                            box-sizing: border-box;
                            border-bottom: 1px solid #e5e8ec;
                        ">
                            <div style="
                                font-size: 9px;
                                font-weight: 700;
                            ">
                                Konfirmasi Pembayaran
                            </div>

                            <div style="
                                font-size: 7px;
                                color: #8b95a3;
                                margin-top: 2px;
                            ">
                                Pembayaran yang menunggu verifikasi
                            </div>
                        </div>

                        @if ($pendingPayments > 0)

                            <div style="
                                padding: 18px 12px;
                                font-size: 8px;
                                color: #7f8998;
                            ">
                                Terdapat
                                <strong style="color: #172033;">
                                    {{ number_format($pendingPayments, 0, ',', '.') }}
                                </strong>
                                pembayaran yang menunggu konfirmasi.
                            </div>

                        @else

                            <div style="
                                padding: 20px 12px;
                                text-align: center;
                                font-size: 8px;
                                color: #8b95a3;
                            ">
                                Tidak ada pembayaran yang menunggu konfirmasi.
                            </div>

                        @endif

                        <div style="
                            text-align: center;
                            padding: 13px;
                            font-size: 7px;
                            color: #286be8;
                            border-top: 1px solid #edf0f3;
                        ">
                            Lihat semua
                        </div>

                    </div>

                </div>


                {{-- TENANT TABLE --}}
                <div style="
                    background: #ffffff;
                    border: 1px solid #e1e5ea;
                    border-radius: 8px;
                    overflow: hidden;
                ">

                    <div style="
                        height: 42px;
                        padding: 0 13px;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        border-bottom: 1px solid #e5e8ec;
                    ">

                        <div style="
                            font-size: 9px;
                            font-weight: 700;
                        ">
                            Tenant Terbaru
                        </div>

                        <button type="button" style="
                            border: none;
                            background: #172338;
                            color: white;
                            border-radius: 5px;
                            padding: 6px 10px;
                            font-size: 7px;
                        ">
                            + &nbsp; Tambah Tenant
                        </button>

                    </div>


                    <div style="
                        overflow-x: auto;
                    ">

                        <table style="
                            width: 100%;
                            border-collapse: collapse;
                            font-size: 8px;
                        ">

                            <thead>
                                <tr style="
                                    border-bottom: 1px solid #e5e8ec;
                                    color: #778294;
                                ">

                                    <th style="
                                        text-align: left;
                                        padding: 9px 13px;
                                        font-weight: 500;
                                    ">
                                        Tenant
                                    </th>

                                    <th style="
                                        text-align: left;
                                        padding: 9px;
                                        font-weight: 500;
                                    ">
                                        Lokasi
                                    </th>

                                    <th style="
                                        text-align: left;
                                        padding: 9px;
                                        font-weight: 500;
                                    ">
                                        Paket
                                    </th>

                                    <th style="
                                        text-align: left;
                                        padding: 9px;
                                        font-weight: 500;
                                    ">
                                        Kendaraan
                                    </th>

                                    <th style="
                                        text-align: left;
                                        padding: 9px;
                                        font-weight: 500;
                                    ">
                                        Status
                                    </th>

                                    <th style="
                                        text-align: right;
                                        padding: 9px 13px;
                                        font-weight: 500;
                                    ">
                                        Detail
                                    </th>

                                </tr>
                            </thead>


                            <tbody>

                                @forelse ($recentTenants as $tenant)

                                    <tr style="
                                        border-bottom: 1px solid #edf0f3;
                                    ">

                                        {{-- TENANT --}}
                                        <td style="
                                            padding: 10px 13px;
                                        ">
                                            <div style="
                                                font-weight: 600;
                                            ">
                                                {{ $tenant->name }}
                                            </div>

                                            <div style="
                                                color: #9aa2ad;
                                                margin-top: 2px;
                                            ">
                                                {{ $tenant->email }}
                                            </div>
                                        </td>


                                        {{-- LOKASI --}}
                                        <td style="
                                            padding: 10px 9px;
                                            color: #7f8998;
                                        ">
                                            -
                                        </td>


                                        {{-- PAKET --}}
                                        <td style="
                                            padding: 10px 9px;
                                        ">
                                            <span style="
                                                background: #eef3fb;
                                                color: #4b6b9d;
                                                border-radius: 10px;
                                                padding: 3px 7px;
                                                font-size: 7px;
                                            ">
                                                {{ $tenant->subscriptionPlan?->name ?? 'Belum ada paket' }}
                                            </span>
                                        </td>


                                        {{-- KENDARAAN --}}
                                        <td style="
                                            padding: 10px 9px;
                                        ">
                                            {{ number_format($tenant->vehicles_count, 0, ',', '.') }}
                                        </td>


                                        {{-- STATUS --}}
                                        <td style="
                                            padding: 10px 9px;
                                        ">

                                            @if ($tenant->status === 'active')

                                                <span style="
                                                    color: #21a35b;
                                                ">
                                                    ● Aktif
                                                </span>

                                            @else

                                                <span style="
                                                    color: #9aa2ad;
                                                ">
                                                    ● Tidak Aktif
                                                </span>

                                            @endif

                                        </td>


                                        {{-- DETAIL --}}
                                        <td style="
                                            padding: 10px 13px;
                                            text-align: right;
                                        ">
                                            <a href="#" style="
                                                color: #286be8;
                                                text-decoration: none;
                                            ">
                                                Detail
                                            </a>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="6"
                                            style="
                                                padding: 35px;
                                                text-align: center;
                                                color: #8b95a3;
                                            "
                                        >
                                            Belum ada tenant terdaftar.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>
</div>