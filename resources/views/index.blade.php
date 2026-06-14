@extends('layouts.app')

@section('content')
<!-- Hero Carousel -->
@include('partials.hero-carousel')

<!-- Search Bar - Floating overlap -->
<section id="search-section">
    <style>
        #search-section {
            position: relative;
            z-index: 60;
            margin-top: -72px;
            padding-bottom: 44px;
        }
        @media (min-width: 768px) {
            #search-section {
                z-index: 30;
                margin-top: -64px;
                padding-bottom: 32px;
            }
        }
        #search-section .s-card {
            background: rgba(255, 255, 255, 0.985) !important;
            backdrop-filter: blur(18px) !important;
            -webkit-backdrop-filter: blur(18px) !important;
            border: 1px solid rgba(239, 68, 68, 0.18) !important;
            border-radius: 24px !important;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14), 0 0 24px rgba(239, 68, 68, 0.08) !important;
            padding: clamp(22px, 5vw, 28px) !important;
        }
        @media (max-width: 767px) {
            #search-section .s-card {
                border-radius: 24px !important;
                padding: 24px 20px 22px !important;
            }
        }
        #search-section .s-card h3 {
            color: #111 !important;
            font-size: clamp(19px, 5vw, 22px) !important;
            line-height: 1.18 !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.11em !important;
            margin: 0 0 20px 0 !important;
            text-wrap: balance !important;
        }
        @media (min-width: 768px) {
            #search-section .s-card h3 {
                font-size: 16px !important;
                letter-spacing: 0.14em !important;
                margin-bottom: 18px !important;
            }
        }
        #search-section .s-form {
            display: flex !important;
            flex-direction: column !important;
            gap: 14px !important;
        }
        @media (min-width: 1024px) {
            #search-section .s-form {
                flex-direction: row !important;
                align-items: center !important;
            }
        }
        #search-section .s-input,
        #search-section .s-select {
            display: block !important;
            flex: 1 !important;
            width: 100% !important;
            min-width: 0 !important;
            height: 58px !important;
            min-height: 58px !important;
            padding: 0 18px !important;
            box-sizing: border-box !important;
            border-radius: 16px !important;
            border: 1px solid rgba(17, 17, 17, 0.14) !important;
            background: #fff !important;
            color: #111 !important;
            font-size: 16px !important;
            font-weight: 650 !important;
            line-height: 1.2 !important;
            outline: none !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
            -webkit-appearance: none !important;
            appearance: none !important;
            box-shadow: none !important;
        }
        #search-section .s-select {
            padding-right: 46px !important;
            background-image:
                linear-gradient(45deg, transparent 50%, rgba(17, 17, 17, 0.82) 50%),
                linear-gradient(135deg, rgba(17, 17, 17, 0.82) 50%, transparent 50%) !important;
            background-position:
                calc(100% - 22px) 50%,
                calc(100% - 16px) 50% !important;
            background-size: 6px 6px, 6px 6px !important;
            background-repeat: no-repeat !important;
        }
        @media (min-width: 1024px) {
            #search-section .s-input,
            #search-section .s-select {
                height: 50px !important;
                min-height: 50px !important;
                border-radius: 12px !important;
                font-size: 14px !important;
                font-weight: 500 !important;
            }
        }
        #search-section .s-input::placeholder {
            color: rgba(17, 17, 17, 0.38) !important;
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
            gap: 10px !important;
            height: 60px !important;
            width: 100% !important;
            min-width: 0 !important;
            padding: 0 28px !important;
            border: none !important;
            border-radius: 18px !important;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: #fff !important;
            font-size: 16px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.13em !important;
            cursor: pointer !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease !important;
            box-shadow: 0 16px 34px rgba(239, 68, 68, 0.24) !important;
            white-space: nowrap !important;
        }
        @media (min-width: 1024px) {
            #search-section .s-btn {
                width: auto !important;
                height: 50px !important;
                min-width: 148px !important;
                border-radius: 12px !important;
                font-size: 14px !important;
                letter-spacing: 0.14em !important;
            }
        }
        #search-section .s-btn:hover {
            transform: translateY(-1px) !important;
            filter: brightness(1.02) !important;
            box-shadow: 0 20px 42px rgba(239, 68, 68, 0.26) !important;
        }
        #search-section .s-btn svg {
            width: 19px !important;
            height: 19px !important;
            color: #fff !important;
        }
        @media (min-width: 1024px) {
            #search-section .s-btn svg {
                width: 16px !important;
                height: 16px !important;
            }
        }
    </style>

    <div class="container mx-auto px-5 sm:px-4">
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
                    name="search"
                    placeholder="Model, varian, atau kata kunci"
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
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 9% 0%, rgba(229, 62, 62, 0.18), transparent 30%),
            radial-gradient(circle at 94% 82%, rgba(229, 62, 62, 0.12), transparent 28%),
            linear-gradient(180deg, #101114 0%, #07080b 100%);
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .trust-story-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.038) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.038) 1px, transparent 1px);
        background-size: 72px 72px;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.42), transparent 74%);
        pointer-events: none;
    }
    .why-choose-section {
        position: relative;
        background: transparent;
        padding: clamp(56px, 10vw, 84px) 0 clamp(30px, 6vw, 48px);
    }
    .why-choose-head {
        display: grid;
        gap: 18px;
        align-items: end;
        margin-bottom: clamp(30px, 5vw, 44px);
    }
    @media (min-width: 900px) {
        .why-choose-head {
            grid-template-columns: minmax(0, 0.95fr) minmax(340px, 0.62fr);
        }
    }
    .why-choose-title {
        font-family: var(--font-display);
        font-size: clamp(32px, 5vw, 56px);
        font-weight: 900;
        line-height: 0.98;
        text-transform: uppercase;
        letter-spacing: 0;
        color: #ffffff;
        max-width: 760px;
    }
    .why-choose-subtitle {
        color: rgba(255, 255, 255, 0.62);
        font-size: clamp(14px, 3vw, 15px);
        line-height: 1.8;
        max-width: 460px;
    }
    .why-choose-grid {
        display: grid;
        gap: 14px;
    }
    @media (min-width: 768px) {
        .why-choose-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    .why-choose-card {
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 18px;
        min-height: 210px;
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.018));
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: clamp(20px, 4vw, 28px);
        transition: transform 0.24s ease, border-color 0.24s ease, background 0.24s ease;
    }
    .why-choose-card::before {
        content: '01';
        position: absolute;
        right: 22px;
        bottom: 18px;
        color: rgba(255, 255, 255, 0.08);
        font-family: var(--font-display);
        font-size: 58px;
        font-weight: 900;
        line-height: 1;
    }
    .why-choose-card:nth-child(2)::before {
        content: '02';
    }
    .why-choose-card:nth-child(3)::before {
        content: '03';
    }
    .why-choose-card::after {
        content: '';
        position: absolute;
        inset: 0 auto 0 0;
        width: 3px;
        background: linear-gradient(180deg, #ef4444, rgba(239, 68, 68, 0));
        opacity: 0.4;
    }
    .why-choose-card:hover {
        transform: translateY(-3px);
        border-color: rgba(239, 68, 68, 0.34);
        background:
            linear-gradient(180deg, rgba(239, 68, 68, 0.1), rgba(255, 255, 255, 0.024));
    }
    .why-icon-wrapper {
        width: 54px;
        height: 54px;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid rgba(239, 68, 68, 0.28);
        background: rgba(239, 68, 68, 0.1);
        transition: all 0.3s ease;
    }
    .why-choose-card:hover .why-icon-wrapper {
        box-shadow: 0 0 22px rgba(239, 68, 68, 0.34);
        border-color: rgba(239, 68, 68, 0.5);
        background: rgba(239, 68, 68, 0.12);
    }
    .why-icon-wrapper svg {
        width: 26px;
        height: 26px;
        color: #e53e3e;
        stroke-width: 2;
    }
    .why-card-title {
        font-family: var(--font-display);
        font-size: 16px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #ffffff;
        max-width: 18rem;
        margin-bottom: -4px;
        line-height: 1.45;
    }
    .why-card-description {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
        line-height: 1.75;
        max-width: 29rem;
    }
    @media (max-width: 640px) {
        .why-choose-card {
            min-height: auto;
        }
        .why-choose-card::before {
            font-size: 44px;
        }
    }
</style>

<div class="trust-story-section" id="trust-story">
<section class="why-choose-section">
    <div class="container mx-auto px-4">
        <div class="why-choose-head">
            <h2 class="why-choose-title">Mengapa Memilih Rizki Mobil?</h2>
            <p class="why-choose-subtitle">
                Kami lebih dari sekedar menjual mobil. Setiap kendaraan hadir dengan jaminan kualitas dan transparansi.
            </p>
        </div>

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
        position: relative;
        background: transparent;
        padding: clamp(26px, 5vw, 40px) 0 clamp(62px, 11vw, 92px);
    }
    .testimonials-shell {
        display: grid;
        gap: 26px;
        align-items: start;
    }
    @media (min-width: 1024px) {
        .testimonials-shell {
            grid-template-columns: minmax(0, 0.74fr) minmax(0, 1.26fr);
            gap: clamp(38px, 5vw, 76px);
        }
    }
    .testimonials-intro {
        position: relative;
        overflow: hidden;
        padding: clamp(26px, 5vw, 34px) 0;
    }
    .testimonials-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        color: rgba(255, 255, 255, 0.72);
        font-size: 12px;
        font-weight: 900;
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
        font-size: clamp(34px, 6vw, 58px);
        font-weight: 900;
        line-height: 0.98;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0;
        margin-bottom: 18px;
    }
    .testimonials-description {
        color: rgba(255, 255, 255, 0.68);
        font-size: 15px;
        line-height: 1.8;
        max-width: 38rem;
    }
    .testimonials-highlight {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        max-width: 430px;
        margin-top: 30px;
        border-block: 1px solid rgba(255, 255, 255, 0.12);
    }
    .testimonials-highlight-card {
        padding: 16px 18px 16px 0;
        background: transparent;
        border: 0;
    }
    .testimonials-highlight-card + .testimonials-highlight-card {
        padding-left: 18px;
        border-left: 1px solid rgba(255, 255, 255, 0.12);
    }
    .testimonials-highlight-number {
        font-family: var(--font-display);
        font-size: clamp(26px, 4vw, 34px);
        font-weight: 900;
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
        gap: 14px;
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
        border-radius: 8px;
        padding: clamp(20px, 3vw, 26px);
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.048), rgba(255, 255, 255, 0.018));
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: none;
        transition: transform 0.24s ease, border-color 0.24s ease, box-shadow 0.24s ease;
    }
    @media (min-width: 768px) {
        .testimonials-grid .testimonial-card:first-child {
            display: grid;
            grid-template-columns: minmax(0, 0.7fr) minmax(0, 1fr);
            gap: 24px;
            align-items: center;
            padding: clamp(24px, 4vw, 32px);
            background:
                linear-gradient(135deg, rgba(239, 68, 68, 0.12), rgba(255, 255, 255, 0.032) 42%, rgba(255, 255, 255, 0.018));
            border-color: rgba(239, 68, 68, 0.22);
        }
    }
    .testimonial-card::after {
        content: '';
        position: absolute;
        inset: auto -16% -44% auto;
        width: 150px;
        height: 150px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(229, 62, 62, 0.14), transparent 70%);
        pointer-events: none;
    }
    .testimonial-card:hover {
        transform: translateY(-2px);
        border-color: rgba(239, 68, 68, 0.28);
        box-shadow: 0 20px 48px rgba(0, 0, 0, 0.24);
    }
    .testimonial-topline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 16px;
    }
    .testimonial-name {
        font-family: var(--font-display);
        font-size: 19px;
        font-weight: 900;
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
        padding: 7px 11px;
        border-radius: 999px;
        background: rgba(229, 62, 62, 0.14);
        border: 1px solid rgba(239, 68, 68, 0.2);
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
        font-size: clamp(17px, 2vw, 20px);
        font-weight: 900;
        color: rgba(255, 255, 255, 0.94);
        line-height: 1.42;
        margin-bottom: 12px;
    }
    @media (min-width: 768px) {
        .testimonials-grid .testimonial-card:first-child .testimonial-headline {
            font-size: clamp(22px, 2.6vw, 28px);
            line-height: 1.18;
        }
    }
    .testimonial-quote {
        color: rgba(255, 255, 255, 0.68);
        font-size: 14px;
        line-height: 1.8;
    }
    @media (max-width: 640px) {
        .testimonials-intro {
            padding-top: 16px;
        }
        .testimonials-highlight {
            grid-template-columns: 1fr;
        }
        .testimonials-highlight-card + .testimonials-highlight-card {
            padding-left: 0;
            border-left: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }
        .testimonial-topline {
            align-items: flex-start;
            flex-direction: column;
        }
    }
    
    /* === ABOUT RIZKI MOBIL - EDITORIAL DOSSIER === */
    .about-faq-section {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 12% 8%, rgba(239, 68, 68, 0.14), transparent 32%),
            radial-gradient(circle at 90% 18%, rgba(17, 24, 39, 0.08), transparent 34%),
            linear-gradient(135deg, #fffafa 0%, #f8f3ee 45%, #f6f6f6 100%);
    }
    .about-faq-section::before {
        content: '';
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        background-image:
            linear-gradient(rgba(17, 24, 39, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(17, 24, 39, 0.04) 1px, transparent 1px);
        background-size: 72px 72px;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.38), transparent 68%);
        pointer-events: none;
    }
    .about-rizki-section {
        position: relative;
        overflow: hidden;
        padding: clamp(78px, 12vw, 126px) 0 clamp(46px, 7vw, 76px);
        background: transparent;
    }
    .about-rizki-shell {
        position: relative;
        z-index: 1;
        display: grid;
        gap: clamp(34px, 5vw, 76px);
        align-items: center;
    }
    @media (min-width: 1024px) {
        .about-rizki-shell {
            grid-template-columns: minmax(0, 0.92fr) minmax(0, 1.08fr);
        }
    }

    .about-rizki-media {
        position: relative;
    }
    .about-rizki-media-frame {
        position: relative;
        overflow: hidden;
        min-height: clamp(420px, 47vw, 650px);
        border-radius: clamp(22px, 4vw, 38px);
        background: #070b12;
        border: 1px solid rgba(17, 24, 39, 0.12);
        box-shadow:
            0 34px 90px rgba(17, 24, 39, 0.24),
            0 12px 30px rgba(220, 38, 38, 0.12);
    }
    .about-rizki-media-frame::before,
    .about-rizki-media-frame::after {
        content: '';
        position: absolute;
        z-index: 2;
        pointer-events: none;
    }
    .about-rizki-media-frame::before {
        inset: 0;
        background:
            linear-gradient(180deg, rgba(8, 12, 20, 0.18), rgba(8, 12, 20, 0.56)),
            radial-gradient(circle at 84% 24%, rgba(239, 68, 68, 0.34), transparent 27%);
    }
    .about-rizki-media-frame::after {
        inset: 22px;
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: clamp(16px, 3vw, 28px);
    }
    .about-rizki-car {
        width: 100%;
        height: 100%;
        min-height: inherit;
        object-fit: cover;
        object-position: 58% center;
        transform: scale(1.04);
        filter: saturate(1.02) contrast(1.03);
    }
    .about-rizki-scan {
        position: absolute;
        z-index: 3;
        left: 10%;
        right: 10%;
        top: 42%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.78), #ef4444, transparent);
        box-shadow: 0 0 28px rgba(239, 68, 68, 0.48);
    }
    .about-rizki-media-note {
        position: absolute;
        z-index: 4;
        top: 34px;
        left: 34px;
        max-width: 230px;
        color: rgba(255, 255, 255, 0.78);
        font-size: 12px;
        font-weight: 600;
        line-height: 1.55;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .about-rizki-dossier {
        position: absolute;
        z-index: 4;
        left: 28px;
        right: 28px;
        bottom: 28px;
        display: grid;
        gap: 18px;
        padding: 22px;
        border-radius: 22px;
        background: rgba(9, 14, 24, 0.76);
        border: 1px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.24);
        backdrop-filter: blur(18px);
    }
    .about-rizki-dossier-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .about-rizki-logo {
        height: 34px;
        width: auto;
        filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.34));
    }
    .about-rizki-dossier-code {
        color: rgba(255, 255, 255, 0.58);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .about-rizki-dossier-title {
        font-family: var(--font-display);
        color: #ffffff;
        font-size: clamp(24px, 4vw, 36px);
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -0.02em;
    }
    .about-rizki-dossier-title span {
        color: #ff4d4d;
    }
    .about-rizki-dossier-footer {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }
    .about-rizki-dossier-chip {
        min-height: 68px;
        border-radius: 16px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .about-rizki-dossier-chip strong {
        display: block;
        color: #ffffff;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.2;
    }
    .about-rizki-dossier-chip span {
        display: block;
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.54);
        font-size: 11px;
        line-height: 1.35;
    }

    .about-rizki-content {
        position: relative;
    }
    .about-rizki-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: #991b1b;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        margin-bottom: 24px;
    }
    .about-rizki-kicker::before {
        content: '';
        width: 32px;
        height: 2px;
        background: linear-gradient(90deg, #ef4444, #111827);
        border-radius: 2px;
    }
    .about-rizki-title {
        font-family: var(--font-display);
        font-size: clamp(40px, 6vw, 76px);
        font-weight: 800;
        line-height: 0.96;
        letter-spacing: -0.03em;
        color: #0b101a;
        max-width: 790px;
    }
    .about-rizki-title-highlight {
        color: #ef3333;
    }
    .about-rizki-subtitle {
        margin-top: 30px;
        color: #262c38;
        font-size: 17px;
        line-height: 1.75;
        max-width: 610px;
    }
    .about-rizki-copy {
        display: grid;
        gap: 14px;
        margin-top: 18px;
        color: #6b7280;
        font-size: 15px;
        line-height: 1.85;
        max-width: 590px;
    }

    .about-rizki-proof {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1px;
        overflow: hidden;
        margin-top: 36px;
        max-width: 610px;
        border-radius: 22px;
        background: rgba(17, 24, 39, 0.12);
        border: 1px solid rgba(17, 24, 39, 0.08);
        box-shadow: 0 18px 48px rgba(17, 24, 39, 0.08);
    }
    .about-rizki-proof-item {
        min-height: 116px;
        padding: 22px;
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(14px);
    }
    .about-rizki-proof-value {
        display: block;
        color: #0b101a;
        font-family: var(--font-display);
        font-size: clamp(34px, 4vw, 46px);
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.02em;
    }
    .about-rizki-proof-label {
        display: block;
        margin-top: 8px;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.45;
    }

    .about-rizki-highlights {
        display: grid;
        gap: 0;
        margin-top: 36px;
        max-width: 650px;
        border-top: 1px solid rgba(17, 24, 39, 0.1);
    }
    .about-rizki-highlight {
        display: grid;
        grid-template-columns: 66px minmax(0, 1fr) 38px;
        gap: 18px;
        align-items: center;
        padding: 24px 0;
        border-bottom: 1px solid rgba(17, 24, 39, 0.1);
        transition: color 0.25s ease, transform 0.25s ease;
    }
    .about-rizki-highlight:hover {
        transform: translateX(8px);
    }
    .about-rizki-highlight-index {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #0b101a;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        color: #ef4444;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.08em;
    }
    .about-rizki-highlight-value {
        font-family: var(--font-display);
        font-size: clamp(22px, 2.5vw, 28px);
        font-weight: 800;
        color: #111827;
        letter-spacing: -0.02em;
    }
    .about-rizki-highlight-label {
        margin-top: 6px;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.65;
    }

    .about-rizki-highlight-mark {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.22);
        background: rgba(255, 255, 255, 0.56);
        transition: all 0.25s ease;
    }
    .about-rizki-highlight:hover .about-rizki-highlight-mark {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }
    .about-rizki-highlight-mark svg {
        width: 16px;
        height: 16px;
    }

    @media (max-width: 640px) {
        .about-rizki-section {
            padding-top: 68px;
        }
        .about-rizki-media-frame {
            min-height: 500px;
        }
        .about-rizki-media-note {
            top: 26px;
            left: 26px;
            right: 26px;
            max-width: none;
        }
        .about-rizki-dossier {
            left: 18px;
            right: 18px;
            bottom: 18px;
            padding: 18px;
        }
        .about-rizki-dossier-footer,
        .about-rizki-proof {
            grid-template-columns: 1fr;
        }
        .about-rizki-proof {
            margin-bottom: 18px;
        }
        .about-rizki-highlight {
            grid-template-columns: 48px minmax(0, 1fr);
            gap: 14px;
            padding: 22px 0;
        }
        .about-rizki-highlight-mark {
            display: none;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .about-rizki-highlight,
        .about-rizki-highlight-mark {
            transition: none;
        }
    }

    /* About rhythm refresh: open editorial layout, not another dark card. */
    .about-faq-section {
        background: linear-gradient(180deg, #fbfaf8 0%, #f5f1ed 48%, #ffffff 100%);
    }
    .about-faq-section::before {
        opacity: 0.42;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.26), transparent 48%);
    }
    .about-rizki-section {
        padding: clamp(82px, 12vw, 132px) 0 clamp(64px, 8vw, 96px);
    }
    .about-rizki-shell {
        align-items: stretch;
    }
    @media (min-width: 1024px) {
        .about-rizki-shell {
            grid-template-columns: minmax(0, 1.05fr) minmax(330px, 0.95fr);
        }
    }
    .about-rizki-title {
        max-width: 820px;
    }
    .about-rizki-proof {
        max-width: 620px;
        border-radius: 0;
        border-width: 1px 0;
        background: transparent;
        box-shadow: none;
    }
    .about-rizki-proof-item {
        background: transparent;
        backdrop-filter: none;
        padding: 22px 0;
    }
    .about-rizki-proof-item + .about-rizki-proof-item {
        padding-left: 28px;
        border-left: 1px solid rgba(17, 24, 39, 0.12);
    }
    .about-rizki-system {
        position: relative;
        display: flex;
        min-height: 100%;
        flex-direction: column;
        padding-top: 12px;
    }
    .about-rizki-system-label {
        color: #991b1b;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    .about-rizki-highlights {
        display: grid;
        flex: 1;
        grid-template-rows: repeat(3, minmax(0, 1fr));
        margin-top: 28px;
        max-width: none;
        border-top-color: rgba(17, 24, 39, 0.16);
    }
    .about-rizki-highlight {
        align-content: center;
        grid-template-columns: 50px minmax(0, 1fr);
        min-height: clamp(118px, 11vw, 154px);
        padding: clamp(22px, 2.6vw, 30px) 0;
    }
    .about-rizki-highlight:hover {
        transform: none;
    }
    .about-rizki-highlight-index {
        width: 38px;
        height: 38px;
        background: transparent;
        border: 1px solid rgba(239, 68, 68, 0.28);
        box-shadow: none;
    }
    .about-rizki-highlight-mark {
        display: none;
    }
    .about-rizki-system-note {
        display: grid;
        gap: 10px;
        margin-top: clamp(20px, 3vw, 34px);
        padding-top: clamp(18px, 2.4vw, 26px);
        border-top: 1px solid rgba(17, 24, 39, 0.12);
    }
    .about-rizki-system-note span {
        color: rgba(153, 27, 27, 0.86);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    .about-rizki-system-note p {
        max-width: 36rem;
        color: #64748b;
        font-size: clamp(14px, 1.1vw, 16px);
        line-height: 1.75;
    }
    .about-rizki-image-band {
        position: relative;
        z-index: 1;
        overflow: hidden;
        min-height: clamp(220px, 24vw, 340px);
        margin-top: clamp(44px, 7vw, 78px);
        border-block: 1px solid rgba(17, 24, 39, 0.12);
        background: #060910;
    }
    .about-rizki-band-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 58% center;
        opacity: 0.72;
        filter: saturate(1.02) contrast(1.04);
    }
    .about-rizki-image-band::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(6, 9, 16, 0.88), rgba(6, 9, 16, 0.18) 58%, rgba(239, 68, 68, 0.16)),
            linear-gradient(180deg, rgba(6, 9, 16, 0.1), rgba(6, 9, 16, 0.54));
    }
    .about-rizki-image-band::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.74), #ef4444, transparent);
        box-shadow: 0 0 28px rgba(239, 68, 68, 0.42);
    }
    .about-rizki-band-copy {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 14px;
        max-width: 38rem;
        padding: clamp(32px, 5vw, 58px);
    }
    .about-rizki-band-copy span {
        color: rgba(255, 255, 255, 0.58);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }
    .about-rizki-band-copy strong {
        color: #ffffff;
        font-family: var(--font-display);
        font-size: clamp(28px, 4vw, 48px);
        font-weight: 900;
        line-height: 1.04;
        letter-spacing: -0.025em;
    }
    @media (max-width: 640px) {
        .about-rizki-system {
            min-height: auto;
        }
        .about-rizki-highlights {
            display: block;
        }
        .about-rizki-highlight {
            min-height: 0;
        }
        .about-rizki-proof-item + .about-rizki-proof-item {
            padding-left: 0;
            border-left: 0;
            border-top: 1px solid rgba(17, 24, 39, 0.12);
        }
        .about-rizki-image-band {
            min-height: 320px;
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
</div>

<div class="about-faq-section">
<section class="about-rizki-section" id="tentang">
    <div class="container mx-auto px-4">
        <div class="about-rizki-shell">
            <div class="about-rizki-content">
                <p class="about-rizki-kicker">{{ $aboutRizki['kicker'] }}</p>
                <h2 class="about-rizki-title">
                    Mobil bekas yang sudah lolos <span class="about-rizki-title-highlight">rasa ragu.</span>
                </h2>
                <p class="about-rizki-subtitle">{{ $aboutRizki['subtitle'] }}</p>

                <div class="about-rizki-copy">
                    @foreach($aboutRizki['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <div class="about-rizki-proof">
                    <div class="about-rizki-proof-item">
                        <strong class="about-rizki-proof-value">{{ $stats['yearsInBusiness'] }}+</strong>
                        <span class="about-rizki-proof-label">tahun membangun proses jual beli yang lebih dipercaya</span>
                    </div>
                    <div class="about-rizki-proof-item">
                        <strong class="about-rizki-proof-value">{{ number_format($stats['carsSold']) }}+</strong>
                        <span class="about-rizki-proof-label">unit menemukan pemilik baru lewat kurasi yang lebih tenang</span>
                    </div>
                </div>
            </div>

            <div class="about-rizki-system" aria-label="Sistem kurasi Rizki Mobil">
                <p class="about-rizki-system-label">RMI selection system</p>
                <div class="about-rizki-highlights">
                    @foreach($aboutRizki['highlights'] as $index => $highlight)
                        <div class="about-rizki-highlight">
                            <span class="about-rizki-highlight-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <div>
                                <p class="about-rizki-highlight-value">{{ $highlight['value'] }}</p>
                                <p class="about-rizki-highlight-label">{{ $highlight['label'] }}</p>
                            </div>
                            <span class="about-rizki-highlight-mark" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H8M17 7v9"/>
                            </svg>
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="about-rizki-system-note">
                    <span>{{ $aboutRizki['system_note']['eyebrow'] }}</span>
                    <p>{{ $aboutRizki['system_note']['text'] }}</p>
                </div>
            </div>
        </div>

        <div class="about-rizki-image-band">
            <img
                src="{{ asset($aboutRizki['vehicle_image']) }}"
                alt="Unit mobil pilihan Rizki Mobil Indonesia"
                class="about-rizki-band-image"
            />
            <div class="about-rizki-band-copy">
                <span>Curated unit dossier</span>
                <strong>Bukan sekadar stok. Setiap unit punya cerita yang dibuka.</strong>
            </div>
        </div>
    </div>
</section>

<style>
    /* === FAQ SECTION - DECISION DESK === */
    .faq-section {
        position: relative;
        padding: clamp(34px, 6vw, 78px) 0 clamp(86px, 12vw, 124px);
        background: transparent;
    }
    .faq-shell {
        position: relative;
        z-index: 1;
        display: grid;
        gap: clamp(24px, 4vw, 48px);
        align-items: stretch;
    }
    @media (min-width: 1024px) {
        .faq-shell {
            grid-template-columns: minmax(320px, 0.78fr) minmax(0, 1.22fr);
        }
    }
    .faq-command {
        position: relative;
        overflow: hidden;
        min-height: 100%;
        border-radius: clamp(22px, 3vw, 34px);
        padding: clamp(28px, 4vw, 42px);
        background:
            radial-gradient(circle at 88% 12%, rgba(239, 68, 68, 0.34), transparent 32%),
            linear-gradient(145deg, #111827 0%, #070b12 58%, #04060a 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow:
            0 36px 90px rgba(17, 24, 39, 0.28),
            0 18px 44px rgba(239, 68, 68, 0.12);
    }
    .faq-command::before {
        content: '';
        position: absolute;
        inset: 22px;
        border-radius: clamp(16px, 2.5vw, 26px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }
    .faq-command::after {
        content: '';
        position: absolute;
        left: 42px;
        right: 42px;
        top: 38%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.7), transparent);
        box-shadow: 0 0 28px rgba(239, 68, 68, 0.44);
        pointer-events: none;
    }
    .faq-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.68);
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.16em;
    }
    .faq-kicker::before {
        content: '';
        width: 32px;
        height: 2px;
        background: linear-gradient(90deg, #ef4444, rgba(255, 255, 255, 0.28));
        border-radius: 2px;
    }
    .faq-title {
        margin-top: 34px;
        font-family: var(--font-display);
        font-size: clamp(34px, 5vw, 58px);
        font-weight: 800;
        line-height: 0.98;
        letter-spacing: -0.03em;
        color: #ffffff;
    }
    .faq-title span {
        color: #ff4747;
    }
    .faq-description {
        margin-top: 22px;
        color: rgba(255, 255, 255, 0.64);
        font-size: 16px;
        line-height: 1.8;
        max-width: 34rem;
    }
    .faq-command-proof {
        display: grid;
        gap: 1px;
        overflow: hidden;
        margin-top: 34px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .faq-command-proof-row {
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
        padding: 16px;
        background: rgba(255, 255, 255, 0.06);
    }
    .faq-command-proof-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.16);
        color: #ff4747;
    }
    .faq-command-proof-icon svg {
        width: 18px;
        height: 18px;
    }
    .faq-command-proof-text {
        color: rgba(255, 255, 255, 0.82);
        font-size: 13px;
        font-weight: 700;
        line-height: 1.45;
    }
    .faq-command-footer {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-top: 34px;
        padding-top: 26px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    .faq-command-code {
        color: rgba(255, 255, 255, 0.46);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    .faq-command-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 44px;
        border-radius: 999px;
        padding: 0 18px;
        background: #ef4444;
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        box-shadow: 0 16px 36px rgba(239, 68, 68, 0.28);
        transition: transform 0.25s ease, background 0.25s ease;
    }
    .faq-command-link:hover {
        transform: translateY(-2px);
        background: #dc2626;
    }
    .faq-command-link svg {
        width: 15px;
        height: 15px;
    }
    .faq-board {
        position: relative;
        display: grid;
        gap: 14px;
        align-content: start;
    }
    .faq-board::before {
        content: '';
        position: absolute;
        left: 28px;
        top: 26px;
        bottom: 26px;
        width: 1px;
        background: linear-gradient(to bottom, transparent, rgba(239, 68, 68, 0.28), transparent);
        pointer-events: none;
    }
    .faq-card {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 58px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
        border-radius: 24px;
        padding: clamp(22px, 3vw, 30px);
        background: rgba(255, 255, 255, 0.74);
        border: 1px solid rgba(17, 24, 39, 0.09);
        box-shadow: 0 20px 55px rgba(17, 24, 39, 0.08);
        backdrop-filter: blur(18px);
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .faq-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #ef4444, rgba(239, 68, 68, 0));
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .faq-card:hover {
        transform: translateX(8px);
        border-color: rgba(239, 68, 68, 0.22);
        box-shadow: 0 26px 70px rgba(239, 68, 68, 0.12);
    }
    .faq-card:hover::before {
        opacity: 1;
    }
    .faq-card-index {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #0b101a;
        color: #ef4444;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.08em;
        box-shadow: 0 12px 28px rgba(17, 24, 39, 0.16);
    }
    .faq-card-question {
        font-family: var(--font-display);
        font-size: clamp(21px, 2.4vw, 30px);
        font-weight: 800;
        line-height: 1.12;
        letter-spacing: -0.025em;
        color: #0b101a;
    }
    .faq-card-divider {
        width: 52px;
        height: 3px;
        margin: 16px 0 14px;
        background: linear-gradient(90deg, #ef4444, rgba(239, 68, 68, 0.16));
        border-radius: 2px;
    }
    .faq-card-answer {
        color: #6b7280;
        font-size: 15px;
        line-height: 1.82;
        max-width: 48rem;
    }
    @media (max-width: 640px) {
        .faq-section {
            padding-top: 42px;
        }
        .faq-command {
            padding: 28px;
        }
        .faq-command::before {
            inset: 14px;
        }
        .faq-command-footer {
            align-items: flex-start;
            flex-direction: column;
        }
        .faq-command-link {
            width: 100%;
            justify-content: center;
        }
        .faq-board::before {
            display: none;
        }
        .faq-card {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .faq-card:hover {
            transform: none;
        }
    }

    /* FAQ rhythm refresh: open ledger, no second dark card system. */
    .faq-section {
        padding: clamp(72px, 10vw, 118px) 0 clamp(78px, 10vw, 118px);
        background:
            linear-gradient(180deg, #ffffff 0%, #f6f6f4 100%);
    }
    .faq-shell {
        gap: clamp(34px, 5vw, 70px);
    }
    @media (min-width: 1024px) {
        .faq-shell {
            grid-template-columns: minmax(260px, 0.7fr) minmax(0, 1.3fr);
        }
    }
    .faq-command {
        position: sticky;
        top: 104px;
        align-self: start;
        overflow: visible;
        min-height: auto;
        padding: 0;
        border-radius: 0;
        background: transparent;
        border: 0;
        box-shadow: none;
    }
    @media (min-width: 1024px) {
        .faq-command {
            margin-top: clamp(34px, 5vw, 78px);
            top: 124px;
        }
    }
    .faq-command::before,
    .faq-command::after,
    .faq-command-proof {
        display: none;
    }
    .faq-kicker {
        color: #991b1b;
    }
    .faq-kicker::before {
        background: linear-gradient(90deg, #ef4444, #111827);
    }
    .faq-title {
        margin-top: 24px;
        color: #0b101a;
        font-size: clamp(36px, 5vw, 64px);
    }
    .faq-description {
        color: #6b7280;
    }
    .faq-command-footer {
        justify-content: flex-start;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid rgba(17, 24, 39, 0.12);
    }
    .faq-command-code {
        color: rgba(17, 24, 39, 0.48);
    }
    .faq-command-link {
        background: #0b101a;
        color: #ffffff;
        box-shadow: none;
    }
    .faq-command-link:hover {
        background: #ef4444;
    }
    .faq-board {
        gap: 0;
        border-top: 1px solid rgba(17, 24, 39, 0.14);
    }
    .faq-board::before {
        display: none;
    }
    .faq-card {
        grid-template-columns: 68px minmax(0, 1fr);
        gap: 22px;
        border-radius: 0;
        padding: clamp(26px, 4vw, 44px) 0;
        background: transparent;
        border: 0;
        border-bottom: 1px solid rgba(17, 24, 39, 0.14);
        box-shadow: none;
        backdrop-filter: none;
    }
    .faq-card::before {
        display: none;
    }
    .faq-card:hover {
        transform: none;
        box-shadow: none;
        border-color: rgba(17, 24, 39, 0.14);
    }
    .faq-card-index {
        width: 42px;
        height: 42px;
        background: transparent;
        border: 1px solid rgba(239, 68, 68, 0.3);
        box-shadow: none;
    }
    .faq-card-question {
        max-width: 58rem;
        font-size: clamp(24px, 3vw, 38px);
    }
    .faq-card-answer {
        max-width: 62rem;
    }
    @media (max-width: 640px) {
        .faq-command {
            position: relative;
            top: auto;
        }
        .faq-command-footer {
            align-items: stretch;
        }
        .faq-card {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="faq-section" id="faq">
    <div class="container mx-auto px-4">
        <div class="faq-shell">
            <header class="faq-command">
                <p class="faq-kicker">FAQ Rizki Mobil</p>
                <h2 class="faq-title">Biar keputusan beli terasa <span>lebih terang.</span></h2>
                <p class="faq-description">
                    Kami rangkum pertanyaan yang biasanya muncul sebelum pelanggan lihat unit, tukar tambah, atau mengunci pilihan.
                </p>

                <div class="faq-command-footer">
                    <span class="faq-command-code">Ask before deal</span>
                    <a href="{{ route('contact') }}" class="faq-command-link">
                        Tanya Admin
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H8M17 7v9"/>
                        </svg>
                    </a>
                </div>
            </header>

            <div class="faq-board">
                @foreach($faqs as $index => $faq)
                    <article class="faq-card">
                        <span class="faq-card-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <div>
                            <h3 class="faq-card-question">{{ $faq['question'] }}</h3>
                            <div class="faq-card-divider"></div>
                            <p class="faq-card-answer">{{ $faq['answer'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
</div>

<style>
    /* === CLOSING CTA - SHOWROOM HANDOVER === */
    .closing-cta-section {
        position: relative;
        overflow: hidden;
        padding: clamp(78px, 10vw, 118px) 0;
        background:
            radial-gradient(circle at 80% 12%, rgba(239, 68, 68, 0.1), transparent 30%),
            linear-gradient(180deg, #f7f7f5 0%, #ffffff 48%, #f8f8f8 100%);
    }
    .closing-cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(17, 24, 39, 0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(17, 24, 39, 0.035) 1px, transparent 1px);
        background-size: 76px 76px;
        mask-image: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.34), transparent);
        pointer-events: none;
    }
    .closing-cta-panel {
        position: relative;
        z-index: 1;
        overflow: hidden;
        display: grid;
        gap: 0;
        border-radius: clamp(24px, 3vw, 38px);
        background:
            radial-gradient(circle at 30% 0%, rgba(239, 68, 68, 0.28), transparent 34%),
            linear-gradient(135deg, #101722 0%, #060910 58%, #030407 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow:
            0 42px 100px rgba(17, 24, 39, 0.24),
            0 22px 55px rgba(239, 68, 68, 0.12);
    }
    @media (min-width: 1024px) {
        .closing-cta-panel {
            grid-template-columns: minmax(0, 1.04fr) minmax(360px, 0.96fr);
            min-height: 460px;
        }
    }
    .closing-cta-copy {
        position: relative;
        z-index: 2;
        padding: clamp(30px, 6vw, 68px);
    }
    .closing-cta-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.64);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }
    .closing-cta-kicker::before {
        content: '';
        width: 34px;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, #ef4444, rgba(255, 255, 255, 0.3));
    }
    .closing-cta-title {
        margin-top: 28px;
        max-width: 760px;
        font-family: var(--font-display);
        font-size: clamp(38px, 5.4vw, 72px);
        font-weight: 900;
        line-height: 0.96;
        letter-spacing: -0.035em;
        color: #ffffff;
    }
    .closing-cta-title span {
        color: #ff4747;
    }
    .closing-cta-description {
        margin-top: 22px;
        max-width: 39rem;
        color: rgba(255, 255, 255, 0.68);
        font-size: 16px;
        line-height: 1.82;
    }
    .closing-cta-proof {
        display: grid;
        gap: 1px;
        overflow: hidden;
        max-width: 680px;
        margin-top: 34px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.11);
        border: 1px solid rgba(255, 255, 255, 0.09);
    }
    @media (min-width: 640px) {
        .closing-cta-proof {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    .closing-cta-proof-item {
        min-height: 94px;
        padding: 18px;
        background: rgba(255, 255, 255, 0.06);
    }
    .closing-cta-proof-item strong {
        display: block;
        color: #ffffff;
        font-size: 14px;
        font-weight: 900;
        line-height: 1.25;
    }
    .closing-cta-proof-item span {
        display: block;
        margin-top: 8px;
        color: rgba(255, 255, 255, 0.54);
        font-size: 12px;
        line-height: 1.5;
    }
    .closing-cta-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 34px;
    }
    .closing-cta-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 52px;
        border-radius: 999px;
        padding: 0 24px;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        transition: transform 0.25s ease, background 0.25s ease, border-color 0.25s ease;
    }
    .closing-cta-button svg {
        width: 16px;
        height: 16px;
    }
    .closing-cta-button-primary {
        background: #ef4444;
        color: #ffffff;
        box-shadow: 0 18px 42px rgba(239, 68, 68, 0.32);
    }
    .closing-cta-button-primary:hover {
        transform: translateY(-2px);
        background: #dc2626;
    }
    .closing-cta-button-secondary {
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
    }
    .closing-cta-button-secondary:hover {
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.34);
        background: rgba(255, 255, 255, 0.1);
    }
    .closing-cta-media {
        position: relative;
        min-height: clamp(330px, 42vw, 520px);
        background: #05070d;
    }
    .closing-cta-car {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 58% center;
        filter: saturate(1.04) contrast(1.08);
        opacity: 0.86;
    }
    .closing-cta-media::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 1;
        background:
            linear-gradient(90deg, #060910 0%, rgba(6, 9, 16, 0.72) 22%, rgba(6, 9, 16, 0.1) 74%),
            radial-gradient(circle at 72% 24%, rgba(239, 68, 68, 0.4), transparent 28%);
        pointer-events: none;
    }
    .closing-cta-scan {
        position: absolute;
        z-index: 2;
        left: 10%;
        right: 8%;
        top: 42%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.78), #ef4444, transparent);
        box-shadow: 0 0 28px rgba(239, 68, 68, 0.46);
    }
    .closing-cta-media-card {
        position: absolute;
        z-index: 3;
        right: clamp(18px, 4vw, 44px);
        bottom: clamp(18px, 4vw, 44px);
        width: min(330px, calc(100% - 36px));
        padding: 22px;
        border-radius: 24px;
        background: rgba(8, 12, 20, 0.76);
        border: 1px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 26px 70px rgba(0, 0, 0, 0.34);
        backdrop-filter: blur(18px);
    }
    .closing-cta-media-code {
        color: rgba(255, 255, 255, 0.52);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    .closing-cta-media-title {
        margin-top: 14px;
        color: #ffffff;
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 900;
        line-height: 1.04;
        letter-spacing: -0.025em;
    }
    .closing-cta-media-title span {
        color: #ff4747;
    }
    .closing-cta-media-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
    }
    .closing-cta-media-meta strong {
        color: #ffffff;
        font-family: var(--font-display);
        font-size: 34px;
        font-weight: 900;
        line-height: 1;
    }
    .closing-cta-media-meta span {
        max-width: 150px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 12px;
        line-height: 1.45;
        text-align: right;
    }
    @media (max-width: 640px) {
        .closing-cta-section {
            padding: 52px 0 72px;
        }
        .closing-cta-actions,
        .closing-cta-button {
            width: 100%;
        }
        .closing-cta-media {
            min-height: 360px;
        }
        .closing-cta-media::before {
            background:
                linear-gradient(180deg, #060910 0%, rgba(6, 9, 16, 0.58) 38%, rgba(6, 9, 16, 0.12) 100%),
                radial-gradient(circle at 74% 18%, rgba(239, 68, 68, 0.4), transparent 34%);
        }
        .closing-cta-media-card {
            top: 22px;
            bottom: auto;
        }
        .closing-cta-media-title {
            font-size: 24px;
        }
        .closing-cta-media-meta strong {
            font-size: 30px;
        }
    }

    /* Closing rhythm refresh: full-bleed handover band, not another rounded card. */
    .closing-cta-section {
        padding: clamp(82px, 11vw, 130px) 0;
        background:
            radial-gradient(circle at 82% 18%, rgba(239, 68, 68, 0.22), transparent 34%),
            linear-gradient(135deg, #0b101a 0%, #05070d 66%, #120306 100%);
    }
    .closing-cta-section::before {
        opacity: 0.22;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.07) 1px, transparent 1px);
    }
    .closing-cta-panel {
        overflow: visible;
        border-radius: 0;
        background: transparent;
        border: 0;
        box-shadow: none;
    }
    @media (min-width: 1024px) {
        .closing-cta-panel {
            grid-template-columns: minmax(0, 0.9fr) minmax(420px, 1.1fr);
            min-height: 520px;
        }
    }
    .closing-cta-copy {
        padding: clamp(28px, 4vw, 48px) 0;
    }
    .closing-cta-proof {
        border-radius: 0;
        border-width: 1px 0;
        background: transparent;
    }
    .closing-cta-proof-item {
        background: transparent;
        padding: 18px 18px 18px 0;
    }
    .closing-cta-proof-item + .closing-cta-proof-item {
        border-left: 1px solid rgba(255, 255, 255, 0.14);
        padding-left: 18px;
    }
    .closing-cta-media {
        overflow: hidden;
        min-height: clamp(360px, 38vw, 560px);
        border-left: 1px solid rgba(255, 255, 255, 0.12);
        background: transparent;
    }
    .closing-cta-media-card {
        left: clamp(28px, 5vw, 72px);
        right: auto;
        bottom: clamp(28px, 5vw, 68px);
        width: min(420px, calc(100% - 56px));
        padding: 0;
        border-radius: 0;
        background: transparent;
        border: 0;
        box-shadow: none;
        backdrop-filter: none;
    }
    .closing-cta-media-title {
        font-size: clamp(30px, 4vw, 48px);
    }
    .closing-cta-media-meta {
        justify-content: flex-start;
        gap: 22px;
        border-top-color: rgba(255, 255, 255, 0.18);
    }
    .closing-cta-media-meta span {
        text-align: left;
    }
    @media (max-width: 640px) {
        .closing-cta-panel {
            gap: 28px;
        }
        .closing-cta-copy {
            padding: 0;
        }
        .closing-cta-proof-item + .closing-cta-proof-item {
            border-left: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            padding-left: 0;
        }
        .closing-cta-media {
            min-height: 390px;
            border-left: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }
        .closing-cta-media-card {
            left: 24px;
            top: 28px;
            width: calc(100% - 48px);
        }
    }
</style>

<section class="closing-cta-section">
    <div class="container mx-auto px-4">
        <div class="closing-cta-panel">
            <div class="closing-cta-copy">
                <p class="closing-cta-kicker">Final checkpoint</p>
                <h2 class="closing-cta-title">
                    Unit yang tepat biasanya tidak <span>menunggu lama.</span>
                </h2>
                <p class="closing-cta-description">
                    Lihat stok yang sedang tersedia, bandingkan unit pilihan, lalu bicara dengan admin untuk jadwal visit atau detail kondisi sebelum Anda datang.
                </p>

                <div class="closing-cta-proof" aria-label="Keunggulan proses Rizki Mobil">
                    <div class="closing-cta-proof-item">
                        <strong>Stok terkurasi</strong>
                        <span>unit pilihan dengan detail kondisi yang lebih jelas</span>
                    </div>
                    <div class="closing-cta-proof-item">
                        <strong>Visit fleksibel</strong>
                        <span>atur waktu lihat mobil sesuai agenda Anda</span>
                    </div>
                    <div class="closing-cta-proof-item">
                        <strong>Admin responsif</strong>
                        <span>tanya harga, dokumen, dan opsi tukar tambah</span>
                    </div>
                </div>

                <div class="closing-cta-actions">
                    <a href="{{ route('inventory') }}" class="closing-cta-button closing-cta-button-primary">
                        Lihat Inventori
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H8M17 7v9"/>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="closing-cta-button closing-cta-button-secondary">
                        Hubungi Kami
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h8M8 14h5m-9 6 3.5-3.5H20a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10.5a1 1 0 0 0 1 1Z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="closing-cta-media" aria-hidden="true">
                <img
                    src="{{ asset($aboutRizki['handover_image']) }}"
                    alt=""
                    class="closing-cta-car"
                />
                <div class="closing-cta-scan"></div>
                <div class="closing-cta-media-card">
                    <p class="closing-cta-media-code">RMI handover</p>
                    <p class="closing-cta-media-title">Pilih unit. Cek detail. <span>Datang lebih yakin.</span></p>
                    <div class="closing-cta-media-meta">
                        <strong>{{ number_format($stats['carsSold']) }}+</strong>
                        <span>unit telah menemukan pemilik baru</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
