<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$histories = \App\Models\ImportHistory::orderBy('id', 'desc')->take(3)->get();
foreach ($histories as $h) {
    echo "ID: " . $h->id . " File: " . $h->file_name . " Status: " . $h->status . " Total: " . $h->total_records . " Processed: " . $h->processed_records . " Error: " . $h->error_message . PHP_EOL;
}
