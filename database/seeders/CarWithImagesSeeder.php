<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarImage;

class CarWithImagesSeeder extends Seeder
{
    public function run(): void
    {
        // === CREATE CAR ===
        $car = Car::create([
            'title' => 'BYD Atto 3 Electric',
            'make' => 'BYD',
            'model' => 'Atto 3',
            'variant' => null,

            // Spesifikasi
            'year' => 2023,
            'mileage_km' => 1200,
            'transmission' => 'automatic',
            'fuel_type' => 'electric',
            'color' => 'Putih',
            'seats' => 5,
            'body_type' => 'suv',

            // Legal & plat
            'plate_parity' => 'genap',
            'stnk_valid_until' => '2026-02-01',

            // Bisnis
            'price' => 515000000,
            'description' => 'BYD Atto 3 kondisi sangat mulus, full electric, interior bersih, siap pakai.',

            // Identitas
            'vin' => 'VIN-BYD-ATTO3-0001',

            // Fitur
            'features' => [
                'Electric Vehicle',
                'ABS',
                'Airbags',
                'Panoramic Sunroof',
                'Touchscreen Display',
                'Rear Camera'
            ],

            // Status
            'featured' => true,
            'sold' => false,
        ]);

        // === CAR IMAGES ===
        $images = [
            'images/cars/byd1.jpg',
            'images/cars/byd2.jpg',
            'images/cars/byd3.jpg',
        ];

        foreach ($images as $index => $path) {
            CarImage::create([
                'car_id' => $car->id,
                'image_path' => $path,
                'is_primary' => $index === 0, // gambar pertama = thumbnail utama
                'sort_order' => $index,
            ]);
        }
    }
}
