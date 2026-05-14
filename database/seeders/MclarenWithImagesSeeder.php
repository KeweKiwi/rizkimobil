<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarImage;

class MclarenWithImagesSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // CREATE MCLAREN
        // =========================
        $car = Car::create([
            'title' => 'McLaren 720S',
            'make' => 'McLaren',
            'model' => '720S',
            'variant' => null,

            // Spesifikasi
            'year' => 2022,
            'mileage_km' => 5400,
            'transmission' => 'automatic',
            'fuel_type' => 'bensin', // SESUAI ENUM
            'color' => 'Papaya Orange',
            'seats' => 2,
            'body_type' => 'coupe',

            // Legal
            'plate_parity' => 'ganjil',
            'stnk_valid_until' => '2027-01-12',

            // Bisnis
            'price' => 1200000000,
            'description' => 'McLaren 720S supercar ringan dengan handling presisi, akselerasi ekstrem, kondisi sangat terawat.',

            // Identitas
            'vin' => 'VIN-MCLAREN-720S-0001',

            // Fitur
            'features' => [
                'V8 Twin Turbo',
                'Carbon Fiber Monocoque',
                'Active Aerodynamics',
                'Launch Control',
                'Drive Mode Selector',
                'Digital Instrument Cluster',
            ],

            // Status
            'featured' => true,
            'sold' => false,
        ]);

        // =========================
        // IMAGES (13 files: fer1–fer13)
        // =========================
        $images = [
            'images/cars/fer1.jpg',
            'images/cars/fer2.jpg',
            'images/cars/fer3.jpg',
            'images/cars/fer4.jpg',
            'images/cars/fer5.jpg',
            'images/cars/fer6.jpg',
            'images/cars/fer7.jpg',
            'images/cars/fer8.jpg',
            'images/cars/fer9.jpg',
            'images/cars/fer10.jpg',
            'images/cars/fer11.jpg',
            'images/cars/fer12.jpg',
            'images/cars/fer13.jpg',
        ];

        foreach ($images as $index => $path) {
            CarImage::create([
                'car_id' => $car->id,
                'image_path' => $path,
                'is_primary' => $index === 0, // fer1.jpg = thumbnail
                'sort_order' => $index,
            ]);
        }
    }
}
