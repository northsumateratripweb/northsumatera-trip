<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = ['label', 'value', 'order', 'is_active'];
}
