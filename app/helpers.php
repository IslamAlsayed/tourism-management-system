<?php

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Support\Activity\ActivityMessageFormatter;

if (!function_exists('getActiveUser')) {
    /**
     * Get the currently authenticated user or a user by ID.
     * Checks authentication first.
     *
     * @param int|null $id
     * @return \App\Models\User|null
     */
    function getActiveUser($id = null)
    {
        if (!Auth::check()) {
            return null;
        }

        if ($id != null) {
            return User::find($id) ?? null;
        }

        return Auth::user();
    }
}

// تحديث حالة المستخدم (متصل/غير متصل)
if (!function_exists('setUserStatus')) {
    function setUserStatus($status = 'offline')
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userDB = User::find($user->id);
            if ($userDB) {
                $userDB->update(['user_status' => $status, 'last_login_at' => now(), 'last_login_ip' => request()->ip()]);
            }
        }
    }
}

if (!function_exists('getActiveSettings')) {
    function getActiveSettings()
    {
        return Setting::first() ?? [];
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

if (!function_exists('hasEmpty')) {
    function hasEmpty($data)
    {
        return is_array($data) ? count($data) > 0 : !is_null($data);
    }
}

if (!function_exists('routeExists')) {
    /**
     * Check if a named route exists.
     *
     * @param string $routeName
     * @return bool
     */
    function routeExists(string $routeName): bool
    {
        return app('router')->has($routeName);
    }
}

if (!function_exists('showRouteExists')) {
    /**
     * Check if a 'show' route exists for a given resource.
     *
     * @param string $resource
     * @return bool
     */
    function showRouteExists(string $resource): bool
    {
        return routeExists($resource . '.show');
    }
}

if (!function_exists('showFunctionExists')) {
    /**
     * Check if a 'show' method exists in the controller for a given resource.
     *
     * @param string $resource
     * @return bool
     */
    function showFunctionExists(string $resource)
    {
        try {
            // Convert resource name to controller name (e.g., 'tour-guides' => 'TourGuidesController')
            $controllerName = singularLowerCaseName($resource, '') . 'Controller';
            $controllerClass = 'App\\Http\\Controllers\\' . $controllerName;
            $controllerClassDashboard = 'App\\Http\\Controllers\\Dashboard\\' . $controllerName;

            if (!class_exists($controllerClass) && !class_exists($controllerClassDashboard)) {
                return false;
            }

            return method_exists($controllerClass, 'show') || method_exists($controllerClassDashboard, 'show');
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('generateUniqueFilename')) {
    function generateUniqueFilename($prefix = 'data')
    {
        // return $prefix . '_' . substr(md5(uniqid(mt_rand(), true)), 0, 6);
        return $prefix . '_' . date('Y_m_d_H_i_s');
    }
}

if (!function_exists('getPaginate')) {
    function getPaginate()
    {
        $settings = Setting::first();
        return (int) session('paginate_count', $settings->app_paginate_count ?? config('app.paginate_count'));
    }
}

if (!function_exists('highlightSearch')) {
    function highlightSearch(string $html, ?string $search = null): string
    {
        if (!$search) {
            return $html;
        }

        $search = trim($search);

        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // لتفادي الأخطاء مع HTML غير مكتمل

        // إضافة wrapper لأن DOMDocument لازم يكون فيه عنصر root
        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="wrapper">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $xpath = new DOMXPath($dom);
        $textNodes = $xpath->query('//text()');

        foreach ($textNodes as $node) {
            $value = $node->nodeValue;

            // هنا استخدم الـ search العادي
            if (stripos($value, $search) !== false) {
                // وهنا استخدم نسخة escaped للـ regex
                $escapedSearch = preg_quote($search, '/');

                $highlighted = preg_replace(
                    "/($escapedSearch)/i",
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


if (!function_exists('highlightSearch2')) {
    function highlightSearch2(string $html, ?string $search = null): string
    {
        if (!$search) {
            return $html;
        }

        $search = trim($search);

        $search = preg_quote($search, '/');

        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // لتفادي الأخطاء مع HTML غير مكتمل

        // إضافة wrapper لأن DOMDocument لازم يكون فيه عنصر root
        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="wrapper">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

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

if (!function_exists('limitedText')) {
    function limitedText($text, $limit, $end = '...'): string
    {
        return \Illuminate\Support\Str::limit($text, $limit, $end);
    }
}

if (!function_exists('db_connection')) {
    function db_connection(?string $mode = null): string
    {
        $mode2 = $mode ?? env('DB_MODE', 'local');

        return match ($mode2) {
            'local' => 'mysql',
            'testing' => 'mysql_testing',
            'production' => 'mysql_production',
            default => 'mysql',
        };
    }
}

if (!function_exists('modelTypeToRoute')) {
    function modelTypeToRoute(?string $modelType, bool $plural = false): ?string
    {
        if (!$modelType)
            return null;

        $name = Str::kebab(class_basename($modelType));
        return $plural ? Str::plural($name) : Str::singular($name);
    }
}


// if (!function_exists('modelTypeToRoute')) {
//     function modelTypeToRoute(?string $modelType): ?string
//     {
//         if (!$modelType)
//             return null;

//         return Str::plural(Str::kebab(class_basename($modelType)));
//     }
// }

/* Removed invalid anonymous function definition that caused a syntax error */
if (!function_exists('pluralLowerCaseName')) {
    function pluralLowerCaseName(?string $models, string $type = '-')
    {
        return implode($type, array_map([Str::class, 'lower'], array_map([Str::class, 'plural'], explode('-', $models))));
    }
}

// ارجاع الاسم مفرد => جمع
if (!function_exists('studlySingular')) {
    function studlySingular(?string $models, string $type = '')
    {
        return implode($type, array_map([Str::class, 'studly'], array_map([Str::class, 'singular'], explode('-', $models))));
    }
}

// ارجاع الاسم مفرد => جمع مفصول بشرطة
if (!function_exists('studyCapitalCaseName')) {
    function studyCapitalCaseName(?string $models, string $type = '-')
    {
        return implode($type, array_map([Str::class, 'studly'], explode('-', $models)));
    }
}

// ارجاع الاسم مفرد مفصول بشرطة
if (!function_exists('singularLowerCaseName')) {
    function singularLowerCaseName(?string $models, string $type = '-')
    {
        return implode($type, array_map([Str::class, 'lower'], array_map([Str::class, 'singular'], explode('-', $models))));
    }
}

// تحقق من وجود ملف في التخزين
if (!function_exists('checkExistFile')) {
    function checkExistFile(?string $path = null, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        return Storage::disk($disk)->exists($path);
    }
}

// تلخيص رسالة النشاط
if (!function_exists('activityMessageSummary')) {
    function activityMessageSummary($activity, $limit = 180)
    {
        $activityMessage = $activity ? ActivityMessageFormatter::summary($activity, $limit) : false;
        return $activityMessage;
    }
}

if (!function_exists('badgeClasses')) {
    function badgeClasses($event)
    {
        return match ($event) {
            'created' => 'bg-success/30 text-green-800',
            'updated' => 'bg-primary/30 text-blue-800',
            'deleted', 'force_deleted' => 'bg-danger/30 text-red-800',
            'restored' => 'bg-yellow/30 text-yellow-800',
            'error' => 'bg-danger/30 text-red-800',
            'login' => 'bg-success/30 text-green-800',
            'register' => 'bg-success/30 text-green-800',
            'logout' => 'bg-success/30 text-green-800',
            'password_reset' => 'bg-success/30 text-green-800',
            'password_update' => 'bg-success/30 text-green-800',
            'password_reset_request' => 'bg-success/30 text-green-800',
            default => 'bg-gray/30 text-gray-700',
        };
    }
}

if (!function_exists('makeTimezone')) {
    function makeTimezone($timezone)
    {
        $timezoneData = [];
        if ($timezone) {
            $timezone = trim(preg_replace('/\s*\(.*\)$/', '', $timezone));
            $tz = new \DateTimeZone($timezone);
            $now = new \DateTime("now", $tz);

            $offset = $tz->getOffset($now);
            $hours = floor($offset / 3600);
            $minutes = abs(($offset % 3600) / 60);
            $sign = $offset >= 0 ? '+' : '-';
            $gmtOffsetName = sprintf('UTC%s%02d:%02d', $sign, abs($hours), $minutes);

            $data = [
                "tzName" => $timezone,
                "zoneName" => $timezone,
                "gmtOffset" => $offset,
                "abbreviation" => $now->format('T'),
                "gmtOffsetName" => $gmtOffsetName,
            ];
            $timezoneData = [$data];
        }

        return $timezoneData;
    }
}

if (!function_exists('makeTimezone2')) {
    function makeTimezone2($timezone, $key)
    {
        $timezoneData = [];
        if ($timezone) {
            $timezone = trim(preg_replace('/\s*\(.*\)$/', '', $timezone));
            $tz = new \DateTimeZone($timezone);
            $now = new \DateTime("now", $tz);

            $offset = $tz->getOffset($now);
            $hours = floor($offset / 3600);
            $minutes = abs(($offset % 3600) / 60);
            $sign = $offset >= 0 ? '+' : '-';
            $gmtOffsetName = sprintf('UTC%s%02d:%02d', $sign, abs($hours), $minutes);

            $timezoneData = [
                "tzName" => $timezone,
                "zoneName" => $timezone,
                "gmtOffset" => $offset,
                "abbreviation" => $now->format('T'),
                "gmtOffsetName" => $gmtOffsetName,
            ];
        }

        return $timezoneData[$key] ?? null;
    }
}

if (!function_exists('shouldSendNotification')) {
    /**
     * Check if push notifications should be sent based on settings
     *
     * @return bool
     */
    function shouldSendNotification()
    {
        $settings = Setting::first();
        return $settings && $settings->app_push_notifications == 1;
    }
}

if (!function_exists('shouldSendEmail')) {
    /**
     * Check if email notifications should be sent based on settings
     *
     * @return bool
     */
    function shouldSendEmail()
    {
        $settings = Setting::first();
        return $settings && $settings->app_email_notifications == 1;
    }
}

if (!function_exists('shouldSendSms')) {
    /**
     * Check if SMS notifications should be sent based on settings
     *
     * @return bool
     */
    function shouldSendSms()
    {
        $settings = Setting::first();
        return $settings && $settings->app_sms_notifications == 1;
    }
}