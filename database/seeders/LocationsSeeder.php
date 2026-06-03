<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        $whatsappNumber = config('rizki.whatsapp.wa_number');

        Location::create([
            'name' => 'Jakarta',
            'address' => 'Jl. Contoh No. 1',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'whatsapp' => $whatsappNumber,
            'google_maps_url' => 'https://maps.google.com',
            'is_active' => true,
        ]);

        Location::create([
            'name' => 'Surabaya',
            'address' => 'Jl. Contoh No. 2',
            'city' => 'Surabaya',
            'province' => 'Jawa Timur',
            'whatsapp' => $whatsappNumber,
            'google_maps_url' => 'https://maps.google.com',
            'is_active' => true,
        ]);
    }
}
