<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripChecklist extends Model
{
    protected $fillable = [
        'trip_data_id',
        'item',
        'is_done',
        'order',
    ];

    public function tripData()
    {
        return $this->belongsTo(TripData::class);
    }
}

