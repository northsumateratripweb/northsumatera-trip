<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    protected $fillable = ['name', 'slug', 'brand', 'plat_nomor', 'jenis_mobil', 'thumbnail', 'capacity', 'transmission', 'price_per_day', 'is_available', 'description'];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->thumbnail) {
            return asset('images/default-car.jpg');
        }
        return str_starts_with($this->thumbnail, 'http') 
            ? $this->thumbnail 
            : asset('storage/' . $this->thumbnail);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('thumbnail') && $model->thumbnail && !str_starts_with($model->thumbnail, 'http')) {
                self::optimizeImage($model->thumbnail);
            }
        });
    }

    protected static function optimizeImage($path)
    {
        // Body initially empty
    }
}
