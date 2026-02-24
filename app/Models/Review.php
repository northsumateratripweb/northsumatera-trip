<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'tour_id',
        'customer_name',
        'rating',
        'comment',
        'is_published',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
