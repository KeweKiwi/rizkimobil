<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'make',
        'model',
        'variant',
        'year',
        'mileage_km',
        'transmission',
        'fuel_type',
        'color',
        'seats',
        'body_type',
        'plate_parity',
        'stnk_valid_until',
        'price',
        'description',
        'vin',
        'features',
        'featured',
        'sold',
    ];

    protected $casts = [
        'features' => 'array',
        'featured' => 'boolean',
        'sold' => 'boolean',
        'year' => 'integer',
        'mileage_km' => 'integer',
        'seats' => 'integer',
        'stnk_valid_until' => 'date',
        'price' => 'integer', // karena di migration kita pakai integer rupiah
    ];

    /**
     * Car has many images
     */
    public function images()
    {
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    /**
     * Primary image (thumbnail)
     */
    public function primaryImage()
    {
        return $this->hasOne(CarImage::class)->where('is_primary', true);
    }

    /**
     * Get main image URL (primary -> first -> placeholder)
     * NOTE: image_path sebaiknya disimpan relatif ke public/ (mis: "images/cars/1.jpg")
     */
    public function getMainImageAttribute()
    {
        // coba pakai primary image dulu
        $img = $this->relationLoaded('primaryImage')
            ? $this->primaryImage
            : $this->primaryImage()->first();

        if (!$img) {
            // fallback: gambar pertama
            $img = $this->relationLoaded('images')
                ? $this->images->first()
                : $this->images()->first();
        }

        return $img ? asset($img->image_path) : 'https://via.placeholder.com/800x600?text=No+Image';
    }

    /**
     * Scope: featured cars
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope: available (not sold)
     */
    public function scopeAvailable($query)
    {
        return $query->where('sold', false);
    }

    /**
     * Search/filter (make, model, price range)
     * priceRange format: "100000000-200000000"
     */
    public function scopeSearch($query, $make = null, $model = null, $priceRange = null)
    {
        if ($make) {
            $query->where('make', $make);
        }

        if ($model) {
            $query->where('model', 'like', "%{$model}%");
        }

        if ($priceRange) {
            [$min, $max] = explode('-', $priceRange);
            $query->whereBetween('price', [(int) $min, (int) $max]);
        }

        return $query;
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    /**
     * Favorites relationships (optional - kalau tabel favorites belum ada, jangan dipakai dulu)
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
