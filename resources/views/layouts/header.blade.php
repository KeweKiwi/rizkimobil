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
