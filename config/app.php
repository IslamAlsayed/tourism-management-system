<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),
    'paginate_array' => ['all', 5, 10, 25, 50, 100, 500],
    'paginate_max' => env('PAGINATE_MAX', 10000),
    'paginate_count' => (int) env('PAGINATE_COUNT', 25),
    'excel_export_format' => env('EXCEL_EXPORT_FORMAT', 'xlsx'),
    'app_theme' => env('APP_THEME', 'system'),

    'app_name' => env('APP_NAME', 'laravel'),
    'app_url' => env('APP_URL', 'http://localhost'),
    'app_timezone' => env('APP_TIMEZONE', 'Africa/Cairo'),
    'app_language' => env('APP_LANGUAGE', 'en'),
    'app_version' => env('APP_VERSION', '4.5.0'),
    'app_php_version' => env('APP_PHP_VERSION', '8.2.28'),
    'app_columns_length' => env('APP_COLUMNS_LENGTH', 6),
    'app_status' => env('APP_STATUS', true),
    'app_minimum_password_length' => env('APP_MINIMUM_PASSWORD_LENGTH', 8),
    'app_session_lifetime' => env('SESSION_LIFETIME', 120),
    'app_password_confirmation' => env('APP_PASSWORD_CONFIRMATION', true),
    'app_backup_frequency' => env('APP_BACKUP_FREQUENCY', 'weekly'),
    'app_email_notification' => env('APP_EMAIL_NOTIFICATION', false),
    'app_push_notification' => env('APP_PUSH_NOTIFICATION', false),
    'app_sms_notification' => env('APP_SMS_NOTIFICATION', false),
    'app_sidebar_width' => env('APP_SIDEBAR_WIDTH', 290),
    'idle_timeout' => env('IDLE_TIMEOUT', 1800000),
    'ably_key' => env('ABLY_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'Africa/Cairo'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];