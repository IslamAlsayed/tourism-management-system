<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = \Illuminate\Http\Request::capture());

$user = \Modules\Core\Entities\User::first();
echo "User: {$user->name}\n";
echo "Roles: {$user->getRoleNames()->implode(', ')}\n";

$allPerms = $user->getAllPermissions()->pluck('name')->sort()->values();
$servicePerms = $allPerms->filter(fn($p) => str_contains($p, 'service') || str_contains($p, 'tourist'));
echo "Service-related permissions:\n";
foreach ($servicePerms as $p) {
    echo "  - $p\n";
}

echo "\nDoes user have 'manage_tourist_services'? " . ($user->can('manage_tourist_services') ? 'YES' : 'NO') . "\n";
echo "Does user have 'manage_services'? " . ($user->can('manage_services') ? 'YES' : 'NO') . "\n";
echo "Is superadmin? " . ($user->hasRole('superadmin') ? 'YES' : 'NO') . "\n";
