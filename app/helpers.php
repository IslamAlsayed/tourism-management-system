<?php

if (!function_exists('getActiveUser')) {
    function getActiveUser($id = null)
    {
        $user = Auth::check() ? Auth::user() : null;
        return $id ? $user->find($id) : $user;
    }
}

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
    function isActive($route, $parameters, $currentRoute, $currentParameters = [])
    {
        if (!isset($route) || $route !== $currentRoute) {
            return false;
        }

        foreach ($parameters as $key => $value) {
            if (($currentParameters[$key] ?? null) != $value) {
                return false;
            }
        }

        return true;
    }

}

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($routeName, $currentRoute)
    {
        return isset($routeName) && $routeName === $currentRoute;
    }
}

if (!function_exists('hasActiveChild')) {
    function hasActiveChild(array $children, $currentRoute, array $currentParameters = []): bool
    {
        foreach ($children as $child) {
            if (isset($child['route'])) {
                if ($child['route'] === $currentRoute) {
                    if (isset($child['parameters'])) {
                        $allMatch = true;
                        foreach ($child['parameters'] as $key => $value) {
                            if (($currentParameters[$key] ?? null) != $value) {
                                $allMatch = false;
                                break;
                            }
                        }
                        if ($allMatch) {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            }

            if (isset($child['children']) && hasActiveChild($child['children'], $currentRoute, $currentParameters)) {
                return true;
            }
        }
        return false;
    }
}


if (!function_exists('generateUniqueFilename')) {
    function generateUniqueFilename($prefix = 'export')
    {
        // return $prefix . '_' . substr(md5(uniqid(mt_rand(), true)), 0, 6);
        return $prefix . '_' . date('Y_m_d_H_i_s');
    }
}

if (!function_exists('getPaginate')) {
    function getPaginate()
    {
        return session('paginate_count', config('app.paginate_count'));
        // $sessionValue = session('paginate_count');
        // $configValue = config('app.paginate_count');
        // $allowedValues = config('app.paginate_array', [10, 25, 50, 100]);

        // // Return session value if exists and is valid
        // if ($sessionValue && in_array((int) $sessionValue, $allowedValues)) {
        //     return (int) $sessionValue;
        // }

        // // Fallback to config value and set it in session
        // $configInt = (int) $configValue;
        // if (!in_array($configInt, $allowedValues)) {
        //     $configInt = 50; // Safe fallback to middle value
        // }

        // session(['paginate_count' => $configInt]);
        // return $configInt;
    }
}

if (!function_exists('highlightSearch')) {
    function highlightSearch(string $html, ?string $search = null): string
    {
        if (!$search) {
            return $html;
        }

        $search = preg_quote($search, '/');

        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // لتفادي الأخطاء مع HTML غير مكتمل

        // إضافة wrapper لأن DOMDocument لازم يكون فيه عنصر root
        $dom->loadHTML('<div id="wrapper">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);
        $textNodes = $xpath->query('//text()');

        foreach ($textNodes as $node) {
            $value = $node->nodeValue;

            // لو النص يحتوي الكلمة، ظللها
            if (stripos($value, $search) !== false) {
                $highlighted = preg_replace(
                    "/($search)/i",
                    '<span class="highlight">$1</span>',
                    $value
                );

                // استبدال النص القديم بالـ HTML الجديد
                $newNode = $dom->createDocumentFragment();
                $newNode->appendXML($highlighted);
                $node->parentNode->replaceChild($newNode, $node);
            }
        }

        // استخرج فقط ما بداخل الـ wrapper
        $wrapper = $dom->getElementById('wrapper');
        $output = '';
        foreach ($wrapper->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return $output;
    }
}