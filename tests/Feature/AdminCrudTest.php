<?php

namespace Tests\Feature;

use App\Filament\Resources\Cars\Pages\CreateCar;
use App\Filament\Resources\Cars\Pages\EditCar;
use App\Filament\Resources\Cars\RelationManagers\ImagesRelationManager;
use App\Models\Car;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_car_with_location_from_filament(): void
    {
        $admin = User::factory()->admin()->create();
        $location = Location::create([
            'name' => 'Showroom Pusat',
            'city' => 'Jakarta',
            'is_active' => true,
        ]);

        Livewire::actingAs($admin)
            ->test(CreateCar::class)
            ->fillForm([
                'title' => 'Toyota Avanza Veloz 2022',
                'make' => 'Toyota',
                'model' => 'Avanza',
                'variant' => 'Veloz',
                'year' => 2022,
                'mileage_km' => 32000,
                'transmission' => 'automatic',
                'fuel_type' => 'bensin',
                'body_type' => 'mpv',
                'color' => 'Putih',
                'seats' => 7,
                'price' => 218000000,
                'location_id' => $location->id,
                'featured' => false,
                'sold' => false,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('cars', [
            'title' => 'Toyota Avanza Veloz 2022',
            'location_id' => $location->id,
        ]);
    }

    public function test_admin_can_update_car_location_from_filament(): void
    {
        $admin = User::factory()->admin()->create();
        $oldLocation = Location::create([
            'name' => 'Showroom Lama',
            'city' => 'Jakarta',
            'is_active' => true,
        ]);
        $newLocation = Location::create([
            'name' => 'Showroom Baru',
            'city' => 'Tangerang',
            'is_active' => true,
        ]);
        $car = Car::create($this->carData([
            'location_id' => $oldLocation->id,
        ]));

        Livewire::actingAs($admin)
            ->test(EditCar::class, [
                'record' => $car->getKey(),
            ])
            ->fillForm([
                'location_id' => $newLocation->id,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'location_id' => $newLocation->id,
        ]);
    }

    public function test_edit_car_photo_relation_manager_is_rendered_without_lazy_placeholder(): void
    {
        $admin = User::factory()->admin()->create();
        $car = Car::create($this->carData());

        $car->images()->create([
            'image_path' => 'images/cars/sample.jpg',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $this->assertArrayNotHasKey('lazy', ImagesRelationManager::getDefaultProperties());

        $this->actingAs($admin)
            ->get("/admin/cars/{$car->getKey()}/edit")
            ->assertOk()
            ->assertSee('Foto Mobil')
            ->assertSee('Pratinjau');
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private function carData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Honda Brio RS 2021',
            'make' => 'Honda',
            'model' => 'Brio',
            'variant' => 'RS',
            'year' => 2021,
            'mileage_km' => 28000,
            'transmission' => 'automatic',
            'fuel_type' => 'bensin',
            'body_type' => 'hatchback',
            'color' => 'Merah',
            'seats' => 5,
            'price' => 185000000,
            'featured' => false,
            'sold' => false,
        ], $overrides);
    }
}
