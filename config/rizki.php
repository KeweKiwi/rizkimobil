<?php

return [
    'whatsapp' => [
        'number' => env('RIZKI_WHATSAPP_NUMBER', '081555307307'),
        'wa_number' => env('RIZKI_WHATSAPP_WA_NUMBER', '6281555307307'),
    ],

    'financing' => [
        'tenor_years' => 5,
        'tdp_rate' => 0.38196,
        'monthly_payment_rate' => 0.017696,
        'simulator_down_payment_rate' => 0.30,
        'simulator_annual_interest_rate' => 0.0875,
        'simulator_admin_fee_rate' => 0.006,
        'simulator_protection_rate' => 0.01,
        'simulator_insurance_rates' => [
            'none' => 0,
            'comprehensive' => 0.025,
            'tlo' => 0.012,
        ],
        'simulator_region_multipliers' => [
            'jabodetabek' => 1,
            'jawa' => 1.01,
            'luar_jawa' => 1.03,
        ],
    ],

    'car_makes' => [
        'BMW' => 'BMW',
        'BYD' => 'BYD',
        'Chevrolet' => 'Chevrolet',
        'Daihatsu' => 'Daihatsu',
        'DFSK' => 'DFSK',
        'Ford' => 'Ford',
        'Honda' => 'Honda',
        'Hyundai' => 'Hyundai',
        'Isuzu' => 'Isuzu',
        'Kia' => 'Kia',
        'Lexus' => 'Lexus',
        'Mazda' => 'Mazda',
        'Mercedes-Benz' => 'Mercedes-Benz',
        'Mini' => 'Mini',
        'Mitsubishi' => 'Mitsubishi',
        'Nissan' => 'Nissan',
        'Porsche' => 'Porsche',
        'Subaru' => 'Subaru',
        'Suzuki' => 'Suzuki',
        'Tesla' => 'Tesla',
        'Toyota' => 'Toyota',
        'Volkswagen' => 'Volkswagen',
        'Volvo' => 'Volvo',
        'Wuling' => 'Wuling',
    ],

    'car_body_types' => [
        'suv' => 'SUV',
        'mpv' => 'MPV',
        'sedan' => 'Sedan',
        'hatchback' => 'Hatchback',
        'city' => 'City',
        'lcgc' => 'LCGC',
        'pickup' => 'Pickup Truck',
        'van' => 'Van',
        'coupe' => 'Coupe',
        'convertible' => 'Convertible',
        'wagon' => 'Wagon',
    ],
];
