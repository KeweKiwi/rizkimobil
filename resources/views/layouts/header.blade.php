@php
    $navLinks = [
        ['route' => 'home', 'label' => 'Beranda'],
        ['route' => 'inventory', 'label' => 'Inventori'],
        ['route' => 'favorites.index', 'label' => 'Tersimpan'],
        ['route' => 'contact', 'label' => 'Kontak'],
    ];

    $headerSearchQuery = trim((string) request('search', ''));
    $showHeaderSearch = request()->routeIs('inventory');
@endphp

<style>
    .rmi-header {
        position: sticky;
        top: 0;
        z-index: 50;
        width: 100%;
    }
    .rmi-header::before {
        content: '';
        display: block;
        height: 2px;
        background: linear-gradient(90deg, transparent, #ef3333 34%, rgba(255, 255, 255, 0.28) 50%, #ef3333 66%, transparent);
    }
    .rmi-header-shell {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 12% 0%, rgba(239, 68, 68, 0.14), transparent 28%),
            linear-gradient(180deg, rgba(15, 18, 24, 0.98), rgba(8, 10, 14, 0.96));
        border-bottom: 1px solid rgba(255, 255, 255, 0.09);
        box-shadow: 0 18px 54px rgba(0, 0, 0, 0.38);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }
    .rmi-header-shell::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
        background-size: 64px 64px;
        opacity: 0.42;
        pointer-events: none;
    }
    .rmi-header-nav {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: auto 1fr auto;
        min-height: 78px;
        align-items: center;
        gap: 24px;
    }
    .rmi-header-brand {
        display: inline-flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        color: #ffffff;
        text-decoration: none;
    }
    .rmi-header-logo {
        width: 150px;
        height: auto;
        filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.32));
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    .rmi-header-brand:hover .rmi-header-logo {
        transform: translateY(-1px);
        opacity: 0.94;
    }
    .rmi-header-brand-copy {
        display: grid;
        gap: 2px;
        max-width: 260px;
    }
    .rmi-header-brand-copy strong,
    .rmi-header-brand-copy span {
        display: block;
        line-height: 1.08;
    }
    .rmi-header-brand-copy strong {
        color: rgba(255, 255, 255, 0.86);
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.045em;
    }
    .rmi-header-brand-copy span {
        color: rgba(255, 255, 255, 0.46);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 0.08em;
    }
    .rmi-header-brand-copy .rmi-header-brand-credit {
        color: rgba(255, 255, 255, 0.78);
        font-size: 9px;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }
    .rmi-header-center {
        display: none;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .rmi-header-center {
            display: flex;
        }
    }
    .rmi-header-nav-rail {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.045);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }
    .rmi-header-link {
        position: relative;
        display: inline-flex;
        min-height: 38px;
        align-items: center;
        border-radius: 999px;
        padding: 0 16px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.03em;
        text-decoration: none;
        transition: color 0.2s ease, background 0.2s ease, transform 0.2s ease;
    }
    .rmi-header-link:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.07);
    }
    .rmi-header-link.is-active {
        color: #ffffff;
        background: rgba(239, 68, 68, 0.18);
        box-shadow: inset 0 0 0 1px rgba(239, 68, 68, 0.18);
    }
    .rmi-header-actions {
        display: none;
        align-items: center;
        gap: 10px;
        justify-content: end;
    }
    @media (min-width: 768px) {
        .rmi-header-actions {
            display: flex;
        }
    }
    .rmi-header-cta,
    .rmi-header-ghost {
        appearance: none;
        border: 0;
        cursor: pointer;
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border-radius: 999px;
        padding: 0 18px;
        font-size: 13px;
        font-family: inherit;
        font-weight: 900;
        letter-spacing: 0.02em;
        text-decoration: none;
        transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .rmi-header-cta {
        color: #ffffff;
        background: #ef3333;
        box-shadow: 0 16px 36px rgba(239, 51, 51, 0.32);
    }
    .rmi-header-cta:hover {
        transform: translateY(-1px);
        background: #dc2626;
        box-shadow: 0 20px 42px rgba(220, 38, 38, 0.38);
    }
    .rmi-header-ghost {
        color: rgba(255, 255, 255, 0.68);
        border: 1px solid rgba(255, 255, 255, 0.16);
        background: rgba(255, 255, 255, 0.04);
    }
    .rmi-header-ghost:hover {
        color: #ffffff;
        border-color: rgba(239, 68, 68, 0.42);
        background: rgba(239, 68, 68, 0.1);
    }
    .rmi-header-cta svg,
    .rmi-header-ghost svg {
        width: 16px;
        height: 16px;
    }
    .rmi-header-auth-form {
        display: inline-flex;
        margin: 0;
    }
    .rmi-header-account {
        max-width: 190px;
    }
    .rmi-header-account span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .rmi-mobile-toggle {
        display: inline-flex;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        justify-self: end;
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 999px;
        color: rgba(255, 255, 255, 0.76);
        background: rgba(255, 255, 255, 0.055);
        transition: color 0.2s ease, background 0.2s ease, border-color 0.2s ease;
    }
    .rmi-mobile-toggle:hover {
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.28);
        background: rgba(255, 255, 255, 0.09);
    }
    @media (min-width: 768px) {
        .rmi-mobile-toggle {
            display: none;
        }
    }
    .header-stock-search {
        position: relative;
        width: 100%;
        max-width: 48rem;
    }
    .header-stock-search-form {
        position: relative;
    }
    .header-stock-search-input {
        width: 100%;
        height: 3.25rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
        padding: 0 3.25rem 0 3rem;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .header-stock-search-input::placeholder {
        color: rgba(255, 255, 255, 0.46);
    }
    .header-stock-search-input:focus {
        border-color: rgba(239, 68, 68, 0.48);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08), 0 18px 42px rgba(0, 0, 0, 0.28);
    }
    .header-stock-search-icon,
    .header-stock-search-clear {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
    }
    .header-stock-search-icon {
        left: 0.95rem;
        width: 1.125rem;
        height: 1.125rem;
        color: rgba(255, 255, 255, 0.56);
        pointer-events: none;
    }
    .header-stock-search-clear {
        right: 0.75rem;
        width: 1.9rem;
        height: 1.9rem;
        border: none;
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.62);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .header-stock-search-clear:hover {
        background: rgba(239, 68, 68, 0.14);
        color: #fff;
    }
    .header-stock-search-dropdown {
        position: absolute;
        top: calc(100% + 0.7rem);
        left: 0;
        right: 0;
        z-index: 70;
        overflow: hidden;
        border-radius: 1.35rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(180deg, rgba(16, 18, 22, 0.98), rgba(9, 10, 13, 0.98));
        box-shadow: 0 28px 60px rgba(0, 0, 0, 0.42);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }
    .header-stock-search-status {
        padding: 1rem 1.25rem;
        color: rgba(255, 255, 255, 0.64);
        font-size: 0.875rem;
    }
    .header-stock-search-results {
        display: grid;
    }
    .header-stock-search-item,
    .header-stock-search-all {
        display: grid;
        grid-template-columns: 3.5rem minmax(0, 1fr) auto;
        gap: 0.9rem;
        align-items: center;
        padding: 0.9rem 1rem;
        color: inherit;
        text-decoration: none;
        transition: background 0.2s ease;
    }
    .header-stock-search-item:hover,
    .header-stock-search-all:hover {
        background: rgba(255, 255, 255, 0.04);
    }
    .header-stock-search-thumb {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1rem;
        object-fit: cover;
        background: rgba(255, 255, 255, 0.06);
    }
    .header-stock-search-label {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.35;
    }
    .header-stock-search-meta {
        margin-top: 0.2rem;
        color: rgba(255, 255, 255, 0.52);
        font-size: 0.76rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .header-stock-search-price {
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .header-stock-search-all {
        grid-template-columns: minmax(0, 1fr) auto;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        color: #fff;
        font-weight: 700;
    }
    .header-stock-search-all small {
        display: block;
        margin-top: 0.2rem;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        font-weight: 500;
    }
    .rmi-header-search-shelf {
        position: relative;
        z-index: 1;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.025);
    }
    .rmi-mobile-menu {
        position: relative;
        z-index: 1;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(6, 8, 12, 0.98);
    }
    .rmi-mobile-menu-panel {
        display: grid;
        gap: 10px;
        padding: 16px 0 18px;
    }
    .rmi-mobile-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 48px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 0 14px;
        color: rgba(255, 255, 255, 0.72);
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
    }
    .rmi-mobile-link.is-active {
        color: #ffffff;
        border-color: rgba(239, 68, 68, 0.32);
        background: rgba(239, 68, 68, 0.12);
    }
    .rmi-mobile-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 10px;
        padding-top: 8px;
    }
    .rmi-mobile-actions form {
        display: contents;
    }
    .rmi-mobile-actions .rmi-header-cta,
    .rmi-mobile-actions .rmi-header-ghost {
        width: 100%;
    }
    @media (max-width: 767px) {
        .rmi-header-nav {
            grid-template-columns: 1fr auto;
            min-height: 92px;
        }
        .rmi-header-logo {
            width: 132px;
        }
        .rmi-header-brand-copy {
            max-width: 230px;
        }
        .rmi-header-brand-copy strong {
            font-size: 8.5px;
        }
        .rmi-header-brand-copy span,
        .rmi-header-brand-copy .rmi-header-brand-credit {
            font-size: 8px;
        }
        .header-stock-search-input {
            height: 3rem;
            font-size: 0.9rem;
        }
        .header-stock-search-item,
        .header-stock-search-all {
            grid-template-columns: 3rem minmax(0, 1fr);
        }
        .header-stock-search-price {
            display: none;
        }
    }
</style>

<header class="rmi-header" id="site-header">
    <div class="rmi-header-shell">
        <nav class="container rmi-header-nav mx-auto px-4 lg:px-6" aria-label="Primary navigation">
            <a href="{{ route('home') }}" class="rmi-header-brand">
                <img
                    src="{{ asset('images/cars/aset/logo-rmi-hitam.png') }}"
                    alt="Rizki Mobil Indonesia"
                    class="rmi-header-logo"
                />
                <span class="rmi-header-brand-copy">
                    <strong>Jual Beli Mobil Bekas Berkualitas</strong>
                    <span class="rmi-header-brand-credit">CASH DAN KREDIT</span>
                    <span>Bisa Proses seluruh Wilayah Indonesia</span>
                </span>
            </a>

            <div class="rmi-header-center">
                <div class="rmi-header-nav-rail">
                    @foreach($navLinks as $link)
                        @php $active = request()->routeIs($link['route']); @endphp
                        <a href="{{ route($link['route']) }}" class="rmi-header-link {{ $active ? 'is-active' : '' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="rmi-header-actions">
                <a href="{{ route('inventory') }}" class="rmi-header-cta">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M6 7v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M9 7V5a3 3 0 0 1 6 0v2"/>
                    </svg>
                    Lihat Stok
                </a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="/admin" class="rmi-header-ghost">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            Admin
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="rmi-header-auth-form">
                        @csrf
                        <button type="submit" class="rmi-header-ghost">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H9m9 0-3-3m3 3-3 3"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                    <a href="{{ route('account.show') }}" class="rmi-header-ghost rmi-header-account" title="Akun {{ auth()->user()->name }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.5 20.25a8.25 8.25 0 0 1 15 0"/>
                        </svg>
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="rmi-header-ghost">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 21a6 6 0 0 0-12 0M9 10.5a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5z"/>
                        </svg>
                        Daftar
                    </a>
                    <a href="{{ route('login') }}" class="rmi-header-ghost">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/>
                        </svg>
                        Masuk
                    </a>
                @endauth
            </div>

            <button
                type="button"
                id="mobile-menu-btn"
                data-mobile-menu-toggle
                class="rmi-mobile-toggle"
                aria-expanded="false"
                aria-label="Toggle navigation"
                onclick="toggleMobileMenu()"
            >
                <svg id="icon-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
                <svg id="icon-close" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </nav>

        @if($showHeaderSearch)
            <div class="rmi-header-search-shelf">
                <div class="container mx-auto flex items-center justify-between gap-4 px-4 py-3 lg:px-6">
                    <div
                        class="header-stock-search"
                        data-global-car-search
                        data-suggestions-url="{{ route('inventory.suggestions') }}"
                        data-results-url="{{ route('inventory') }}"
                    >
                        <form action="{{ route('inventory') }}" method="GET" class="header-stock-search-form">
                            <svg class="header-stock-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"/>
                            </svg>
                            <input
                                type="search"
                                name="search"
                                value="{{ $headerSearchQuery }}"
                                placeholder="Cari stok mobil, merek, atau model"
                                class="header-stock-search-input"
                                autocomplete="off"
                                data-search-input
                            />
                            <button
                                type="button"
                                class="header-stock-search-clear {{ $headerSearchQuery === '' ? 'hidden' : '' }}"
                                aria-label="Hapus pencarian"
                                data-search-clear
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>

                        <div class="header-stock-search-dropdown hidden" data-search-dropdown></div>
                    </div>

                    <p class="hidden shrink-0 text-xs font-black uppercase tracking-[0.22em] text-white/34 xl:block">
                        Stok tersedia / live search
                    </p>
                </div>
            </div>
        @endif

        <div id="mobile-menu" class="rmi-mobile-menu hidden md:hidden">
            <div class="container mx-auto px-4">
                <div class="rmi-mobile-menu-panel">
                    @foreach($navLinks as $link)
                        @php $active = request()->routeIs($link['route']); @endphp
                        <a href="{{ route($link['route']) }}" class="rmi-mobile-link {{ $active ? 'is-active' : '' }}">
                            {{ $link['label'] }}
                            <span>{{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}</span>
                        </a>
                    @endforeach

                    <div class="rmi-mobile-actions">
                        <a href="{{ route('inventory') }}" class="rmi-header-cta">Lihat Stok</a>
                        @auth
                            @if(auth()->user()->is_admin)
                                <a href="/admin" class="rmi-header-ghost">Admin</a>
                            @endif
                            <a href="{{ route('account.show') }}" class="rmi-header-ghost">Akun: {{ auth()->user()->name }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rmi-header-ghost">Keluar</button>
                            </form>
                        @else
                            <a href="{{ route('register') }}" class="rmi-header-ghost">Daftar</a>
                            <a href="{{ route('login') }}" class="rmi-header-ghost">Masuk</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
    function escapeHeaderSearchHtml(value) {
        return value
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function renderHeaderSearchSuggestions(root, suggestions, query) {
        const dropdown = root.querySelector('[data-search-dropdown]');
        const resultsUrl = root.dataset.resultsUrl;
        const safeQuery = escapeHeaderSearchHtml(query);

        if (!Array.isArray(suggestions) || suggestions.length === 0) {
            dropdown.innerHTML = `
                <div class="header-stock-search-status">
                    Tidak ada stok yang cocok${safeQuery ? ` untuk "<strong>${safeQuery}</strong>"` : ''}.
                </div>
                <a class="header-stock-search-all" href="${resultsUrl}?search=${encodeURIComponent(query)}">
                    <div>
                        Lihat semua hasil pencarian
                        <small>Buka halaman inventori dengan kata kunci ini</small>
                    </div>
                    <svg class="h-4 w-4 text-white/45" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7 7 7-7 7" />
                    </svg>
                </a>
            `;
            dropdown.classList.remove('hidden');
            return;
        }

        const items = suggestions.map((item) => `
            <a class="header-stock-search-item" href="${item.url}">
                <img class="header-stock-search-thumb" src="${item.image}" alt="${escapeHeaderSearchHtml(item.label)}">
                <div>
                    <div class="header-stock-search-label">${escapeHeaderSearchHtml(item.label)}</div>
                    <div class="header-stock-search-meta">${escapeHeaderSearchHtml(item.meta)}</div>
                </div>
                <div class="header-stock-search-price">${escapeHeaderSearchHtml(item.price)}</div>
            </a>
        `).join('');

        dropdown.innerHTML = `
            <div class="header-stock-search-results">${items}</div>
            <a class="header-stock-search-all" href="${resultsUrl}?search=${encodeURIComponent(query)}">
                <div>
                    Lihat semua hasil pencarian
                    <small>Filter inventori dengan kata kunci ini</small>
                </div>
                <svg class="h-4 w-4 text-white/45" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7 7 7-7 7" />
                </svg>
            </a>
        `;
        dropdown.classList.remove('hidden');
    }

    function setupGlobalCarSearch(root) {
        const input = root.querySelector('[data-search-input]');
        const dropdown = root.querySelector('[data-search-dropdown]');
        const clearButton = root.querySelector('[data-search-clear]');
        const form = root.querySelector('form');
        const suggestionsUrl = root.dataset.suggestionsUrl;
        let debounceTimer = null;
        let requestToken = 0;

        const setLoading = () => {
            dropdown.innerHTML = '<div class="header-stock-search-status">Mencari stok mobil...</div>';
            dropdown.classList.remove('hidden');
        };

        const loadSuggestions = (query = '') => {
            requestToken += 1;
            const currentToken = requestToken;
            setLoading();

            fetch(`${suggestionsUrl}?q=${encodeURIComponent(query)}`, {
                headers: {
                    'Accept': 'application/json',
                },
            })
                .then((response) => response.json())
                .then((payload) => {
                    if (currentToken !== requestToken) {
                        return;
                    }

                    renderHeaderSearchSuggestions(root, payload.suggestions ?? [], query);
                })
                .catch(() => {
                    if (currentToken !== requestToken) {
                        return;
                    }

                    dropdown.innerHTML = '<div class="header-stock-search-status">Suggestion belum bisa dimuat. Coba lagi sebentar.</div>';
                    dropdown.classList.remove('hidden');
                });
        };

        const syncClearButton = () => {
            clearButton.classList.toggle('hidden', input.value.trim() === '');
        };

        input.addEventListener('focus', () => {
            loadSuggestions(input.value.trim());
        });

        input.addEventListener('input', () => {
            syncClearButton();
            window.clearTimeout(debounceTimer);
            debounceTimer = window.setTimeout(() => {
                loadSuggestions(input.value.trim());
            }, 180);
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                dropdown.classList.add('hidden');
            }
        });

        clearButton.addEventListener('click', () => {
            input.value = '';
            syncClearButton();
            input.focus();
            loadSuggestions('');
        });

        form.addEventListener('submit', (event) => {
            if (input.value.trim() === '') {
                event.preventDefault();
                window.location.href = form.action;
            }
        });

        document.addEventListener('click', (event) => {
            if (!root.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }

    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');
        const btn = document.getElementById('mobile-menu-btn');
        const isOpen = !menu.classList.contains('hidden');

        menu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', String(!isOpen));
    }

    document.addEventListener('click', function(e) {
        const header = document.getElementById('site-header');
        if (!header.contains(e.target)) {
            const menu = document.getElementById('mobile-menu');
            if (!menu.classList.contains('hidden')) toggleMobileMenu();
        }
    });

    document.querySelectorAll('[data-global-car-search]').forEach(setupGlobalCarSearch);
</script>
@endpush
