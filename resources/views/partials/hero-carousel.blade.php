@php
    $heroSlides = $featuredCars ?? \App\Models\Car::where('is_featured', true)
                                                ->where('is_sold', false)
                                                ->with('images')
                                                ->take(4)
                                                ->get();
@endphp

@if (count($heroSlides) > 0)
<section class="relative overflow-hidden bg-secondary" id="hero-carousel">

    <style>
        #hero-carousel {
            height: clamp(560px, 76vh, 660px);
            height: clamp(560px, 76svh, 660px);
        }
        @media (min-width: 1024px) { #hero-carousel { height: clamp(600px, 80vh, 700px); } }

        /* Slide transitions */
        .hero-slide { position: absolute; inset: 0; transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
        .hero-slide.active { opacity: 1; transform: scale(1); }
        .hero-slide.inactive { opacity: 0; transform: scale(1.05); }
        .hero-image { width: 100%; height: 100%; object-fit: cover; object-position: 58% center; }

        /* Content transitions */
        .hero-content { position: absolute; inset: 0; z-index: 20; display: flex; align-items: flex-end; padding-bottom: clamp(128px, 22svh, 168px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
        .hero-content.active { opacity: 1; transform: translateY(0); pointer-events: auto; }
        .hero-content.inactive { opacity: 0; transform: translateY(1rem); pointer-events: none; }
        @media (min-width: 768px) {
            .hero-content { align-items: center; padding-bottom: 0; }
        }

        /* Grid overlay */
        .hero-grid-overlay {
            position: absolute; inset: 0; z-index: 10; opacity: 0.1;
            background-image:
                linear-gradient(to right, var(--color-primary, #e53e3e) 1px, transparent 1px),
                linear-gradient(to bottom, var(--color-primary, #e53e3e) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Indicators */
        .hero-indicator { height: 4px; border-radius: 9999px; border: none; cursor: pointer; transition: width 0.3s, background-color 0.3s; }
        .hero-indicator.active { width: 48px; background-color: var(--color-primary, #e53e3e); box-shadow: 0 0 10px 2px rgba(239,68,68,0.45); }
        .hero-indicator.inactive { width: 24px; background-color: rgba(255,255,255,0.3); }
        .hero-indicator.inactive:hover { background-color: rgba(255,255,255,0.5); }

        /* Nav arrows */
        .hero-nav-btn {
            position: absolute; top: 50%; transform: translateY(-50%); z-index: 30;
            width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;
            border-radius: 9999px; border: 1px solid rgba(239,68,68,0.3);
            background: rgba(0,0,0,0.15); backdrop-filter: blur(4px);
            color: white; cursor: pointer; transition: background 0.2s, border-color 0.2s;
        }
        .hero-nav-btn:hover { background: rgba(239,68,68,0.2); border-color: rgba(239,68,68,0.7); }
        .hero-nav-btn.prev { left: 16px; }
        .hero-nav-btn.next { right: 16px; }

        /* Spec pills */
        .hero-spec-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 14px; border-radius: 6px;
            border: 1px solid rgba(239,68,68,0.2);
            background: rgba(0,0,0,0.2); backdrop-filter: blur(4px);
            color: rgba(255,255,255,0.75); font-size: clamp(13px, 2.5vw, 14px);
            min-width: 0;
        }
        .hero-spec-pill svg { color: var(--color-primary, #e53e3e); width: 16px; height: 16px; }
        .hero-spec-text { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* CTA buttons */
        .hero-btn-primary {
            display: inline-flex; height: 44px; align-items: center; justify-content: center;
            padding: 0 32px; border-radius: 6px; border: none;
            background-color: var(--color-primary, #e53e3e); color: white;
            font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;
            text-decoration: none; cursor: pointer; transition: background 0.2s;
            box-shadow: 0 0 16px 2px rgba(239,68,68,0.45);
        }
        .hero-btn-primary:hover { background-color: rgba(239,68,68,0.85); color: white; }

        .hero-btn-outline {
            display: inline-flex; height: 44px; align-items: center; justify-content: center;
            padding: 0 32px; border-radius: 6px;
            border: 1px solid rgba(239,68,68,0.5); background: transparent; color: white;
            font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;
            text-decoration: none; cursor: pointer; transition: background 0.2s;
        }
        .hero-btn-outline:hover { background: rgba(239,68,68,0.15); color: white; }
        .hero-actions { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .hero-actions .hero-btn-primary,
        .hero-actions .hero-btn-outline {
            width: 100%;
            padding-inline: 14px;
        }
        @media (min-width: 640px) {
            .hero-actions { display: flex; flex-wrap: wrap; gap: 16px; }
            .hero-actions .hero-btn-primary,
            .hero-actions .hero-btn-outline {
                width: auto;
                padding-inline: 32px;
            }
        }

        /* Badge */
        .hero-badge {
            display: inline-flex; align-items: center; margin-bottom: 16px;
            padding: 4px 12px; border-radius: 4px;
            border: 1px solid rgba(239,68,68,0.5);
            background: rgba(239,68,68,0.12); backdrop-filter: blur(4px);
            color: var(--color-primary, #e53e3e);
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;
        }

        /* Corner accents */
        .hero-corner-tl { position: absolute; top: 0; left: 0; width: clamp(64px, 15vw, 128px); height: clamp(64px, 15vw, 128px); border-left: 2px solid rgba(239,68,68,0.3); border-top: 2px solid rgba(239,68,68,0.3); z-index: 20; pointer-events: none; }
        .hero-corner-br { position: absolute; bottom: 0; right: 0; width: clamp(64px, 15vw, 128px); height: clamp(64px, 15vw, 128px); border-right: 2px solid rgba(239,68,68,0.3); border-bottom: 2px solid rgba(239,68,68,0.3); z-index: 20; pointer-events: none; }
        @media (max-width: 639px) {
            #hero-carousel {
                height: clamp(510px, 62vh, 575px);
                height: clamp(510px, 62svh, 575px);
            }
            .hero-content {
                padding-bottom: clamp(92px, 12vh, 112px);
                padding-bottom: clamp(92px, 12svh, 112px);
            }
            .hero-grid-overlay { opacity: 0.07; background-size: 54px 54px; }
            .hero-content .container { padding-left: 22px; padding-right: 22px; }
            .hero-content .max-w-2xl { max-width: min(100%, 34rem); }
            .hero-badge {
                margin-bottom: 12px;
                padding: 5px 10px;
                font-size: 9px;
                letter-spacing: 0.14em;
            }
            .hero-content h1 {
                margin-bottom: 4px;
                font-size: clamp(2.05rem, 9.8vw, 2.85rem) !important;
                line-height: 1.03 !important;
                letter-spacing: -0.01em;
                text-wrap: balance;
            }
            .hero-content h2 {
                margin-bottom: 14px;
                font-size: clamp(1.75rem, 8.4vw, 2.35rem) !important;
                line-height: 1 !important;
                letter-spacing: -0.01em;
            }
            .hero-spec-list { display: grid !important; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 7px !important; margin-bottom: 16px !important; }
            .hero-spec-pill {
                justify-content: center;
                min-height: 44px;
                padding: 7px 8px;
                border-radius: 10px;
                border-color: rgba(239, 68, 68, 0.28);
                background: rgba(15, 18, 24, 0.58);
                font-size: 12px;
            }
            .hero-spec-pill svg { width: 14px; height: 14px; flex-shrink: 0; }
            .hero-price {
                margin-bottom: 18px !important;
                font-size: clamp(1.85rem, 8.8vw, 2.5rem) !important;
                line-height: 1.05 !important;
                overflow-wrap: anywhere;
            }
            .hero-btn-primary,
            .hero-btn-outline {
                height: 48px;
                border-radius: 10px;
                font-size: 11px;
                letter-spacing: 0.11em;
            }
            .hero-nav-btn { display: none; }
            .hero-indicators { bottom: 26px !important; }
            .hero-corner-tl,
            .hero-corner-br { display: none; }
        }
        @media (max-width: 379px) {
            .hero-actions { grid-template-columns: 1fr; }
            .hero-spec-list { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
    </style>

    <!-- Background Slides -->
    @foreach ($heroSlides as $index => $car)
        @php
            $imageSrc = $car->primaryImage
                ? asset($car->primaryImage->image_path)
                : (isset($car->images[0]) ? asset($car->images[0]->image_path) : 'https://via.placeholder.com/1600x900');
        @endphp

        <div class="hero-slide {{ $index === 0 ? 'active' : 'inactive' }}" data-slide="{{ $index }}">
            <!-- Overlay gelap kiri -->
            <div class="absolute inset-0 z-10 bg-[linear-gradient(to_right,rgba(15,15,20,0.95)_0%,rgba(15,15,20,0.7)_40%,transparent_75%)]"></div>
            <!-- Overlay gelap bawah -->
            <div class="absolute inset-0 z-10 bg-[linear-gradient(to_top,rgba(15,15,20,0.8)_0%,transparent_50%,rgba(15,15,20,0.25)_100%)]"></div>

            <img src="{{ $imageSrc }}" alt="{{ $car->make }} {{ $car->model }}" class="hero-image" />
        </div>
    @endforeach

    <!-- Grid overlay -->
    <div class="hero-grid-overlay"></div>

    <!-- Slide Contents -->
    @foreach ($heroSlides as $index => $car)
        <div class="hero-content {{ $index === 0 ? 'active' : 'inactive' }} font-body" data-slide-content="{{ $index }}">
            <div class="container mx-auto px-4">
                <div class="max-w-2xl">

                    <span class="hero-badge font-body">Unit Unggulan</span>

                    {{-- Heading 1: Orbitron --}}
                    <h1 class="font-display mb-2 text-white font-bold tracking-wide leading-[1.15] text-[clamp(2.25rem,5vw,3.75rem)]">
                        {{ $car->year }} {{ $car->make }}
                    </h1>

                    {{-- Heading 2: Orbitron --}}
                    <h2 class="font-display mb-6 font-bold leading-[1.15] text-[clamp(1.875rem,4vw,3rem)] text-[color:var(--color-primary,#e53e3e)]">
                        {{ $car->model }}
                    </h2>

                    <!-- Specs (Body font) -->
                    <div class="hero-spec-list flex flex-wrap gap-3 mb-6 font-body">
                        <div class="hero-spec-pill font-body">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span class="hero-spec-text">{{ number_format($car->mileage_km) }} km</span>
                        </div>
                        <div class="hero-spec-pill font-body">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span class="hero-spec-text">{{ ucfirst($car->fuel_type) }}</span>
                        </div>
                        <div class="hero-spec-pill font-body">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="hero-spec-text">{{ $car->year }}</span>
                        </div>
                    </div>

                    <!-- Price (Orbitron biar “hero feel”) -->
                    <p class="hero-price font-display mb-8 text-white font-bold text-[clamp(2rem,4vw,3rem)]">
                        Rp {{ number_format($car->price, 0, ',', '.') }}
                    </p>

                    <!-- CTA (Body font) -->
                    <div class="hero-actions font-body">
                        <a href="{{ route('car.show', $car->id) }}" class="hero-btn-primary font-body">View Details</a>
                        <a href="{{ route('inventory') }}" class="hero-btn-outline font-body">Browse All</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

    <!-- Nav Arrows -->
    <button id="hero-prev" class="hero-nav-btn prev" aria-label="Previous slide">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button id="hero-next" class="hero-nav-btn next" aria-label="Next slide">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    <!-- Indicators -->
    <div class="hero-indicators absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex gap-3">
        @foreach ($heroSlides as $index => $car)
            <button class="hero-indicator {{ $index === 0 ? 'active' : 'inactive' }}" data-indicator="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}"></button>
        @endforeach
    </div>

    <!-- Corner accents -->
    <div class="hero-corner-tl"></div>
    <div class="hero-corner-br"></div>

</section>

@push('scripts')
<script>
(function () {
    const totalSlides = {{ count($heroSlides) }};
    let current = 0;
    let autoPlay = null;
    let resumeTimer = null;

    const slides    = document.querySelectorAll('[data-slide]');
    const contents  = document.querySelectorAll('[data-slide-content]');
    const dots      = document.querySelectorAll('[data-indicator]');
    const prevBtn   = document.getElementById('hero-prev');
    const nextBtn   = document.getElementById('hero-next');

    function goTo(i) {
        slides.forEach(function (el, idx)   { el.classList.toggle('active', idx === i); el.classList.toggle('inactive', idx !== i); });
        contents.forEach(function (el, idx) { el.classList.toggle('active', idx === i); el.classList.toggle('inactive', idx !== i); });
        dots.forEach(function (el, idx)     { el.classList.toggle('active', idx === i); el.classList.toggle('inactive', idx !== i); });
        current = i;
    }

    function startAuto() { autoPlay = setInterval(function () { goTo((current + 1) % totalSlides); }, 5000); }
    function stopAuto()  { clearInterval(autoPlay); }

    function pauseResume() {
        stopAuto();
        clearTimeout(resumeTimer);
        resumeTimer = setTimeout(startAuto, 10000);
    }

    prevBtn.addEventListener('click', function () { goTo((current - 1 + totalSlides) % totalSlides); pauseResume(); });
    nextBtn.addEventListener('click', function () { goTo((current + 1) % totalSlides); pauseResume(); });
    dots.forEach(function (el, i) { el.addEventListener('click', function () { goTo(i); pauseResume(); }); });

    startAuto();
})();
</script>
@endpush
@endif
