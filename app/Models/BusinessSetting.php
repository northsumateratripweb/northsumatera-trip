<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'whatsapp', 'email', 'instagram', 'tiktok', 'facebook', 'logo', 'hero_image', 'primary_color', 'secondary_color'
    ];

    public static function get(): ?self
    {
        return self::first();
    }
}
