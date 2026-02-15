<?php

namespace App\Traits;

use Modules\Core\Entities\Setting;
use App\Events\RecordEvent;
use Illuminate\Support\Facades\Schema;

trait BroadcastsRecordEvents
{
    /**
     * Boot the BroadcastsRecordEvents trait for a model.
     */
    protected static function bootBroadcastsRecordEvents(): void
    {
        // Trait responsibilities: only fire RecordEvent for model lifecycle events.
        // Unified notification creation & broadcasting lives in the HandleRecord listener.

        // Broadcast when a model is created
        static::created(function ($model) {
            if (Schema::hasTable('settings')) {
                $settings = Setting::withoutGlobalScopes()->first();
                if ($settings && $settings->app_notifications_new_record == 1) {
                    $user = getActiveUser();
                    if ($user && !app()->runningInConsole()) {
                        $modelType = strtolower(class_basename($model));
                        event(new RecordEvent('created', $model, $modelType));
                    }
                }
            }
        });

        // Broadcast when a model is updated
        static::updated(function ($model) {
            if (Schema::hasTable('settings')) {
                $settings = Setting::withoutGlobalScopes()->first();
                if ($settings && $settings->app_notifications_data_updates == 1) {
                    $user = getActiveUser();
                    if ($user && !app()->runningInConsole()) {
                        $modelType = strtolower(class_basename($model));
                        event(new RecordEvent('updated', $model, $modelType));
                    }
                }
            }
        });

        // Broadcast when a model is deleted
        static::deleted(function ($model) {
            if (Schema::hasTable('settings')) {
                $settings = Setting::withoutGlobalScopes()->first();
                if ($settings && $settings->app_notifications_data_deletes == 1) {
                    $user = getActiveUser();
                    if ($user && !app()->runningInConsole()) {
                        $modelType = strtolower(class_basename($model));
                        event(new RecordEvent('deleted', $model, $modelType));
                    }
                }
            }
        });
    }
}
