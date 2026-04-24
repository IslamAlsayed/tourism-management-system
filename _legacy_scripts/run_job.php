<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\DB::enableQueryLog();

try {
    $job = new \App\Jobs\ImportDataJob(
        \Modules\Geography\Entities\Country::class, 
        storage_path('app/public/excels/imports/countries/countries_2026_03_18_07_37_41_drive.csv'), 
        1000, 
        1
    );
    dispatch_sync($job);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$queries = \DB::getQueryLog();
// Get the last 15 queries related to countries
$countryQueries = array_filter($queries, function($q) { return stripos($q['query'], 'countries') !== false; });
echo "Total core country queries: " . count($countryQueries) . "\n";
foreach (array_slice($countryQueries, -10) as $q) {
    echo $q['query'] . " | " . json_encode($q['bindings']) . "\n";
}

echo "Count: " . \DB::table('countries')->count() . PHP_EOL;
