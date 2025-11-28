<?php

namespace App\Listeners;

use Ably\AblyRest;
use App\Events\ActivityCreated;
use Illuminate\Support\Facades\Log;

class HandleActivityCreated
{
    /**
     * Handle the event.
     */
    public function handle(ActivityCreated $event)
    {
        $ablyKey = config('app.ably_key');

        if (!$ablyKey) {
            Log::warning('ABLY_KEY not configured, skipping Ably broadcast for activity');
            return;
        }

        try {
            $ably = new AblyRest($ablyKey);
            $activity = $event->activity;

            // Broadcast to Ably channel
            $ably->channel('activity-created')->publish('activity.created', [
                'id' => $activity->id,
                'description' => $activity->description,
                'log_name' => $activity->log_name,
                'event' => $activity->event,
                'subject_type' => $activity->subject_type,
                'subject_id' => $activity->subject_id,
                'causer' => $activity->causer ? [
                    'id' => $activity->causer->id,
                    'name' => $activity->causer->name ?? null,
                ] : null,
                'created_at' => $activity->created_at->toDateTimeString(),
            ]);

            if (env('APP_ENV') != 'production') {
                Log::info("Broadcasted activity via Ably", [
                    'activity_id' => $activity->id,
                    'event' => $activity->event,
                    'log_name' => $activity->log_name
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to broadcast activity to Ably: ' . $e->getMessage());
        }
    }
}