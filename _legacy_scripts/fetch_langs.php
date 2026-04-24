<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "--- SETTINGS ---\n";
try {
    $settings = DB::table('settings')->where('key', 'like', '%lang%')->get();
    foreach ($settings as $s) {
        echo $s->key . ": " . $s->value . "\n";
    }
} catch (\Exception $e) { echo "Settings Error\n"; }

echo "\n--- PKG CONFIGS ---\n";
if (config()->has('translation.locales')) {
    echo "translation.locales: " . implode(',', config('translation.locales')) . "\n";
}
if (config()->has('laravellocalization.supportedLocales')) {
    echo "laravellocalization: " . implode(',', array_keys(config('laravellocalization.supportedLocales'))) . "\n";
}
if (config()->has('app.locales')) {
    echo "app.locales: " . implode(',', config('app.locales')) . "\n";
}

echo "\n--- MODELS ---\n";
try {
    if (class_exists('\App\Models\Language')) {
        $cols = \Illuminate\Support\Facades\Schema::getColumnListing('languages');
        if (in_array('status', $cols)) {
            $langs = \App\Models\Language::where('status', 1)->pluck('code')->toArray();
            echo "Language::status=1: " . implode(',', $langs) . "\n";
        } elseif (in_array('is_active', $cols)) {
            $langs = \App\Models\Language::where('is_active', 1)->pluck('code')->toArray();
            echo "Language::is_active=1: " . implode(',', $langs) . "\n";
        }
    }
} catch (\Exception $e) { }
