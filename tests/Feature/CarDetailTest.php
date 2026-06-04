<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_car_detail_page_shows_unit_location_from_database(): void
    {
        $location = Location::create([
            'name' => 'Rizki Mobil BSD',
            'address' => 'Jl. Showroom No. 10',
            'city' => 'Tangerang Selatan',
            'province' => 'Banten',
            'google_maps_url' => 'https://maps.google.com/?q=Rizki+Mobil+BSD',
            'whatsapp' => '081555307307',
            'is_active' => true,
        ]);

        $car = Car::create([
            'title' => 'Daihatsu Sirion 2011',
            'location_id' => $location->id,
            'make' => 'Daihatsu',
            'model' => 'Sirion',
            'year' => 2011,
            'mileage_km' => 114000,
            'transmission' => 'manual',
            'fuel_type' => 'bensin',
            'body_type' => 'mpv',
            'color' => 'Ungu',
            'seats' => 5,
            'price' => 89500000,
            'featured' => false,
            'sold' => false,
        ]);

        $response = $this->get(route('car.show', $car));

        $response->assertOk();
        $response->assertSee('Lokasi Unit');
        $response->assertSee('Rizki Mobil BSD');
        $response->assertSee('Jl. Showroom No. 10');
        $response->assertSee('Tangerang Selatan, Banten');
        $response->assertSee('https://maps.google.com/?q=Rizki+Mobil+BSD');
    }
}
