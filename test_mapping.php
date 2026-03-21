<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$reader = \Spatie\SimpleExcel\SimpleExcelReader::create(storage_path('app/public/excels/imports/countries/countries_2026_03_18_07_37_41_drive.csv'));
$rows = $reader->getRows();
$model = new \Modules\Geography\Entities\Country;
$fillable = $model->getFillable();

$counter = 0;
foreach ($rows as $data) {
    if ($counter >= 50 && $counter <= 52) { // Inspect rows around ID 52
        echo "Raw Data keys: " . implode(',', array_keys($data)) . "\n";
        echo "Data for row " . ($counter+1) . " (ID " . ($data['id'] ?? 'none') . "):\n";
        
        $filtered = [];
        foreach ($data as $key => $value) {
            $allowedOrig = in_array($key, $fillable) ? $key : null;
            if ($allowedOrig) {
                $filtered[$allowedOrig] = $value;
            } else {
                // simple mapping logic ...
                if ($key == 'curancy_id') $filtered['currency_id'] = $value;
            }
        }
        echo "Filtered keys: " . implode(',', array_keys($filtered)) . "\n";
        print_r($filtered);
    }
    $counter++;
}
