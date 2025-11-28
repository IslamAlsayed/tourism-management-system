<?php

namespace App\Listeners;

use Ably\AblyRest;
use App\Models\User;
use App\Events\RecordEvent;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class HandleRecord
{
    public function handle(RecordEvent $event)
    {
        // Check if push notifications are enabled
        if (!shouldSendNotification()) {
            return;
        }

        $status = $event->status ?? null;
        $record = $event->record ?? null;
        $type = $event->type ?? null;

        $ablyKey = config('app.ably_key');
        if (!$ablyKey) {
            Log::warning('ABLY_KEY not configured, skipping Ably broadcast');
            return;
        }
        try {
            $ably = new AblyRest($ablyKey);

            $message = __('messages.type_' . $status . '_by', [
                'record_name' => $record->name,
                'type' => __('main.' . strtolower($type)),
                'user_name' => $event->user->name
            ]);

            // Create notification for all users except the one who performed the action
            if (!empty($message)) {
                $users = User::withNotMe()->get();
                foreach ($users as $user) {
                    Notification::create([
                        'user_id' => $user->id,
                        'type' => 'success',
                        'message' => $message,
                        'is_read' => 0,
                        'data' => json_encode(['source' => 'toast', 'messageMode' => true])
                    ]);
                }
            }

            $data = [
                'status' => $status,
                'record_name' => $record->name,
                'type' => $type,
                'user_name' => $event->user->name,
                'message' => $message,
                'performer_id' => $event->user->id,
                'activities_logs_count' => Activity::count() ?? 0,
                'users_count' => User::count() ?? 0,
                'notification_count' => Notification::forUser(getActiveUser()?->id)->unread()->count() ?? 0,
                'unread_notifications_count' => Notification::forUser(getActiveUser()?->id)->unread()->count() ?? 0,
            ];
            $ably->channel('status-record')->publish('record.updated', $data);

            if (env('APP_ENV') != 'production') {
                Log::info("Broadcasted user status via Ably", ['user_id' => $event->user->id, 'status' => $status]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to broadcast to Ably: ' . $e->getMessage());
        }
    }
}