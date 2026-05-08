@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = '6281359359069';
    $whatsappMessage = urlencode('Halo Rizki Mobil, saya ingin konsultasi tentang stok mobil yang tersedia.');
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}";
    $quickPrompts = [
        'Saya ingin cek stok SUV yang siap dilihat minggu ini.',
        'Saya cari MPV 7 seater dengan budget sekitar Rp 200 juta.',
        'Saya ingin tukar tambah dan butuh estimasi appraisal.',
    ];
@endphp

<style>
    .contact-page {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 12% 12%, rgba(239, 68, 68, 0.26), transparent 30%),
            radial-gradient(circle at 92% 8%, rgba(255, 255, 255, 0.1), transparent 24%),
            linear-gradient(135deg, #090d15 0%, #05070c 52%, #150407 100%);
    }
    .contact-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.055) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.055) 1px, transparent 1px);
        background-size: 76px 76px;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.55), transparent 64%);
        pointer-events: none;
    }
    .contact-shell {
        position: relative;
        z-index: 1;
        padding: clamp(64px, 9vw, 118px) 0 clamp(72px, 9vw, 126px);
    }
    .contact-hero {
        display: grid;
        gap: clamp(34px, 5vw, 76px);
        align-items: center;
    }
    @media (min-width: 1024px) {
        .contact-hero {
            grid-template-columns: minmax(0, 0.9fr) minmax(420px, 1.1fr);
        }
    }
    .contact-kicker,
    .contact-panel-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }
    .contact-kicker {
        color: #ff6b6b;
    }
    .contact-kicker::before,
    .contact-panel-kicker::before {
        content: '';
        width: 36px;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg, #ef4444, rgba(255, 255, 255, 0.28), transparent);
    }
    .contact-title {
        margin-top: 22px;
        max-width: 780px;
        color: #ffffff;
        font-family: var(--font-display);
        font-size: clamp(48px, 8vw, 92px);
        font-weight: 900;
        line-height: 0.94;
        letter-spacing: -0.04em;
    }
    .contact-title span {
        color: #ff4747;
    }
    .contact-copy {
        margin-top: 26px;
        max-width: 640px;
        color: rgba(255, 255, 255, 0.7);
        font-size: clamp(16px, 2vw, 19px);
        line-height: 1.85;
    }
    .contact-primary-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 32px;
    }
    .contact-action-primary,
    .contact-action-secondary {
        display: inline-flex;
        min-height: 52px;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 999px;
        padding: 0 22px;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        text-decoration: none;
        transition: transform 0.22s ease, background 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
    }
    .contact-action-primary {
        color: #ffffff;
        background: #ef3333;
        box-shadow: 0 22px 48px rgba(239, 51, 51, 0.34);
    }
    .contact-action-secondary {
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.22);
        background: rgba(255, 255, 255, 0.05);
    }
    .contact-action-primary:hover,
    .contact-action-secondary:hover {
        transform: translateY(-2px);
    }
    .contact-action-secondary:hover {
        border-color: rgba(255, 255, 255, 0.42);
        background: rgba(255, 255, 255, 0.1);
    }
    .contact-action-primary svg,
    .contact-action-secondary svg {
        width: 18px;
        height: 18px;
    }
    .contact-signal {
        display: grid;
        max-width: 640px;
        margin-top: 46px;
        border-block: 1px solid rgba(255, 255, 255, 0.14);
    }
    .contact-signal-item {
        display: grid;
        grid-template-columns: 72px minmax(0, 1fr);
        gap: 18px;
        padding: 20px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }
    .contact-signal-item:last-child {
        border-bottom: 0;
    }
    .contact-signal-code {
        color: #ff4747;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.12em;
    }
    .contact-signal-item strong {
        display: block;
        color: #ffffff;
        font-size: 17px;
        font-weight: 900;
        line-height: 1.25;
    }
    .contact-signal-item span {
        display: block;
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.56);
        font-size: 14px;
        line-height: 1.55;
    }
    .contact-visual {
        position: relative;
        min-height: clamp(440px, 48vw, 680px);
        overflow: hidden;
        border-left: 1px solid rgba(255, 255, 255, 0.12);
        background: #05070c;
    }
    .contact-visual-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 60% center;
        opacity: 0.58;
        filter: saturate(1.08) contrast(1.06);
    }
    .contact-visual::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, #05070c 0%, rgba(5, 7, 12, 0.58) 44%, rgba(5, 7, 12, 0.06) 100%),
            radial-gradient(circle at 78% 18%, rgba(239, 68, 68, 0.36), transparent 28%);
    }
    .contact-visual::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 47%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.7), #ef4444, transparent);
        box-shadow: 0 0 26px rgba(239, 68, 68, 0.42);
    }
    .contact-visual-card {
        position: absolute;
        left: clamp(24px, 5vw, 64px);
        right: clamp(24px, 5vw, 64px);
        bottom: clamp(26px, 5vw, 58px);
        display: grid;
        gap: 20px;
        max-width: 520px;
        padding: clamp(22px, 4vw, 34px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        background: rgba(6, 9, 16, 0.78);
        backdrop-filter: blur(18px);
    }
    .contact-visual-logo {
        width: 132px;
        height: auto;
        filter: drop-shadow(0 12px 28px rgba(0, 0, 0, 0.38));
    }
    .contact-visual-card h2 {
        color: #ffffff;
        font-family: var(--font-display);
        font-size: clamp(28px, 4vw, 46px);
        font-weight: 900;
        line-height: 1.02;
        letter-spacing: -0.03em;
    }
    .contact-visual-card h2 span {
        color: #ff4747;
    }
    .contact-visual-meta {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-top: 1px solid rgba(255, 255, 255, 0.14);
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);
    }
    .contact-visual-meta div {
        padding: 14px 14px 14px 0;
    }
    .contact-visual-meta div + div {
        padding-left: 14px;
        border-left: 1px solid rgba(255, 255, 255, 0.14);
    }
    .contact-visual-meta strong,
    .contact-visual-meta span {
        display: block;
    }
    .contact-visual-meta strong {
        color: #ffffff;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.2;
    }
    .contact-visual-meta span {
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.52);
        font-size: 11px;
        line-height: 1.45;
    }
    .contact-brief {
        position: relative;
        z-index: 2;
        margin-top: clamp(46px, 7vw, 84px);
        display: grid;
        gap: clamp(24px, 4vw, 42px);
    }
    @media (min-width: 1024px) {
        .contact-brief {
            grid-template-columns: minmax(260px, 0.72fr) minmax(0, 1.28fr);
            align-items: start;
        }
    }
    .contact-route-panel {
        display: grid;
        gap: 0;
        border-top: 1px solid rgba(255, 255, 255, 0.18);
        color: #ffffff;
    }
    .contact-route-heading {
        padding: 0 0 22px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);
    }
    .contact-panel-kicker {
        color: rgba(255, 255, 255, 0.58);
    }
    .contact-route-heading h2 {
        margin-top: 18px;
        max-width: 430px;
        font-family: var(--font-display);
        font-size: clamp(30px, 4vw, 44px);
        font-weight: 900;
        line-height: 1.02;
        letter-spacing: -0.03em;
    }
    .contact-route-item {
        display: grid;
        grid-template-columns: 54px minmax(0, 1fr);
        gap: 18px;
        padding: 24px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);
    }
    .contact-route-number {
        display: inline-flex;
        width: 42px;
        height: 42px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgba(239, 68, 68, 0.44);
        color: #ff4747;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.08em;
    }
    .contact-route-item strong {
        display: block;
        color: #ffffff;
        font-size: 18px;
        font-weight: 900;
        line-height: 1.25;
    }
    .contact-route-item span {
        display: block;
        margin-top: 7px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 14px;
        line-height: 1.65;
    }
    .contact-form-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.94)),
            radial-gradient(circle at 100% 0%, rgba(239, 68, 68, 0.16), transparent 30%);
        box-shadow: 0 34px 90px rgba(0, 0, 0, 0.34);
    }
    .contact-form-inner {
        padding: clamp(24px, 4vw, 44px);
    }
    .contact-form-top {
        display: grid;
        gap: 18px;
    }
    @media (min-width: 760px) {
        .contact-form-top {
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: end;
        }
    }
    .contact-form-heading {
        color: #0b101a;
        font-family: var(--font-display);
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 900;
        line-height: 1.04;
        letter-spacing: -0.025em;
    }
    .contact-form-subtitle {
        margin-top: 10px;
        max-width: 620px;
        color: #667085;
        font-size: 15px;
        line-height: 1.75;
    }
    .contact-response-badge {
        display: inline-grid;
        gap: 4px;
        min-width: 148px;
        padding: 14px 16px;
        border-left: 2px solid #ef4444;
        background: #f8fafc;
    }
    .contact-response-badge strong {
        color: #0b101a;
        font-family: var(--font-display);
        font-size: 24px;
        font-weight: 900;
        line-height: 1;
    }
    .contact-response-badge span {
        color: #667085;
        font-size: 12px;
        line-height: 1.35;
    }
    .contact-alert {
        margin-top: 22px;
        padding: 15px 16px;
        border-radius: 0;
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
    .contact-form {
        display: grid;
        gap: 18px;
        margin-top: 28px;
    }
    .contact-form-grid {
        display: grid;
        gap: 18px;
    }
    @media (min-width: 700px) {
        .contact-form-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    .contact-field label {
        display: block;
        margin-bottom: 9px;
        color: #344054;
        font-size: 13px;
        font-weight: 900;
    }
    .contact-input,
    .contact-textarea {
        width: 100%;
        border: 1px solid #d7dce4;
        border-radius: 0;
        background: rgba(255, 255, 255, 0.84);
        color: #0b101a;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .contact-input {
        height: 54px;
        padding: 0 16px;
    }
    .contact-textarea {
        min-height: 160px;
        resize: vertical;
        padding: 16px;
        line-height: 1.7;
    }
    .contact-input:focus,
    .contact-textarea:focus {
        border-color: #ef4444;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.09);
    }
    .contact-error-text {
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
        line-height: 1.5;
    }
    .contact-prompt-row {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 10px;
    }
    .contact-prompt {
        border: 1px solid rgba(239, 68, 68, 0.18);
        background: #fff5f5;
        color: #b91c1c;
        cursor: pointer;
        padding: 9px 12px;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.35;
        transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }
    .contact-prompt:hover {
        transform: translateY(-1px);
        border-color: rgba(239, 68, 68, 0.36);
        background: #fee2e2;
    }
    .contact-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding-top: 6px;
    }
    @media (min-width: 640px) {
        .contact-actions {
            flex-direction: row;
            align-items: center;
        }
    }
    .contact-submit,
    .contact-whatsapp {
        display: inline-flex;
        min-height: 52px;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 999px;
        padding: 0 22px;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        text-decoration: none;
        transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease, border-color 0.22s ease;
    }
    .contact-submit {
        border: 0;
        background: #ef3333;
        color: #ffffff;
        box-shadow: 0 18px 38px rgba(239, 51, 51, 0.28);
        cursor: pointer;
    }
    .contact-whatsapp {
        color: #0b101a;
        border: 1px solid #d7dce4;
        background: #ffffff;
    }
    .contact-submit:hover,
    .contact-whatsapp:hover {
        transform: translateY(-2px);
    }
    .contact-submit:hover {
        background: #dc2626;
        box-shadow: 0 22px 44px rgba(220, 38, 38, 0.32);
    }
    .contact-whatsapp:hover {
        border-color: rgba(239, 68, 68, 0.42);
        background: #fff5f5;
    }
    .contact-submit svg,
    .contact-whatsapp svg {
        width: 17px;
        height: 17px;
    }
    .contact-form-footer {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-top: 1px solid #e5e7eb;
        background: #f8fafc;
    }
    .contact-form-footer span {
        display: block;
        padding: 14px 16px;
        color: #667085;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.35;
    }
    .contact-form-footer span + span {
        border-left: 1px solid #e5e7eb;
    }
    @media (max-width: 900px) {
        .contact-visual {
            border-left: 0;
            min-height: 520px;
        }
    }
    @media (max-width: 640px) {
        .contact-shell {
            padding-top: 52px;
        }
        .contact-title {
            font-size: clamp(42px, 14vw, 58px);
        }
        .contact-primary-actions,
        .contact-action-primary,
        .contact-action-secondary,
        .contact-submit,
        .contact-whatsapp {
            width: 100%;
        }
        .contact-signal-item,
        .contact-route-item {
            grid-template-columns: 1fr;
        }
        .contact-visual-card {
            left: 20px;
            right: 20px;
            bottom: 22px;
        }
        .contact-visual-meta,
        .contact-form-footer {
            grid-template-columns: 1fr;
        }
        .contact-visual-meta div + div,
        .contact-form-footer span + span {
            border-left: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            padding-left: 0;
        }
        .contact-form-footer span + span {
            border-top-color: #e5e7eb;
        }
        .contact-form-footer span {
            padding: 13px 20px;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .contact-action-primary,
        .contact-action-secondary,
        .contact-prompt,
        .contact-submit,
        .contact-whatsapp {
            transition: none;
        }
    }
</style>

<section class="contact-page">
    <div class="contact-shell">
        <div class="container mx-auto px-4">
            <div class="contact-hero">
                <div class="contact-hero-copy">
                    <p class="contact-kicker">Kontak Rizki Mobil</p>
                    <h1 class="contact-title">Bicarakan mobil yang Anda incar, <span>tanpa tebak-tebakan.</span></h1>
                    <p class="contact-copy">
                        Kirim kebutuhan Anda sebagai brief singkat. Admin Rizki Mobil akan bantu cek stok, kondisi unit, opsi tukar tambah, dan jadwal visit dengan konteks yang jelas.
                    </p>

                    <div class="contact-primary-actions">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="contact-action-primary">
                            Chat WhatsApp
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H8M17 7v9"/>
                            </svg>
                        </a>
                        <a href="{{ route('inventory') }}" class="contact-action-secondary">
                            Lihat Stok
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M6 7v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M9 7V5a3 3 0 0 1 6 0v2"/>
                            </svg>
                        </a>
                    </div>

                    <div class="contact-signal" aria-label="Cara tim Rizki Mobil membantu pelanggan">
                        <div class="contact-signal-item">
                            <span class="contact-signal-code">01</span>
                            <p>
                                <strong>Mulai dari kebutuhan, bukan stok acak.</strong>
                                <span>Ceritakan budget, tipe mobil, dan rencana penggunaan agar rekomendasi lebih presisi.</span>
                            </p>
                        </div>
                        <div class="contact-signal-item">
                            <span class="contact-signal-code">02</span>
                            <p>
                                <strong>Detail unit dijelaskan sebelum Anda datang.</strong>
                                <span>Kondisi, dokumen, dan ketersediaan dikonfirmasi supaya visit terasa lebih yakin.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="contact-visual" aria-hidden="true">
                    <img src="{{ asset('images/cars/fer1.jpg') }}" alt="" class="contact-visual-image">
                    <div class="contact-visual-card">
                        <img src="{{ asset('images/cars/aset/logo-rmi-hitam.png') }}" alt="" class="contact-visual-logo">
                        <h2>RMI concierge: <span>pilih unit, cek detail, atur visit.</span></h2>
                        <div class="contact-visual-meta">
                            <div>
                                <strong>Stok</strong>
                                <span>dicek ulang</span>
                            </div>
                            <div>
                                <strong>Visit</strong>
                                <span>by appointment</span>
                            </div>
                            <div>
                                <strong>Trade-in</strong>
                                <span>bisa dibahas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-brief">
                <aside class="contact-route-panel">
                    <div class="contact-route-heading">
                        <p class="contact-panel-kicker">Pilih jalur</p>
                        <h2>Semua pertanyaan masuk ke alur yang sama: lebih jelas sebelum lihat unit.</h2>
                    </div>

                    <div class="contact-route-item">
                        <span class="contact-route-number">01</span>
                        <p>
                            <strong>WhatsApp untuk respons cepat</strong>
                            <span>Cocok untuk cek stok, harga terbaru, dan jadwal lihat mobil hari ini.</span>
                        </p>
                    </div>
                    <div class="contact-route-item">
                        <span class="contact-route-number">02</span>
                        <p>
                            <strong>Form untuk kebutuhan detail</strong>
                            <span>Lebih enak kalau Anda ingin jelaskan budget, tipe mobil, atau opsi tukar tambah.</span>
                        </p>
                    </div>
                    <div class="contact-route-item">
                        <span class="contact-route-number">03</span>
                        <p>
                            <strong>Visit setelah unit dikonfirmasi</strong>
                            <span>Tim akan bantu pastikan unit tersedia sebelum Anda mengatur waktu datang.</span>
                        </p>
                    </div>
                </aside>

                <div class="contact-form-panel">
                    <div class="contact-form-inner">
                        <div class="contact-form-top">
                            <div>
                                <h2 class="contact-form-heading">Buat brief pembelian</h2>
                                <p class="contact-form-subtitle">Isi data singkat agar admin bisa membalas dengan rekomendasi dan langkah berikutnya yang lebih relevan.</p>
                            </div>
                            <div class="contact-response-badge">
                                <strong>WA</strong>
                                <span>jalur tercepat untuk follow-up</span>
                            </div>
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

                            <div class="contact-form-grid">
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
                                <div class="contact-prompt-row" aria-label="Contoh pesan cepat">
                                    @foreach ($quickPrompts as $prompt)
                                        <button type="button" class="contact-prompt" data-message="{{ $prompt }}">{{ $prompt }}</button>
                                    @endforeach
                                </div>
                                @error('message')
                                    <p class="contact-error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="contact-actions">
                                <button type="submit" class="contact-submit">
                                    Kirim Pesan
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                                    </svg>
                                </button>
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="contact-whatsapp">
                                    Chat WhatsApp
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h8M8 14h5m-9 6 3.5-3.5H20a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10.5a1 1 0 0 0 1 1Z"/>
                                    </svg>
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="contact-form-footer" aria-label="Catatan proses kontak">
                        <span>Harga dan stok dikonfirmasi ulang.</span>
                        <span>Visit sebaiknya dibuat terjadwal.</span>
                        <span>Tukar tambah bisa dibahas lebih awal.</span>
                    </div>
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
