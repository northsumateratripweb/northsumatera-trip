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
        return static::get()->primary_color ?? '#1d4ed8';
    }

    public static function secondaryColor()
    {
        return static::get()->secondary_color ?? '#1e40af';
    }

    public static function heroImage()
    {
        $image = static::get()->hero_image;

        return $image ? asset('storage/'.$image) : null;
    }

    public static function logo()
    {
        $logo = static::get()->logo;

        return $logo ? asset('storage/'.$logo) : null;
    }

    public static function favicon()
    {
        $favicon = static::get()->favicon;

        return $favicon ? asset('storage/'.$favicon) : asset('favicon.ico');
    }

    public static function bankDetails()
    {
        $s = static::get();
        return [
            'bank_1' => [
                'name'    => $s->bank_name_1 ?? 'Mandiri',
                'account' => $s->bank_account_1 ?? '1070014838637',
                'holder'  => $s->bank_holder_1 ?? 'Ridho Pasia',
            ],
            'bank_2' => [
                'name'    => $s->bank_name_2 ?? 'BCA',
                'account' => $s->bank_account_2 ?? '8000490520',
                'holder'  => $s->bank_holder_2 ?? 'Ridho Pasia',
            ],
            'qris' => $s->qris_image ? asset('storage/'.$s->qris_image) : null,
        ];
    }
    public static function heroTitle()
    {
        return static::get()->hero_title ?? 'Jelajahi Sumatera Utara Tanpa Batas';
    }

    public static function heroSubtitle()
    {
        return static::get()->hero_subtitle ?? 'Solusi perjalanan wisata profesional untuk Danau Toba, Berastagi, Bukit Lawang, dan sekitarnya.';
    }

    public static function heroBadge()
    {
        return static::get()->hero_badge ?? 'The Best Travel Partner 2026';
    }

    public static function ctaTitle()
    {
        return static::get()->cta_title ?? 'Siap Menjelajahi Sumatera Utara?';
    }

    public static function ctaSubtitle()
    {
        return static::get()->cta_subtitle ?? 'Konsultasikan rencana perjalanan Anda secara gratis bersama tim profesional kami.';
    }

    public static function ctaButtonText()
    {
        return static::get()->cta_button_text ?? 'Konsultasi Gratis';
    }
}
