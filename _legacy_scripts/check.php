<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    $cols = Schema::getColumnListing('languages');
    if (in_array('status', $cols)) {
        $langs = DB::table('languages')->where('status', 1)->pluck('code')->toArray();
        echo "Active Languages (status): " . implode(', ', $langs) . "\n";
    } elseif (in_array('is_active', $cols)) {
        $langs = DB::table('languages')->where('is_active', 1)->pluck('code')->toArray();
        echo "Active Languages (is_active): " . implode(', ', $langs) . "\n";
    } else {
        echo "No status/is_active col found. First 10: " . implode(', ', DB::table('languages')->limit(10)->pluck('code')->toArray()) . "\n";
    }
} catch (\Exception $e) { 
    echo "DB Error: " . $e->getMessage() . "\n"; 
}

$lines = file('storage/logs/laravel.log');
foreach (array_reverse($lines) as $line) {
    if (strpos($line, 'local.ERROR') !== false) {
        echo "LATEST ERROR: \n" . trim($line) . "\n";
        break;
    }
}
