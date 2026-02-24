<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationHelper
{
    /**
     * Get translation for a key based on current locale.
     * Fallback to Laravel's default __() if not found in database.
     */
    public static function translate(string $key, array $replace = [], ?string $locale = null): string
    {
        $locale = $locale ?: App::getLocale();

        try {
            // Cache translations for better performance
            $translations = Cache::rememberForever("translations_{$locale}", function () use ($locale) {
                $column = "{$locale}_value";
                // Ensure the column exists, fallback to en_value if needed
                if (! in_array($locale, ['id', 'en', 'ms'])) {
                    $column = 'en_value';
                }

                return Translation::all()->pluck($column, 'key')->toArray();
            });

            if (isset($translations[$key]) && ! empty($translations[$key])) {
                $result = $translations[$key];

                foreach ($replace as $k => $v) {
                    $result = str_replace(":{$k}", $v, $result);
                }

                return $result;
            }
        } catch (\Exception $e) {
            Log::error("Translation error for key '{$key}' in locale '{$locale}': ".$e->getMessage());
        }

        // Log missing translation in database
        if (config('app.debug')) {
            Log::info("Missing database translation for key: '{$key}' in locale: '{$locale}'");
        }

        // Fallback to Laravel's default translation
        return __($key, $replace, $locale);
    }
}
