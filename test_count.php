<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Count: " . \DB::table('countries')->count() . PHP_EOL;
$c = \DB::table('countries')->latest('id')->first();
echo "Latest ID: " . $c->id . " UUID: " . ($c->uuid ?? 'NULL') . PHP_EOL;
