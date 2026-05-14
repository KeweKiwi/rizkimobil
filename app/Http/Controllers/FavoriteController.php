<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function toggle(Request $request, $carId)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $car = Car::findOrFail($carId);

        $isFavorite = $user->toggleFavorite($carId);

        return response()->json([
            'success' => true,
            'isFavorite' => $isFavorite,
            'message' => $isFavorite ? 'Added to favorites' : 'Removed from favorites',
        ]);
    }

    public function toggleWeb(Request $request, Car $car): RedirectResponse
    {
        $isFavorite = $request->user()->toggleFavorite($car->id);

        return back()->with(
            'favorite_status',
            $isFavorite ? 'Mobil berhasil disimpan.' : 'Mobil dihapus dari daftar tersimpan.'
        );
    }

    public function saved(Request $request): View
    {
        $cars = $request->user()
            ->favoriteCars()
            ->with(['primaryImage', 'fallbackImage'])
            ->orderByPivot('created_at', 'desc')
            ->paginate(12);

        return view('saved-cars', compact('cars'));
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $favorites = $user->favoriteCars()->get();

        return response()->json([
            'success' => true,
            'favorites' => $favorites,
        ]);
    }
}
