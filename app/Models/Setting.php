<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'whatsapp_number',
        'email',
        'instagram_url',
        'tiktok_url',
        'facebook_url',
        'primary_color',
        'secondary_color',
        'hero_image',
        'logo',
    ];

    /**
     * Get the first (and only) setting record
     */
    public static function firstOrCreateDefault()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'NorthSumateraTrip',
                'primary_color' => '#FF4433',
                'secondary_color' => '#f53003',
            ]
        );
    }
}
