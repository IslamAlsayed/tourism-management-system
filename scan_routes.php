<?php

define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);
$kernel->terminate($request, $response);

$routesToTest = [
    '/dashboard',
    '/dashboard/restaurants',
    '/dashboard/restaurants/types',
    '/dashboard/restaurants/meals',
    '/dashboard/restaurants/supplements',
    '/dashboard/accommodations',
    '/dashboard/tourguides/guides',
    '/dashboard/tourguides/guides-types',
    '/dashboard/tourists/sites',
    '/dashboard/tourists/services',
    '/dashboard/tourists/facilities',
    '/dashboard/media-files',
    '/dashboard/geography/countries',
    '/dashboard/geography/states',
    '/dashboard/geography/cities',
    '/dashboard/geography/regions',
    '/dashboard/geography/subregions',
    '/dashboard/localization/languages',
    '/dashboard/localization/currencies',
    '/dashboard/localization/timezones',
    '/dashboard/accommodations/seasons',
    '/dashboard/localization/pricing-units',
    '/dashboard/core/users',
    '/dashboard/core/roles',
    '/dashboard/core/activity-log',
];

$errors = [];
$ok = [];

echo "=== DASHBOARD ROUTE SCAN ===\n\n";

$user = \Modules\Core\Entities\User::first();
if ($user) {
    auth()->login($user);
    echo "Logged in as: " . $user->email . "\n\n";
} else {
    echo "WARNING: No user found\n\n";
}

foreach ($routesToTest as $uri) {
    $req = Illuminate\Http\Request::create($uri, 'GET');
    auth()->setUser($user);
    try {
        $resp = $kernel->handle($req);
        $status = $resp->getStatusCode();
        if ($status >= 500) {
            $content = $resp->getContent();
            preg_match('/<title[^>]*>(.*?)<\/title>/s', $content, $m1);
            // Also try to find error class message
            preg_match('/class="exception-message-wrapper"[^>]*>.*?<span>(.*?)<\/span>/s', $content, $m2);
            // Also try FatalError pattern
            preg_match('/FatalError[^\n]*\n\n\s+(.*?)(?:\n|at )/s', $content, $m3);
            $msg = trim(strip_tags($m3[1] ?? $m2[1] ?? $m1[1] ?? 'Unknown 500 error'));
            $errors[] = ['url' => $uri, 'status' => $status, 'error' => substr($msg, 0, 250)];
            echo "FAIL [{$status}] {$uri}\n       => " . substr($msg, 0, 200) . "\n";
        } elseif ($status >= 400) {
            echo "WARN [{$status}] {$uri}\n";
            $errors[] = ['url' => $uri, 'status' => $status, 'error' => "HTTP {$status}"];
        } else {
            echo "OK   [{$status}] {$uri}\n";
            $ok[] = $uri;
        }
    } catch (\Throwable $e) {
        $errors[] = ['url' => $uri, 'status' => 'EXCEPTION', 'error' => $e->getMessage()];
        echo "FAIL [EXC] {$uri}\n       => " . substr($e->getMessage(), 0, 200) . "\n";
    }
}

echo "\n=== SUMMARY ===\n";
echo "OK:     " . count($ok) . " routes\n";
echo "ERRORS: " . count($errors) . " routes\n\n";
if (!empty($errors)) {
    echo "=== BROKEN ROUTES ===\n";
    foreach ($errors as $err) {
        echo "[{$err['status']}] {$err['url']}\n  => {$err['error']}\n\n";
    }
}
