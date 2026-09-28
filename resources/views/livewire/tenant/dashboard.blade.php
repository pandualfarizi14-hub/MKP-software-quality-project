<div style="
    min-height: 100vh;
    background: #f4f6f8;
    font-family: Arial, Helvetica, sans-serif;
    color: #172033;
">

    {{-- SIDEBAR --}}
    <aside style="
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 158px;
        background: #172338;
        color: #fff;
        padding: 12px 10px;
        box-sizing: border-box;
    ">

        <div style="
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 4px 14px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            font-size: 11px;
            font-weight: 700;
        ">
            <div style="
                width: 18px;
                height: 18px;
                border-radius: 4px;
                background: #2878ff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
            ">
                ↗
            </div>

            RentAll
        </div>

        {{-- TENANT INFO --}}
        <div style="
            padding: 12px 4px 14px;
            font-size: 8px;
            color: #fff;
        ">
            <div style="margin-bottom: 5px;">
                {{ auth()->user()->name }}
            </div>

            <div style="
                color: #7f8ba0;
                display: flex;
                align-items: center;
                gap: 4px;
            ">
                <span style="
                    background: #273b67;
                    color: #91a9e8;
                    padding: 2px 4px;
                    border-radius: 3px;
                    font-size: 6px;
                ">
                    {{ auth()->user()->tenant_id ? 'TENANT' : 'DEMO' }}
                </span>

                Tenant
            </div>
        </div>

        {{-- NAVIGATION --}}
        <div style="
            font-size: 7px;
            color: #68758c;
            text-transform: uppercase;
            margin: 8px 4px;
        ">
            Menu
        </div>

        <nav>

            <div style="
                background: #30415d;
                border-radius: 5px;
                padding: 8px 7px;
                margin-bottom: 4px;
                font-size: 8px;
            ">
                ▦ &nbsp; Ringkasan
            </div>

            <div style="
                padding: 8px 7px;
                margin-bottom: 2px;
                font-size: 8px;
                color: #c0c8d5;
            ">
                ♙ &nbsp; Customer
            </div>

            <div style="
                padding: 8px 7px;
                margin-bottom: 2px;
                font-size: 8px;
                color: #c0c8d5;
            ">
                ▱ &nbsp; Kendaraan
            </div>

            <div style="
                padding: 8px 7px;
                margin-bottom: 2px;
                font-size: 8px;
                color: #c0c8d5;
            ">
                ⌖ &nbsp; Peta Armada
            </div>

            <div style="
                padding: 8px 7px;
                margin-bottom: 2px;
                font-size: 8px;
                color: #c0c8d5;
            ">
                ▤ &nbsp; Booking & Kontrak
            </div>

            <div style="
                padding: 8px 7px;
                margin-bottom: 2px;
                font-size: 8px;
                color: #c0c8d5;
            ">
                ▤ &nbsp; Pembayaran
            </div>

            <div style="
                font-size: 7px;
                color: #68758c;
                text-transform: uppercase;
                margin: 18px 4px 8px;
            ">
                Pengaturan
            </div>

            <div style="
                padding: 8px 7px;
                margin-bottom: 2px;
                font-size: 8px;
                color: #c0c8d5;
            ">
                ♙ &nbsp; Staff & Role
            </div>

            <div style="
                padding: 8px 7px;
                margin-bottom: 2px;
                font-size: 8px;
                color: #c0c8d5;
            ">
                ⚙ &nbsp; Pengaturan
            </div>

        </nav>

        {{-- USER --}}
        <div style="
            position: absolute;
            left: 10px;
            right: 10px;
            bottom: 12px;
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 12px 4px 0;
            display: flex;
            align-items: center;
            gap: 7px;
        ">
            <div style="
                width: 21px;
                height: 21px;
                border-radius: 50%;
                background: #f3b53f;
                color: #172033;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 7px;
                font-weight: 700;
            ">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>

            <div>
                <div style="
                    font-size: 7px;
                    color: #fff;
                    margin-bottom: 2px;
                ">
                    {{ auth()->user()->name }}
                </div>

                <div style="
                    font-size: 6px;
                    color: #7f8ba0;
                ">
                    Pemilik Tenant
                </div>
            </div>
        </div>

    </aside>


    {{-- MAIN CONTENT --}}
    <main style="
        margin-left: 158px;
        min-height: 100vh;
        background: #f4f6f8;
    ">

        {{-- HEADER --}}
        <header style="
            height: 49px;
            background: #fff;
            border-bottom: 1px solid #e5e8ed;
            padding: 8px 20px;
            box-sizing: border-box;
        ">
            <div style="
                font-size: 11px;
                font-weight: 700;
                margin-bottom: 3px;
            ">
                Selamat siang, {{ auth()->user()->name }}
            </div>

            <div style="
                font-size: 7px;
                color: #7f8998;
            ">
                {{ now()->translatedFormat('l, d F Y') }} · {{ now()->format('H:i') }} WIB
            </div>
        </header>


        <div style="
            padding: 20px;
        ">

            {{-- EMERGENCY ALERT --}}
            <div style="
                background: #ef443b;
                color: #fff;
                border-radius: 7px;
                min-height: 36px;
                padding: 8px 12px;
                box-sizing: border-box;
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 8px;
                margin-bottom: 15px;
            ">
                <div>
                    △ &nbsp;
                    <strong>Tidak ada keadaan darurat aktif.</strong>
                    Sistem akan menampilkan alert GPS di area ini.
                </div>

                <button style="
                    border: 0;
                    background: #fff;
                    color: #d93630;
                    border-radius: 5px;
                    padding: 6px 12px;
                    font-size: 7px;
                    font-weight: 700;
                ">
                    Tangani Sekarang
                </button>
            </div>


            {{-- KPI --}}
            <div style="
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 12px;
                margin-bottom: 16px;
            ">

                {{-- RENTED VEHICLES --}}
                <div style="
                    background: #fff;
                    border: 1px solid #e1e5ea;
                    border-radius: 7px;
                    padding: 13px;
                ">
                    <div style="
                        font-size: 7px;
                        color: #7f8998;
                        margin-bottom: 7px;
                    ">
                        Kendaraan Disewa
                    </div>

                    <div style="
                        font-size: 20px;
                        font-weight: 700;
                    ">
                        {{ $rentedVehicles }}
                        <span style="
                            font-size: 9px;
                            color: #8c95a3;
                            font-weight: 400;
                        ">
                            /{{ $totalVehicles }}
                        </span>
                    </div>
                </div>


                {{-- ACTIVE BOOKINGS --}}
                <div style="
                    background: #fff;
                    border: 1px solid #e1e5ea;
                    border-radius: 7px;
                    padding: 13px;
                ">
                    <div style="
                        font-size: 7px;
                        color: #7f8998;
                        margin-bottom: 7px;
                    ">
                        Booking Aktif
                    </div>

                    <div style="
                        font-size: 20px;
                        font-weight: 700;
                    ">
                        {{ $activeBookings }}
                    </div>
                </div>


                {{-- PAYMENT --}}
                <div style="
                    background: #fff;
                    border: 1px solid #e1e5ea;
                    border-radius: 7px;
                    padding: 13px;
                ">
                    <div style="
                        font-size: 7px;
                        color: #7f8998;
                        margin-bottom: 7px;
                    ">
                        Menunggu Approval Bayar
                    </div>

                    <div style="
                        font-size: 20px;
                        font-weight: 700;
                        color: #f5a623;
                    ">
                        {{ $pendingPayments }}
                    </div>
                </div>


                {{-- SERVICE --}}
                <div style="
                    background: #fff;
                    border: 1px solid #e1e5ea;
                    border-radius: 7px;
                    padding: 13px;
                ">
                    <div style="
                        font-size: 7px;
                        color: #7f8998;
                        margin-bottom: 7px;
                    ">
                        Servis Jatuh Tempo
                    </div>

                    <div style="
                        font-size: 20px;
                        font-weight: 700;
                        color: #ef443b;
                    ">
                        {{ $serviceVehicles }}
                    </div>
                </div>

            </div>


            {{-- CONTENT GRID --}}
            <div style="
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 15px;
            ">

                {{-- BOOKING --}}
                <div style="
                    background: #fff;
                    border: 1px solid #e1e5ea;
                    border-radius: 7px;
                    overflow: hidden;
                ">

                    <div style="
                        padding: 13px;
                        border-bottom: 1px solid #e8ebef;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                    ">
                        <div style="
                            font-size: 9px;
                            font-weight: 700;
                        ">
                            Booking Berlangsung
                        </div>

                        <span style="
                            font-size: 7px;
                            color: #2878ff;
                        ">
                            Lihat semua →
                        </span>
                    </div>


                    <table style="
                        width: 100%;
                        border-collapse: collapse;
                        font-size: 7px;
                    ">
                        <thead>
                            <tr style="
                                color: #68758c;
                                border-bottom: 1px solid #e8ebef;
                            ">
                                <th style="
                                    text-align: left;
                                    padding: 9px 12px;
                                    font-weight: 400;
                                ">
                                    Customer
                                </th>

                                <th style="
                                    text-align: left;
                                    padding: 9px 12px;
                                    font-weight: 400;
                                ">
                                    Kendaraan
                                </th>

                                <th style="
                                    text-align: left;
                                    padding: 9px 12px;
                                    font-weight: 400;
                                ">
                                    Risiko
                                </th>

                                <th style="
                                    text-align: left;
                                    padding: 9px 12px;
                                    font-weight: 400;
                                ">
                                    Selesai
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($ongoingBookings as $booking)

                                <tr style="
                                    border-bottom: 1px solid #edf0f3;
                                ">

                                    <td style="
                                        padding: 9px 12px;
                                    ">
                                        {{ $booking->customer?->name ?? '-' }}
                                    </td>

                                    <td style="
                                        padding: 9px 12px;
                                    ">
                                        {{ $booking->vehicle?->plate_number ?? '-' }}
                                    </td>

                                    <td style="
                                        padding: 9px 12px;
                                    ">
                                        <span style="
                                            color: #16a34a;
                                        ">
                                            ●
                                        </span>
                                        Belum tersedia
                                    </td>

                                    <td style="
                                        padding: 9px 12px;
                                        color: #68758c;
                                    ">
                                        {{ $booking->end_date?->format('d M') ?? '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" style="
                                        padding: 24px 12px;
                                        text-align: center;
                                        color: #8b95a3;
                                    ">
                                        Belum ada booking yang sedang berlangsung.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>

                </div>


                {{-- RISK PANEL --}}
                <div style="
                    background: #fff;
                    border: 1px solid #e1e5ea;
                    border-radius: 7px;
                    overflow: hidden;
                ">

                    <div style="
                        padding: 13px;
                        border-bottom: 1px solid #e8ebef;
                    ">
                        <div style="
                            font-size: 9px;
                            font-weight: 700;
                        ">
                            Skor Risiko Rata-rata
                        </div>
                    </div>

                    <div style="
                        padding: 22px 15px;
                    ">

                        <div style="
                            text-align: center;
                            margin-bottom: 18px;
                        ">
                            <div style="
                                font-size: 20px;
                                font-weight: 700;
                                color: #172033;
                            ">
                                —
                            </div>

                            <div style="
                                font-size: 7px;
                                color: #8b95a3;
                            ">
                                / 100
                            </div>

                            <div style="
                                margin-top: 10px;
                                font-size: 7px;
                                color: #8b95a3;
                            ">
                                Data skor risiko belum tersedia.
                            </div>
                        </div>


                        <div style="
                            font-size: 7px;
                            color: #7f8998;
                            border-top: 1px solid #edf0f3;
                            padding-top: 12px;
                        ">
                            Sistem akan menampilkan ringkasan skor risiko
                            customer setelah modul scoring tersedia.
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>