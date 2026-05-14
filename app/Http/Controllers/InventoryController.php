<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Location;

class InventoryController extends Controller
{
    /**
     * Display the inventory listing page with filters
     */
    public function index(Request $request)
    {
        if ($request->filled('model') && ! $request->filled('search')) {
            return redirect()->route('inventory', array_merge(
                $request->except('model'),
                ['search' => $this->cleanString($request->input('model'))],
            ));
        }

        $carMakes = Car::query()
            ->available()
            ->whereNotNull('make')
            ->distinct()
            ->orderBy('make')
            ->pluck('make')
            ->filter()
            ->values()
            ->all();

        if ($carMakes === []) {
            $carMakes = [
                'Toyota', 'Honda', 'Ford', 'Chevrolet', 'BMW',
                'Mercedes-Benz', 'Audi', 'Nissan', 'Hyundai',
                'Volkswagen', 'Mazda', 'Subaru', 'Lexus', 'Kia',
                'Jeep', 'Ram', 'GMC', 'Tesla', 'Porsche', 'Volvo',
            ];
        }

        $bodyTypes = ['suv', 'sedan', 'hatchback', 'mpv', 'pickup', 'van', 'coupe', 'convertible', 'wagon'];
        $fuelTypes = ['bensin', 'diesel', 'electric', 'hybrid'];
        $transmissions = ['manual', 'automatic'];
        $mileagePresets = [
            ['label' => '< 10k KM', 'min' => null, 'max' => 10000],
            ['label' => '10 - 30k KM', 'min' => 10000, 'max' => 30000],
            ['label' => '30 - 50k KM', 'min' => 30000, 'max' => 50000],
            ['label' => '> 50k KM', 'min' => 50000, 'max' => null],
        ];

        $searchQuery = $this->cleanString($request->input('search'));
        $selectedMake = $this->cleanString($request->input('make'));
        $priceRange = $this->priceRange($request->input('price_range'));
        $locationId = $this->integerValue($request->input('location'));
        $selectedBodyTypes = $this->validArray($request->input('body_type'), $bodyTypes);
        $selectedFuelTypes = $this->validArray($request->input('fuel_type'), $fuelTypes);
        $selectedTransmissions = $this->validArray($request->input('transmission'), $transmissions);
        $yearMin = $this->integerValue($request->input('year_min'));
        $yearMax = $this->integerValue($request->input('year_max'));
        $mileageMin = $this->integerValue($request->input('mileage_min'));
        $mileageMax = $this->integerValue($request->input('mileage_max'));

        // Base query: hanya yang belum sold + eager load gambar utama
        $query = Car::query()
            ->select([
                'id',
                'title',
                'make',
                'model',
                'variant',
                'year',
                'mileage_km',
                'transmission',
                'fuel_type',
                'body_type',
                'price',
                'featured',
                'sold',
                'location_id',
                'created_at',
            ])
            ->available()
            ->with(['primaryImage', 'fallbackImage']);

        // Filter search (title, make, model, or variant)
        $query->textSearch($searchQuery);

        // Filter make
        if ($selectedMake !== '') {
            $query->where('make', $selectedMake);
        }

        // Filter price range (format: "100000000-200000000")
        if ($priceRange !== null) {
            $query->whereBetween('price', $priceRange);
        }

        // Filter location
        if ($locationId !== null) {
            $query->where('location_id', $locationId);
        }

        // Filter body type
        if ($selectedBodyTypes !== []) {
            $query->whereIn('body_type', $selectedBodyTypes);
        }

        // Filter fuel type
        if ($selectedFuelTypes !== []) {
            $query->whereIn('fuel_type', $selectedFuelTypes);
        }

        // Filter transmission (array of values)
        if ($selectedTransmissions !== []) {
            $query->whereIn('transmission', $selectedTransmissions);
        }

        // Filter year range
        if ($yearMin !== null) {
            $query->where('year', '>=', $yearMin);
        }
        if ($yearMax !== null) {
            $query->where('year', '<=', $yearMax);
        }

        // Filter mileage range
        if ($mileageMin !== null) {
            $query->where('mileage_km', '>=', $mileageMin);
        }
        if ($mileageMax !== null) {
            $query->where('mileage_km', '<=', $mileageMax);
        }

        // Sorting
        $sort = $this->sortValue($request->input('sort'));
        switch ($sort) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'mileage-low':
                $query->orderBy('mileage_km', 'asc');
                break;
            case 'year-new':
                $query->orderBy('year', 'desc');
                break;
            case 'newest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        // Pagination
        $cars = $query->paginate(12)->withQueryString();

        // Get active locations
        $locations = Location::where('is_active', true)->pluck('name', 'id');

        // Auth OFF dulu
        $favorites = [];

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.cars-grid', compact('cars'))->render(),
                'pagination' => (string) $cars->appends(request()->query())->links(),
                'total' => $cars->total()
            ]);
        }

        return view('inventory', compact(
            'cars',
            'carMakes',
            'bodyTypes',
            'fuelTypes',
            'transmissions',
            'mileagePresets',
            'locations',
            'favorites',
            'searchQuery',
            'selectedMake',
            'sort',
            'selectedBodyTypes',
            'selectedFuelTypes',
            'selectedTransmissions',
        ));
    }

    public function suggestions(Request $request)
    {
        $search = $this->cleanString($request->get('q', ''));

        $cars = Car::query()
            ->select([
                'id',
                'title',
                'make',
                'model',
                'variant',
                'year',
                'price',
                'featured',
                'sold',
                'created_at',
            ])
            ->available()
            ->with(['primaryImage', 'fallbackImage'])
            ->textSearch($search)
            ->orderByDesc('featured')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return response()->json([
            'suggestions' => $cars->map(fn (Car $car) => [
                'id' => $car->id,
                'label' => $car->search_label,
                'meta' => trim(implode(' • ', array_filter([
                    $car->make,
                    $car->model,
                    $car->year,
                ]))),
                'price' => 'Rp ' . number_format((int) $car->price, 0, ',', '.'),
                'image' => $car->main_image,
                'url' => route('car.show', $car->id),
            ]),
        ]);
    }

    private function cleanString(mixed $value, int $limit = 80): string
    {
        $value = trim(strip_tags((string) $value));

        return mb_substr($value, 0, $limit);
    }

    private function integerValue(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $integer = filter_var($value, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 0],
        ]);

        return $integer === false ? null : $integer;
    }

    private function priceRange(mixed $value): ?array
    {
        if (! is_string($value) || ! preg_match('/^\d+-\d+$/', $value)) {
            return null;
        }

        [$min, $max] = array_map('intval', explode('-', $value, 2));

        return $max >= $min ? [$min, $max] : null;
    }

    private function validArray(mixed $value, array $allowed): array
    {
        $values = is_array($value) ? $value : [$value];

        return array_values(array_intersect(
            array_map(fn ($item) => (string) $item, $values),
            $allowed,
        ));
    }

    private function sortValue(mixed $value): string
    {
        $value = (string) $value;

        return in_array($value, ['newest', 'price-low', 'price-high', 'mileage-low', 'year-new'], true)
            ? $value
            : 'newest';
    }
}
