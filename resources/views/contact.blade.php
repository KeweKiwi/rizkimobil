@php
    $hideFloatingWhatsApp = true;
    $whatsappNumber = config('rizki.whatsapp.wa_number');
    $whatsappMessage = urlencode('Halo Rizki Mobil, saya ingin konsultasi tentang stok mobil yang tersedia.');
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}";
    $quickPrompts = [
        'Saya ingin cek stok yang tersedia.',
        'Saya ingin jadwalkan lihat mobil.',
        'Saya ingin tanya opsi tukar tambah.',
    ];
@endphp

@extends('layouts.app')

@section('content')
<style>
    .contact-page {
        background:
            linear-gradient(180deg, #f6f7f9 0%, #ffffff 58%, #f7f8fa 100%);
        color: #101522;
    }
    .contact-wrap {
        padding: clamp(54px, 7vw, 94px) 0 clamp(64px, 8vw, 112px);
    }
    .contact-layout {
        display: grid;
        gap: clamp(28px, 5vw, 68px);
        align-items: start;
        min-width: 0;
    }
    @media (min-width: 1024px) {
        .contact-layout {
            grid-template-columns: minmax(0, 0.78fr) minmax(460px, 0.9fr);
        }
    }
    .contact-copy {
        min-width: 0;
        max-width: 620px;
    }
    .contact-title {
        font-family: var(--font-display);
        font-size: clamp(42px, 7vw, 76px);
        font-weight: 900;
        line-height: 0.98;
        letter-spacing: 0;
        color: #0b101a;
    }
    .contact-title span {
        color: #ef3333;
    }
    .contact-lead {
        margin-top: 22px;
        max-width: 560px;
        color: #667085;
        font-size: clamp(16px, 2vw, 18px);
        line-height: 1.8;
    }
    .contact-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }
    .contact-button {
        display: inline-flex;
        min-height: 50px;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 999px;
        padding: 0 20px;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, border-color 0.2s ease;
    }
    .contact-button svg {
        width: 17px;
        height: 17px;
    }
    .contact-button-primary {
        background: #ef3333;
        color: #ffffff;
        box-shadow: 0 18px 38px rgba(239, 51, 51, 0.24);
    }
    .contact-button-secondary {
        border: 1px solid #d7dce4;
        background: #ffffff;
        color: #101522;
    }
    .contact-button:hover {
        transform: translateY(-1px);
    }
    .contact-button-primary:hover {
        background: #dc2626;
        box-shadow: 0 22px 44px rgba(220, 38, 38, 0.28);
    }
    .contact-button-secondary:hover {
        border-color: rgba(239, 51, 51, 0.34);
        background: #fff6f6;
    }
    .contact-note {
        display: grid;
        gap: 14px;
        margin-top: clamp(34px, 5vw, 54px);
        padding-top: 26px;
        border-top: 1px solid #e1e5ec;
    }
    .contact-note-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        color: #667085;
        font-size: 14px;
        line-height: 1.6;
    }
    .contact-note-dot {
        width: 8px;
        height: 8px;
        margin-top: 8px;
        flex: 0 0 auto;
        border-radius: 50%;
        background: #ef3333;
        box-shadow: 0 0 0 6px rgba(239, 51, 51, 0.08);
    }
    .contact-note-item strong {
        display: block;
        color: #101522;
        font-size: 14px;
        font-weight: 900;
        line-height: 1.4;
    }
    .contact-card {
        min-width: 0;
        border: 1px solid #e1e5ec;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 28px 70px rgba(16, 21, 34, 0.08);
    }
    .contact-card-head {
        padding: clamp(22px, 4vw, 34px);
        border-bottom: 1px solid #edf0f4;
    }
    .contact-card-title {
        font-family: var(--font-display);
        font-size: clamp(26px, 4vw, 38px);
        font-weight: 900;
        line-height: 1.08;
        color: #0b101a;
    }
    .contact-card-subtitle {
        margin-top: 10px;
        color: #667085;
        font-size: 15px;
        line-height: 1.7;
    }
    .contact-form {
        display: grid;
        gap: 18px;
        padding: clamp(22px, 4vw, 34px);
    }
    .contact-grid {
        display: grid;
        gap: 18px;
    }
    @media (min-width: 700px) {
        .contact-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    .contact-field label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 13px;
        font-weight: 900;
    }
    .contact-input,
    .contact-textarea {
        width: 100%;
        min-width: 0;
        border: 1px solid #d7dce4;
        border-radius: 8px;
        background: #ffffff;
        color: #101522;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .contact-input {
        height: 52px;
        padding: 0 15px;
    }
    .contact-textarea {
        min-height: 148px;
        resize: vertical;
        padding: 15px;
        line-height: 1.7;
    }
    .contact-input:focus,
    .contact-textarea:focus {
        border-color: #ef3333;
        box-shadow: 0 0 0 4px rgba(239, 51, 51, 0.09);
    }
    .contact-alert {
        margin: 0 clamp(22px, 4vw, 34px);
        padding: 14px 15px;
        border-radius: 8px;
        font-size: 14px;
        line-height: 1.6;
    }
    .contact-alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .contact-alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .contact-error-text {
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
        line-height: 1.5;
    }
    .contact-prompts {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    .contact-prompt {
        border: 1px solid #f4c7c7;
        border-radius: 999px;
        background: #fff7f7;
        color: #b91c1c;
        cursor: pointer;
        padding: 8px 11px;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.3;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .contact-prompt:hover {
        border-color: rgba(239, 51, 51, 0.38);
        background: #feecec;
    }
    .contact-submit-row {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding-top: 4px;
    }
    @media (min-width: 640px) {
        .contact-submit-row {
            flex-direction: row;
            align-items: center;
        }
    }
    .contact-submit {
        border: 0;
        cursor: pointer;
    }
    .contact-small {
        color: #98a2b3;
        font-size: 12px;
        line-height: 1.6;
    }
    @media (max-width: 640px) {
        .contact-button,
        .contact-submit {
            width: 100%;
        }
        .contact-card {
            border-radius: 0;
            margin-inline: -1rem;
            border-left: 0;
            border-right: 0;
        }
    }
</style>

<section class="contact-page">
    <div class="contact-wrap">
        <div class="container mx-auto px-4">
            <div class="contact-layout">
                <div class="contact-copy">
                    <h1 class="contact-title">Kontak Rizki Mobil. <span>Langsung jelas.</span></h1>
                    <p class="contact-lead">
                        Tanyakan stok, kondisi unit, jadwal lihat mobil, atau tukar tambah. Kami bantu jawab seperlunya tanpa membuat proses terasa rumit.
                    </p>

                    <div class="contact-actions">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="contact-button contact-button-primary">
                            Chat WhatsApp
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H8M17 7v9"/>
                            </svg>
                        </a>
                        <a href="{{ route('inventory') }}" class="contact-button contact-button-secondary">
                            Lihat Stok
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M6 7v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M9 7V5a3 3 0 0 1 6 0v2"/>
                            </svg>
                        </a>
                    </div>

                    <div class="contact-note" aria-label="Catatan kontak Rizki Mobil">
                        <div class="contact-note-item">
                            <span class="contact-note-dot"></span>
                            <p>
                                <strong>WhatsApp untuk respons cepat.</strong>
                                Cocok untuk cek stok, harga terbaru, dan jadwal lihat unit.
                            </p>
                        </div>
                        <div class="contact-note-item">
                            <span class="contact-note-dot"></span>
                            <p>
                                <strong>Form untuk kebutuhan lebih detail.</strong>
                                Tulis budget, tipe mobil, atau kebutuhan tukar tambah agar balasan lebih relevan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-card-head">
                        <h2 class="contact-card-title">Kirim pesan</h2>
                        <p class="contact-card-subtitle">Isi singkat saja. Admin akan follow-up lewat kontak yang Anda tulis.</p>
                    </div>

                    @if (session('success'))
                        <div class="contact-alert contact-alert-success">
                            Pesan berhasil dikirim. Tim Rizki Mobil akan menghubungi Anda secepatnya.
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="contact-alert contact-alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="contact-alert contact-alert-error">
                            Mohon cek kembali data yang belum sesuai.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="contact-form">
                        @csrf

                        <div class="contact-grid">
                            <div class="contact-field">
                                <label for="name">Nama</label>
                                <input id="name" class="contact-input" name="name" value="{{ old('name') }}" autocomplete="name" required>
                                @error('name')
                                    <p class="contact-error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="contact-field">
                                <label for="phone">WhatsApp</label>
                                <input id="phone" class="contact-input" name="phone" value="{{ old('phone') }}" inputmode="tel" autocomplete="tel" placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="contact-error-text">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="contact-field">
                            <label for="email">Email</label>
                            <input id="email" class="contact-input" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                            @error('email')
                                <p class="contact-error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="contact-field">
                            <label for="message">Pesan</label>
                            <textarea id="message" class="contact-textarea" name="message" required placeholder="Contoh: Saya cari MPV 7 seater, budget sekitar Rp 200 juta.">{{ old('message') }}</textarea>
                            <div class="contact-prompts" aria-label="Contoh pesan cepat">
                                @foreach ($quickPrompts as $prompt)
                                    <button type="button" class="contact-prompt" data-message="{{ $prompt }}">{{ $prompt }}</button>
                                @endforeach
                            </div>
                            @error('message')
                                <p class="contact-error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="contact-submit-row">
                            <button type="submit" class="contact-button contact-button-primary contact-submit">
                                Kirim Pesan
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
                            </button>
                            <p class="contact-small">Harga dan stok selalu dikonfirmasi ulang sebelum visit.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const messageField = document.getElementById('message');

        document.querySelectorAll('.contact-prompt').forEach((button) => {
            button.addEventListener('click', () => {
                if (!messageField) {
                    return;
                }

                messageField.value = button.dataset.message || '';
                messageField.focus();
            });
        });
    });
</script>
@endsection
