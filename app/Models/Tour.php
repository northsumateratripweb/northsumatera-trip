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
    ];

    protected $casts = [
        'trips' => 'array', // Casting JSON ke array
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}