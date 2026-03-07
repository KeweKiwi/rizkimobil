<header
    class="sticky top-0 z-50 w-full
           border-b border-white/10
           bg-[#0A0C10]/98 backdrop-blur
           supports-[backdrop-filter]:bg-[#0A0C10]/90">

    <nav class="container mx-auto flex h-24 items-center justify-between px-4">
        <!-- LOGO -->
        <div class="flex">
            <a href="{{ route('home') }}" class="flex items-center">
                <img
                    src="{{ asset('images/cars/aset/logo-rmi-hitam.png') }}"
                    alt="Rizki Mobil Indonesia"
                    class="h-28 w-auto object-contain
                           drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]"
                />
            </a>
        </div>

        <!-- DESKTOP MENU -->
        <nav class="hidden md:flex items-center space-x-10 text-base font-medium">
            <a href="{{ route('home') }}"
               class="transition-colors
                      {{ request()->routeIs('home') ? 'text-white' : 'text-white/70' }}
                      hover:text-white">
                Beranda
            </a>

            <a href="{{ route('inventory') }}"
               class="transition-colors
                      {{ request()->routeIs('inventory') ? 'text-white' : 'text-white/70' }}
                      hover:text-white">
                Inventori
            </a>

            <a href="{{ route('contact') }}"
               class="transition-colors
                      {{ request()->routeIs('contact') ? 'text-white' : 'text-white/70' }}
                      hover:text-white">
                Kontak
            </a>
        </nav>

        <!-- ADMIN BUTTON (desktop) -->
        <div class="hidden md:flex items-center">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="/admin"
                       class="text-sm font-medium text-white/70 hover:text-white transition-colors flex items-center gap-1.5">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Admin Panel
                    </a>
                @endif
            @else
                <a href="/admin/login"
                   class="text-sm font-medium text-white/70 hover:text-white transition-colors flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Login
                </a>
            @endauth
        </div>

        <!-- MOBILE BUTTON -->
        <button
            type="button"
            class="inline-flex items-center justify-center rounded-md
                   md:hidden h-10 w-10 text-white
                   hover:bg-white/10 transition"
            onclick="toggleMobileMenu()">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-white/10 bg-[#0A0C10]/98">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="{{ route('home') }}"
               class="block px-4 py-2 rounded-md text-sm font-medium
                      {{ request()->routeIs('home') ? 'bg-white/10 text-white' : 'text-white/80' }}
                      hover:bg-white/10 hover:text-white">
                Beranda
            </a>

            <a href="{{ route('inventory') }}"
               class="block px-4 py-2 rounded-md text-sm font-medium
                      {{ request()->routeIs('inventory') ? 'bg-white/10 text-white' : 'text-white/80' }}
                      hover:bg-white/10 hover:text-white">
                Inventori
            </a>

            <a href="{{ route('contact') }}"
               class="block px-4 py-2 rounded-md text-sm font-medium
                      {{ request()->routeIs('contact') ? 'bg-white/10 text-white' : 'text-white/80' }}
                      hover:bg-white/10 hover:text-white">
                Kontak
            </a>

            @auth
                @if(auth()->user()->is_admin)
                    <a href="/admin"
                       class="block px-4 py-2 rounded-md text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white">
                        Admin Panel
                    </a>
                @endif
            @else
                <a href="/admin/login"
                   class="block px-4 py-2 rounded-md text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white">
                    Login
                </a>
            @endauth
        </div>
    </div>
</header>

@push('scripts')
<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>
@endpush
