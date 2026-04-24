<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\DB::enableQueryLog();

$modelClass = \Modules\Geography\Entities\Country::class;
$matchCondition = ['id' => 51];
$updateCols = ['name' => 'Test Country', 'iso2' => 'TC', 'iso3' => 'TST', 'phone_code' => 123];

$modelClass::withoutEvents(function () use ($modelClass, $matchCondition, $updateCols) {
    $record = $modelClass::firstOrNew($matchCondition);
    if (!$record->exists) {
        $record->uuid = (string) \Illuminate\Support\Str::uuid();
        echo "Record is new, UUID generated: " . $record->uuid . "\n";
    } else {
        echo "Record exists\n";
    }
    
    $record->fill($updateCols);
    $result = $record->save();
    
    echo "Save result: " . ($result ? 'true' : 'false') . "\n";
});

$queries = \DB::getQueryLog();
foreach ($queries as $q) {
    echo $q['query'] . " | " . json_encode($q['bindings']) . "\n";
}
