<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Car;
use App\Models\Favorite;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get all favorites rows for this user
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get all cars favorited by this user
     */
    public function favoriteCars()
    {
        return $this->belongsToMany(Car::class, 'favorites')->withTimestamps();
    }

    /**
     * Check if user has favorited a car
     */
    public function hasFavorited($carId): bool
    {
        return $this->favorites()->where('car_id', $carId)->exists();
    }

    /**
     * Toggle favorite status for a car
     * Returns true if added, false if removed
     */
    public function toggleFavorite($carId): bool
    {
        $favorite = $this->favorites()->where('car_id', $carId)->first();

        if ($favorite) {
            $favorite->delete();
            return false;
        }

        $this->favorites()->create([
            'car_id' => $carId,
        ]);

        return true;
    }
}
