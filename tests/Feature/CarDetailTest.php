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

    public function test_car_detail_page_shows_financing_estimate_under_price(): void
    {
        $car = Car::create([
            'title' => 'Honda Brio RS 2022',
            'make' => 'Honda',
            'model' => 'Brio RS',
            'year' => 2022,
            'mileage_km' => 18000,
            'transmission' => 'automatic',
            'fuel_type' => 'bensin',
            'body_type' => 'hatchback',
            'color' => 'Merah',
            'seats' => 5,
            'price' => 309000000,
            'featured' => false,
            'sold' => false,
        ]);

        $response = $this->get(route('car.show', $car));

        $response->assertOk();
        $response->assertSee('Estimasi Biaya');
        $response->assertSee('5 tahun');
        $response->assertSee('Rp 118.026.000');
        $response->assertSee('Rp 5.468.000');
        $response->assertSee('Sesuaikan Budget');
        $response->assertSee('Simulasi Kredit');
        $response->assertSee('Simulasi pembiayaan');
        $response->assertSee('Hitung Budget');
        $response->assertSee('Hasil Perhitungan');
        $response->assertSee('Harga OTR otomatis dari listing unit.');
        $response->assertSee('Terkunci');
        $response->assertSee('id="credit-price" type="text" inputmode="numeric" readonly aria-readonly="true"', false);
        $response->assertSee('credit-down-payment-help');
        $response->assertSee('credit-down-payment-error');
        $response->assertSee('minDownPaymentRate');
        $response->assertSee('maxTenorYears');
        $response->assertSee('for (let tenor = 1; tenor <= maxTenorYears; tenor += 1)', false);
        $response->assertSee('tdp: downPayment', false);
        $response->assertDontSee('tenor <= 6', false);
        $response->assertDontSee('syncCreditPrice');
        $response->assertDontSee('BCA');
        $response->assertDontSee('adminFeeRate');
        $response->assertDontSee('saya%20ingin%20sesuaikan%20budget', false);
    }
}
