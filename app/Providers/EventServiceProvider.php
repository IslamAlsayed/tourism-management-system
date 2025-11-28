<?php

namespace App\Providers;

use App\Events\RecordEvent;
use App\Events\ActivityCreated;
use App\Events\UserLoggedEvent;
use App\Listeners\HandleRecord;
use App\Listeners\HandleUserLogged;
use App\Events\ImportExportCompleted;
use Illuminate\Support\ServiceProvider;
use App\Listeners\HandleActivityCreated;
use App\Listeners\NotifyUserAfterImport;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        UserLoggedEvent::class => [
            HandleUserLogged::class,
        ],

        ActivityCreated::class => [
            HandleActivityCreated::class,
        ],

        RecordEvent::class => [
            HandleRecord::class,
        ],

        ImportExportCompleted::class => [
            NotifyUserAfterImport::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}