@php
    $navLinks = [
        ['route' => 'home', 'label' => 'Beranda'],
        ['route' => 'inventory', 'label' => 'Inventori'],
    ];

    $headerSearchQuery = trim((string) request('search', ''));
    $showHeaderSearch = request()->routeIs('inventory');
@endphp

<style>
    .header-stock-search {
        position: relative;
        width: 100%;
        max-width: 46rem;
    }
    .header-stock-search-form {
        position: relative;
    }
    .header-stock-search-input {
        width: 100%;
        height: 3.25rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.07), rgba(255, 255, 255, 0.04));
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
        border-color: rgba(239, 68, 68, 0.45);
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
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
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
        font-weight: 600;
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
        font-weight: 600;
        white-space: nowrap;
    }
    .header-stock-search-all {
        grid-template-columns: minmax(0, 1fr) auto;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        color: #fff;
        font-weight: 600;
    }
    .header-stock-search-all small {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.2rem;
        display: block;
    }
    @media (max-width: 767px) {
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

<header
    class="sticky top-0 z-50 w-full"
    id="site-header">

    {{-- Top red accent line --}}
    <div class="h-[2px] w-full bg-gradient-to-r from-transparent via-red-600 to-transparent"></div>

    <div class="bg-[#0A0C10]/95 backdrop-blur-md border-b border-white/[0.07]"
         style="box-shadow: 0 4px 30px rgba(0,0,0,0.5), 0 1px 0 rgba(239,68,68,0.08);">

        <nav class="container mx-auto flex h-[68px] items-center justify-between px-4 lg:px-6">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0 group">
                <img
                    src="{{ asset('images/cars/aset/logo-rmi-hitam.png') }}"
                    alt="Rizki Mobil Indonesia"
                    class="h-20 w-auto object-contain transition-all duration-300
                           opacity-90 group-hover:opacity-100"
                />
            </a>

            {{-- DESKTOP NAV --}}
            <div class="hidden md:flex items-center gap-1">
                @foreach($navLinks as $link)
                    @php $active = request()->routeIs($link['route']); @endphp
                    <a href="{{ route($link['route']) }}"
                       class="relative px-4 py-2 text-sm font-medium tracking-wide transition-colors duration-200
                              {{ $active ? 'text-white' : 'text-white/60 hover:text-white' }}">
                        {{ $link['label'] }}
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[2px] rounded-full bg-red-500 transition-all duration-300
                                     {{ $active ? 'w-4/5' : 'w-0' }}"></span>
                    </a>
                @endforeach
            </div>

            {{-- RIGHT SIDE --}}
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('inventory') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold
                          bg-red-600 hover:bg-red-500 text-white
                          transition-all duration-200 shadow-[0_0_16px_rgba(220,38,38,0.4)]
                          hover:shadow-[0_0_24px_rgba(220,38,38,0.6)] hover:-translate-y-px">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Lihat Stok
                </a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="/admin"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium
                                  border border-white/20 text-white/60 hover:text-white hover:border-white/40
                                  transition-all duration-200">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin
                        </a>
                    @endif
                @else
                    <a href="/admin/login"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium
                              border border-white/20 text-white/60 hover:text-white hover:border-white/40
                              transition-all duration-200">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Login
                    </a>
                @endauth
            </div>

            {{-- MOBILE HAMBURGER --}}
            <button
                type="button"
                id="mobile-menu-btn"
                class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-lg
                       text-white/70 hover:text-white hover:bg-white/10 transition"
                aria-expanded="false"
                onclick="toggleMobileMenu()">
                <svg id="icon-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="icon-close" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        @if($showHeaderSearch)
        <div class="border-t border-white/[0.06]">
            <div class="container mx-auto flex items-center justify-between gap-4 px-4 py-3 lg:px-6">
                <div
                    class="header-stock-search"
                    data-global-car-search
                    data-suggestions-url="{{ route('inventory.suggestions') }}"
                    data-results-url="{{ route('inventory') }}"
                >
                    <form action="{{ route('inventory') }}" method="GET" class="header-stock-search-form">
                        <svg class="header-stock-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>

                    <div class="header-stock-search-dropdown hidden" data-search-dropdown></div>
                </div>

                <p class="hidden xl:block shrink-0 text-xs uppercase tracking-[0.22em] text-white/34">
                    Cari langsung dari stok yang tersedia
                </p>
            </div>
        </div>
        @endif
    </div>

    {{-- MOBILE MENU --}}
    <div
        id="mobile-menu"
        class="hidden md:hidden bg-[#0D0F14] border-b border-white/[0.07]
               transition-all duration-200">
        <div class="container mx-auto px-4 py-3 space-y-1">
            @foreach($navLinks as $link)
                @php $active = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}"
                   class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ $active
                              ? 'bg-red-600/15 text-white border-l-2 border-red-500 pl-2'
                              : 'text-white/70 hover:bg-white/[0.06] hover:text-white' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach

            <div class="pt-2 mt-2 border-t border-white/[0.07] flex gap-2">
                <a href="{{ route('inventory') }}"
                   class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold
                          bg-red-600 hover:bg-red-500 text-white transition-colors">
                    Lihat Stok
                </a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="/admin"
                           class="flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-sm font-medium
                                  border border-white/20 text-white/70 hover:text-white transition-colors">
                            Admin
                        </a>
                    @endif
                @else
                    <a href="/admin/login"
                       class="flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-sm font-medium
                              border border-white/20 text-white/70 hover:text-white transition-colors">
                        Login
                    </a>
                @endauth
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

    // Close on outside click
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
