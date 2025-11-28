<?php

namespace App\Providers;

use App\Models\Setting;
use App\Events\ActivityCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use App\Services\Activity\ModelActivityLogger;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!config('activitylog.enabled') || !config('activitylog.auto_log_models.enabled')) {
            return;
        }

        if (!Schema::hasTable(config('activitylog.table_name', 'activity_log'))) {
            return;
        }

        // Check if activity log is enabled in settings
        $settings = Setting::first();
        if (!$settings || !$settings->app_activity_log_enabled) {
            return;
        }

        $logger = $this->app->make(ModelActivityLogger::class);

        $events = [
            'eloquent.created: *' => 'created',
            'eloquent.updated: *' => 'updated',
            'eloquent.deleted: *' => 'deleted',
            'eloquent.restored: *' => 'restored',
            'eloquent.forceDeleted: *' => 'force_deleted',
        ];

        foreach ($events as $eloquentEvent => $activityEvent) {
            Event::listen($eloquentEvent, function (string $eventName, array $payload) use ($logger, $activityEvent): void {
                $model = $payload[0] ?? null;
                if (!$model instanceof Model) {
                    return;
                }
                $logger->log($model, $activityEvent);
            });
        }

        // Broadcast when a new activity is created
        Activity::created(function ($activity) {
            if (!app()->runningInConsole()) {
                broadcast(new ActivityCreated($activity));
            }
        });
    }
}