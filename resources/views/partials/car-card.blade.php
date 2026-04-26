<a href="{{ route('car.show', $car->id) }}" class="block">
    <div class="group overflow-hidden transition-all duration-300 hover:shadow-card-hover rounded-lg border border-red-600/20 hover:border-red-600/40 shadow-[0_0_15px_rgba(220,38,38,0.15)] hover:shadow-[0_0_25px_rgba(220,38,38,0.3)] bg-card text-card-foreground {{ $className ?? '' }}">
        <div class="relative aspect-[4/3] overflow-hidden">
            @php
                $primaryImage = $car->primaryImage ?? null;
                $imagePath = $primaryImage?->image_path;
                $imageUrl = $imagePath
                    ? (str_starts_with($imagePath, 'http') ? $imagePath : asset($imagePath))
                    : 'https://via.placeholder.com/800x600?text=No+Image';
                $mileage = $car->mileage_km ?? $car->mileage ?? 0;
                $fuelType = $car->fuel_type ?? $car->fuelType ?? null;
                $bodyType = $car->body_type ?? $car->bodyType ?? null;
            @endphp

            <img
                src="{{ $imageUrl }}"
                alt="{{ $car->year }} {{ $car->make }} {{ $car->model }}"
                loading="lazy"
                decoding="async"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 transition-opacity group-hover:opacity-100"></div>

            <!-- Badges -->
            <div class="absolute left-3 top-3 flex flex-wrap gap-1.5">
                @if($car->featured)
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-500 text-white shadow-md">
                        Unggulan
                    </span>
                @endif

                @if($fuelType === 'electric')
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-emerald-500 text-white shadow-md">
                        Listrik
                    </span>
                @endif
                @if($fuelType === 'bensin')
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-emerald-500 text-white shadow-md">
                        Bensin
                    </span>
                @endif
                @if($fuelType === 'diesel')
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-emerald-500 text-white shadow-md">
                        Diesel
                    </span>
                @endif
                @if($fuelType === 'hybrid')
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-emerald-500 text-white shadow-md">
                        Hybrid
                    </span>
                @endif
            </div>
        </div>

        <div class="p-4">
            <div class="mb-2">
                <p class="text-sm text-gray-500">{{ $car->year }} {{ $car->make }}</p>
                <h3 class="font-display text-lg font-semibold text-foreground line-clamp-1">
                    {{ $car->model }}{{ ($car->variant ?? null) ? ' ' . $car->variant : '' }}
                </h3>
            </div>

            <div class="mb-4 grid grid-cols-2 gap-2 text-xs sm:text-sm">
                <!-- Kilometer - Speedometer/gauge icon -->
                <div class="flex items-center gap-1.5 text-gray-600">
                    <img src="{{ asset('images/icons/road.svg') }}" alt="Mileage" class="h-3.5 w-3.5 sm:h-4 sm:w-4" style="filter: brightness(0) saturate(100%) invert(27%) sepia(88%) saturate(3447%) hue-rotate(349deg) brightness(96%) contrast(90%);">
                    <span class="truncate">{{ number_format($mileage) }} km</span>
                </div>

                <!-- Fuel Type - Fuel pump grid icon (same as car details) -->
                <div class="flex items-center gap-1.5 text-gray-600">
                    <img src="{{ asset('images/icons/fuel.svg') }}" alt="Fuel" class="h-3.5 w-3.5 sm:h-4 sm:w-4" style="filter: brightness(0) saturate(100%) invert(27%) sepia(88%) saturate(3447%) hue-rotate(349deg) brightness(96%) contrast(90%);">
                    <span class="truncate">{{ ucfirst($fuelType ?? '-') }}</span>
                </div>

                <!-- Transmission - Sliders icon (same as car details) -->
                <div class="flex items-center gap-1.5 text-gray-600">
                    <img src="{{ asset('images/icons/transmission.svg') }}" alt="Transmission" class="h-3.5 w-3.5 sm:h-4 sm:w-4" style="filter: brightness(0) saturate(100%) invert(27%) sepia(88%) saturate(3447%) hue-rotate(349deg) brightness(96%) contrast(90%);">
                    <span class="truncate">{{ ucfirst($car->transmission ?? '-') }}</span>
                </div>

                <!-- Year - Calendar icon (same as car details) -->
                <div class="flex items-center gap-1.5 text-gray-600">
                    <img src="{{ asset('images/icons/calendar.svg') }}" alt="Year" class="h-3.5 w-3.5 sm:h-4 sm:w-4" style="filter: brightness(0) saturate(100%) invert(27%) sepia(88%) saturate(3447%) hue-rotate(349deg) brightness(96%) contrast(90%);">
                    <span class="truncate">{{ $car->year }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between border-t pt-3">
                <p class="font-display text-lg sm:text-xl font-bold text-red-600">
                    Rp {{ number_format($car->price ?? 0, 0, ',', '.') }}
                </p>

                <span class="inline-flex items-center rounded-full border px-2 sm:px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80">
                    {{ strtoupper($bodyType ?? '-') }}
                </span>
            </div>
        </div>
    </div>
</a>
