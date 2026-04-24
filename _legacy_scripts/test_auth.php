<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \Modules\Core\Entities\User::where('email', 'tawfiq@example.com')->first();
$nationality = \Modules\Geography\Entities\Nationality::first();

echo "=== Direct checkPermissionTo test ===" . PHP_EOL;
try {
    $result = $user->checkPermissionTo('view');
    echo "checkPermissionTo('view'): " . ($result ? 'YES' : 'NO') . PHP_EOL;
} catch (\Spatie\Permission\Exceptions\UnauthorizedException $e) {
    echo "UnauthorizedException: " . $e->getMessage() . PHP_EOL;
} catch (\Exception $e) {
    echo "Exception (" . get_class($e) . "): " . $e->getMessage() . PHP_EOL;
}

// Simulate what Spatie's Gate::before does exactly
echo PHP_EOL . "=== Spatie Gate::before simulation ===" . PHP_EOL;
$args = [$nationality];
$ability = 'view';

if (is_string($args[0] ?? null) && !class_exists($args[0])) {
    echo "Would shift guard" . PHP_EOL;
    $guard = array_shift($args);
} else {
    echo "Args[0] is not a guard string, guard=null" . PHP_EOL;
    $guard = null;
}

if (method_exists($user, 'checkPermissionTo')) {
    echo "User has checkPermissionTo method" . PHP_EOL;
    try {
        $result = $user->checkPermissionTo($ability, $guard);
        echo "checkPermissionTo returned: " . var_export($result, true) . PHP_EOL;
        $final = $result ?: null;
        echo "After ?: null: " . var_export($final, true) . PHP_EOL;
    } catch (\Exception $e) {
        echo "EXCEPTION in checkPermissionTo: " . get_class($e) . " - " . $e->getMessage() . PHP_EOL;
    }
}
