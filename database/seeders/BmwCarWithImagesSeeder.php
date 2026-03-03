<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarImage;

class BmwCarWithImagesSeeder extends Seeder
{
    public function run(): void
    {
        // === CREATE CAR ===
        $car = Car::create([
            'title' => 'BMW X5 xDrive40i',
            'make' => 'BMW',
            'model' => 'X5',
            'variant' => 'xDrive40i',

            // Spesifikasi
            'year' => 2022,
            'mileage_km' => 18500,
            'transmission' => 'automatic',
            'fuel_type' => 'bensin',
            'color' => 'Hitam',
            'seats' => 5,
            'body_type' => 'suv',

            // Legal
            'plate_parity' => 'ganjil',
            'stnk_valid_until' => '2026-11-15',

            // Bisnis
            'price' => 1485000000,
            'description' => 'BMW X5 xDrive40i kondisi istimewa, interior premium, full service record, siap pakai.',

            // Identitas
            'vin' => 'VIN-BMW-X5-0001',

            // Fitur
            'features' => [
                'ABS',
                'Airbags',
                'Panoramic Sunroof',
                'Adaptive Cruise Control',
                'Lane Assist',
                'Parking Sensors',
                '360 Camera',
                'Apple CarPlay',
                'Android Auto',
                'Electric Tailgate',
            ],

            // Status
            'featured' => true,
            'sold' => false,
        ]);

        // === CAR IMAGES (13 images) ===
        $images = [
            'images/cars/bmw1.jpg',
            'images/cars/bmw2.jpg',
            'images/cars/bmw3.jpg',
            'images/cars/bmw4.jpg',
            'images/cars/bmw5.jpg',
            'images/cars/bmw6.jpg',
            'images/cars/bmw7.jpg',
            'images/cars/bmw8.jpg',
            'images/cars/bmw9.jpg',
            'images/cars/bmw10.jpg',
            'images/cars/bmw11.jpg',
            'images/cars/bmw12.jpg',
            'images/cars/bmw13.jpg',
        ];

        foreach ($images as $index => $path) {
            CarImage::create([
                'car_id' => $car->id,
                'image_path' => $path,
                'is_primary' => $index === 0,
                'sort_order' => $index,
            ]);
        }
    }
}
