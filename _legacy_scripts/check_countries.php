<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\Geography\Entities\Country;

// Get all country names from database
$dbCountries = Country::withoutGlobalScopes()->pluck('name')->toArray();
sort($dbCountries);

echo "Total countries in DB: " . count($dbCountries) . "\n\n";

// Expected 251 countries from the spreadsheet
// Let's check the IDs
$countryIds = Country::withoutGlobalScopes()->pluck('id')->toArray();
sort($countryIds);

echo "ID range: " . min($countryIds) . " - " . max($countryIds) . "\n";
echo "Total unique IDs: " . count(array_unique($countryIds)) . "\n\n";

// Check for gaps in IDs (which IDs from 1-251 are missing)
$allIds = range(1, max($countryIds));
$missingIds = array_diff($allIds, $countryIds);

if (!empty($missingIds)) {
    echo "Missing IDs (not in DB): " . implode(', ', $missingIds) . "\n";
    echo "Count of missing IDs: " . count($missingIds) . "\n";
} else {
    echo "No gaps in IDs found.\n";
}

// Also check if there are any duplicate names
$nameCounts = array_count_values($dbCountries);
$duplicates = array_filter($nameCounts, fn($count) => $count > 1);
if (!empty($duplicates)) {
    echo "\nDuplicate country names:\n";
    foreach ($duplicates as $name => $count) {
        echo "  '$name' appears $count times\n";
    }
}

// Show last 10 countries
echo "\nLast 10 countries by ID:\n";
$lastCountries = Country::withoutGlobalScopes()->orderBy('id', 'desc')->take(10)->get(['id', 'name']);
foreach ($lastCountries as $c) {
    echo "  ID {$c->id}: {$c->name}\n";
}
