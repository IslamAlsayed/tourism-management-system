<?php

use Modules\Core\Entities\User;
use Modules\Core\Entities\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Support\Activity\ActivityMessageFormatter;

if (!function_exists('getActiveUser')) {
    /**
     * Get the currently authenticated user or a user by ID.
     * Checks authentication first.
     *
     * @param int|null $id
     * @return \Modules\Core\Entities\User|null
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
if (!function_exists('getActiveUserId')) {
    /**
     * Get the currently authenticated user's ID.
     * Checks authentication first.
     *
     * @param int|null $id
     * @return \Modules\Core\Entities\User|null
     */
    function getActiveUserId($id = null)
    {
        if (!Auth::check()) {
            return null;
        }

        if ($id != null) {
            $user = User::find($id);
            return $user ? $user->id : null;
        }

        return Auth::id();
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
        static $cached = null;
        static $resolved = false;

        if (!$resolved) {
            $cached = Setting::first();
            $resolved = true;
        }

        return $cached;
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
     * Check if a locale is RTL (Right-to-Left).
     * First checks the system_languages DB table, then falls back to a hardcoded list.
     *
     * @param string|null $locale
     * @return bool
     */
    function isRtlLocale($locale = null)
    {
        $locale = $locale ?? getCurrentLocale();
        $baseLocale = explode('-', str_replace('_', '-', $locale))[0];

        // Try DB first (cached per request)
        static $dbDirCache = [];
        if (!isset($dbDirCache[$locale])) {
            try {
                $lang = \Modules\Localization\Entities\SystemLanguage::where('code', $locale)->first();
                $dbDirCache[$locale] = $lang ? $lang->dir : null;
            } catch (\Throwable $e) {
                $dbDirCache[$locale] = null;
            }
        }
        if ($dbDirCache[$locale] !== null) {
            return $dbDirCache[$locale] === 'rtl';
        }

        // Comprehensive RTL language codes (Smartling + CLDR standards)
        $rtlLocales = [
            'ar', 'he', 'fa', 'ur', 'yi', 'ps', 'ug', 'ku', 'sd',
            'dv', 'ks', 'ckb', 'syr', 'arc', 'nqo', 'ks', 'khw',
            'bal', 'lah', 'iw', 'kd',
            // Arabic variants
            'ar-AE', 'ar-BH', 'ar-DJ', 'ar-DZ', 'ar-EG', 'ar-IQ',
            'ar-JO', 'ar-KW', 'ar-LB', 'ar-LY', 'ar-MA', 'ar-OM',
            'ar-QA', 'ar-SA', 'ar-SD', 'ar-SY', 'ar-TN', 'ar-YE',
            // Persian variants
            'fa-AF', 'fa-IR',
            // Hebrew variants
            'he-IL',
            // Urdu variants
            'ur-IN', 'ur-PK',
            // Yiddish variants
            'yi-US',
            // Panjabi-Shahmuki
            'pk-PK',
        ];

        return in_array($locale, $rtlLocales) || in_array($baseLocale, $rtlLocales);
    }
}

if (!function_exists('getLocaleDirection')) {
    /**
     * Get the text direction for a locale ('rtl' or 'ltr')
     */
    function getLocaleDirection($locale = null)
    {
        return isRtlLocale($locale) ? 'rtl' : 'ltr';
    }
}

// تحقق من كون الراوت الحالي هو الراوت المحدد مع إمكانية التحقق من البراميترز
if (!function_exists('isActive')) {
    function isActive(?string $route, array $menuParameters = [], ?string $currentRoute = null, array $currentParameters = [])
    {
        if (!$route || $route !== $currentRoute) {
            return false;
        }

        // لو المينيو مفيهوش parameters → route match يكفي
        if (empty($menuParameters)) {
            return true;
        }

        // parameters الحالية (route + query)
        $requestParams = array_merge(request()->route()?->parameters() ?? [], request()->query() ?? []);

        foreach ($menuParameters as $key => $value) {
            // تجاهل أي key رقمي (زي Str::random)
            if (is_int($key)) {
                continue;
            }

            // لو المينيو متوقع parameter مش موجود في الطلب → تجاهله
            if (!array_key_exists($key, $requestParams)) {
                continue;
            }

            // لو موجود بس القيمة مختلفة → مش active
            if ((string) $requestParams[$key] !== (string) $value) {
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

// تحقق من وجود راوت نشط بين الأطفال
if (!function_exists('hasActiveChild')) {
    function hasActiveChild(array $children, ?string $currentRoute, array $currentParameters)
    {
        foreach ($children as $child) {
            if (isActive($child['route'] ?? null, $child['parameters'] ?? [], $currentRoute, $currentParameters)) {
                return true;
            }

            if (
                isset($child['children']) &&
                hasActiveChild($child['children'], $currentRoute, $currentParameters)
            ) {
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

// تحقق من وجود دالة show في الكنترولر الخاص بالريسورس
if (!function_exists('showFunctionExists')) {

    function showFunctionExists(string $routeName): bool
    {
        try {
            $parts = explode('.', $routeName);

            // Determine module & resource
            if (count($parts) === 2) {
                [$module, $resource] = $parts;
            } else {
                $module = null;
                $resource = $parts[0];
            }

            $resource = str_replace('.', '\\', $routeName);
            $controller = studlyCaseName($resource) . 'Controller';

            $possibleControllers = array_filter([
                $module ? "App\\Http\\Controllers\\Dashboard\\$controller" : null,
                $module ? "App\\Http\\Controllers\\$controller" : null,
                "App\\Http\\Controllers\\Dashboard\\$controller",
                "App\\Http\\Controllers\\$controller",
            ]);

            foreach ($possibleControllers as $class) {
                if (class_exists($class)) {
                    return method_exists($class, 'show');
                }
            }
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }
}

// اخر حاجه شغاله
// if (!function_exists('showFunctionExists')) {
//     /**
//      * Check if a 'show' method exists in the controller for a given resource.
//      *
//      * @param string $resource
//      * @return bool
//      */
//     function showFunctionExists(string $resource)
//     {
//         try {
//             // Convert resource name to controller name (e.g., 'tour-guides' => 'TourGuidesController')
//             $controllerName = singularLowerCaseName($resource, '') . 'Controller';
//             dd($controllerName, class_basename($controllerName));
//             $controllerClass = 'App\\Http\\Controllers\\' . $controllerName;
//             $controllerClassDashboard = 'App\\Http\\Controllers\\Dashboard\\' . $controllerName;

//             if (!class_exists($controllerClass) && !class_exists($controllerClassDashboard)) {
//                 return false;
//             }

//             return method_exists($controllerClass, 'show') || method_exists($controllerClassDashboard, 'show');
//         } catch (\Exception $e) {
//             return false;
//         }
//     }
// }

if (!function_exists('generateUniqueFilename')) {
    function generateUniqueFilename($prefix = 'data')
    {
        // return $prefix . '_' . substr(md5(uniqid(mt_rand(), true)), 0, 6);
        return $prefix . '_' . date('Y_m_d_H_i_s');
    }
}

if (!function_exists('generateCode')) {
    function generateCode($prefix = 'CODE-', $length = 5)
    {
        $max = (int) str_repeat('9', $length);
        $randomNum = random_int(1, $max);
        $paddedNum = str_pad($randomNum, $length, '0', STR_PAD_LEFT);
        return $prefix . $paddedNum;
    }
}

if (!function_exists('getPaginate')) {
    function getPaginate()
    {
        $settings = getActiveSettings();
        return (int) session('paginate_count', optional($settings)->app_paginate_count ?? config('app.paginate_count'));
    }
}

if (!function_exists('highlightSearch')) {
    function highlightSearch(?string $html, ?string $search = null): string
    {
        if (!$html) {
            return '';
        }

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

// تحويل نوع الموديل إلى نص مفصول بشرطة
if (!function_exists('modelTypeToString')) {

    function modelTypeToString(?string $modelType, string $separator = '-'): ?string
    {
        if (!$modelType) {
            return null;
        }

        // Get class name only (TransportationCompany)
        $className = class_basename($modelType);

        // Split CamelCase into words
        preg_match_all('/[A-Z][a-z]*/', $className, $matches);
        $parts = $matches[0];

        // Convert to lowercase
        $parts = array_map(fn($part) => Str::lower($part), $parts);

        // Join with requested separator
        return implode($separator, $parts);
    }
}

// تحويل نوع الموديل إلى مسار الراوت
if (!function_exists('modelTypeToRoute')) {

    function modelTypeToRoute(?string $modelType, bool $plural = true, ?string $separator = '.'): string|null
    {
        if (!$modelType)
            return null;

        $className = class_basename($modelType);

        // Split CamelCase words
        preg_match_all('/[A-Z][a-z]*/', $className, $matches);
        $parts = $matches[0];

        // Case: Single word model (Season, City, User)
        if (count($parts) === 1) {
            $resource = Str::kebab($parts[0]);
            return $plural ? Str::plural($resource) : Str::singular($resource);
        }

        // Known domain prefixes that should use dot separator
        $knownDomains = ['transportation', 'accommodation', 'tour'];

        // Convert all parts to kebab-case
        $kebabParts = array_map(fn($p) => Str::kebab($p), $parts);

        // Check if first part is a known domain
        if (in_array($kebabParts[0], $knownDomains)) {
            // Domain.Resource pattern (e.g., transportation.companies)
            $domain = pluralLowerCaseName(array_shift($kebabParts));
            $resource = implode('-', $kebabParts);
            $resource = $plural ? Str::plural($resource) : Str::singular($resource);
            return $domain . $separator . $resource;
        }

        // Default: join all parts with hyphen (e.g., tour-guides, tour-guide-types)
        $resource = implode('-', $kebabParts);
        $resource = $plural ? Str::plural($resource) : Str::singular($resource);
        return $resource;
    }
}


// if (!function_exists('modelTypeToRoute')) {
//     function modelTypeToRoute(?string $modelType, bool $plural = true): ?string
//     {
//         if (!$modelType) {
//             return null;
//         }

//         $className = class_basename($modelType);

//         // Split by capital letters
//         preg_match_all('/[A-Z][a-z]*/', $className, $matches);
//         $parts = $matches[0];

//         if (count($parts) < 2) {
//             return Str::kebab($className);
//         }

//         $domain = Str::kebab(array_shift($parts));
//         $resource = Str::kebab(implode('', $parts));
//         $resource = $plural
//             ? Str::plural($resource)
//             : Str::singular($resource);
//         return "{$domain}.{$resource}";
//     }
// }


// دي اخر حاجه شغاله
// if (!function_exists('modelTypeToRoute')) {
//     function modelTypeToRoute(?string $modelType, bool $plural = false): ?string
//     {
//         if (!$modelType)
//             return null;

//         $name = Str::kebab(class_basename($modelType));
//         return $plural ? Str::plural($name) : Str::singular($name);
//     }
// }


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
        return implode($type, array_map([Str::class, 'lower'], array_map([Str::class, 'plural'], explode($type, $models))));
    }
}

// ارجاع الاسم مفرد => جمع
if (!function_exists('studlyCaseName')) {
    function studlyCaseName(?string $models, string $glue = '')
    {
        if (!$models)
            return null;

        return implode($glue, array_map(
            fn($item) => Str::studly(Str::singular($item)),
            preg_split('/[.\-_]/', $models)
        ));
    }
}

// ارجاع الاسم مفرد => جمع مفصول بشرطة
if (!function_exists('pluralCaseName')) {
    function pluralCaseName(?string $models, string $glue = '-', bool $lower = false)
    {
        if (!$models)
            return null;

        return implode($glue, array_map(
            fn($item) => $lower ? Str::lower(Str::studly($item)) : Str::studly($item),
            preg_split('/[.\-_]/', $models)
        ));
    }
}

// ارجاع الاسم مفرد مفصول بشرطة
if (!function_exists('singularLowerCaseName')) {
    function singularLowerCaseName(?string $models, string $glue = '-')
    {
        if (!$models)
            return null;

        return implode($glue, array_map(
            fn($item) => Str::lower(Str::singular($item)),
            preg_split('/[.\-_]/', $models)
        ));
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
        $event = str_replace('event_', '', strtolower($event));
        return match ($event) {
            'created', 'create', 'register', 'signup' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/50 px-2.5 py-1 rounded-md font-bold',
            'updated', 'update', 'edit' => 'bg-blue-50 text-blue-700 border border-blue-200/50 px-2.5 py-1 rounded-md font-bold',
            'deleted', 'delete', 'force_deleted', 'destroy' => 'bg-rose-50 text-rose-700 border border-rose-200/50 px-2.5 py-1 rounded-md font-bold',
            'restored', 'restore' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/50 px-2.5 py-1 rounded-md font-bold',
            'error', 'failed', 'exception', 'critical' => 'bg-red-600 text-white shadow-sm px-2.5 py-1 rounded-md font-bold',
            'login', 'signin' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/50 px-2.5 py-1 rounded-md font-bold',
            'logout', 'signout' => 'bg-amber-50 text-amber-700 border border-amber-200/50 px-2.5 py-1 rounded-md font-bold',
            'password_reset', 'password_update', 'password_reset_request' => 'bg-purple-50 text-purple-700 border border-purple-200/50 px-2.5 py-1 rounded-md font-bold',
            'login_failed' => 'bg-rose-700 text-white px-2.5 py-1 rounded-md font-bold',
            'download', 'export' => 'bg-teal-50 text-teal-700 border border-teal-200/50 px-2.5 py-1 rounded-md font-bold',
            'view', 'show' => 'bg-slate-100 text-slate-700 border border-slate-200/50 px-2.5 py-1 rounded-md font-bold',
            default => 'bg-gray-50 text-gray-600 border border-gray-200/50 px-2.5 py-1 rounded-md font-bold shadow-sm',
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

if (!function_exists('randomToken')) {
    /**
     * Generate a random token string
     *
     * @return string
     */
    function randomToken($length = 120)
    {
        return Str::random($length);
    }
}

if (!function_exists('hasDisplayableRichText')) {
    /**
     * Check if a record has displayable content in a specific column
     *
     * @return bool
     */
    function hasDisplayableRichText($record = null, string $column = 'description'): bool
    {
        if (! $record || ! isset($record->$column)) {
            return false;
        }

        $body = $record->$column->body ?? '';

        // شيل HTML
        $text = strip_tags($body);

        // شيل &nbsp; والمسافات الغير مرئية
        $text = preg_replace('/\xc2\xa0|\s+/u', '', $text);

        return $text !== '';
    }

    // function hasDisplayableDescAndNotes($record = null, $column = 'description')
    // {
    //     if (!$record || !isset($record->$column)) {
    //         return false;
    //     }
    //     return isset($record->$column->body->fragment->source->textContent) &&
    //         !empty($record->$column->body->fragment->source->textContent);
    // }
}

if (!function_exists('truncateWithReset')) {
    /**
     * Truncate a model's table and reset AUTO_INCREMENT to 1
     * 
     * Note: This function tries multiple approaches to reset AUTO_INCREMENT:
     * 1. DELETE FROM table (recommended for InnoDB with persistent AUTO_INCREMENT)
     * 2. ALTER TABLE to reset AUTO_INCREMENT value
     * 3. TRUNCATE TABLE as fallback
     *
     * @param string|object $model Model class name or instance
     * @param bool $disableForeignKeys Whether to disable foreign key checks
     * @return void
     */
    function truncateWithReset($model, $disableForeignKeys = true)
    {
        // Get model instance if class name was provided
        if (is_string($model)) {
            $model = new $model;
        }

        $tableName = $model->getTable();

        if ($disableForeignKeys) {
            \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        }

        try {
            // Method 1: Use DELETE instead of TRUNCATE for better AUTO_INCREMENT reset
            // This works better with InnoDB's persistent AUTO_INCREMENT
            \Illuminate\Support\Facades\DB::table($tableName)->delete();

            // Reset AUTO_INCREMENT to 1
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE `{$tableName}` AUTO_INCREMENT = 1");
        } catch (\Exception $e) {
            // Fallback: Try traditional truncate if delete fails
            try {
                $model::truncate();
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `{$tableName}` AUTO_INCREMENT = 1");
            } catch (\Exception $innerException) {
                // Log the error but don't throw - let the seeder continue
                \Illuminate\Support\Facades\Log::warning("Failed to truncate table {$tableName}: " . $innerException->getMessage());
            }
        }

        if ($disableForeignKeys) {
            \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        }
    }
}

if (!function_exists('showToastInfoMessage')) {
    function showToastInfoMessage($message)
    {
        if (function_exists('addToastInfo')) {
            addToastInfo($message);
        }
    }
}

if (!function_exists('showToastSuccessMessage')) {
    function showToastSuccessMessage($message)
    {
        if (function_exists('addToastSuccess')) {
            addToastSuccess($message);
        }
    }
}

if (!function_exists('showToastWarningMessage')) {
    function showToastWarningMessage($message)
    {
        if (function_exists('addToastWarning')) {
            addToastWarning($message);
        }
    }
}

if (!function_exists('showToastErrorMessage')) {
    function showToastErrorMessage($message)
    {
        if (function_exists('addToastError')) {
            addToastError($message);
        }
    }
}
