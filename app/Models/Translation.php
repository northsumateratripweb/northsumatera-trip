<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    protected $fillable = ['key', 'id_value', 'en_value', 'ms_value', 'group'];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('translations_id');
            Cache::forget('translations_en');
            Cache::forget('translations_ms');
        });

        static::deleted(function () {
            Cache::forget('translations_id');
            Cache::forget('translations_en');
            Cache::forget('translations_ms');
        });
    }
}
