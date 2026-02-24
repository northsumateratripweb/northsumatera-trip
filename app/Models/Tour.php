<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    // Mass assignment: Daftarkan semua kolom agar bisa diisi oleh Filament
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'itinerary',
        'thumbnail',
        'location',
        'duration_days',
        'trip_image',
        'trips',
        'itinerary_url',
    ];

    protected $casts = [
        'trips' => 'array', // Casting JSON ke array
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->thumbnail) {
            return asset('images/default-tour.jpg');
        }
        return str_starts_with($this->thumbnail, 'http') 
            ? $this->thumbnail 
            : asset('storage/' . $this->thumbnail);
    }

    protected static function booted()
    {
        static::deleting(function ($tour) {
            // Hapus semua booking terkait sebelum tour dihapus
            $tour->bookings()->delete();
        });

        static::saving(function ($model) {
            if ($model->isDirty('thumbnail') && $model->thumbnail && !str_starts_with($model->thumbnail, 'http')) {
                self::optimizeImage($model->thumbnail);
            }
        });
    }

    protected static function optimizeImage($path)
    {
        try {
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                $image = \Intervention\Image\Laravel\Facades\Image::read($fullPath);
                
                // Resize if width > 1200px
                if ($image->width() > 1200) {
                    $image->scale(width: 1200);
                }
                
                // Save with 80% quality
                $image->save($fullPath, 80);
            }
        } catch (\Exception $e) {
            \Log::error('Image optimization failed: ' . $e->getMessage());
        }
    }
}
