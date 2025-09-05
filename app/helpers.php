<?php

if (!function_exists('getLocalizedText')) {
    /**
     * Get localized text based on current locale
     *
     * @param array|string $text
     * @param string|null $locale
     * @return string
     */
    function getLocalizedText($text, $locale = null)
    {
        if (is_string($text)) {
            return $text;
        }

        if (!is_array($text)) {
            return '';
        }

        $locale = $locale ?? getCurrentLocale();

        // Try to get text for current locale
        if (isset($text[$locale])) {
            return $text[$locale];
        }

        // Fallback to English
        if (isset($text['en'])) {
            return $text['en'];
        }

        // Fallback to Arabic
        if (isset($text['ar'])) {
            return $text['ar'];
        }

        // Return first available value
        return array_values($text)[0] ?? '';
    }
}

if (!function_exists('getCurrentLocale')) {
    /**
     * Get current locale with fallback
     *
     * @return string
     */
    function getCurrentLocale()
    {
        // Check session first
        if (session()->has('locale')) {
            return session('locale');
        }

        // Fallback to app locale
        return app()->getLocale() ?? config('app.locale', 'en');
    }
}

if (!function_exists('isRtlLocale')) {
    /**
     * Check if current locale is RTL
     *
     * @param string|null $locale
     * @return bool
     */
    function isRtlLocale($locale = null)
    {
        $locale = $locale ?? getCurrentLocale();
        $rtlLocales = ['ar', 'he', 'fa', 'ur'];

        return in_array($locale, $rtlLocales);
    }
}

if (!function_exists('isActive')) {
    function isActive($route, $currentRoute)
    {
        return isset($route) && $route === $currentRoute;
    }
}

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($routeName, $currentRoute)
    {
        return isset($routeName) && $routeName === $currentRoute;
    }
}

if (!function_exists('hasActiveChild')) {
    function hasActiveChild(array $children, $currentRoute): bool
    {
        foreach ($children as $child) {
            if (isset($child['route']) && $child['route'] === $currentRoute) {
                return true;
            }
            if (isset($child['children']) && hasActiveChild($child['children'], $currentRoute)) {
                return true;
            }
        }
        return false;
    }
}