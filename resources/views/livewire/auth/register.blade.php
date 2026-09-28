<div style="
    min-height: 100vh;
    display: flex;
    background: #f5f7fa;
    font-family: Arial, Helvetica, sans-serif;
    color: #172033;
">

    {{-- LEFT BRANDING --}}
    <section style="
        width: 40%;
        min-height: 100vh;
        background: #172338;
        color: #fff;
        padding: 52px 56px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    ">

        <div>

            {{-- LOGO --}}
            <div style="
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 17px;
                font-weight: 700;
                margin-bottom: 80px;
            ">
                <div style="
                    width: 30px;
                    height: 30px;
                    background: #2878ff;
                    border-radius: 7px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 15px;
                ">
                    ↗
                </div>

                RentAll
            </div>


            {{-- HERO TEXT --}}
            <div style="
                max-width: 390px;
            ">

                <div style="
                    font-size: 12px;
                    color: #8da0bd;
                    margin-bottom: 14px;
                    letter-spacing: .3px;
                ">
                    PLATFORM MANAJEMEN RENTAL
                </div>

                <h1 style="
                    margin: 0 0 18px;
                    font-size: 36px;
                    line-height: 1.18;
                    letter-spacing: -1px;
                ">
                    Kelola seluruh<br>
                    armada dalam<br>
                    satu platform.
                </h1>

                <p style="
                    margin: 0;
                    color: #9caac0;
                    font-size: 13px;
                    line-height: 1.8;
                ">
                    Pantau kendaraan, kelola booking,
                    customer, pembayaran, dan operasional
                    rental dari satu tempat.
                </p>

            </div>

        </div>


        {{-- BOTTOM INFO --}}
        <div>

            <div style="
                display: flex;
                gap: 36px;
                margin-bottom: 32px;
            ">

                <div>
                    <div style="
                        font-size: 20px;
                        font-weight: 700;
                        margin-bottom: 4px;
                    ">
                        24/7
                    </div>

                    <div style="
                        font-size: 9px;
                        color: #8291a8;
                    ">
                        Monitoring armada
                    </div>
                </div>


                <div>
                    <div style="
                        font-size: 20px;
                        font-weight: 700;
                        margin-bottom: 4px;
                    ">
                        Multi
                    </div>

                    <div style="
                        font-size: 9px;
                        color: #8291a8;
                    ">
                        Tenant management
                    </div>
                </div>


                <div>
                    <div style="
                        font-size: 20px;
                        font-weight: 700;
                        margin-bottom: 4px;
                    ">
                        Live
                    </div>

                    <div style="
                        font-size: 9px;
                        color: #8291a8;
                    ">
                        Tracking & activity
                    </div>
                </div>

            </div>

            <div style="
                font-size: 9px;
                color: #65748c;
            ">
                © {{ date('Y') }} RentAll · Centrental
            </div>

        </div>

    </section>


    {{-- RIGHT REGISTER --}}
    <section style="
        width: 60%;
        min-height: 100vh;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        box-sizing: border-box;
    ">

        <div style="
            width: 100%;
            max-width: 430px;
        ">

            {{-- HEADER --}}
            <div style="
                margin-bottom: 28px;
            ">

                <div style="
                    display: inline-flex;
                    align-items: center;
                    padding: 6px 10px;
                    background: #eef4ff;
                    color: #2878ff;
                    border-radius: 5px;
                    font-size: 9px;
                    font-weight: 700;
                    margin-bottom: 13px;
                ">
                    BUAT AKUN
                </div>

                <h2 style="
                    margin: 0 0 8px;
                    font-size: 28px;
                    line-height: 1.25;
                    letter-spacing: -.5px;
                ">
                    Mulai gunakan RentAll
                </h2>

                <p style="
                    margin: 0;
                    color: #7d8795;
                    font-size: 12px;
                    line-height: 1.6;
                ">
                    Buat akun untuk mulai mengelola
                    operasional rental kamu.
                </p>

            </div>


            {{-- SUCCESS MESSAGE --}}
            @if (session()->has('success'))
                <div style="
                    margin-bottom: 18px;
                    padding: 11px 13px;
                    border-radius: 6px;
                    background: #ecfdf3;
                    border: 1px solid #b7ebca;
                    color: #18794e;
                    font-size: 11px;
                ">
                    {{ session('success') }}
                </div>
            @endif


            {{-- FORM --}}
            <form wire:submit="register">

                {{-- NAME --}}
                <div style="
                    margin-bottom: 17px;
                ">

                    <label style="
                        display: block;
                        font-size: 10px;
                        font-weight: 700;
                        color: #374151;
                        margin-bottom: 7px;
                    ">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                        style="
                            width: 100%;
                            height: 43px;
                            box-sizing: border-box;
                            border: 1px solid #dfe4ea;
                            border-radius: 6px;
                            padding: 0 12px;
                            font-size: 11px;
                            color: #172033;
                            outline: none;
                            background: #fff;
                        "
                    >

                    @error('name')
                        <div style="
                            margin-top: 5px;
                            color: #dc3545;
                            font-size: 9px;
                        ">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div style="
                    margin-bottom: 17px;
                ">

                    <label style="
                        display: block;
                        font-size: 10px;
                        font-weight: 700;
                        color: #374151;
                        margin-bottom: 7px;
                    ">
                        Email
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        style="
                            width: 100%;
                            height: 43px;
                            box-sizing: border-box;
                            border: 1px solid #dfe4ea;
                            border-radius: 6px;
                            padding: 0 12px;
                            font-size: 11px;
                            color: #172033;
                            outline: none;
                            background: #fff;
                        "
                    >

                    @error('email')
                        <div style="
                            margin-top: 5px;
                            color: #dc3545;
                            font-size: 9px;
                        ">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- PASSWORD --}}
                <div style="
                    margin-bottom: 17px;
                ">

                    <label style="
                        display: block;
                        font-size: 10px;
                        font-weight: 700;
                        color: #374151;
                        margin-bottom: 7px;
                    ">
                        Password
                    </label>

                    <input
                        type="password"
                        wire:model="password"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        style="
                            width: 100%;
                            height: 43px;
                            box-sizing: border-box;
                            border: 1px solid #dfe4ea;
                            border-radius: 6px;
                            padding: 0 12px;
                            font-size: 11px;
                            color: #172033;
                            outline: none;
                            background: #fff;
                        "
                    >

                    @error('password')
                        <div style="
                            margin-top: 5px;
                            color: #dc3545;
                            font-size: 9px;
                        ">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- PASSWORD CONFIRMATION --}}
                <div style="
                    margin-bottom: 22px;
                ">

                    <label style="
                        display: block;
                        font-size: 10px;
                        font-weight: 700;
                        color: #374151;
                        margin-bottom: 7px;
                    ">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        wire:model="password_confirmation"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        style="
                            width: 100%;
                            height: 43px;
                            box-sizing: border-box;
                            border: 1px solid #dfe4ea;
                            border-radius: 6px;
                            padding: 0 12px;
                            font-size: 11px;
                            color: #172033;
                            outline: none;
                            background: #fff;
                        "
                    >

                    @error('password_confirmation')
                        <div style="
                            margin-top: 5px;
                            color: #dc3545;
                            font-size: 9px;
                        ">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- TERMS INFO --}}
                <div style="
                    display: flex;
                    align-items: flex-start;
                    gap: 8px;
                    margin-bottom: 18px;
                    color: #7d8795;
                    font-size: 9px;
                    line-height: 1.5;
                ">

                    <div style="
                        width: 14px;
                        height: 14px;
                        min-width: 14px;
                        border-radius: 3px;
                        background: #eef4ff;
                        color: #2878ff;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 9px;
                    ">
                        ✓
                    </div>

                    <div>
                        Data akun kamu akan digunakan untuk
                        kebutuhan autentikasi dan akses ke platform.
                    </div>

                </div>


                {{-- SUBMIT --}}
                <button
                    type="submit"
                    style="
                        width: 100%;
                        height: 44px;
                        border: 0;
                        border-radius: 6px;
                        background: #172338;
                        color: #fff;
                        font-size: 11px;
                        font-weight: 700;
                        cursor: pointer;
                    "
                >
                    Buat Akun
                </button>

            </form>


            {{-- LOGIN LINK --}}
            <div style="
                text-align: center;
                margin-top: 22px;
                font-size: 10px;
                color: #7d8795;
            ">
                Sudah punya akun?

                <a
                    href="{{ route('login') }}"
                    style="
                        color: #2878ff;
                        font-weight: 700;
                        text-decoration: none;
                    "
                >
                    Masuk di sini
                </a>
            </div>

        </div>

    </section>

</div>