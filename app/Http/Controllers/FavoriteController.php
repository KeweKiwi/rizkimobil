<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, $carId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $car = Car::findOrFail($carId);

        $isFavorite = Auth::user()->toggleFavorite($carId);

        return response()->json([
            'success' => true,
            'isFavorite' => $isFavorite,
            'message' => $isFavorite ? 'Added to favorites' : 'Removed from favorites',
        ]);
    }

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $favorites = Auth::user()->favoriteCars()->get();

        return response()->json([
            'success' => true,
            'favorites' => $favorites,
        ]);
    }
}
