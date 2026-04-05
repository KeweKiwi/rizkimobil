@extends('layouts.app')

@section('content')
<!-- Hero Carousel -->
@include('partials.hero-carousel')

<!-- Search Bar - Floating overlap -->
<section id="search-section" style="position: relative; margin-top: -64px; z-index: 30; padding-bottom: 32px;">
    <style>
        #search-section .s-card {
            background: rgba(255, 255, 255, 0.985) !important;
            backdrop-filter: blur(18px) !important;
            -webkit-backdrop-filter: blur(18px) !important;
            border: 1px solid rgba(239, 68, 68, 0.18) !important;
            border-radius: 18px !important;
            box-shadow: 0 22px 54px rgba(15, 23, 42, 0.12), 0 0 24px rgba(239, 68, 68, 0.08) !important;
            padding: clamp(18px, 4vw, 28px) !important;
        }
        #search-section .s-card h3 {
            color: #111 !important;
            font-size: 16px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.14em !important;
            margin: 0 0 18px 0 !important;
        }
        #search-section .s-form {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }
        @media (min-width: 1024px) {
            #search-section .s-form {
                flex-direction: row !important;
                align-items: center !important;
            }
        }
        #search-section .s-input,
        #search-section .s-select {
            flex: 1 !important;
            height: 50px !important;
            padding: 0 16px !important;
            border-radius: 12px !important;
            border: 1px solid rgba(17, 17, 17, 0.14) !important;
            background: #fff !important;
            color: #111 !important;
            font-size: 14px !important;
            outline: none !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
            -webkit-appearance: auto !important;
            appearance: auto !important;
            box-shadow: none !important;
        }
        #search-section .s-input::placeholder {
            color: rgba(17, 17, 17, 0.42) !important;
        }
        #search-section .s-select option {
            background: #fff !important;
            color: #111 !important;
        }
        #search-section .s-input:focus,
        #search-section .s-select:focus {
            border-color: rgba(239, 68, 68, 0.45) !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08) !important;
        }
        #search-section .s-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            height: 50px !important;
            min-width: 148px !important;
            padding: 0 28px !important;
            border: none !important;
            border-radius: 12px !important;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: #fff !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.14em !important;
            cursor: pointer !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease !important;
            box-shadow: 0 16px 34px rgba(239, 68, 68, 0.22) !important;
            white-space: nowrap !important;
        }
        #search-section .s-btn:hover {
            transform: translateY(-1px) !important;
            filter: brightness(1.02) !important;
            box-shadow: 0 20px 42px rgba(239, 68, 68, 0.26) !important;
        }
        #search-section .s-btn svg {
            width: 16px !important;
            height: 16px !important;
            color: #fff !important;
        }
    </style>

    <div class="container mx-auto px-4">
        <div class="s-card">
            <h3>Temukan Mobil Impian Anda</h3>
            <form action="{{ route('inventory') }}" method="GET" class="s-form">
                <select name="make" class="s-select">
                    <option value="">Pilih Merek</option>
                    @foreach($carMakes as $make)
                        <option value="{{ $make }}">{{ $make }}</option>
                    @endforeach
                </select>

                <input
                    type="text"
                    name="model"
                    placeholder="Model (mis. Avanza)"
                    class="s-input"
                />

                <select name="price_range" class="s-select">
                    <option value="">Rentang Harga</option>
                    <option value="0-100000000">Di bawah Rp 100 juta</option>
                    <option value="100000000-200000000">Rp 100 juta - Rp 200 juta</option>
                    <option value="200000000-300000000">Rp 200 juta - Rp 300 juta</option>
                    <option value="300000000-999999999">Di atas Rp 300 juta</option>
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
    .trust-story-section {
        background:
            radial-gradient(circle at top left, rgba(229, 62, 62, 0.16), transparent 32%),
            radial-gradient(circle at bottom right, rgba(229, 62, 62, 0.12), transparent 28%),
            linear-gradient(180deg, #111214 0%, #09090b 100%);
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    /* Why Choose Us Dark Theme with Red Glow */
    .why-choose-section {
        background: transparent;
        padding: clamp(40px, 10vw, 64px) 0 clamp(28px, 7vw, 40px);
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

<div class="trust-story-section">
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
        background: transparent;
        padding: clamp(20px, 5vw, 28px) 0 clamp(56px, 11vw, 88px);
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
    
    /* === ABOUT RIZKI MOBIL - NEW DESIGN === */
    .about-faq-section {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #fef7f0 0%, #fdf2e9 25%, #fce8db 50%, #f5f5f5 100%);
    }
    .about-faq-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60%;
        height: 100%;
        background: linear-gradient(to left, rgba(245, 245, 245, 0.9), transparent);
        pointer-events: none;
    }
    .about-rizki-section {
        position: relative;
        overflow: hidden;
        padding: clamp(80px, 14vw, 120px) 0 clamp(40px, 6vw, 60px);
        background: transparent;
    }
    .about-rizki-shell {
        position: relative;
        display: grid;
        gap: 48px;
        align-items: center;
    }
    @media (min-width: 1024px) {
        .about-rizki-shell {
            grid-template-columns: 1fr 420px;
            gap: 80px;
        }
    }
    @media (min-width: 1280px) {
        .about-rizki-shell {
            grid-template-columns: 1fr 480px;
            gap: 100px;
        }
    }
    
    /* Left Side - Content */
    .about-rizki-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-bottom: 24px;
    }
    .about-rizki-kicker::before {
        content: '';
        width: 32px;
        height: 2px;
        background: linear-gradient(90deg, #ef4444, #f97316);
        border-radius: 2px;
    }
    .about-rizki-title {
        font-family: var(--font-display);
        font-size: clamp(36px, 6vw, 64px);
        font-weight: 700;
        line-height: 1.05;
        letter-spacing: -0.03em;
        color: #111827;
    }
    .about-rizki-title-highlight {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .about-rizki-subtitle {
        margin-top: 28px;
        color: #4b5563;
        font-size: 17px;
        line-height: 1.8;
        max-width: 540px;
    }
    .about-rizki-copy {
        display: grid;
        gap: 16px;
        margin-top: 20px;
        color: #6b7280;
        font-size: 15px;
        line-height: 1.85;
        max-width: 540px;
    }
    
    /* Feature Cards - Enhanced Design */
    .about-rizki-highlights {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 48px;
    }
    @media (max-width: 768px) {
        .about-rizki-highlights {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
    .about-rizki-highlight {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        padding: 28px 24px 24px;
        background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
        border: 1px solid rgba(239, 68, 68, 0.08);
        box-shadow: 
            0 4px 6px rgba(0, 0, 0, 0.02),
            0 12px 24px rgba(0, 0, 0, 0.04),
            0 -1px 0 rgba(255, 255, 255, 0.8) inset;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .about-rizki-highlight::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ef4444 0%, #f97316 50%, #fca5a5 100%);
    }
    .about-rizki-highlight::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(239, 68, 68, 0.08) 0%, transparent 70%);
        transition: all 0.4s ease;
    }
    .about-rizki-highlight:hover {
        transform: translateY(-8px);
        box-shadow: 
            0 8px 16px rgba(239, 68, 68, 0.08),
            0 20px 40px rgba(239, 68, 68, 0.12),
            0 -1px 0 rgba(255, 255, 255, 0.8) inset;
        border-color: rgba(239, 68, 68, 0.2);
    }
    .about-rizki-highlight:hover::after {
        transform: scale(1.3);
        background: radial-gradient(circle, rgba(239, 68, 68, 0.12) 0%, transparent 70%);
    }
    .about-rizki-highlight-topline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    .about-rizki-highlight-index {
        font-size: 13px;
        font-weight: 800;
        color: #ef4444;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        padding: 6px 14px;
        border-radius: 20px;
        letter-spacing: 0.05em;
    }
    .about-rizki-highlight-mark {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: linear-gradient(135deg, #fef2f2, #fff);
        border: 1px solid rgba(239, 68, 68, 0.1);
        color: #ef4444;
        transition: all 0.3s ease;
    }
    .about-rizki-highlight:hover .about-rizki-highlight-mark {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-color: #ef4444;
        color: #fff;
        transform: translateX(4px);
    }
    .about-rizki-highlight-mark svg {
        width: 18px;
        height: 18px;
    }
    .about-rizki-highlight-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
        transition: all 0.3s ease;
    }
    .about-rizki-highlight:hover .about-rizki-highlight-icon {
        transform: scale(1.05);
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
    }
    .about-rizki-highlight-icon svg {
        width: 30px;
        height: 30px;
        color: #ef4444;
    }
    .about-rizki-highlight-value {
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }
    .about-rizki-highlight-label {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
        position: relative;
        z-index: 1;
    }
    
    /* Right Side - Dark Card */
    .about-rizki-visual {
        position: relative;
        border-radius: 32px;
        background: linear-gradient(160deg, #1f2937 0%, #111827 50%, #0f172a 100%);
        padding: 36px;
        box-shadow: 
            0 50px 100px -20px rgba(0, 0, 0, 0.25),
            0 30px 60px -30px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }
    .about-rizki-visual::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 32px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }
    .about-rizki-visual-panel {
        position: relative;
    }
    .about-rizki-visual-topline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 28px;
    }
    .about-rizki-visual-kicker {
        color: rgba(255, 255, 255, 0.5);
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }
    .about-rizki-visual-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .about-rizki-logo {
        height: 56px;
        width: auto;
        margin-bottom: 32px;
        filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.3));
    }
    .about-rizki-visual-copy {
        margin-bottom: 32px;
    }
    .about-rizki-visual-label {
        color: rgba(255, 255, 255, 0.4);
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-bottom: 12px;
    }
    .about-rizki-visual-title {
        font-family: var(--font-display);
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 700;
        line-height: 1.2;
        color: #ffffff;
    }
    .about-rizki-visual-title span {
        color: #ef4444;
    }
    .about-rizki-visual-description {
        margin-top: 16px;
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
        line-height: 1.8;
    }
    
    /* Stats */
    .about-rizki-stats {
        display: grid;
        gap: 0;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 28px;
    }
    .about-rizki-stat {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 20px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }
    .about-rizki-stat:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .about-rizki-stat:first-child {
        padding-top: 0;
    }
    .about-rizki-stat-value {
        font-family: var(--font-display);
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1;
        letter-spacing: -0.02em;
    }
    .about-rizki-stat-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 13px;
        line-height: 1.6;
        text-align: right;
        max-width: 180px;
    }
    @media (max-width: 640px) {
        .about-rizki-visual {
            padding: 28px;
        }
        .about-rizki-stat {
            flex-direction: column;
            gap: 8px;
        }
        .about-rizki-stat-label {
            text-align: left;
            max-width: none;
        }
        .about-rizki-stat-value {
            font-size: 36px;
        }
    }
    }
    .about-rizki-highlight-value {
        font-family: var(--font-display);
        font-size: 17px;
        font-weight: 700;
        color: #18181b;
        letter-spacing: -0.02em;
    }
    .about-rizki-highlight-label {
        margin-top: 10px;
        color: rgba(17, 17, 17, 0.58);
        font-size: 13px;
        line-height: 1.75;
        max-width: 18rem;
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
</div>

<div class="about-faq-section">
<section class="about-rizki-section">
    <div class="container mx-auto px-4">
        <div class="about-rizki-shell">
            <!-- Left Content -->
            <div>
                <span class="about-rizki-kicker">{{ $aboutRizki['kicker'] }}</span>
                <h2 class="about-rizki-title">
                    Jual beli mobil<br>
                    bekas yang<br>
                    terasa lebih<br>
                    <span class="about-rizki-title-highlight">tenang, jujur,</span><br>
                    <span class="about-rizki-title-highlight">dan terkurasi.</span>
                </h2>
                <p class="about-rizki-subtitle">{{ $aboutRizki['subtitle'] }}</p>

                <div class="about-rizki-copy">
                    @foreach($aboutRizki['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <div class="about-rizki-highlights">
                    <!-- Card 1: Kurasi Ketat -->
                    <div class="about-rizki-highlight">
                        <div class="about-rizki-highlight-topline">
                            <span class="about-rizki-highlight-index">01</span>
                            <span class="about-rizki-highlight-mark" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                        <div class="about-rizki-highlight-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <p class="about-rizki-highlight-value">Kurasi Ketat</p>
                        <p class="about-rizki-highlight-label">Unit dipilih dengan standar yang jelas dan inspeksi menyeluruh</p>
                    </div>
                    
                    <!-- Card 2: Transparan -->
                    <div class="about-rizki-highlight">
                        <div class="about-rizki-highlight-topline">
                            <span class="about-rizki-highlight-index">02</span>
                            <span class="about-rizki-highlight-mark" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                        <div class="about-rizki-highlight-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <p class="about-rizki-highlight-value">Transparan</p>
                        <p class="about-rizki-highlight-label">Informasi dijelaskan sejak awal tanpa ada yang disembunyikan</p>
                    </div>
                    
                    <!-- Card 3: Personal -->
                    <div class="about-rizki-highlight">
                        <div class="about-rizki-highlight-topline">
                            <span class="about-rizki-highlight-index">03</span>
                            <span class="about-rizki-highlight-mark" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                        <div class="about-rizki-highlight-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <p class="about-rizki-highlight-value">Personal</p>
                        <p class="about-rizki-highlight-label">Pendampingan terasa hangat dan fokus pada kebutuhan Anda</p>
                    </div>
                </div>
            </div>

            <!-- Right Card -->
            <div class="about-rizki-visual">
                <div class="about-rizki-visual-panel">
                    <div class="about-rizki-visual-topline">
                        <p class="about-rizki-visual-kicker">Rizki Mobil Indonesia</p>
                        <span class="about-rizki-visual-badge">Terverifikasi</span>
                    </div>

                    <img
                        src="{{ asset($aboutRizki['image']) }}"
                        alt="Logo Rizki Mobil Indonesia"
                        class="about-rizki-logo"
                    />

                    <div class="about-rizki-visual-copy">
                        <p class="about-rizki-visual-label">Rizki Mobil Indonesia</p>
                        <h3 class="about-rizki-visual-title">
                            Kualitas unit yang dijelaskan dengan cara <span>yang jujur.</span>
                        </h3>
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

<style>
    /* === FAQ SECTION - SEAMLESS DESIGN === */
    .faq-section {
        position: relative;
        padding: clamp(20px, 4vw, 40px) 0 clamp(80px, 12vw, 120px);
        background: transparent;
    }
    .faq-shell {
        position: relative;
        z-index: 1;
    }
    .faq-header {
        max-width: 48rem;
        margin-bottom: 40px;
    }
    .faq-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
    }
    .faq-kicker::before {
        content: '';
        width: 32px;
        height: 2px;
        background: linear-gradient(90deg, #ef4444, #f97316);
        border-radius: 2px;
    }
    .faq-title {
        margin-top: 16px;
        font-family: var(--font-display);
        font-size: clamp(32px, 5vw, 48px);
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -0.03em;
        color: #111827;
    }
    .faq-description {
        margin-top: 16px;
        color: #6b7280;
        font-size: 16px;
        line-height: 1.75;
        max-width: 36rem;
    }
    .faq-grid {
        display: grid;
        gap: 20px;
    }
    @media (min-width: 1024px) {
        .faq-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    .faq-card {
        position: relative;
        overflow: hidden;
        min-height: 100%;
        border-radius: 24px;
        padding: 28px 24px 24px;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }
    .faq-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #ef4444 0%, #fca5a5 100%);
    }
    .faq-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.15);
    }
    .faq-card-index {
        position: absolute;
        top: 24px;
        right: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fef2f2;
        color: #ef4444;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .faq-card:hover .faq-card-index {
        background: #ef4444;
        color: #fff;
    }
    .faq-card-question {
        padding-right: 50px;
        font-family: var(--font-display);
        font-size: clamp(17px, 2vw, 20px);
        font-weight: 700;
        line-height: 1.3;
        color: #111827;
        margin-bottom: 12px;
    }
    .faq-card-divider {
        width: 40px;
        height: 2px;
        margin: 0 0 12px;
        background: linear-gradient(90deg, #ef4444, #fca5a5);
        border-radius: 2px;
    }
    .faq-card-answer {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.75;
    }
</style>

<section class="faq-section">
    <div class="container mx-auto px-4">
        <div class="faq-shell">
            <div class="faq-header">
                <span class="faq-kicker">FAQ Rizki Mobil</span>
                <h2 class="faq-title">Pertanyaan yang sering muncul sebelum pelanggan mengambil keputusan.</h2>
                <p class="faq-description">
                    Kami rangkum hal-hal yang paling sering ditanyakan agar proses memilih mobil terasa lebih jelas, tenang, dan tidak penuh tebakan.
                </p>
            </div>

            <div class="faq-grid">
                @foreach($faqs as $index => $faq)
                    <article class="faq-card">
                        <span class="faq-card-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="faq-card-question">{{ $faq['question'] }}</h3>
                        <div class="faq-card-divider"></div>
                        <p class="faq-card-answer">{{ $faq['answer'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
</div>

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
