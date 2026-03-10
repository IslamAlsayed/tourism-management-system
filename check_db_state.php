<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$regions = \Modules\Geography\Entities\Region::all();
echo "Regions Count: " . $regions->count() . "\n";
foreach($regions as $r) {
    echo "{$r->id}: {$r->name} (" . ($r->is_active ? 'Active' : 'Inactive') . ")\n";
}

$subregions = \Modules\Geography\Entities\Subregion::count();
echo "Subregions Count: $subregions\n";
