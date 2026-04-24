<?php

use App\Jobs\ImportDataJob;
use Illuminate\Support\Facades\DB;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Subregion;

echo "Disabling foreign keys and truncating geography tables...\n";
DB::statement('PRAGMA foreign_keys = OFF;');
City::truncate();
State::truncate();
Country::truncate();
Subregion::truncate();
Region::truncate();
DB::statement('PRAGMA foreign_keys = ON;');

$dir = 'G:\\MixJo 2025 Datafiles-2026-012-5-1-001\\MixJo 2025 Datafiles\\regions   جغرافيا';

$files = [
    [Region::class, $dir.'\\regions.xlsx'],
    [Subregion::class, $dir.'\\subregions.xlsx'],
    [Country::class, $dir.'\\countries.csv'],
    [State::class, $dir.'\\states.xlsx'],
    [City::class, $dir.'\\cities.xlsx'],
];

foreach ($files as $file) {
    if (file_exists($file[1])) {
        echo 'Importing '.class_basename($file[0])."...\n";
        try {
            ImportDataJob::dispatchSync($file[0], $file[1], 1000, 1);
            echo 'Finished importing '.class_basename($file[0]).".\n";
            echo class_basename($file[0]).' count: '.$file[0]::count()."\n\n";
        } catch (\Exception $e) {
            echo 'Error importing '.class_basename($file[0]).': '.$e->getMessage()."\n\n";
        }
    } else {
        echo 'File not found: '.$file[1]."\n\n";
    }
}
