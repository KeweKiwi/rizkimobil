@extends('layouts.app')

@section('content')
    <section class="bg-[#f7f4f1]">
        <div class="container mx-auto px-4 py-14 lg:px-6 lg:py-20">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)] lg:items-end">
                <div>
                    <p class="mb-4 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-red-600">
                        <span class="h-px w-9 bg-red-500"></span>
                        Mobil tersimpan
                    </p>
                    <h1 class="font-display text-4xl font-black leading-[0.98] tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                        Unit yang Anda simpan, siap dicek lagi.
                    </h1>
                </div>
                <div class="max-w-2xl text-base leading-8 text-slate-600 lg:justify-self-end">
                    <p>
                        Simpan unit incaran supaya mudah dibandingkan sebelum chat admin atau jadwalkan visit. Stok dan harga tetap perlu dikonfirmasi ulang karena unit bisa bergerak cepat.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('inventory') }}" class="inline-flex h-11 items-center justify-center rounded-full bg-red-600 px-5 text-sm font-black text-white shadow-lg shadow-red-600/20 transition hover:bg-red-700">
                            Lihat stok lain
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex h-11 items-center justify-center rounded-full border border-slate-300 bg-white px-5 text-sm font-black text-slate-800 transition hover:border-red-300 hover:text-red-600">
                            Tanya admin
                        </a>
                    </div>
                </div>
            </div>

            @if($cars->isEmpty())
                <div class="mt-12 grid min-h-[360px] place-items-center rounded-lg border border-slate-200 bg-white px-6 py-14 text-center shadow-[0_22px_70px_rgba(15,23,42,0.06)]">
                    <div class="max-w-xl">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-red-600">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 0 0 0 6.364L12 20.364l7.682-7.682a4.5 4.5 0 0 0-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 0 0-6.364 0z"/>
                            </svg>
                        </div>
                        <h2 class="font-display text-3xl font-black text-slate-950">Belum ada mobil tersimpan.</h2>
                        <p class="mt-3 text-slate-600">Buka inventori, pilih unit, lalu tekan Simpan di halaman detail mobil.</p>
                        <a href="{{ route('inventory') }}" class="mt-7 inline-flex h-12 items-center justify-center rounded-full bg-slate-950 px-6 text-sm font-black text-white transition hover:bg-red-600">
                            Mulai cari mobil
                        </a>
                    </div>
                </div>
            @else
                <div class="mt-12 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($cars as $car)
                        <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-[0_22px_70px_rgba(15,23,42,0.06)] transition hover:-translate-y-1 hover:border-red-200 hover:shadow-[0_28px_80px_rgba(220,38,38,0.12)]">
                            <a href="{{ route('car.show', $car) }}" class="block">
                                <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                                    <img
                                        src="{{ $car->main_image }}"
                                        alt="{{ $car->year }} {{ $car->make }} {{ $car->model }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    >
                                </div>
                            </a>

                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">{{ $car->year }} / {{ $car->make }}</p>
                                        <h2 class="mt-2 font-display text-xl font-black leading-tight text-slate-950">
                                            {{ $car->model }}{{ $car->variant ? ' ' . $car->variant : '' }}
                                        </h2>
                                    </div>
                                    <form method="POST" action="{{ route('favorites.toggle', $car) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-red-100 bg-red-50 text-red-600 transition hover:bg-red-600 hover:text-white" aria-label="Hapus dari tersimpan">
                                            <svg class="h-5 w-5 fill-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 0 0 0 6.364L12 20.364l7.682-7.682a4.5 4.5 0 0 0-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 0 0-6.364 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="mt-5 grid grid-cols-3 gap-2 border-y border-slate-100 py-4 text-xs text-slate-500">
                                    <span>{{ number_format($car->mileage_km ?? 0) }} km</span>
                                    <span>{{ ucfirst($car->transmission ?? '-') }}</span>
                                    <span>{{ strtoupper($car->body_type ?? '-') }}</span>
                                </div>

                                <div class="mt-5 flex items-center justify-between gap-4">
                                    <p class="font-display text-xl font-black text-red-600">Rp {{ number_format($car->price ?? 0, 0, ',', '.') }}</p>
                                    <a href="{{ route('car.show', $car) }}" class="text-sm font-black text-slate-950 transition hover:text-red-600">
                                        Lihat detail
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $cars->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
