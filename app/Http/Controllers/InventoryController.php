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
        // Base query: hanya yang belum sold + eager load gambar utama
        $query = Car::query()
            ->available()
            ->with(['primaryImage']);

        // Filter search (make or model)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        // Filter make
        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }

        // Filter model (contains)
        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        // Filter price range (format: "100000000-200000000")
        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $query->whereBetween('price', [(int) $min, (int) $max]);
        }

        // Filter location
        if ($request->filled('location')) {
            $query->where('location_id', $request->location);
        }

        // Filter body type
        if ($request->filled('body_type')) {
            $query->whereIn('body_type', $request->body_type);
        }

        // Filter fuel type
        if ($request->filled('fuel_type')) {
            $query->whereIn('fuel_type', $request->fuel_type);
        }

        // Filter transmission (array of values)
        if ($request->filled('transmission')) {
            $query->whereIn('transmission', $request->transmission);
        }

        // Filter year range
        if ($request->filled('year_min')) {
            $query->where('year', '>=', (int) $request->year_min);
        }
        if ($request->filled('year_max')) {
            $query->where('year', '<=', (int) $request->year_max);
        }

        // Filter mileage range
        if ($request->filled('mileage_min')) {
            $query->where('mileage_km', '>=', (int) $request->mileage_min);
        }
        if ($request->filled('mileage_max')) {
            $query->where('mileage_km', '<=', (int) $request->mileage_max);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
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

        // Dropdown makes (bisa nanti dari DB kalau mau)
        $carMakes = [
            'Toyota', 'Honda', 'Ford', 'Chevrolet', 'BMW',
            'Mercedes-Benz', 'Audi', 'Nissan', 'Hyundai',
            'Volkswagen', 'Mazda', 'Subaru', 'Lexus', 'Kia',
            'Jeep', 'Ram', 'GMC', 'Tesla', 'Porsche', 'Volvo'
        ];

        // Body types (from enum)
        $bodyTypes = ['suv', 'sedan', 'hatchback', 'mpv', 'pickup', 'van', 'coupe', 'convertible', 'wagon'];

        // Fuel types (from enum)
        $fuelTypes = ['bensin', 'diesel', 'electric', 'hybrid'];

        // Transmissions (from enum)
        $transmissions = ['manual', 'automatic'];

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

        return view('inventory', compact('cars', 'carMakes', 'bodyTypes', 'fuelTypes', 'transmissions', 'locations', 'favorites'));
    }
}
