1<?php

namespace App\Http\Controllers;

use App\Models\Car;

class CarController extends Controller
{
    /**
     * Display a single car details page
     */
   public function show($id)
{
    $car = Car::with([
        'images' => fn ($q) => $q->orderBy('sort_order'),
        'primaryImage'
    ])->findOrFail($id);

    return view('car-details', compact('car'));
}

}
