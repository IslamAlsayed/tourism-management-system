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
        if (!shouldSendNotification()) {
            return;
        }

        $status = $event->status ?? null;
        $ablyKey = config('app.ably_key');

        if (!$ablyKey) {
            Log::warning('ABLY_KEY not configured, skipping Ably broadcast for activity');
            return;
        }

        try {
            $ably = new AblyRest($ablyKey);
            $notification = $event->notification;

            // Broadcast to Ably channel
            $ably->channel('notifications')->publish('notification.created', [
                'notification_id' => $notification->id,
                'user_id' => $notification->user_id,
                'message' => $notification->message,
                'status' => $status
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