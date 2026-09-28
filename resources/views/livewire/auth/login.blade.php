<div style="min-height: 100vh; display: flex; font-family: Arial, sans-serif;">

    {{-- Left Panel --}}
    <div style="
        width: 40%;
        background: #111827;
        color: white;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-sizing: border-box;
    ">

        <div style="font-size: 32px; font-weight: bold; margin-bottom: 20px;">
            RentAll
        </div>

        <div style="
            font-size: 24px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 40px;
        ">
            Satu platform,<br>
            seluruh armada terpantau.
        </div>

        <div style="display: flex; gap: 50px;">

            <div>
                <div style="font-size: 28px; font-weight: bold;">
                    34,85 km
                </div>

                <div style="color: #9ca3af; margin-top: 5px;">
                    Jarak armada
                </div>
            </div>

            <div>
                <div style="font-size: 28px; font-weight: bold;">
                    85/100
                </div>

                <div style="color: #9ca3af; margin-top: 5px;">
                    Fleet health
                </div>
            </div>

        </div>

    </div>


    {{-- Right Panel --}}
    <div style="
        width: 60%;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
        box-sizing: border-box;
    ">

        <div style="width: 100%; max-width: 450px;">

            <div style="
                display: inline-block;
                padding: 8px 14px;
                background: #e5e7eb;
                border-radius: 20px;
                font-size: 14px;
                margin-bottom: 20px;
            ">
                Masuk ke akun Anda
            </div>

            <h1 style="
                font-size: 36px;
                margin: 0 0 10px 0;
                color: #111827;
            ">
                Selamat datang kembali
            </h1>

            <p style="
                color: #6b7280;
                margin-bottom: 35px;
            ">
                Masukkan kredensial Anda untuk melanjutkan.
            </p>


            <form wire:submit="login">

                {{-- Email --}}
                <div style="margin-bottom: 20px;">

                    <label
                        for="email"
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        wire:model="email"
                        placeholder="nama@email.com"
                        style="
                            width: 100%;
                            box-sizing: border-box;
                            padding: 14px;
                            border: 1px solid #d1d5db;
                            border-radius: 8px;
                            font-size: 16px;
                        "
                    >

                    @error('email')
                        <div style="
                            color: #dc2626;
                            font-size: 14px;
                            margin-top: 6px;
                        ">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Password --}}
                <div style="margin-bottom: 15px;">

                    <label
                        for="password"
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        wire:model="password"
                        placeholder="Masukkan password"
                        style="
                            width: 100%;
                            box-sizing: border-box;
                            padding: 14px;
                            border: 1px solid #d1d5db;
                            border-radius: 8px;
                            font-size: 16px;
                        "
                    >

                    @error('password')
                        <div style="
                            color: #dc2626;
                            font-size: 14px;
                            margin-top: 6px;
                        ">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Remember + Forgot --}}
                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 25px;
                    font-size: 14px;
                ">

                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input
                            type="checkbox"
                            wire:model="remember"
                        >

                        Ingat saya
                    </label>

                    <a
                        href="#"
                        style="
                            color: #2563eb;
                            text-decoration: none;
                        "
                    >
                        Lupa password?
                    </a>

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    style="
                        width: 100%;
                        padding: 15px;
                        border: none;
                        border-radius: 8px;
                        background: #111827;
                        color: white;
                        font-size: 16px;
                        font-weight: 600;
                        cursor: pointer;
                    "
                >
                    Masuk ke dashboard
                </button>


                {{-- Register --}}
                <div style="
                    text-align: center;
                    margin-top: 25px;
                    color: #6b7280;
                    font-size: 14px;
                ">
                    Belum punya akun?

                    <a
                        href="{{ route('register') }}"
                        style="
                            color: #2563eb;
                            text-decoration: none;
                            font-weight: 600;
                        "
                    >
                        Daftar sekarang
                    </a>
                </div>

            </form>


            <div style="
                margin-top: 40px;
                padding-top: 20px;
                border-top: 1px solid #e5e7eb;
                color: #9ca3af;
                font-size: 12px;
                text-align: center;
            ">
                TLS Secure · AES-256 · Multi-tenant
            </div>

        </div>

    </div>

</div>