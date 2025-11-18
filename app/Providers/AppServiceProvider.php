<?php

namespace App\Providers;

use App\Models\MediaFile;
use App\Observers\MediaFileObserver;
use App\Events\ImportExportCompleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Listeners\NotifyUserAfterImport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تسجيل الـ Event والـ Listener
        Event::listen(
            ImportExportCompleted::class,
            NotifyUserAfterImport::class
        );

        MediaFile::observe(MediaFileObserver::class);
    }
}