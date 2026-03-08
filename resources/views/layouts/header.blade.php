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
                @php
                    $navLinks = [
                        ['route' => 'home',      'label' => 'Beranda'],
                        ['route' => 'inventory', 'label' => 'Inventori'],
                        ['route' => 'contact',   'label' => 'Kontak'],
                    ];
                @endphp
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
</script>
@endpush

