<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Modules\Geography\Entities\Region;

// SQLite way to disable foreign keys per transaction
DB::statement('PRAGMA foreign_keys = OFF;');

$regions = Region::orderBy('id')->get();

echo "Current regions in DB:\n";
foreach ($regions as $r) {
    echo "ID: {$r->id} - Name: {$r->name}\n";
}

$i = 1;
foreach ($regions as $region) {
    if ($region->id != $i) {
        $oldId = $region->id;
        $newId = $i;
        
        // Update the region
        DB::table('regions')->where('id', $oldId)->update(['id' => $newId]);
        
        // Update subregions pointing to this region
        DB::table('subregions')->where('region_id', $oldId)->update(['region_id' => $newId]);
        
        echo "Updated Region {$region->name} from ID {$oldId} to {$newId}\n";
    }
    $i++;
}

// Fixed auto increment logic
// If there are regions, max id, otherwise 0
$maxId = Region::max('id') ?? 0;

// Reset auto increment sequence for SQLite
DB::statement("UPDATE sqlite_sequence SET seq = {$maxId} WHERE name = 'regions';");
echo "Reset regions auto increment to {$maxId}\n";

// Re-enable foreign key checks
DB::statement('PRAGMA foreign_keys = ON;');
echo "Done.\n";
