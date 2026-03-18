<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = Schema::getTableListing();
$allColumns = [];

foreach ($tables as $table) {
    if (is_object($table)) {
        // Handle SQLite where $table is an object
        $tablename = $table->name;
    } else {
        $tablename = $table;
    }
    
    $columns = Schema::getColumnListing($tablename);
    foreach ($columns as $column) {
        $allColumns[$column] = true;
    }
}

$uniqueColumns = array_keys($allColumns);
sort($uniqueColumns);

echo "Found " . count($uniqueColumns) . " unique columns.\n\n";

$translationArray = [];
foreach ($uniqueColumns as $col) {
    $humanReadable = ucwords(str_replace('_', ' ', $col));
    $translationArray[$col] = $humanReadable;
}

$sample = array_slice($translationArray, 0, 10);
print_r($sample);

file_put_contents('storage/logs/all_columns.json', json_encode($translationArray, JSON_PRETTY_PRINT));
echo "\nSaved full list to storage/logs/all_columns.json\n";
