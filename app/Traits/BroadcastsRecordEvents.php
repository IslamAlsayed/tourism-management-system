<?php

namespace App\Traits;

use App\Models\Setting;
use App\Events\RecordEvent;

trait BroadcastsRecordEvents
{
    /**
     * Boot the BroadcastsRecordEvents trait for a model.
     */
    protected static function bootBroadcastsRecordEvents(): void
    {
        // Get settings once for performance
        $settings = Setting::first();

        // Broadcast when a model is created
        static::created(function ($model) use ($settings) {
            if (!$settings || !$settings->app_notifications_new_record) {
                return;
            }

            $user = getActiveUser();
            if ($user && !app()->runningInConsole()) {
                $modelType = strtolower(class_basename($model));
                event(new RecordEvent($user, 'created', $model, $modelType));
            }
        });

        // Broadcast when a model is updated
        static::updated(function ($model) use ($settings) {
            if (!$settings || !$settings->app_notifications_data_updates) {
                return;
            }

            $user = getActiveUser();
            if ($user && !app()->runningInConsole()) {
                $modelType = strtolower(class_basename($model));
                event(new RecordEvent($user, 'updated', $model, $modelType));
            }
        });

        // Broadcast when a model is deleted
        static::deleted(function ($model) use ($settings) {
            if (!$settings || !$settings->app_notifications_data_deletes) {
                return;
            }

            $user = getActiveUser();
            if ($user && !app()->runningInConsole()) {
                $modelType = strtolower(class_basename($model));
                event(new RecordEvent($user, 'deleted', $model, $modelType));
            }
        });

        // Broadcast when a model is restored (soft delete)
        // if (method_exists(static::class, 'restored')) {
        //     static::restored(function ($model) use ($settings) {
        //         if (!$settings || !$settings->data_updates) {
        //             return;
        //         }

        //         $user = getActiveUser();
        //         if ($user && !app()->runningInConsole()) {
        //             $modelType = strtolower(class_basename($model));
        //             event(new RecordEvent($user, 'restored', $model, $modelType));
        //         }
        //     });
        // }
    }
}