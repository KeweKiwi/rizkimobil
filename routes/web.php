<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Inventory page
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('/inventory/suggestions', [InventoryController::class, 'suggestions'])
    ->middleware('throttle:inventory-search')
    ->name('inventory.suggestions');

// Single car page
Route::get('/car/{id}', [CarController::class, 'show'])->name('car.show');

// Saved cars
Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])
        ->middleware('throttle:account-security')
        ->name('account.password.update');
    Route::get('/saved', [FavoriteController::class, 'saved'])->name('favorites.index');
    Route::post('/car/{car}/favorite', [FavoriteController::class, 'toggleWeb'])
        ->middleware('throttle:favorites')
        ->name('favorites.toggle');
});

// Contact page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

// Customer authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login')
        ->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:registration')
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
