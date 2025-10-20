<?php

namespace App\Listeners;

use App\Events\ImportExportCompleted;
use Illuminate\Support\Facades\Cache;

class NotifyUserAfterImport
{
    public function handle(ImportExportCompleted $event): void
    {
        Cache::put('import_message', $event->message, now()->addMinute());
    }
}