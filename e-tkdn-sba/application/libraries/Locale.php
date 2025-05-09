<?php

class Locale
{
    public static function getDefault()
    {
        return 'en_US';
    }

    public static function setDefault($locale)
    {
        return true;
    }

    public static function getPrimaryLanguage($locale)
    {
        $parts = explode('_', $locale);
        return $parts[0];
    }

    public static function getDisplayName($locale, $in_locale = null)
    {
        return $locale;
    }

    public static function parseLocale($locale)
    {
        $parts = explode('_', $locale);
        return [
            'language' => $parts[0],
            'region' => isset($parts[1]) ? $parts[1] : null
        ];
    }

    public static function getDisplayLanguage($locale, $in_locale = null)
    {
        $parts = self::parseLocale($locale);
        return $parts['language'];
    }

    public static function getDisplayRegion($locale, $in_locale = null)
    {
        $parts = self::parseLocale($locale);
        return $parts['region'] ?? '';
    }
}
