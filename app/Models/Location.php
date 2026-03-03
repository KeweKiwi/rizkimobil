<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','address','city','province','postal_code',
        'google_maps_url','phone','whatsapp','is_active'
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
