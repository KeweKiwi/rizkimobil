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
    </div>

    @stack('scripts')
</body>
</html>
