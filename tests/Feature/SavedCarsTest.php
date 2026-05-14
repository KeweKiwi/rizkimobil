<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SavedCarsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_must_login_before_viewing_saved_cars(): void
    {
        $this->get(route('favorites.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_must_login_before_saving_a_car(): void
    {
        $car = $this->createCar();

        $this->post(route('favorites.toggle', $car))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_save_and_unsave_a_car(): void
    {
        $user = User::factory()->create();
        $car = $this->createCar();

        $this->actingAs($user)
            ->post(route('favorites.toggle', $car))
            ->assertRedirect();

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'car_id' => $car->id,
        ]);

        $this->actingAs($user)
            ->get(route('favorites.index'))
            ->assertOk()
            ->assertSee('Unit yang Anda simpan')
            ->assertSee('Toyota')
            ->assertSee('Avanza');

        $this->actingAs($user)
            ->post(route('favorites.toggle', $car))
            ->assertRedirect();

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'car_id' => $car->id,
        ]);
    }

    private function createCar(array $overrides = []): Car
    {
        return Car::create(array_merge([
            'title' => 'Toyota Avanza 1.5 G',
            'make' => 'Toyota',
            'model' => 'Avanza',
            'variant' => '1.5 G',
            'year' => 2022,
            'mileage_km' => 32000,
            'transmission' => 'automatic',
            'fuel_type' => 'bensin',
            'body_type' => 'mpv',
            'price' => 218000000,
            'featured' => false,
            'sold' => false,
        ], $overrides));
    }
}
