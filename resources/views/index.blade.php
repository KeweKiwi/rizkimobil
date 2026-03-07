@extends('layouts.app')

@section('content')
<!-- Hero Carousel -->
@include('partials.hero-carousel')

<!-- Search Bar - Floating overlap -->
<section id="search-section" style="position: relative; margin-top: -64px; z-index: 30; padding-bottom: 32px;">
    <style>
        /* All selectors scoped under #search-section so nothing can override */
        #search-section .s-card {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            border-radius: 10px !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4), 0 0 14px rgba(239,68,68,0.18) !important;
            padding: clamp(18px, 4vw, 28px) !important;
        }
        #search-section .s-card h3 {
            color: #111 !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.12em !important;
            margin: 0 0 18px 0 !important;
        }
        #search-section .s-form {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }
        @media (min-width: 768px) {
            #search-section .s-form { flex-direction: row !important; }
        }
        #search-section .s-input,
        #search-section .s-select {
            flex: 1 !important;
            height: 42px !important;
            padding: 0 14px !important;
            border-radius: 6px !important;
            border: 1px solid rgba(0,0,0,0.15) !important;
            background: #fff !important;
            color: #111 !important;
            font-size: 14px !important;
            outline: none !important;
            transition: border-color 0.2s !important;
            -webkit-appearance: auto !important;
            appearance: auto !important;
            box-shadow: none !important;
        }
        #search-section .s-input::placeholder { color: rgba(0,0,0,0.45) !important; }
        #search-section .s-select option { background: #fff !important; color: #111 !important; }
        #search-section .s-input:focus,
        #search-section .s-select:focus { border-color: rgba(239,68,68,0.6) !important; }
        #search-section .s-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            height: 42px !important;
            padding: 0 28px !important;
            border: none !important;
            border-radius: 6px !important;
            background: #e53e3e !important;
            color: #fff !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            cursor: pointer !important;
            transition: background 0.2s !important;
            box-shadow: 0 0 16px 2px rgba(239,68,68,0.4) !important;
            white-space: nowrap !important;
        }
        #search-section .s-btn:hover { background: #c53030 !important; }
        #search-section .s-btn svg { width: 16px !important; height: 16px !important; color: #fff !important; }
    </style>

    <div class="container mx-auto px-4">
        <div class="s-card">
            <h3>Temukan Mobil Impian Anda</h3>
            <form action="{{ route('inventory') }}" method="GET" class="s-form">
                <select name="make" class="s-select">
                    <option value="">Pilih Merek</option>
                    @foreach($carMakes as $make)
                        <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                    @endforeach
                </select>

                <input
                    type="text"
                    name="model"
                    placeholder="Model (mis. Avanza)"
                    value="{{ request('model') }}"
                    class="s-input"
                />

                <select name="priceRange" class="s-select">
                    <option value="">Rentang Harga</option>
                    <option value="0-30000" {{ request('priceRange') == '0-30000' ? 'selected' : '' }}>Di bawah Rp 100 juta</option>
                    <option value="30000-50000" {{ request('priceRange') == '30000-50000' ? 'selected' : '' }}>Rp 100 juta - Rp 200 juta</option>
                    <option value="50000-75000" {{ request('priceRange') == '50000-75000' ? 'selected' : '' }}>Rp 200 juta - Rp 300 juta</option>
                    <option value="75000-999999" {{ request('priceRange') == '75000-999999' ? 'selected' : '' }}>Di atas Rp 300 juta</option>
                </select>

                <button type="submit" class="s-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Trust Indicators -->
<style>
    .trust-section { border-top: 1px solid rgba(255,255,255,0.08); border-bottom: 1px solid rgba(255,255,255,0.08); background: rgba(0,0,0,0.04); padding: clamp(24px, 6vw, 40px) 0; }
    .trust-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: clamp(16px, 4vw, 24px); }
    @media (min-width: 768px) { .trust-grid { grid-template-columns: repeat(4, 1fr); } }
    .trust-item { display: flex; align-items: center; gap: clamp(12px, 3vw, 16px); }
    .trust-icon {
        width: clamp(48px, 10vw, 56px); height: clamp(48px, 10vw, 56px); min-width: 48px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 6px;
        border: 1px solid rgba(239, 68, 68, 0.2);
        background: rgba(239, 68, 68, 0.08);
        transition: box-shadow 0.2s;
    }
    .trust-item:hover .trust-icon { box-shadow: 0 0 16px 2px rgba(239, 68, 68, 0.4); }
    .trust-icon svg { width: clamp(24px, 5vw, 28px); height: clamp(24px, 5vw, 28px); color: var(--color-primary, #e53e3e); }
    .trust-number { font-size: clamp(18px, 4vw, 24px); font-weight: 700; color: var(--color-foreground, #111); line-height: 1; }
    .trust-label { font-size: clamp(10px, 2vw, 12px); text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-muted-foreground, #888); margin-top: 2px; }
</style>

<section class="trust-section">
    <div class="container mx-auto px-4">
        <div class="trust-grid">
            <div class="trust-item">
                <div class="trust-icon">
                    <img src="{{ asset('images/icons/car.svg') }}" alt="Car" class="w-7 h-7" style="filter: invert(31%) sepia(95%) saturate(2589%) hue-rotate(346deg) brightness(95%) contrast(89%);" />
                </div>
                <div>
                    <p class="trust-number">{{ number_format($stats['carsSold']) }}+</p>
                    <p class="trust-label">Mobil Terjual</p>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="trust-number">{{ number_format($stats['satisfiedCustomers']) }}+</p>
                    <p class="trust-label">Pelanggan Puas</p>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="trust-number">{{ $stats['yearsInBusiness'] }}+</p>
                    <p class="trust-label">Tahun Pengalaman</p>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon">
                    <img src="{{ asset('images/icons/warehouse.svg') }}" alt="Warehouse" class="w-7 h-7" style="filter: invert(31%) sepia(95%) saturate(2589%) hue-rotate(346deg) brightness(95%) contrast(89%);" />
                </div>
                <div>
                    <p class="trust-number">{{ $stats['carsInStock'] }}</p>
                    <p class="trust-label">Unit Tersedia</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Vehicles -->
<section class="bg-background py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 flex items-end justify-between">
            <div>
                <h2 class="font-display text-2xl font-bold uppercase tracking-wider text-foreground md:text-3xl">
                    Mobil Unggulan
                </h2>
                <p class="mt-2 font-body text-muted-foreground">
                    Kendaraan premium pilihan dengan nilai terbaik
                </p>
            </div>
            <a href="{{ route('inventory') }}" class="hidden md:inline-flex items-center justify-center gap-1 rounded-md text-sm font-display font-medium uppercase tracking-wider text-primary ring-offset-background transition-colors hover:text-primary/80 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 h-10 px-4 py-2">
                Lihat Semua
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($featuredCars as $car)
                @include('partials.car-card', ['car' => $car])
            @empty
                <!-- Mock Data for Preview - Remove when you have real data -->
                @php
                    $mockCars = [
                        (object)[
                            'id' => 1,
                            'make' => 'Toyota',
                            'model' => 'Camry XSE',
                            'year' => 2022,
                            'price' => 28500,
                            'mileage' => 15000,
                            'fuelType' => 'Gasoline',
                            'transmission' => 'Automatic',
                            'bodyType' => 'Sedan',
                            'images' => ['https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=800&h=600&fit=crop'],
                            'featured' => true
                        ],
                        (object)[
                            'id' => 2,
                            'make' => 'Honda',
                            'model' => 'CR-V Touring',
                            'year' => 2023,
                            'price' => 35900,
                            'mileage' => 8500,
                            'fuelType' => 'Hybrid',
                            'transmission' => 'Automatic',
                            'bodyType' => 'SUV',
                            'images' => ['https://images.unsplash.com/photo-1619767886558-efdc259cde1a?w=800&h=600&fit=crop'],
                            'primaryImage' => (object)['image_path' => 'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?w=800&h=600&fit=crop'],
                            'certified' => true,
                            'featured' => true
                        ],
                        (object)[
                            'id' => 3,
                            'make' => 'BMW',
                            'model' => '330i M Sport',
                            'year' => 2021,
                            'price' => 42800,
                            'mileage' => 22000,
                            'fuelType' => 'Gasoline',
                            'transmission' => 'Automatic',
                            'bodyType' => 'Sedan',
                            'images' => ['https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800&h=600&fit=crop'],
                            'primaryImage' => (object)['image_path' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800&h=600&fit=crop'],
                            'certified' => true,
                            'featured' => true
                        ],
                        (object)[
                            'id' => 4,
                            'make' => 'Tesla',
                            'model' => 'Model 3 Long Range',
                            'year' => 2023,
                            'price' => 48900,
                            'mileage' => 5000,
                            'fuelType' => 'Electric',
                            'transmission' => 'Automatic',
                            'bodyType' => 'Sedan',
                            'images' => ['https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=600&fit=crop'],
                            'primaryImage' => (object)['image_path' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=600&fit=crop'],
                            'certified' => false,
                            'featured' => true
                        ]
                    ];
                @endphp

                @foreach($mockCars as $car)
                    @include('partials.car-card', ['car' => $car])
                @endforeach
            @endforelse
        </div>

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('inventory') }}" class="inline-flex items-center justify-center gap-1 rounded-md border border-primary bg-background text-primary hover:bg-primary/10 h-10 px-4 py-2 text-sm font-display font-medium uppercase tracking-wider transition-colors">
                Lihat Semua Mobil
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<style>
    /* Why Choose Us Dark Theme with Red Glow */
    .why-choose-section {
        background: #0a0a0b;
        padding: clamp(40px, 10vw, 64px) 0;
    }
    .why-choose-title {
        font-family: var(--font-display);
        font-size: clamp(24px, 5vw, 32px);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #ffffff;
        text-align: center;
        margin-bottom: 12px;
    }
    .why-choose-subtitle {
        text-align: center;
        color: rgba(255, 255, 255, 0.65);
        font-size: clamp(14px, 3vw, 15px);
        max-width: 600px;
        margin: 0 auto 48px;
        padding: 0 16px;
    }
    .why-choose-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }
    @media (min-width: 768px) {
        .why-choose-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .why-choose-title {
            font-size: 32px;
        }
    }
    .why-choose-card {
        background: rgba(18, 18, 22, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        padding: clamp(24px, 6vw, 40px) clamp(20px, 5vw, 32px);
        text-align: center;
        transition: all 0.3s ease;
    }
    .why-choose-card:hover {
        border-color: rgba(239, 68, 68, 0.4);
        background: rgba(18, 18, 22, 0.8);
    }
    .why-icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid rgba(239, 68, 68, 0.25);
        background: rgba(239, 68, 68, 0.08);
        transition: all 0.3s ease;
    }
    .why-choose-card:hover .why-icon-wrapper {
        box-shadow: 0 0 20px 4px rgba(239, 68, 68, 0.5), 0 0 40px 8px rgba(239, 68, 68, 0.3);
        border-color: rgba(239, 68, 68, 0.5);
        background: rgba(239, 68, 68, 0.12);
    }
    .why-icon-wrapper svg {
        width: 36px;
        height: 36px;
        color: #e53e3e;
        stroke-width: 2;
    }
    .why-card-title {
        font-family: var(--font-display);
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #ffffff;
        margin-bottom: 12px;
    }
    .why-card-description {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
        line-height: 1.6;
    }
</style>

<section class="why-choose-section">
    <div class="container mx-auto px-4">
        <h2 class="why-choose-title">Mengapa Memilih Rizki Mobil?</h2>
        <p class="why-choose-subtitle">
            Kami lebih dari sekedar menjual mobil. Setiap kendaraan hadir dengan jaminan kualitas dan transparansi.
        </p>

        <div class="why-choose-grid">
            <!-- Card 1: 150-Point Inspection -->
            <div class="why-choose-card">
                <div class="why-icon-wrapper">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="why-card-title">Inspeksi 150 Poin</h3>
                <p class="why-card-description">
                    Setiap kendaraan menjalani inspeksi ketat mencakup aspek mekanis, keselamatan, dan kosmetik.
                </p>
            </div>

            <!-- Card 2: Certified Quality -->
            <div class="why-choose-card">
                <div class="why-icon-wrapper">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="why-card-title">Kualitas Tersertifikasi</h3>
                <p class="why-card-description">
                    Kendaraan bersertifikat kami memenuhi standar tertinggi dengan riwayat dan catatan servis terverifikasi.
                </p>
            </div>

            <!-- Card 3: Full Transparency -->
            <div class="why-choose-card">
                <div class="why-icon-wrapper">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="why-card-title">Transparansi Penuh</h3>
                <p class="why-card-description">
                    Riwayat kendaraan lengkap, laporan kecelakaan, dan detail kepemilikan tersedia untuk setiap mobil.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-background py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="overflow-hidden rounded-lg border-0 bg-red-600">
            <div class="flex flex-col items-center gap-6 p-8 text-center md:flex-row md:justify-between md:text-left lg:p-12">
                <div>
                    <h2 class="font-display text-2xl font-bold uppercase tracking-wider text-white md:text-3xl">
                        Siap Menemukan Mobil Impian Anda?
                    </h2>
                    <p class="mt-2 font-body text-white/90">
                        Jelajahi inventori kendaraan bekas premium kami hari ini.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('inventory') }}" class="inline-flex items-center justify-center h-11 rounded-md bg-gray-900 px-8 text-sm font-display font-medium uppercase tracking-wider text-white ring-offset-background transition-colors hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                        Lihat Inventori
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center h-11 rounded-md border-2 border-white bg-white px-8 text-sm font-display font-medium uppercase tracking-wider text-red-600 transition-colors hover:bg-white/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection