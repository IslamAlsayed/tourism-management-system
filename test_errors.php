<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$h = \App\Models\ImportHistory::orderBy('id', 'desc')->first();
if ($h && $h->error_log) {
    echo "Errors found:\n";
    print_r(json_decode($h->error_log, true));
} else {
    echo "No errors logged.\n";
}
