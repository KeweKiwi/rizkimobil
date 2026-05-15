@php
    $hideFloatingWhatsApp = true;
@endphp

@extends('layouts.app')

@section('content')
<style>
    .account-page {
        min-height: calc(100vh - 80px);
        background:
            radial-gradient(circle at 10% 0%, rgba(239, 68, 68, 0.14), transparent 30%),
            radial-gradient(circle at 92% 100%, rgba(239, 68, 68, 0.1), transparent 34%),
            linear-gradient(135deg, #090d14 0%, #05070b 58%, #130407 100%);
        color: #fff;
    }
    .account-shell {
        padding: clamp(36px, 6vw, 72px) 0;
    }
    .account-top {
        display: grid;
        gap: 18px;
        margin-bottom: 24px;
    }
    @media (min-width: 900px) {
        .account-top {
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: end;
        }
    }
    .account-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: #ff5a5a;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    .account-kicker::before {
        content: '';
        width: 34px;
        height: 1px;
        background: #ff5a5a;
    }
    .account-title {
        margin-top: 14px;
        font-family: var(--font-display);
        font-size: clamp(34px, 5vw, 56px);
        font-weight: 900;
        line-height: 1.02;
        letter-spacing: 0;
    }
    .account-title span {
        color: #ff4747;
    }
    .account-copy {
        max-width: 700px;
        margin-top: 12px;
        color: rgba(255, 255, 255, 0.62);
        font-size: 15px;
        line-height: 1.8;
    }
    .account-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .account-action {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 999px;
        padding: 0 18px;
        color: rgba(255, 255, 255, 0.78);
        font-size: 13px;
        font-weight: 900;
        text-decoration: none;
        transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
    }
    .account-action:hover {
        border-color: rgba(239, 68, 68, 0.45);
        background: rgba(239, 68, 68, 0.12);
        color: #fff;
    }
    .account-grid {
        display: grid;
        gap: 18px;
        min-width: 0;
    }
    @media (min-width: 1100px) {
        .account-grid {
            grid-template-columns: 320px minmax(0, 1fr);
            align-items: start;
        }
    }
    .account-summary,
    .account-card {
        min-width: 0;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.94);
        color: #101522;
        box-shadow: 0 28px 80px rgba(0, 0, 0, 0.26);
    }
    .account-summary {
        overflow: hidden;
    }
    .account-summary-head {
        padding: 24px;
        background:
            radial-gradient(circle at 20% 0%, rgba(239, 68, 68, 0.24), transparent 32%),
            linear-gradient(135deg, #151923, #070910);
        color: #fff;
    }
    .account-avatar {
        display: grid;
        width: 56px;
        height: 56px;
        place-items: center;
        border-radius: 50%;
        background: #ef3333;
        font-family: var(--font-display);
        font-size: 24px;
        font-weight: 900;
        color: #fff;
        box-shadow: 0 18px 38px rgba(239, 51, 51, 0.32);
    }
    .account-summary-name {
        margin-top: 18px;
        font-family: var(--font-display);
        font-size: 26px;
        font-weight: 900;
        line-height: 1.1;
    }
    .account-summary-email {
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 13px;
        overflow-wrap: anywhere;
    }
    .account-stats {
        display: grid;
        gap: 1px;
        background: #e7eaf0;
    }
    .account-stat {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        background: #fff;
        padding: 15px 20px;
    }
    .account-stat span {
        color: #667085;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .account-stat strong {
        font-size: 15px;
        overflow-wrap: anywhere;
        text-align: right;
    }
    .account-card + .account-card {
        margin-top: 18px;
    }
    .account-card-head,
    .account-form {
        padding: clamp(20px, 3vw, 28px);
    }
    .account-card-head {
        border-bottom: 1px solid #edf0f4;
    }
    .account-card-title {
        font-family: var(--font-display);
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 900;
        line-height: 1.1;
    }
    .account-card-copy {
        margin-top: 8px;
        color: #667085;
        font-size: 14px;
        line-height: 1.65;
    }
    .account-form {
        display: grid;
        gap: 16px;
    }
    @media (min-width: 760px) {
        .account-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        .account-field-full {
            grid-column: 1 / -1;
        }
    }
    .account-field label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 13px;
        font-weight: 900;
    }
    .account-input {
        width: 100%;
        min-width: 0;
        height: 50px;
        border: 1px solid #d7dce4;
        border-radius: 8px;
        padding: 0 14px;
        background: #fff;
        color: #101522;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .account-input:focus {
        border-color: #ef3333;
        box-shadow: 0 0 0 4px rgba(239, 51, 51, 0.09);
    }
    .account-submit {
        display: inline-flex;
        min-height: 48px;
        align-items: center;
        justify-content: center;
        justify-self: start;
        border: 0;
        border-radius: 999px;
        background: #ef3333;
        color: #fff;
        cursor: pointer;
        padding: 0 20px;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        box-shadow: 0 18px 38px rgba(239, 51, 51, 0.22);
    }
    .account-error {
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
        line-height: 1.5;
    }
    .account-status {
        border: 1px solid #fecaca;
        border-radius: 8px;
        background: #fef2f2;
        padding: 12px 14px;
        color: #b91c1c;
        font-size: 13px;
        font-weight: 800;
    }
    @media (max-width: 520px) {
        .account-action,
        .account-submit {
            width: 100%;
        }
        .account-stat {
            align-items: flex-start;
            flex-direction: column;
            gap: 6px;
        }
        .account-stat strong {
            text-align: left;
        }
    }
</style>

<section class="account-page">
    <div class="container mx-auto px-4 lg:px-6">
        <div class="account-shell">
            <div class="account-top">
                <div>
                    <p class="account-kicker">Account settings</p>
                    <h1 class="account-title">Kelola akun <span>{{ $user->name }}</span></h1>
                    <p class="account-copy">
                        Perbarui kontak yang dipakai admin untuk follow up unit incaran, cek mobil tersimpan, dan jaga keamanan password akun.
                    </p>
                </div>

                <div class="account-actions">
                    <a href="{{ route('favorites.index') }}" class="account-action">Mobil tersimpan</a>
                    <a href="{{ route('inventory') }}" class="account-action">Lihat stok</a>
                </div>
            </div>

            <div class="account-grid">
                <aside class="account-summary">
                    <div class="account-summary-head">
                        <div class="account-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                        <h2 class="account-summary-name">{{ $user->name }}</h2>
                        <p class="account-summary-email">{{ $user->email }}</p>
                    </div>

                    <div class="account-stats">
                        <div class="account-stat">
                            <span>Akses</span>
                            <strong>{{ $user->is_admin ? 'Admin' : 'Pelanggan' }}</strong>
                        </div>
                        <div class="account-stat">
                            <span>Tersimpan</span>
                            <strong>{{ $favoriteCount }} unit</strong>
                        </div>
                        <div class="account-stat">
                            <span>WhatsApp</span>
                            <strong>{{ $user->phone ?: 'Belum diisi' }}</strong>
                        </div>
                    </div>
                </aside>

                <div>
                    <div class="account-card">
                        <div class="account-card-head">
                            <h2 class="account-card-title">Informasi profil</h2>
                            <p class="account-card-copy">Data ini membantu admin menghubungi Anda dengan konteks yang tepat.</p>
                        </div>

                        <form method="POST" action="{{ route('account.profile.update') }}" class="account-form">
                            @csrf
                            @method('PUT')

                            @if(session('profile_status'))
                                <div class="account-status">{{ session('profile_status') }}</div>
                            @endif

                            <div class="account-form-grid">
                                <div class="account-field">
                                    <label for="name">Nama</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="account-input" required autocomplete="name">
                                    @error('name')
                                        <p class="account-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="account-field">
                                    <label for="phone">Telepon / WhatsApp</label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="account-input" required minlength="8" maxlength="30" autocomplete="tel">
                                    @error('phone')
                                        <p class="account-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="account-field account-field-full">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="account-input" required autocomplete="email">
                                    @error('email')
                                        <p class="account-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="account-submit">Simpan profil</button>
                        </form>
                    </div>

                    <div class="account-card">
                        <div class="account-card-head">
                            <h2 class="account-card-title">Keamanan</h2>
                            <p class="account-card-copy">Gunakan password baru minimal 8 karakter.</p>
                        </div>

                        <form method="POST" action="{{ route('account.password.update') }}" class="account-form">
                            @csrf
                            @method('PUT')

                            @if(session('account_status'))
                                <div class="account-status">{{ session('account_status') }}</div>
                            @endif

                            <div class="account-form-grid">
                                <div class="account-field account-field-full">
                                    <label for="current_password">Password lama</label>
                                    <input id="current_password" type="password" name="current_password" class="account-input" required autocomplete="current-password">
                                    @error('current_password')
                                        <p class="account-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="account-field">
                                    <label for="password">Password baru</label>
                                    <input id="password" type="password" name="password" class="account-input" required minlength="8" autocomplete="new-password">
                                    @error('password')
                                        <p class="account-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="account-field">
                                    <label for="password_confirmation">Konfirmasi password baru</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="account-input" required minlength="8" autocomplete="new-password">
                                </div>
                            </div>

                            <button type="submit" class="account-submit">Simpan password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
