<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a single car details page
     */
   public function show($id)
{
    $car = Car::with([
        'images' => fn ($q) => $q->orderBy('sort_order'),
        'primaryImage',
        'location',
    ])->findOrFail($id);

    $isFavorite = Auth::check() && Auth::user()->hasFavorited($car->id);

    return view('car-details', compact('car', 'isFavorite'));
}

}
