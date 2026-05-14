@extends('layouts.app')

@section('content')
    <!-- Lightbox -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/95 backdrop-blur-sm">
        <button onclick="closeLightbox()"
            class="absolute right-4 top-4 inline-flex h-12 w-12 items-center justify-center rounded-lg border border-red-600/30 bg-black/50 text-white transition-all hover:border-red-600 hover:bg-red-600/20">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <button onclick="prevLightboxImage()"
            class="absolute left-4 inline-flex h-12 w-12 items-center justify-center rounded-lg border border-red-600/30 bg-black/50 text-white transition-all hover:border-red-600 hover:bg-red-600/20">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <img id="lightbox-image" src="" alt="{{ $car->make }} {{ $car->model }}"
            class="max-h-[90vh] max-w-[90vw] object-contain" />
        <button onclick="nextLightboxImage()"
            class="absolute right-4 inline-flex h-12 w-12 items-center justify-center rounded-lg border border-red-600/30 bg-black/50 text-white transition-all hover:border-red-600 hover:bg-red-600/20">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div id="lightbox-indicators" class="absolute bottom-4 flex gap-2">
            @foreach ($car->images as $index => $image)
                <button
                    class="h-2 w-2 rounded-full transition-all {{ $index === 0 ? 'w-8 bg-red-600' : 'bg-white/50 hover:bg-white/80' }}"
                    onclick="setLightboxImage({{ $index }})" data-lightbox-indicator="{{ $index }}"></button>
            @endforeach
        </div>
    </div>

    <div class="container mx-auto px-4 py-6 sm:py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 flex items-center gap-2 text-xs sm:text-sm text-gray-500 overflow-x-auto pb-2">
            <a href="{{ route('home') }}" class="hover:text-red-600 transition-colors whitespace-nowrap">Beranda</a>
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('inventory') }}" class="hover:text-red-600 transition-colors whitespace-nowrap">Inventori</a>
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-foreground truncate">{{ $car->year }} {{ $car->make }} {{ $car->model }}</span>
        </nav>

        <div class="grid gap-6 lg:grid-cols-5">
            <!-- Left Column - Images & Description -->
            <div class="lg:col-span-3">
                @php
                    $mainImage = $car->primaryImage
                        ? asset($car->primaryImage->image_path)
                        : 'https://via.placeholder.com/800x600?text=No+Image';
                @endphp

                <!-- Main Image -->
                <div class="relative aspect-[4/3] sm:aspect-[16/10] cursor-pointer overflow-hidden rounded-xl border border-red-600/20 shadow-[0_0_20px_rgba(220,38,38,0.1)] bg-muted"
                    onclick="openLightbox()">
                    <img id="main-image" src="{{ $mainImage }}" alt="{{ $car->make }} {{ $car->model }}"
                        class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
                    @if (count($car->images) > 1)
                        <button onclick="event.stopPropagation(); prevImage()"
                            class="absolute left-3 top-1/2 inline-flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-lg border border-red-600/30 bg-black/60 backdrop-blur-sm text-white transition-all hover:border-red-600 hover:bg-red-600/80">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button onclick="event.stopPropagation(); nextImage()"
                            class="absolute right-3 top-1/2 inline-flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-lg border border-red-600/30 bg-black/60 backdrop-blur-sm text-white transition-all hover:border-red-600 hover:bg-red-600/80">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @endif
                    <div class="absolute bottom-3 left-3 flex gap-1.5">
                        @if ($car->featured ?? false)
                            <span
                                class="inline-flex items-center rounded-full bg-amber-500 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg">
                                Unggulan
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Thumbnails -->
                @if (count($car->images) > 1)
                    <div class="mt-3 sm:mt-4 flex gap-2 sm:gap-3 overflow-x-auto pb-2">
                        @foreach ($car->images as $index => $img)
                            <button
                                class="relative h-16 w-20 sm:h-20 sm:w-28 shrink-0 overflow-hidden rounded-lg border transition-all {{ $index === 0 ? 'border-red-600 ring-2 ring-red-600/30' : 'border-gray-700 hover:border-red-600/50 opacity-60 hover:opacity-100' }}"
                                onclick="setMainImage({{ $index }})" data-thumbnail="{{ $index }}">
                                <img src="{{ asset($img->image_path) }}" alt=""
                                    loading="lazy" decoding="async"
                                    class="h-full w-full object-cover" />
                            </button>
                        @endforeach>
                    </div>
                @endif

                <!-- Description -->
                <div class="mt-6 sm:mt-8 rounded-xl border border-red-600/20 bg-card shadow-[0_0_20px_rgba(220,38,38,0.05)]">
                    <div class="p-4 sm:p-6 pb-3 sm:pb-4 border-b border-red-600/10">
                        <h3 class="font-display text-lg sm:text-xl font-bold text-foreground flex items-center gap-2">
                            <span class="h-1 w-6 sm:w-8 bg-gradient-to-r from-red-600 to-transparent rounded-full"></span>
                            Tentang Kendaraan Ini
                        </h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <p class="leading-relaxed text-sm sm:text-base text-gray-600">
                            {{ $car->description ?? 'Tidak ada deskripsi tersedia.' }}</p>

                        @if ($car->features && count($car->features) > 0)
                            <div class="mt-6">
                                <h4 class="mb-3 text-sm sm:text-base font-semibold text-foreground">Fitur</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($car->features as $feature)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-red-600/20 bg-red-600/5 px-2.5 sm:px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:border-red-600/40 hover:bg-red-600/10">
                                            <svg class="h-3 w-3 text-red-600 shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Specifications & Price -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Vehicle Information -->
                <div class="rounded-xl border border-red-600/20 bg-card shadow-[0_0_20px_rgba(220,38,38,0.05)]">
                    <div class="p-4 sm:p-6 pb-3 sm:pb-4 border-b border-red-600/10">
                        <h3 class="font-display text-lg sm:text-xl font-bold text-foreground flex items-center gap-2">
                            <span class="h-1 w-6 sm:w-8 bg-gradient-to-r from-red-600 to-transparent rounded-full"></span>
                            Detail Spesifikasi
                        </h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                            <!-- Kilometer -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <img src="{{ asset('images/icons/road.svg') }}" alt="Road" class="h-5 w-5 brightness-0 invert">
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Kilometer</p>
                                    <p class="font-bold text-foreground text-base">{{ number_format($car->mileage_km, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Tahun Perakitan -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <img src="{{ asset('images/icons/calendar.svg') }}" alt="Calendar" class="h-5 w-5 brightness-0 invert">
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Tahun Perakitan</p>
                                    <p class="font-bold text-foreground text-base">{{ $car->year }}</p>
                                </div>
                            </div>

                            <!-- Plat Nomor -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 6h16v2H4zm0 5h16v7H4z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Plat Nomor</p>
                                    <p class="font-bold text-foreground text-base">{{ ucfirst($car->plate_parity) }}</p>
                                </div>
                            </div>

                            <!-- Transmisi -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <img src="{{ asset('images/icons/transmission.svg') }}" alt="Transmission" class="h-5 w-5 brightness-0 invert">
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Transmisi</p>
                                    <p class="font-bold text-foreground text-base">{{ $car->transmission }}</p>
                                </div>
                            </div>

                            <!-- Warna -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5s1.5.67 1.5 1.5S10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 9 17.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Warna</p>
                                    <p class="font-bold text-foreground text-base">{{ strtoupper($car->color) }}</p>
                                </div>
                            </div>

                            <!-- Seater -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 18v3h3v-3h10v3h3v-6H4zm15-8h3v3h-3zM2 10h3v3H2zm15 3H7V5c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2v8z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Seater</p>
                                    <p class="font-bold text-foreground text-base">{{ $car->seats }} Seater</p>
                                </div>
                            </div>

                            <!-- Bahan Bakar -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <img src="{{ asset('images/icons/fuel.svg') }}" alt="Fuel" class="h-5 w-5 brightness-0 invert">
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Bahan Bakar</p>
                                    <p class="font-bold text-foreground text-base">{{ $car->fuel_type }}</p>
                                </div>
                            </div>

                            <!-- Masa Berlaku STNK -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Masa Berlaku STNK</p>
                                    <p class="font-bold text-foreground text-base">{{ $car->stnk_valid_until ? $car->stnk_valid_until->format('M Y') : '-' }}</p>
                                </div>
                            </div>

                            <!-- Type -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white">
                                    <img src="{{ asset('images/icons/car.svg') }}" alt="Car" class="h-5 w-5 brightness-0 invert">
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Type</p>
                                    <p class="font-bold text-foreground text-base">{{ $car->body_type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Card -->
                <div class="rounded-xl border border-red-600/20 bg-white shadow-[0_0_30px_rgba(220,38,38,0.1)]">
                    <div class="p-4 sm:p-6">
                        <div class="mb-4">
                            <p class="text-xs sm:text-sm text-gray-500">{{ $car->year }} {{ $car->make }}</p>
                            <h1 class="font-display text-xl sm:text-2xl font-bold text-foreground">
                                {{ $car->model }}{{ $car->variant ? ' ' . $car->variant : '' }}
                            </h1>
                        </div>

                        <div
                            class="relative rounded-lg border border-red-600/30 bg-gradient-to-br from-gray-50 via-white to-gray-50 p-4 sm:p-5 shadow-[0_0_30px_rgba(220,38,38,0.12)]">
                            <div
                                class="absolute -top-3 left-4 bg-white px-3 py-1 rounded-full border border-red-600/30 shadow-sm">
                                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Harga Terbaik</p>
                            </div>
                            <p class="font-display text-2xl sm:text-4xl font-bold text-red-600 mt-2">
                                Rp {{ number_format($car->price, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-2">Harga dapat berubah sewaktu-waktu</p>
                        </div>

                        <div class="my-6 h-px bg-gradient-to-r from-transparent via-red-600/30 to-transparent"></div>

                        <!-- Quick Specs -->
                        {{-- <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
                                <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <div>
                                    <p class="text-[10px] text-gray-500 leading-tight">Kilometer</p>
                                    <p class="text-xs font-semibold text-foreground">{{ number_format($car->mileage_km) }}
                                        km</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
                                <svg class="h-4 w-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19.77 7.23l.01-.01-3.72-3.72L15 4.56l2.11 2.11c-.94.36-1.61 1.26-1.61 2.33 0 1.38 1.12 2.5 2.5 2.5.36 0 .69-.08 1-.21v7.21c0 .55-.45 1-1 1s-1-.45-1-1V14c0-1.1-.9-2-2-2h-1V5c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v16h10v-7.5h1.5v5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V9c0-.69-.28-1.32-.73-1.77zM12 10H6V5h6v5zm6 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" />
                                </svg>
                                <div>
                                    <p class="text-[10px] text-gray-500 leading-tight">Bahan Bakar</p>
                                    <p class="text-xs font-semibold text-foreground">{{ ucfirst($car->fuel_type) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
                                <svg class="h-4 w-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M7 6c-.55 0-1 .45-1 1v2c0 .55.45 1 1 1s1-.45 1-1V7c0-.55-.45-1-1-1zm0 6c-.55 0-1 .45-1 1v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1zm4-9c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1s1-.45 1-1V4c0-.55-.45-1-1-1zm0 10c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1s1-.45 1-1v-4c0-.55-.45-1-1-1zm4-7c-.55 0-1 .45-1 1v2c0 .55.45 1 1 1s1-.45 1-1V7c0-.55-.45-1-1-1zm0 6c-.55 0-1 .45-1 1v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1zm4-9c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1s1-.45 1-1V4c0-.55-.45-1-1-1zm0 10c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1s1-.45 1-1v-4c0-.55-.45-1-1-1z" />
                                </svg>
                                <div>
                                    <p class="text-[10px] text-gray-500 leading-tight">Transmisi</p>
                                    <p class="text-xs font-semibold text-foreground">{{ ucfirst($car->transmission) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
                                <svg class="h-4 w-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.92 5.01C18.72 4.42 18.16 4 17.5 4h-11c-.66 0-1.21.42-1.42 1.01L3 11v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 6h10.29l1.08 3.11H5.77L6.85 6zM19 17H5v-5h14v5zm-8-4c-.83 0-1.5.67-1.5 1.5S10.17 16 11 16s1.5-.67 1.5-1.5S11.83 13 11 13zm6 0c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5S17.83 13 17 13z" />
                                </svg>
                                <div>
                                    <p class="text-[10px] text-gray-500 leading-tight">Tipe Bodi</p>
                                    <p class="text-xs font-semibold text-foreground">{{ strtoupper($car->body_type) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="my-6 h-px bg-gradient-to-r from-transparent via-red-600/30 to-transparent"></div> --}}

                        <!-- CTA Buttons -->
                        <div class="space-y-3">
                            @php
                                $whatsappMessage = urlencode(
                                    "Halo! Saya tertarik dengan {$car->year} {$car->make} {$car->model} yang terdaftar di Rp " .
                                        number_format($car->price, 0, ',', '.') .
                                        '. Apakah masih tersedia?',
                                );
                                $whatsappLink = "https://wa.me/6281359359069?text={$whatsappMessage}";
                            @endphp

                            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex h-11 sm:h-12 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-[#25D366] to-[#128C7E] px-4 sm:px-6 text-sm font-semibold text-white shadow-lg shadow-[#25D366]/30 transition-all hover:shadow-xl hover:shadow-[#25D366]/40 hover:-translate-y-0.5">
                                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Hubungi via WhatsApp
                            </a>

                            @if(session('favorite_status'))
                                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                                    {{ session('favorite_status') }}
                                </div>
                            @endif

                            <div class="flex gap-3">
                                @auth
                                    <form method="POST" action="{{ route('favorites.toggle', $car) }}" class="flex-1">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-lg border px-4 text-sm font-semibold transition-all {{ $isFavorite ? 'border-red-600 bg-red-50 text-red-600 hover:bg-red-100' : 'border-gray-300 bg-white text-gray-700 hover:border-red-600 hover:bg-red-50 hover:text-red-600' }}">
                                            <svg class="h-5 w-5 {{ $isFavorite ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            {{ $isFavorite ? 'Tersimpan' : 'Simpan' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="inline-flex h-11 flex-1 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 transition-all hover:border-red-600 hover:bg-red-50 hover:text-red-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Masuk untuk simpan
                                    </a>
                                @endauth

                                <button onclick="shareVehicle()"
                                    class="inline-flex h-11 flex-1 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 transition-all hover:border-red-600 hover:bg-red-50 hover:text-red-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Bagikan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Image gallery management
            let currentImageIndex = 0;
            const images = @json($car->images->pluck('image_path'));

            function setMainImage(index) {
                currentImageIndex = index;
                const mainImage = document.getElementById('main-image');
                mainImage.src = '{{ asset('') }}' + images[index];

                // Update thumbnail styles
                document.querySelectorAll('[data-thumbnail]').forEach((thumb, i) => {
                    if (i === index) {
                        thumb.classList.add('border-red-600', 'ring-2', 'ring-red-600/30');
                        thumb.classList.remove('border-gray-700', 'hover:border-red-600/50', 'opacity-60');
                    } else {
                        thumb.classList.remove('border-red-600', 'ring-2', 'ring-red-600/30');
                        thumb.classList.add('border-gray-700', 'hover:border-red-600/50', 'opacity-60');
                    }
                });
            }

            function prevImage() {
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                setMainImage(currentImageIndex);
            }

            function nextImage() {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                setMainImage(currentImageIndex);
            }

            // Lightbox functions
            function openLightbox() {
                document.getElementById('lightbox').classList.remove('hidden');
                document.getElementById('lightbox').classList.add('flex');
                setLightboxImage(currentImageIndex);
            }

            function closeLightbox() {
                document.getElementById('lightbox').classList.add('hidden');
                document.getElementById('lightbox').classList.remove('flex');
            }

            function setLightboxImage(index) {
                currentImageIndex = index;
                const lightboxImage = document.getElementById('lightbox-image');
                lightboxImage.src = '{{ asset('') }}' + images[index];

                // Update indicators
                document.querySelectorAll('[data-lightbox-indicator]').forEach((indicator, i) => {
                    if (i === index) {
                        indicator.classList.add('w-8', 'bg-red-600');
                        indicator.classList.remove('bg-white/50', 'hover:bg-white/80');
                    } else {
                        indicator.classList.remove('w-8', 'bg-red-600');
                        indicator.classList.add('bg-white/50', 'hover:bg-white/80');
                    }
                });
            }

            function prevLightboxImage() {
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                setLightboxImage(currentImageIndex);
            }

            function nextLightboxImage() {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                setLightboxImage(currentImageIndex);
            }

            // Share function
            function shareVehicle() {
                const shareData = {
                    title: '{{ $car->year }} {{ $car->make }} {{ $car->model }}',
                    text: 'Lihat mobil ini di Rizki Mobil Indonesia',
                    url: window.location.href
                };

                if (navigator.share) {
                    navigator.share(shareData);
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(window.location.href);
                    alert('Link telah disalin ke clipboard!');
                }
            }

            // Keyboard navigation for lightbox
            document.addEventListener('keydown', function(e) {
                const lightbox = document.getElementById('lightbox');
                if (!lightbox.classList.contains('hidden')) {
                    if (e.key === 'Escape') closeLightbox();
                    if (e.key === 'ArrowLeft') prevLightboxImage();
                    if (e.key === 'ArrowRight') nextLightboxImage();
                }
            });
        </script>
    @endpush
@endsection
