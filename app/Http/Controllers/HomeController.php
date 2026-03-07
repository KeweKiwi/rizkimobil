<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured cars that are not sold
        $featuredCars = Car::where('featured', true)
            ->where('sold', false)
            ->with('primaryImage')
            ->take(4)
            ->get();

        // Car makes for search dropdown
        $carMakes = [
            'Toyota',
            'Honda',
            'Ford',
            'Chevrolet',
            'BMW',
            'Mercedes-Benz',
            'Audi',
            'Nissan',
            'Hyundai',
            'Volkswagen',
            'Mazda',
            'Subaru',
            'Lexus',
            'Kia',
            'Jeep',
            'Ram',
            'GMC',
            'Tesla',
            'Porsche',
            'Volvo'
        ];

        // Statistics
        $stats = [
            'carsSold' => 5000,
            'satisfiedCustomers' => 4500,
            'yearsInBusiness' => 15,
            'carsInStock' => Car::where('sold', false)->count()
        ];

        // Get user favorites if authenticated
        $favorites = [];
        if (Auth::check()) {
            $favorites = Auth::user()->favorites()->pluck('car_id')->toArray();
        }


        return view('index', compact('featuredCars', 'carMakes', 'stats', 'favorites'));
    }
}
