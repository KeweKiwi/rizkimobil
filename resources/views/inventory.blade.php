@extends('layouts.app')

@section('content')
<style>
    /* Inventory Hero Section */
    .inventory-hero {
        position: relative;
        background: linear-gradient(135deg, #0a0a0b 0%, #1a1a1f 50%, #0a0a0b 100%);
        padding: clamp(40px, 10vw, 80px) 0 clamp(30px, 8vw, 60px);
        overflow: hidden;
    }
    .inventory-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(239, 68, 68, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(239, 68, 68, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }
    .inventory-title {
        position: relative;
        font-family: var(--font-display);
        font-size: clamp(28px, 7vw, 48px);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #ffffff;
        text-align: center;
        margin-bottom: 16px;
        text-shadow: 0 0 30px rgba(239, 68, 68, 0.5);
    }
    .inventory-subtitle {
        position: relative;
        text-align: center;
        color: rgba(255, 255, 255, 0.7);
        font-size: clamp(14px, 3vw, 18px);
        margin-bottom: 40px;
        padding: 0 16px;
    }
    .inventory-stats {
        position: relative;
        display: flex;
        justify-content: center;
        gap: clamp(24px, 6vw, 48px);
        flex-wrap: wrap;
        padding: 0 16px;
    }
    .stat-item {
        text-align: center;
    }
    .stat-number {
        font-size: clamp(24px, 6vw, 36px);
        font-weight: 700;
        color: #e53e3e;
        line-height: 1;
        text-shadow: 0 0 20px rgba(239, 68, 68, 0.6);
    }
    .stat-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255, 255, 255, 0.5);
        margin-top: 8px;
    }

    /* Filter Sidebar - Futuristic Design */
    .filter-sidebar {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        border: 1px solid rgba(239, 68, 68, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 20px rgba(239, 68, 68, 0.1);
        overflow: hidden;
    }
    .filter-header {
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        padding: clamp(16px, 4vw, 24px);
        color: white;
    }
    .filter-header h3 {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .filter-body {
        padding: clamp(16px, 4vw, 24px);
    }
    .filter-group {
        margin-bottom: 28px;
        padding-bottom: 28px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }
    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .filter-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #111;
        margin-bottom: 12px;
        display: block;
    }
    .filter-input,
    .filter-select {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.12);
        background: #fff;
        color: #111;
        font-size: 14px;
        transition: all 0.2s;
    }
    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #e53e3e;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1), 0 0 15px rgba(239, 68, 68, 0.2);
    }
    .filter-btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }
    .filter-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        padding: 5px 13px;
        border-radius: 20px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        background: #f8f8f8;
        font-size: 13px;
        font-weight: 500;
        color: #444;
        cursor: pointer;
        transition: all 0.18s;
        user-select: none;
        white-space: nowrap;
    }
    .filter-btn:hover {
        border-color: rgba(229, 62, 62, 0.5);
        background: rgba(229, 62, 62, 0.06);
        color: #e53e3e;
    }
    .filter-btn:has(input:checked) {
        background: #e53e3e;
        border-color: #e53e3e;
        color: #fff;
        box-shadow: 0 2px 8px rgba(229, 62, 62, 0.35);
    }
    .filter-btn input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
    }
    .clear-filters-btn {
        width: 100%;
        height: 44px;
        border-radius: 8px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #e53e3e;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .clear-filters-btn:hover {
        background: #e53e3e;
        color: white;
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
    }
    .range-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    /* Toolbar */
    .inventory-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 32px;
    }
    .mobile-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        padding: 0 20px;
        border-radius: 8px;
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        color: white;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
    }
    .mobile-filter-btn:hover {
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.5);
        transform: translateY(-2px);
    }
    .sort-select {
        height: 44px;
        padding: 0 40px 0 14px;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.12);
        background: white;
        color: #111;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23111'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
    }
    .sort-select:focus {
        outline: none;
        border-color: #e53e3e;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    /* Mobile Filters Overlay */
    .mobile-filters-overlay {
        position: fixed;
        inset: 0;
        z-index: 50;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        display: none;
        overflow-y: auto;
    }
    .mobile-filters-overlay.active {
        display: block;
        animation: fadeIn 0.3s;
    }
    .mobile-filters-content {
        background: white;
        min-height: 100vh;
        padding: clamp(16px, 4vw, 24px);
    }
    .mobile-filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: clamp(16px, 4vw, 24px);
    }
    .mobile-filters-title {
        font-family: var(--font-display);
        font-size: 24px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #111;
    }
    .close-mobile-filters {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: rgba(239, 68, 68, 0.1);
        color: #e53e3e;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .close-mobile-filters:hover {
        background: #e53e3e;
        color: white;
    }
    .mobile-filter-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }
    .apply-filters-btn {
        flex: 1;
        height: 50px;
        border-radius: 8px;
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        color: white;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
    }
    .apply-filters-btn:hover {
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.5);
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        padding: clamp(40px, 10vw, 80px) 20px;
    }
    .no-results-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e53e3e;
    }
    .no-results-title {
        font-size: 24px;
        font-weight: 700;
        color: #111;
        margin-bottom: 12px;
    }
    .no-results-text {
        color: rgba(0, 0, 0, 0.5);
        margin-bottom: 24px;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @media (max-width: 1023px) {
        .inventory-title {
            font-size: 32px;
        }
        .stat-number {
            font-size: 28px;
        }
    }
</style>

<!-- Hero Section -->
<div class="inventory-hero">
    <div class="container mx-auto px-4">
        <h1 class="inventory-title">Jelajahi Koleksi Kami</h1>
        <p class="inventory-subtitle">Temukan mobil impian Anda dari inventori premium kami</p>
        <div class="inventory-stats">
            <div class="stat-item">
                <div class="stat-number">{{ $cars->total() }}</div>
                <div class="stat-label">Unit Tersedia</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ count($carMakes) }}</div>
                <div class="stat-label">Merek</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ count($bodyTypes) }}</div>
                <div class="stat-label">Tipe Body</div>
            </div>
        </div>
    </div>
</div>

<div class="bg-background py-12">
    <div class="container mx-auto px-4">
        <div class="flex gap-8">
            <!-- Desktop Sidebar Filters -->
            <aside class="hidden w-80 shrink-0 lg:block">
                <div class="filter-sidebar">
                    <div class="filter-header">
                        <h3>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            Filter Pencarian
                        </h3>
                    </div>
                    <div class="filter-body">
                        <form action="{{ route('inventory') }}" method="GET" id="filter-form">
                            <!-- Search -->
                            <div class="filter-group">
                                <label for="search" class="filter-label">Pencarian</label>
                                <div class="relative">
                                    <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input
                                        id="search"
                                        name="search"
                                        type="text"
                                        placeholder="Cari merek atau model..."
                                        value="{{ request('search') }}"
                                        class="filter-input pl-12"
                                    />
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="filter-group">
                                <label class="filter-label">Lokasi</label>
                                <select 
                                    name="location" 
                                    class="filter-select"
                                >
                                    <option value="">Semua Lokasi</option>
                                    @foreach($locations as $id => $name)
                                        <option value="{{ $id }}" {{ request('location') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Make -->
                            <div class="filter-group">
                                <label class="filter-label">Merek</label>
                                <select 
                                    name="make" 
                                    class="filter-select"
                                >
                                    <option value="">Semua Merek</option>
                                    @foreach($carMakes as $make)
                                        <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                                            {{ $make }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="filter-group">
                                <label class="filter-label">Rentang Harga</label>
                                <select 
                                    name="price_range" 
                                    class="filter-select"
                                >
                                    <option value="">Semua Harga</option>
                                    <option value="0-100000000" {{ request('price_range') == '0-100000000' ? 'selected' : '' }}>Di bawah Rp 100 juta</option>
                                    <option value="100000000-200000000" {{ request('price_range') == '100000000-200000000' ? 'selected' : '' }}>Rp 100 juta - 200 juta</option>
                                    <option value="200000000-300000000" {{ request('price_range') == '200000000-300000000' ? 'selected' : '' }}>Rp 200 juta - 300 juta</option>
                                    <option value="300000000-999999999" {{ request('price_range') == '300000000-999999999' ? 'selected' : '' }}>Di atas Rp 300 juta</option>
                                </select>
                            </div>

                            <!-- Body Type -->
                            <div class="filter-group">
                                <label class="filter-label">Tipe Body</label>
                                <div class="filter-btn-group">
                                    @foreach($bodyTypes as $type)
                                        <label class="filter-btn">
                                            <input type="checkbox" name="body_type[]" value="{{ $type }}"
                                                {{ in_array($type, request('body_type', [])) ? 'checked' : '' }} />
                                            {{ ucfirst($type) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Fuel Type -->
                            <div class="filter-group">
                                <label class="filter-label">Jenis Bahan Bakar</label>
                                <div class="filter-btn-group">
                                    @foreach($fuelTypes as $type)
                                        <label class="filter-btn">
                                            <input type="checkbox" name="fuel_type[]" value="{{ $type }}"
                                                {{ in_array($type, request('fuel_type', [])) ? 'checked' : '' }} />
                                            {{ ucfirst($type) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Transmission -->
                            <div class="filter-group">
                                <label class="filter-label">Transmisi</label>
                                <div class="filter-btn-group">
                                    @foreach($transmissions as $type)
                                        <label class="filter-btn">
                                            <input type="checkbox" name="transmission[]" value="{{ $type }}"
                                                {{ in_array($type, request('transmission', [])) ? 'checked' : '' }} />
                                            {{ ucfirst($type) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Year Range -->
                            <div class="filter-group">
                                <label class="filter-label">Tahun</label>
                                <div class="range-inputs">
                                    <input
                                        type="number"
                                        name="year_min"
                                        placeholder="Min"
                                        value="{{ request('year_min') }}"
                                        class="filter-input"
                                    />
                                    <input
                                        type="number"
                                        name="year_max"
                                        placeholder="Max"
                                        value="{{ request('year_max') }}"
                                        class="filter-input"
                                    />
                                </div>
                            </div>

                            <!-- Mileage Range -->
                            <div class="filter-group">
                                <label class="filter-label">Kilometer</label>
                                <div class="range-inputs">
                                    <input
                                        type="number"
                                        name="mileage_min"
                                        placeholder="Min"
                                        value="{{ request('mileage_min') }}"
                                        class="filter-input"
                                    />
                                    <input
                                        type="number"
                                        name="mileage_max"
                                        placeholder="Max"
                                        value="{{ request('mileage_max') }}"
                                        class="filter-input"
                                    />
                                </div>
                            </div>

                            <!-- Clear Filters -->
                            @if(request()->hasAny(['search', 'location', 'make', 'price_range', 'body_type', 'fuel_type', 'transmission', 'year_min', 'year_max', 'mileage_min', 'mileage_max']))
                                <a href="{{ route('inventory') }}" class="clear-filters-btn">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Hapus Semua Filter
                                </a>
                            @endif
                        </form>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Toolbar -->
                <div id="inventory-toolbar" class="inventory-toolbar scroll-mt-24">
                    <div class="flex items-center gap-3">
                        <!-- Mobile Filter Button -->
                        <button onclick="toggleMobileFilters()" class="mobile-filter-btn lg:hidden">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            Filter
                        </button>

                        <!-- Car Count Display -->
                        <div id="car-count-display" class="hidden sm:flex items-center gap-2 text-sm">
                            <span class="font-medium text-gray-700">
                                Menampilkan {{ $cars->total() }} Mobil
                                @if(request('make'))
                                    <span class="text-red-600">"{{ request('make') }}"</span>
                                @elseif(request('search'))
                                    <span class="text-red-600">"{{ request('search') }}"</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Sort -->
                    <select 
                        name="sort" 
                        class="sort-select"
                    >
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                        <option value="mileage-low" {{ request('sort') == 'mileage-low' ? 'selected' : '' }}>Kilometer Terendah</option>
                        <option value="year-new" {{ request('sort') == 'year-new' ? 'selected' : '' }}>Tahun Terbaru</option>
                    </select>
                </div>

                <!-- Loading Overlay -->
                <div id="loading-overlay" class="hidden fixed inset-0 bg-black/20 backdrop-blur-sm z-40 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 shadow-xl">
                        <div class="animate-spin h-8 w-8 border-4 border-red-600 border-t-transparent rounded-full mx-auto"></div>
                        <p class="mt-3 text-sm text-gray-600">Memuat...</p>
                    </div>
                </div>

                <!-- Cars Grid -->
                <div id="cars-container" class="scroll-mt-48 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @include('partials.cars-grid', ['cars' => $cars])
                </div>

                <!-- Pagination -->
                <div id="pagination-container" class="mt-12">
                    @if($cars->count() > 0)
                        {{ $cars->appends(request()->query())->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Filters Overlay -->
<div id="mobile-filters" class="mobile-filters-overlay">
    <div class="mobile-filters-content">
        <div class="mobile-filters-header">
            <h2 class="mobile-filters-title">Filter</h2>
            <button onclick="toggleMobileFilters()" class="close-mobile-filters">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('inventory') }}" method="GET">
            <!-- Search -->
            <div class="filter-group">
                <label class="filter-label">Pencarian</label>
                <input
                    name="search"
                    type="text"
                    placeholder="Cari merek atau model..."
                    value="{{ request('search') }}"
                    class="filter-input"
                />
            </div>

            <!-- Location -->
            <div class="filter-group">
                <label class="filter-label">Lokasi</label>
                <select name="location" class="filter-select">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $id => $name)
                        <option value="{{ $id }}" {{ request('location') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Make -->
            <div class="filter-group">
                <label class="filter-label">Merek</label>
                <select name="make" class="filter-select">
                    <option value="">Semua Merek</option>
                    @foreach($carMakes as $make)
                        <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price Range -->
            <div class="filter-group">
                <label class="filter-label">Rentang Harga</label>
                <select name="price_range" class="filter-select">
                    <option value="">Semua Harga</option>
                    <option value="0-100000000" {{ request('price_range') == '0-100000000' ? 'selected' : '' }}>Di bawah Rp 100 juta</option>
                    <option value="100000000-200000000" {{ request('price_range') == '100000000-200000000' ? 'selected' : '' }}>Rp 100 juta - 200 juta</option>
                    <option value="200000000-300000000" {{ request('price_range') == '200000000-300000000' ? 'selected' : '' }}>Rp 200 juta - 300 juta</option>
                    <option value="300000000-999999999" {{ request('price_range') == '300000000-999999999' ? 'selected' : '' }}>Di atas Rp 300 juta</option>
                </select>
            </div>

            <!-- Body Type -->
            <div class="filter-group">
                <label class="filter-label">Tipe Body</label>
                <div class="filter-btn-group">
                    @foreach($bodyTypes as $type)
                        <label class="filter-btn">
                            <input type="checkbox" name="body_type[]" value="{{ $type }}"
                                {{ in_array($type, request('body_type', [])) ? 'checked' : '' }} />
                            {{ ucfirst($type) }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Fuel Type -->
            <div class="filter-group">
                <label class="filter-label">Jenis Bahan Bakar</label>
                <div class="filter-btn-group">
                    @foreach($fuelTypes as $type)
                        <label class="filter-btn">
                            <input type="checkbox" name="fuel_type[]" value="{{ $type }}"
                                {{ in_array($type, request('fuel_type', [])) ? 'checked' : '' }} />
                            {{ ucfirst($type) }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Transmission -->
            <div class="filter-group">
                <label class="filter-label">Transmisi</label>
                <div class="filter-btn-group">
                    @foreach($transmissions as $type)
                        <label class="filter-btn">
                            <input type="checkbox" name="transmission[]" value="{{ $type }}"
                                {{ in_array($type, request('transmission', [])) ? 'checked' : '' }} />
                            {{ ucfirst($type) }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Actions -->
            <div class="mobile-filter-actions">
                <button type="submit" class="apply-filters-btn">
                    Terapkan Filter
                </button>
                <a href="{{ route('inventory') }}" class="clear-filters-btn" style="flex: 1;">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Hapus
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// AJAX Filter System
(function() {
    const filterForm = document.getElementById('filter-form');
    const carsContainer = document.getElementById('cars-container');
    const paginationContainer = document.getElementById('pagination-container');
    const loadingOverlay = document.getElementById('loading-overlay');
    const statNumber = document.querySelector('.stat-number');
    
    let debounceTimer;
    
    // Debounce function for text inputs
    function debounce(func, delay = 500) {
        return function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(func, delay);
        };
    }
    
    // Show loading state
    function showLoading() {
        loadingOverlay.classList.remove('hidden');
        carsContainer.style.opacity = '0.5';
        carsContainer.style.pointerEvents = 'none';
    }
    
    // Hide loading state
    function hideLoading() {
        loadingOverlay.classList.add('hidden');
        carsContainer.style.opacity = '1';
        carsContainer.style.pointerEvents = 'auto';
    }
    
    // Fetch filtered results
    async function fetchResults() {
        showLoading();
        
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        // Build query string
        for (const [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }
        
        // Add sort if exists
        const sortSelect = document.querySelector('select[name=\"sort\"]');
        if (sortSelect && sortSelect.value) {
            params.append('sort', sortSelect.value);
        }
        
        try {
            const response = await fetch(`{{ route('inventory') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            
            // Update cars grid
            carsContainer.innerHTML = data.html;
            
            // Update pagination
            paginationContainer.innerHTML = data.pagination;
            
            // Update total count
            if (statNumber) {
                statNumber.textContent = data.total;
            }
            
            // Update car count display
            const carCountDisplay = document.getElementById('car-count-display');
            if (carCountDisplay) {
                const makeParam = params.get('make');
                const searchParam = params.get('search');
                let displayText = `Menampilkan ${data.total} Mobil`;
                
                if (makeParam) {
                    displayText += ` <span class="text-red-600">"${makeParam}"</span>`;
                } else if (searchParam) {
                    displayText += ` <span class="text-red-600">"${searchParam}"</span>`;
                }
                
                carCountDisplay.querySelector('span').innerHTML = displayText;
            }
            
            // Update URL without reload
            const newUrl = `{{ route('inventory') }}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);
            
            // Scroll to toolbar (above results)
            const toolbar = document.getElementById('inventory-toolbar');
            if (toolbar) {
                toolbar.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
        } catch (error) {
            console.error('Filter error:', error);
            alert('Terjadi kesalahan saat memfilter. Silakan coba lagi.');
        } finally {
            hideLoading();
        }
    }
    
    // Add event listeners
    if (filterForm) {
        // Text inputs with debounce
        const textInputs = filterForm.querySelectorAll('input[type=\"text\"], input[type=\"number\"]');
        textInputs.forEach(input => {
            input.addEventListener('input', debounce(fetchResults, 800));
        });
        
        // Select dropdowns - instant
        const selects = filterForm.querySelectorAll('select');
        selects.forEach(select => {
            select.addEventListener('change', fetchResults);
        });
        
        // Checkboxes - instant
        const checkboxes = filterForm.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', fetchResults);
        });
    }
    
    // Sort dropdown
    const sortSelect = document.querySelector('select[name=\"sort\"]');
    if (sortSelect) {
        sortSelect.addEventListener('change', fetchResults);
    }
    
    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('#pagination-container a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;
            
            showLoading();
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                carsContainer.innerHTML = data.html;
                paginationContainer.innerHTML = data.pagination;
                window.history.pushState({}, '', url);
                window.scrollTo({ top:0, behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Pagination error:', error);
            })
            .finally(() => {
                hideLoading();
            });
        }
    });
})();

// Toggle mobile filters
function toggleMobileFilters() {
    const filters = document.getElementById('mobile-filters');
    filters.classList.toggle('active');
    document.body.classList.toggle('overflow-hidden');
}
</script>
@endpush
@endsection