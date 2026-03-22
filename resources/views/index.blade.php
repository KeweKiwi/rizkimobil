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

<!-- Customer Testimonials -->
<style>
    .testimonials-section {
        background:
            radial-gradient(circle at top left, rgba(229, 62, 62, 0.16), transparent 32%),
            radial-gradient(circle at bottom right, rgba(229, 62, 62, 0.12), transparent 28%),
            linear-gradient(180deg, #111214 0%, #09090b 100%);
        padding: clamp(56px, 11vw, 88px) 0;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .testimonials-shell {
        display: grid;
        gap: 24px;
        align-items: start;
    }
    @media (min-width: 1024px) {
        .testimonials-shell {
            grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.6fr);
            gap: 32px;
        }
    }
    .testimonials-intro {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: clamp(28px, 5vw, 36px);
        background: linear-gradient(160deg, rgba(24, 24, 27, 0.94), rgba(10, 10, 11, 0.88));
        border: 1px solid rgba(239, 68, 68, 0.18);
        box-shadow: 0 18px 60px rgba(0, 0, 0, 0.32);
    }
    .testimonials-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        color: rgba(255, 255, 255, 0.72);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.18em;
    }
    .testimonials-kicker::before {
        content: '';
        width: 24px;
        height: 1px;
        background: rgba(239, 68, 68, 0.65);
    }
    .testimonials-title {
        font-family: var(--font-display);
        font-size: clamp(28px, 6vw, 40px);
        font-weight: 700;
        line-height: 1.08;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 14px;
    }
    .testimonials-description {
        color: rgba(255, 255, 255, 0.68);
        font-size: 15px;
        line-height: 1.8;
        max-width: 34rem;
    }
    .testimonials-highlight {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 28px;
    }
    .testimonials-highlight-card {
        min-width: 140px;
        border-radius: 14px;
        padding: 16px 18px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .testimonials-highlight-number {
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }
    .testimonials-highlight-label {
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }
    .testimonials-grid {
        display: grid;
        gap: 18px;
    }
    @media (min-width: 768px) {
        .testimonials-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .testimonials-grid .testimonial-card:first-child {
            grid-column: span 2;
        }
    }
    .testimonial-card {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 24px;
        background: linear-gradient(180deg, rgba(19, 19, 23, 0.96), rgba(10, 10, 11, 0.92));
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 18px 44px rgba(0, 0, 0, 0.24);
        transition: transform 0.24s ease, border-color 0.24s ease, box-shadow 0.24s ease;
    }
    .testimonial-card::after {
        content: '';
        position: absolute;
        inset: auto -24% -42% auto;
        width: 160px;
        height: 160px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(229, 62, 62, 0.16), transparent 70%);
        pointer-events: none;
    }
    .testimonial-card:hover {
        transform: translateY(-4px);
        border-color: rgba(239, 68, 68, 0.28);
        box-shadow: 0 24px 54px rgba(0, 0, 0, 0.32), 0 0 0 1px rgba(239, 68, 68, 0.06);
    }
    .testimonial-topline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }
    .testimonial-name {
        font-family: var(--font-display);
        font-size: 19px;
        font-weight: 700;
        color: #fff;
    }
    .testimonial-purchase {
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.48);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }
    .testimonial-rating {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(229, 62, 62, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.16);
        color: #ffd166;
        flex-shrink: 0;
    }
    .testimonial-rating-value {
        font-family: var(--font-display);
        font-size: 14px;
        font-weight: 700;
        color: #fff;
    }
    .testimonial-stars {
        display: inline-flex;
        gap: 4px;
    }
    .testimonial-stars svg {
        width: 14px;
        height: 14px;
    }
    .testimonial-headline {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.94);
        line-height: 1.5;
        margin-bottom: 14px;
    }
    .testimonial-quote {
        color: rgba(255, 255, 255, 0.68);
        font-size: 14px;
        line-height: 1.8;
    }
    .about-rizki-section {
        background:
            radial-gradient(circle at top left, rgba(229, 62, 62, 0.06), transparent 28%),
            linear-gradient(180deg, #f7f2ed 0%, #ffffff 100%);
        padding: clamp(60px, 12vw, 96px) 0;
    }
    .about-rizki-shell {
        display: grid;
        gap: 32px;
        align-items: center;
    }
    @media (min-width: 1024px) {
        .about-rizki-shell {
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
            gap: 64px;
        }
    }
    .about-rizki-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: rgba(17, 17, 17, 0.58);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        margin-bottom: 16px;
    }
    .about-rizki-kicker::before {
        content: '';
        width: 24px;
        height: 1px;
        background: rgba(229, 62, 62, 0.72);
    }
    .about-rizki-title {
        font-family: var(--font-display);
        font-size: clamp(32px, 5vw, 56px);
        font-weight: 700;
        line-height: 1.02;
        letter-spacing: -0.03em;
        color: #141414;
        max-width: 11ch;
    }
    .about-rizki-subtitle {
        margin-top: 16px;
        color: rgba(17, 17, 17, 0.6);
        font-size: 18px;
        line-height: 1.75;
        max-width: 38rem;
    }
    .about-rizki-copy {
        display: grid;
        gap: 14px;
        margin-top: 22px;
        color: rgba(17, 17, 17, 0.76);
        font-size: 15px;
        line-height: 1.85;
        max-width: 40rem;
    }
    .about-rizki-highlights {
        display: grid;
        gap: 12px;
        margin-top: 26px;
    }
    @media (min-width: 640px) {
        .about-rizki-highlights {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    .about-rizki-highlight {
        border-radius: 16px;
        padding: 16px 16px 14px;
        background: rgba(255, 255, 255, 0.86);
        border: 1px solid rgba(17, 17, 17, 0.08);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.05);
    }
    .about-rizki-highlight-value {
        font-family: var(--font-display);
        font-size: 16px;
        font-weight: 700;
        color: #18181b;
    }
    .about-rizki-highlight-label {
        margin-top: 8px;
        color: rgba(17, 17, 17, 0.6);
        font-size: 12px;
        line-height: 1.65;
    }
    .about-rizki-visual {
        min-height: 100%;
        border-radius: 28px;
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(239, 68, 68, 0.18), transparent 34%),
            linear-gradient(160deg, #17171a 0%, #0b0b0d 100%);
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.14);
        border: 1px solid rgba(17, 17, 17, 0.08);
        padding: clamp(26px, 5vw, 36px);
    }
    .about-rizki-visual-panel {
        width: 100%;
        height: 100%;
        border-radius: 24px;
        padding: clamp(28px, 6vw, 36px);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: grid;
        gap: 24px;
        box-shadow: 0 18px 48px rgba(0, 0, 0, 0.22);
    }
    .about-rizki-visual-topline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.09);
    }
    .about-rizki-visual-kicker {
        color: rgba(255, 255, 255, 0.54);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.16em;
    }
    .about-rizki-visual-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(229, 62, 62, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.18);
        color: rgba(255, 255, 255, 0.88);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }
    .about-rizki-logo {
        width: min(100%, 210px);
        margin: 8px 0 0;
        filter: drop-shadow(0 18px 30px rgba(0, 0, 0, 0.28));
    }
    .about-rizki-visual-copy {
        max-width: 24rem;
    }
    .about-rizki-visual-title {
        font-family: var(--font-display);
        font-size: clamp(22px, 3vw, 28px);
        font-weight: 700;
        line-height: 1.15;
        color: #fff;
        max-width: 12ch;
        margin-top: 4px;
    }
    .about-rizki-visual-description {
        margin-top: 12px;
        color: rgba(255, 255, 255, 0.68);
        font-size: 14px;
        line-height: 1.8;
    }
    .about-rizki-stats {
        display: grid;
        gap: 12px;
        margin-top: 6px;
    }
    .about-rizki-stat {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 16px;
        padding: 14px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    .about-rizki-stat:first-child {
        border-top: none;
        padding-top: 0;
    }
    .about-rizki-stat-value {
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        white-space: nowrap;
    }
    .about-rizki-stat-label {
        color: rgba(255, 255, 255, 0.62);
        font-size: 13px;
        line-height: 1.7;
        text-align: right;
        max-width: 15rem;
    }
    .about-rizki-visual-label {
        color: rgba(255, 255, 255, 0.62);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.16em;
    }
    @media (max-width: 640px) {
        .about-rizki-stat {
            align-items: flex-start;
            flex-direction: column;
        }
        .about-rizki-stat-label {
            text-align: left;
            max-width: none;
        }
    }
</style>

<section class="testimonials-section">
    <div class="container mx-auto px-4">
        <div class="testimonials-shell">
            <div class="testimonials-intro">
                <span class="testimonials-kicker">Ulasan Pelanggan</span>
                <h2 class="testimonials-title">Kepercayaan Yang Terasa Sejak Pertemuan Pertama.</h2>
                <p class="testimonials-description">
                    Kami ingin pengalaman membeli mobil terasa jernih, hangat, dan meyakinkan. Karena itu, ulasan pelanggan kami selalu bicara tentang kualitas unit, transparansi proses, dan rasa aman setelah transaksi selesai.
                </p>

                <div class="testimonials-highlight">
                    <div class="testimonials-highlight-card">
                        <p class="testimonials-highlight-number">4.9/5</p>
                        <p class="testimonials-highlight-label">Rata-Rata Penilaian</p>
                    </div>
                    <div class="testimonials-highlight-card">
                        <p class="testimonials-highlight-number">1.200+</p>
                        <p class="testimonials-highlight-label">Review Positif</p>
                    </div>
                </div>
            </div>

            <div class="testimonials-grid">
                @foreach($testimonials as $testimonial)
                    <article class="testimonial-card">
                        <div class="testimonial-topline">
                            <div>
                                <h3 class="testimonial-name">{{ $testimonial['name'] }}</h3>
                                <p class="testimonial-purchase">{{ $testimonial['purchase'] }}</p>
                            </div>

                            <div class="testimonial-rating" aria-label="Rating {{ $testimonial['rating'] }} dari 5">
                                <span class="testimonial-rating-value">{{ number_format($testimonial['rating'], 1) }}</span>
                                <div class="testimonial-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg
                                            fill="{{ $i <= $testimonial['rating'] ? '#ffd166' : 'rgba(255,255,255,0.16)' }}"
                                            viewBox="0 0 20 20"
                                            aria-hidden="true"
                                        >
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <p class="testimonial-headline">{{ $testimonial['headline'] }}</p>
                        <p class="testimonial-quote">"{{ $testimonial['quote'] }}"</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="about-rizki-section">
    <div class="container mx-auto px-4">
        <div class="about-rizki-shell">
            <div>
                <span class="about-rizki-kicker">{{ $aboutRizki['kicker'] }}</span>
                <h2 class="about-rizki-title">{{ $aboutRizki['title'] }}</h2>
                <p class="about-rizki-subtitle">{{ $aboutRizki['subtitle'] }}</p>

                <div class="about-rizki-copy">
                    @foreach($aboutRizki['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <div class="about-rizki-highlights">
                    @foreach($aboutRizki['highlights'] as $highlight)
                        <div class="about-rizki-highlight">
                            <p class="about-rizki-highlight-value">{{ $highlight['value'] }}</p>
                            <p class="about-rizki-highlight-label">{{ $highlight['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="about-rizki-visual">
                <div class="about-rizki-visual-panel">
                    <div class="about-rizki-visual-topline">
                        <p class="about-rizki-visual-kicker">Rizki Mobil Indonesia</p>
                        <span class="about-rizki-visual-badge">Terverifikasi</span>
                    </div>

                    <div class="about-rizki-visual-copy">
                        <img
                            src="{{ asset($aboutRizki['image']) }}"
                            alt="Logo Rizki Mobil Indonesia"
                            class="about-rizki-logo"
                        />
                        <p class="about-rizki-visual-label">Rizki Mobil Indonesia</p>
                        <h3 class="about-rizki-visual-title">Kualitas unit yang dijelaskan dengan cara yang jujur.</h3>
                        <p class="about-rizki-visual-description">
                            Kami merancang pengalaman beli mobil yang terasa rapi, profesional, dan tetap dekat secara personal.
                        </p>
                    </div>

                    <div class="about-rizki-stats">
                        <div class="about-rizki-stat">
                            <strong class="about-rizki-stat-value">{{ $stats['yearsInBusiness'] }}+</strong>
                            <span class="about-rizki-stat-label">tahun pengalaman membangun kepercayaan pelanggan</span>
                        </div>
                        <div class="about-rizki-stat">
                            <strong class="about-rizki-stat-value">{{ number_format($stats['carsSold']) }}+</strong>
                            <span class="about-rizki-stat-label">unit telah menemukan pemilik baru lewat proses yang lebih tenang</span>
                        </div>
                    </div>
                </div>
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
