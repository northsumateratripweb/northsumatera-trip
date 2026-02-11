<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'tour_id',
        'customer_name',
        'customer_whatsapp',
        'email',
        'phone',
        'travel_date',
        'qty',
        'total_price',
        'status',
        'payment_status',
        'payment_link',
        'external_id',
        'snap_token',
    ];
}
