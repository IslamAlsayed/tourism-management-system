<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\Subregion;

try {
    Subregion::truncate();
    echo "Subregions truncated.\n";
    Region::truncate();
    echo "Regions truncated.\n";

    DB::statement("DELETE FROM sqlite_sequence WHERE name='regions'");
    echo "Sequence for regions deleted.\n";
    DB::statement("DELETE FROM sqlite_sequence WHERE name='subregions'");
    echo "Sequence for subregions deleted.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
