<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InventoryFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_model_filter_redirects_to_search_parameter(): void
    {
        $response = $this->get('/inventory?model=Avanza');

        $response->assertRedirect(route('inventory', ['search' => 'Avanza']));
    }

    public function test_inventory_search_filters_available_cars(): void
    {
        $this->insertCar('Toyota', 'Avanza');
        $this->insertCar('Honda', 'Civic');

        $response = $this->get('/inventory?search=Avanza');

        $response->assertOk();
        $response->assertSee('Avanza');
        $response->assertDontSee('Civic');
    }

    public function test_invalid_filter_values_do_not_break_inventory_page(): void
    {
        $this->insertCar('Toyota', 'Avanza');

        $response = $this->get('/inventory?price_range=not-a-range&body_type=invalid&fuel_type[]=wrong&sort=wrong');

        $response->assertOk();
        $response->assertSee('Avanza');
    }

    public function test_inventory_make_filter_includes_mini_from_supported_make_list(): void
    {
        $response = $this->get('/inventory');

        $response->assertOk();
        $response->assertSee('Mini');
    }

    public function test_inventory_body_type_filter_includes_city_and_lcgc(): void
    {
        $response = $this->get('/inventory');

        $response->assertOk();
        $response->assertSee('City');
        $response->assertSee('LCGC');
    }

    private function insertCar(string $make, string $model): void
    {
        DB::table('cars')->insert([
            'title' => "{$make} {$model}",
            'make' => $make,
            'model' => $model,
            'year' => 2024,
            'mileage_km' => 12000,
            'transmission' => 'automatic',
            'fuel_type' => 'bensin',
            'body_type' => 'mpv',
            'price' => 250000000,
            'featured' => false,
            'sold' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
