<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CarVault') }}</title>

    <!-- Fonts: Inter (Headings/UI) + Exo 2 (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Exo+2:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-body">
    <div class="flex min-h-screen flex-col">
        @include('layouts.header')

        <main class="flex-1">
            @yield('content')
        </main>

        @if(!isset($hideFooter) || !$hideFooter)
            @include('layouts.footer')
        @endif

        @if(empty($hideFloatingWhatsApp))
            <!-- WhatsApp Floating Button -->
            <a href="https://wa.me/6281359359069?text=Halo%20Rizki%20Mobil%2C%20saya%20tertarik%20dengan%20mobil%20di%20website%20Anda"
               target="_blank"
               rel="noopener noreferrer"
               class="fixed bottom-4 right-4 z-50 group sm:bottom-6 sm:right-6"
               aria-label="Chat via WhatsApp">
                <!-- Button Container -->
                <div class="flex items-center gap-3 rounded-full bg-gradient-to-br from-red-600 to-red-700 p-3 shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(220,38,38,0.6)] hover:from-red-500 hover:to-red-600 sm:px-5 sm:py-3.5">
                    <!-- WhatsApp Icon -->
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <!-- Pulse animation -->
                        <span class="absolute -inset-0.5 rounded-full bg-white/20 animate-ping"></span>
                    </div>

                    <!-- Text -->
                    <span class="hidden font-semibold text-white text-base pr-1 sm:inline">Chat Kami</span>
                </div>

                <!-- Glow effect -->
                <div class="absolute inset-0 -z-10 rounded-full bg-red-600/40 blur-xl transition-all duration-300 group-hover:bg-red-600/60"></div>
            </a>
        @endif
    </div>

    @stack('scripts')
</body>
</html>
