@php
    $whatsappNumber = '6281359359069';
    $whatsappMessage = urlencode('Halo Rizki Mobil, saya ingin tanya stok mobil yang tersedia.');
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}";
@endphp

<style>
    .rmi-footer {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 10% 0%, rgba(239, 68, 68, 0.22), transparent 32%),
            radial-gradient(circle at 88% 18%, rgba(239, 68, 68, 0.12), transparent 28%),
            linear-gradient(135deg, #090d15 0%, #05070c 58%, #120306 100%);
        color: #ffffff;
    }
    .rmi-footer::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.055) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.055) 1px, transparent 1px);
        background-size: 76px 76px;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.38), transparent 72%);
        pointer-events: none;
    }
    .rmi-footer::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.9), transparent);
    }
    .rmi-footer-inner {
        position: relative;
        z-index: 1;
        padding-top: clamp(56px, 7vw, 86px);
        padding-bottom: 26px;
    }
    .rmi-footer-main {
        display: grid;
        gap: clamp(34px, 5vw, 72px);
        align-items: start;
    }
    @media (min-width: 1024px) {
        .rmi-footer-main {
            grid-template-columns: minmax(0, 1.08fr) minmax(360px, 0.92fr);
        }
    }
    .rmi-footer-logo {
        width: 150px;
        height: auto;
        filter: drop-shadow(0 16px 30px rgba(0, 0, 0, 0.34));
    }
    .rmi-footer-title {
        margin-top: 26px;
        max-width: 760px;
        font-family: var(--font-display);
        font-size: clamp(34px, 5vw, 64px);
        font-weight: 900;
        line-height: 0.98;
        letter-spacing: 0;
    }
    .rmi-footer-title span {
        color: #ff4747;
    }
    .rmi-footer-copy {
        margin-top: 20px;
        max-width: 640px;
        color: rgba(255, 255, 255, 0.62);
        font-size: 15px;
        line-height: 1.85;
    }
    .rmi-footer-proof {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        max-width: 760px;
        margin-top: 34px;
        border-block: 1px solid rgba(255, 255, 255, 0.14);
    }
    .rmi-footer-proof span {
        display: block;
        padding: 16px 18px 16px 0;
        color: rgba(255, 255, 255, 0.58);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.45;
    }
    .rmi-footer-proof span + span {
        border-left: 1px solid rgba(255, 255, 255, 0.14);
        padding-left: 18px;
    }
    .rmi-footer-actions {
        display: grid;
        gap: 18px;
        padding: clamp(22px, 4vw, 34px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.035));
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.24);
        backdrop-filter: blur(14px);
    }
    .rmi-footer-actions-label {
        color: rgba(255, 255, 255, 0.52);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }
    .rmi-footer-actions-title {
        color: #ffffff;
        font-family: var(--font-display);
        font-size: clamp(24px, 3vw, 36px);
        font-weight: 900;
        line-height: 1.06;
        letter-spacing: 0;
    }
    .rmi-footer-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 6px;
    }
    .rmi-footer-button {
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
        transition: transform 0.22s ease, background 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
    }
    .rmi-footer-button svg {
        width: 17px;
        height: 17px;
    }
    .rmi-footer-button-primary {
        background: #ef3333;
        color: #ffffff;
        box-shadow: 0 18px 38px rgba(239, 51, 51, 0.3);
    }
    .rmi-footer-button-secondary {
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.04);
    }
    .rmi-footer-button:hover {
        transform: translateY(-2px);
    }
    .rmi-footer-button-primary:hover {
        background: #dc2626;
        box-shadow: 0 22px 44px rgba(220, 38, 38, 0.34);
    }
    .rmi-footer-button-secondary:hover {
        border-color: rgba(239, 68, 68, 0.5);
        background: rgba(239, 68, 68, 0.1);
    }
    .rmi-footer-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
    }
    .rmi-footer-nav a {
        display: inline-flex;
        align-items: center;
        min-height: 36px;
        border-radius: 999px;
        padding: 0 13px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease, background 0.2s ease;
    }
    .rmi-footer-nav a:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.07);
    }
    .rmi-footer-bottom {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-top: clamp(36px, 5vw, 62px);
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.44);
        font-size: 13px;
        line-height: 1.6;
    }
    @media (min-width: 768px) {
        .rmi-footer-bottom {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }
    .rmi-footer-code {
        color: rgba(255, 255, 255, 0.4);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    @media (max-width: 640px) {
        .rmi-footer-inner {
            padding-top: 42px;
            padding-bottom: 132px;
        }
        .rmi-footer-logo {
            width: 132px;
        }
        .rmi-footer-title {
            margin-top: 22px;
            max-width: 22rem;
            font-size: 32px;
            line-height: 1.04;
        }
        .rmi-footer-copy {
            font-size: 14px;
            line-height: 1.75;
        }
        .rmi-footer-proof {
            grid-template-columns: 1fr;
            margin-top: 28px;
        }
        .rmi-footer-proof span {
            padding: 14px 0;
        }
        .rmi-footer-proof span + span {
            border-left: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            padding-left: 0;
        }
        .rmi-footer-actions {
            padding: 22px;
        }
        .rmi-footer-actions-title {
            font-size: 28px;
            line-height: 1.12;
        }
        .rmi-footer-button {
            width: 100%;
        }
        .rmi-footer-nav {
            gap: 8px;
        }
        .rmi-footer-bottom {
            margin-top: 34px;
        }
    }
</style>

<footer class="rmi-footer">
    <div class="container rmi-footer-inner mx-auto px-4">
        <div class="rmi-footer-main">
            <div>
                <a href="{{ route('home') }}" class="inline-flex" aria-label="Rizki Mobil Indonesia">
                    <img
                        src="{{ asset('images/cars/aset/logo-rmi-hitam.png') }}"
                        alt="Rizki Mobil Indonesia"
                        class="rmi-footer-logo"
                    />
                </a>

                <h2 class="rmi-footer-title">Mobil bekas terkurasi, <span>dibicarakan dengan jelas.</span></h2>
                <p class="rmi-footer-copy">
                    Untuk stok, kondisi unit, opsi tukar tambah, dan jadwal lihat mobil, mulai dari percakapan singkat dengan admin Rizki Mobil.
                </p>

                <div class="rmi-footer-proof" aria-label="Prinsip layanan Rizki Mobil">
                    <span>Informasi unit dijelaskan sebelum visit.</span>
                    <span>Stok dan harga dikonfirmasi ulang.</span>
                    <span>Jadwal lihat mobil dibuat lebih terarah.</span>
                </div>
            </div>

            <div class="rmi-footer-actions">
                <p class="rmi-footer-actions-label">Next move</p>
                <p class="rmi-footer-actions-title">Tanya unit yang sedang Anda incar, atau langsung lihat stok tersedia.</p>

                <div class="rmi-footer-buttons">
                    <a
                        href="{{ $whatsappUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rmi-footer-button rmi-footer-button-primary"
                    >
                        Chat WhatsApp
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H8M17 7v9"/>
                        </svg>
                    </a>
                    <a
                        href="{{ route('inventory') }}"
                        class="rmi-footer-button rmi-footer-button-secondary"
                    >
                        Lihat Stok
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M6 7v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M9 7V5a3 3 0 0 1 6 0v2"/>
                        </svg>
                    </a>
                </div>

                <nav class="rmi-footer-nav" aria-label="Footer navigation">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('inventory') }}">Inventori</a>
                    <a href="{{ route('home') }}#tentang">Tentang</a>
                    <a href="{{ route('home') }}#faq">FAQ</a>
                    <a href="{{ route('contact') }}">Kontak</a>
                </nav>
            </div>
        </div>

        <div class="rmi-footer-bottom">
            <p>© {{ date('Y') }} Rizki Mobil Indonesia. Stok dan harga dapat berubah; konfirmasi terakhir melalui admin.</p>
            <p class="rmi-footer-code">RMI / verified used car</p>
        </div>
    </div>
</footer>
