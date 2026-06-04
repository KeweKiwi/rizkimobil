<?php

namespace Tests\Feature;

use App\Filament\Resources\Cars\Pages\CreateCar;
use App\Filament\Resources\Cars\Pages\EditCar;
use App\Filament\Resources\Cars\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\Locations\Pages\CreateLocation;
use App\Filament\Resources\Locations\Pages\EditLocation;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Models\Car;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
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
                'body_type' => 'lcgc',
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
            'body_type' => 'lcgc',
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

    public function test_admin_pages_use_admin_scoped_livewire_update_endpoint(): void
    {
        $admin = User::factory()->admin()->create();
        $car = Car::create($this->carData());

        $this->assertSame('/admin/livewire/update', Livewire::getUpdateUri());
        $this->assertSame('admin/livewire/update', Route::getRoutes()->getByName('admin.livewire.update')?->uri());

        $this->actingAs($admin)
            ->get("/admin/cars/{$car->getKey()}/edit")
            ->assertOk();
    }

    public function test_admin_can_create_and_update_location_from_filament(): void
    {
        $admin = User::factory()->admin()->create();

        Livewire::actingAs($admin)
            ->test(CreateLocation::class)
            ->fillForm([
                'name' => 'Rizki Mobil BSD',
                'address' => 'Jl. Showroom No. 10',
                'city' => 'Tangerang Selatan',
                'province' => 'Banten',
                'postal_code' => '15310',
                'google_maps_url' => 'https://maps.google.com/?q=Rizki+Mobil+BSD',
                'phone' => '0215551234',
                'whatsapp' => '081234567890',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $location = Location::where('name', 'Rizki Mobil BSD')->firstOrFail();

        $this->assertSame('Tangerang Selatan', $location->city);
        $this->assertTrue((bool) $location->is_active);

        Livewire::actingAs($admin)
            ->test(EditLocation::class, [
                'record' => $location->getKey(),
            ])
            ->fillForm([
                'name' => 'Rizki Mobil BSD Update',
                'city' => 'Jakarta Selatan',
                'is_active' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'Rizki Mobil BSD Update',
            'city' => 'Jakarta Selatan',
            'is_active' => false,
        ]);
    }

    public function test_admin_can_create_and_update_user_from_filament(): void
    {
        $admin = User::factory()->admin()->create();

        Livewire::actingAs($admin)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'Sales Admin',
                'email' => 'sales-admin@example.com',
                'phone' => '081111222233',
                'is_admin' => true,
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $createdUser = User::where('email', 'sales-admin@example.com')->firstOrFail();

        $this->assertTrue($createdUser->isAdmin());
        $this->assertSame('081111222233', $createdUser->phone);
        $this->assertTrue(Hash::check('password123', $createdUser->password));

        Livewire::actingAs($admin)
            ->test(EditUser::class, [
                'record' => $createdUser->getKey(),
            ])
            ->fillForm([
                'name' => 'Sales Customer Care',
                'email' => 'customer-care@example.com',
                'phone' => '082222333344',
                'is_admin' => false,
                'password' => '',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $createdUser->refresh();

        $this->assertSame('Sales Customer Care', $createdUser->name);
        $this->assertSame('customer-care@example.com', $createdUser->email);
        $this->assertSame('082222333344', $createdUser->phone);
        $this->assertFalse($createdUser->isAdmin());
        $this->assertTrue(Hash::check('password123', $createdUser->password));
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
