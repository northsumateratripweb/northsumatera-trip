<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'booking_type',
        'tour_id',
        'trip_type',
        'use_drone',
        'car_id',
        'customer_name',
        'customer_whatsapp',
        'email',
        'phone',
        'travel_date',
        'qty',
        'duration_days',
        'total_price',
        'status',
        'payment_status',
        'payment_link',
        'payment_proof',
        'external_id',
        'nama_driver',
        'plat_mobil',
        'jenis_mobil',
        'hotel_1',
        'hotel_2',
        'hotel_3',
        'hotel_4',
        'deposit',
        'pelunasan',
        'tiba',
        'flight_balik',
        'notes',
    ];

    protected $casts = [
        'use_drone'   => 'boolean',
        'travel_date' => 'date',
        'total_price' => 'integer',
        'qty'         => 'integer',
        'deposit'     => 'decimal:2',
        'pelunasan'   => 'decimal:2',
        'tiba'        => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function tripData()
    {
        return $this->hasOne(TripData::class, 'booking_id');
    }
}
