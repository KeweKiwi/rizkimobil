<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ContactController;

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
Route::get('/inventory/suggestions', [InventoryController::class, 'suggestions'])->name('inventory.suggestions');

// Single car page
Route::get('/car/{id}', [CarController::class, 'show'])->name('car.show');

// Contact page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// If you have authentication routes, they would be here
// Auth::routes();
