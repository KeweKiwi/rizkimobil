@php
    $hideFloatingWhatsApp = true;
@endphp

@extends('layouts.app')

@section('content')
<style>
    .auth-page {
        min-height: calc(100vh - 80px);
        background:
            radial-gradient(circle at 12% 0%, rgba(239, 68, 68, 0.18), transparent 28%),
            radial-gradient(circle at 88% 92%, rgba(239, 68, 68, 0.12), transparent 32%),
            linear-gradient(135deg, #090d15 0%, #05070c 62%, #120306 100%);
        color: #ffffff;
    }
    .auth-wrap {
        display: grid;
        align-items: center;
        gap: clamp(28px, 5vw, 64px);
        min-width: 0;
        padding: clamp(56px, 8vw, 96px) 0;
    }
    @media (min-width: 1024px) {
        .auth-wrap {
            grid-template-columns: minmax(0, 0.88fr) minmax(420px, 0.72fr);
        }
    }
    .auth-title {
        max-width: 720px;
        font-family: var(--font-display);
        font-size: clamp(42px, 7vw, 72px);
        font-weight: 900;
        line-height: 0.98;
        letter-spacing: 0;
    }
    .auth-title span {
        color: #ff4747;
    }
    .auth-copy {
        max-width: 590px;
        margin-top: 20px;
        color: rgba(255, 255, 255, 0.64);
        font-size: 15px;
        line-height: 1.85;
    }
    .auth-card {
        min-width: 0;
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.94);
        color: #101522;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.34);
    }
    .auth-card-head,
    .auth-form {
        padding: clamp(22px, 4vw, 34px);
    }
    .auth-card-head {
        border-bottom: 1px solid #edf0f4;
    }
    .auth-card-title {
        font-family: var(--font-display);
        font-size: clamp(28px, 4vw, 38px);
        font-weight: 900;
        line-height: 1.08;
    }
    .auth-card-copy {
        margin-top: 8px;
        color: #667085;
        font-size: 14px;
        line-height: 1.7;
    }
    .auth-form {
        display: grid;
        gap: 18px;
    }
    .auth-field label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 13px;
        font-weight: 900;
    }
    .auth-input {
        width: 100%;
        min-width: 0;
        height: 52px;
        border: 1px solid #d7dce4;
        border-radius: 8px;
        padding: 0 15px;
        background: #ffffff;
        color: #101522;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .auth-input:focus {
        border-color: #ef3333;
        box-shadow: 0 0 0 4px rgba(239, 51, 51, 0.09);
    }
    .auth-check {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #667085;
        font-size: 13px;
        font-weight: 700;
    }
    .auth-submit,
    .auth-link-button {
        display: inline-flex;
        min-height: 50px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0 20px;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        text-decoration: none;
    }
    .auth-submit {
        border: 0;
        background: #ef3333;
        color: #ffffff;
        cursor: pointer;
        box-shadow: 0 18px 38px rgba(239, 51, 51, 0.24);
    }
    .auth-alt {
        color: #667085;
        font-size: 14px;
        line-height: 1.7;
    }
    .auth-alt a {
        color: #dc2626;
        font-weight: 900;
        text-decoration: none;
    }
    .auth-error {
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
        line-height: 1.5;
    }
    @media (max-width: 520px) {
        .auth-submit {
            width: 100%;
        }
    }
</style>

<section class="auth-page">
    <div class="container mx-auto px-4">
        <div class="auth-wrap">
            <div>
                <h1 class="auth-title">Masuk untuk menyimpan <span>mobil incaran.</span></h1>
                <p class="auth-copy">
                    Akun pelanggan dipakai untuk menyimpan favorit dan melanjutkan pencarian stok dengan lebih mudah. Akses admin tetap dipisahkan untuk tim Rizki Mobil.
                </p>
            </div>

            <div class="auth-card">
                <div class="auth-card-head">
                    <h2 class="auth-card-title">Masuk akun</h2>
                    <p class="auth-card-copy">Gunakan email dan password yang sudah terdaftar.</p>
                </div>

                <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                    @csrf

                    <div class="auth-field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="auth-input" required autofocus autocomplete="email">
                        @error('email')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" class="auth-input" required autocomplete="current-password">
                        @error('password')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="auth-check">
                        <input type="checkbox" name="remember" value="1">
                        Ingat saya
                    </label>

                    <button type="submit" class="auth-submit">Masuk</button>

                    <p class="auth-alt">
                        Belum punya akun? <a href="{{ route('register') }}">Buat akun pelanggan</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
