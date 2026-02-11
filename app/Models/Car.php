<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['name', 'slug', 'thumbnail', 'capacity', 'transmission', 'price_per_day', 'is_available', 'description'];
}
