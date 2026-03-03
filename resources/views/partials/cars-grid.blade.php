@forelse($cars as $car)
    @include('partials.car-card', ['car' => $car])
@empty
    <div class="col-span-full">
        <div class="no-results">
            <div class="no-results-icon">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="no-results-title">Tidak Ada Hasil Ditemukan</h3>
            <p class="no-results-text">
                Maaf, tidak ada mobil yang cocok dengan kriteria Anda.<br>
                Coba sesuaikan filter untuk melihat lebih banyak hasil.
            </p>
            <a href="{{ route('inventory') }}" class="clear-filters-btn" style="max-width: 300px; margin: 0 auto; display: inline-flex;">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Hapus Semua Filter
            </a>
        </div>
    </div>
@endforelse
