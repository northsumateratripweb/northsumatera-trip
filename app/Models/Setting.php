<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'whatsapp_number',
        'email',
        'address',
        'business_hours',
        'timezone',
        'instagram_url',
        'tiktok_url',
        'facebook_url',
        'youtube_url',
        'twitter_url',
        'primary_color',
        'secondary_color',
        'hero_image',
        'logo',
        'favicon',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'google_analytics_id',
        'bank_name_1',
        'bank_account_1',
        'bank_holder_1',
        'bank_name_2',
        'bank_account_2',
        'bank_holder_2',
        'qris_image',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'hero_title',
        'hero_subtitle',
        'hero_badge',
        'cta_title',
        'cta_subtitle',
        'cta_button_text',
    ];

    public static function firstOrCreateDefault()
    {
        $setting = static::first();
        
        if (! $setting) {
            $setting = static::create([
                'company_name' => 'NorthSumateraTrip',
                'primary_color' => '#1d4ed8',
                'secondary_color' => '#1e40af',
            ]);
        }

        return $setting;
    }
}
