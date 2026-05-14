@php
    $whatsappNumber = '6281359359069';
    $whatsappMessage = urlencode('Halo Rizki Mobil, saya ingin tanya stok mobil yang tersedia.');
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}";
@endphp

<style>
    .rmi-footer {
        position: relative;
        overflow: hidden;
        color: #ffffff;
        background:
            radial-gradient(circle at 8% 0%, rgba(239, 68, 68, 0.18), transparent 30%),
            radial-gradient(circle at 92% 100%, rgba(239, 68, 68, 0.12), transparent 30%),
            linear-gradient(135deg, #090d15 0%, #05070c 62%, #120306 100%);
    }
    .rmi-footer::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
        background-size: 72px 72px;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.35), transparent 78%);
        pointer-events: none;
    }
    .rmi-footer::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.8), transparent);
    }
    .rmi-footer-inner {
        position: relative;
        z-index: 1;
        padding-top: clamp(30px, 3.2vw, 40px);
        padding-bottom: 22px;
    }
    .rmi-footer-main {
        display: grid;
        gap: clamp(26px, 4vw, 48px);
        align-items: end;
    }
    @media (min-width: 1024px) {
        .rmi-footer-main {
            grid-template-columns: minmax(0, 1fr) minmax(420px, 0.78fr);
        }
    }
    .rmi-footer-logo {
        width: 118px;
        height: auto;
        filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.28));
    }
    .rmi-footer-title {
        max-width: 760px;
        margin-top: 16px;
        color: #ffffff;
        font-family: var(--font-display);
        font-size: clamp(26px, 2.9vw, 36px);
        font-weight: 900;
        line-height: 1.02;
        letter-spacing: 0;
    }
    .rmi-footer-title span {
        color: #ff4747;
    }
    .rmi-footer-copy {
        max-width: 650px;
        margin-top: 12px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 13px;
        line-height: 1.75;
    }
    .rmi-footer-command {
        display: grid;
        gap: 14px;
        padding: 20px 0 0;
        border-top: 1px solid rgba(255, 255, 255, 0.14);
    }
    @media (min-width: 1024px) {
        .rmi-footer-command {
            padding: 6px 0 6px 34px;
            border-top: 0;
            border-left: 1px solid rgba(255, 255, 255, 0.14);
        }
    }
    .rmi-footer-command-title {
        max-width: 460px;
        color: #ffffff;
        font-family: var(--font-display);
        font-size: clamp(20px, 2.1vw, 26px);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: 0;
    }
    .rmi-footer-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .rmi-footer-button {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border-radius: 999px;
        padding: 0 17px;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        text-decoration: none;
        transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .rmi-footer-button svg {
        width: 16px;
        height: 16px;
    }
    .rmi-footer-button-primary {
        background: #ef3333;
        color: #ffffff;
        box-shadow: 0 14px 30px rgba(239, 51, 51, 0.28);
    }
    .rmi-footer-button-secondary {
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.035);
    }
    .rmi-footer-button:hover {
        transform: translateY(-1px);
    }
    .rmi-footer-button-primary:hover {
        background: #dc2626;
        box-shadow: 0 18px 34px rgba(220, 38, 38, 0.32);
    }
    .rmi-footer-button-secondary:hover {
        border-color: rgba(239, 68, 68, 0.48);
        background: rgba(239, 68, 68, 0.1);
    }
    .rmi-footer-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .rmi-footer-nav a {
        display: inline-flex;
        min-height: 32px;
        align-items: center;
        border-radius: 999px;
        padding: 0 11px;
        color: rgba(255, 255, 255, 0.52);
        font-size: 12px;
        font-weight: 800;
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
        gap: 10px;
        margin-top: clamp(20px, 2.5vw, 28px);
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.4);
        font-size: 12px;
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
        color: rgba(255, 255, 255, 0.38);
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    @media (min-width: 1024px) {
        .rmi-footer-code {
            padding-right: 180px;
        }
    }
    @media (max-width: 640px) {
        .rmi-footer-inner {
            padding-top: 34px;
            padding-bottom: 118px;
        }
        .rmi-footer-logo {
            width: 122px;
        }
        .rmi-footer-title {
            max-width: 24rem;
            margin-top: 18px;
            font-size: 30px;
            line-height: 1.04;
        }
        .rmi-footer-copy {
            font-size: 13px;
            line-height: 1.72;
        }
        .rmi-footer-command-title {
            font-size: 24px;
            line-height: 1.12;
        }
        .rmi-footer-button {
            width: 100%;
        }
        .rmi-footer-nav {
            gap: 4px;
        }
        .rmi-footer-nav a {
            padding-inline: 10px;
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
            </div>

            <div class="rmi-footer-command">
                <p class="rmi-footer-command-title">Tanya unit incaran, atau cek stok yang tersedia.</p>

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
