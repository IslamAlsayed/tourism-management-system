<?php

namespace App\Listeners;

use Ably\AblyRest;
use App\Events\NotificationCreated;
use Illuminate\Support\Facades\Log;

class HandleNotificationCreated
{
    /**
     * Handle the event.
     */
    public function handle(NotificationCreated $event)
    {
        $ablyKey = env('ABLY_KEY');

        if (!$ablyKey) {
            Log::warning('ABLY_KEY not configured, skipping Ably broadcast for activity');
            return;
        }

        try {
            $ably = new AblyRest($ablyKey);
            $notification = $event->notification;

            // Broadcast to Ably channel
            $ably->channel('notification-created')->publish('notification.created', [
                'id' => $notification->id
            ]);

            if (env('APP_ENV') != 'production') {
                Log::info("Broadcasted notification via Ably", [
                    'notification_id' => $notification->id,
                    'event' => $notification->event,
                    'log_name' => $notification->log_name
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to broadcast notification to Ably: ' . $e->getMessage());
        }
    }
}