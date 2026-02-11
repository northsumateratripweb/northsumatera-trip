<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    protected static $setting = null;

    public static function get()
    {
        if (static::$setting === null) {
            static::$setting = Setting::firstOrCreateDefault();
        }
        return static::$setting;
    }

    public static function companyName()
    {
        return static::get()->company_name ?? 'NorthSumateraTrip';
    }

    public static function whatsappNumber()
    {
        return static::get()->whatsapp_number ?? env('WHATSAPP_NUMBER', '6282381118520');
    }

    public static function email()
    {
        return static::get()->email ?? '';
    }

    public static function instagramUrl()
    {
        return static::get()->instagram_url ?? '';
    }

    public static function tiktokUrl()
    {
        return static::get()->tiktok_url ?? '';
    }

    public static function facebookUrl()
    {
        return static::get()->facebook_url ?? '';
    }

    public static function primaryColor()
    {
        return static::get()->primary_color ?? '#FF4433';
    }

    public static function secondaryColor()
    {
        return static::get()->secondary_color ?? '#f53003';
    }

    public static function heroImage()
    {
        $image = static::get()->hero_image;
        return $image ? asset('storage/' . $image) : null;
    }

    public static function logo()
    {
        $logo = static::get()->logo;
        return $logo ? asset('storage/' . $logo) : null;
    }
}
