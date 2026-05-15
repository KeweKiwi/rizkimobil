<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrNew([
            'email' => 'admin@rizkimobil.com',
        ]);

        if (!$user->exists) {
            $user->fill([
                'name' => 'Admin',
                'password' => Hash::make('RizkiMobil2024!'),
            ]);
        }

        $user->forceFill([
            'is_admin' => true,
        ])->save();
    }
}
