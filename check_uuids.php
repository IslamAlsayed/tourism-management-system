<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SELECT name FROM sqlite_master WHERE type="table"');
$missing = [];
$ignored_tables = ['migrations', 'sqlite_sequence', 'failed_jobs', 'password_reset_tokens', 'personal_access_tokens', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches'];

foreach($tables as $t) {
    if (in_array($t->name, $ignored_tables)) {
        continue;
    }
    
    $cols = DB::select('PRAGMA table_info(' . $t->name . ')');
    $hasUuid = false;
    foreach($cols as $c) {
        if($c->name == 'uuid') {
            $hasUuid = true;
            break;
        }
    }
    
    if(!$hasUuid) {
        $missing[] = $t->name;
    }
}

echo "Tables missing UUID column:\n";
echo str_repeat('-', 30) . "\n";
echo implode("\n", $missing);
echo "\n";
