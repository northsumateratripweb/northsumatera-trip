<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'date','customer_name','status','phone','driver_name','service','plate','car_type','drone','days','passengers',
        'hotel_1','hotel_2','hotel_3','hotel_4','price','deposit','payment','arrived_at','return_flight_at','notes'
    ];
}
