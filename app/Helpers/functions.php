<?php

use App\Helpers\TranslationHelper;

if (! function_exists('__t')) {
    /**
     * Translate the given message from database or fallback to Laravel default.
     *
     * @param  string  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string
     */
    function __t($key, $replace = [], $locale = null)
    {
        return TranslationHelper::translate($key, $replace, $locale);
    }
}
