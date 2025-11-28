<?php

namespace App\Listeners;

use Ably\AblyRest;
use App\Models\User;
use App\Events\UserLoggedEvent;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class HandleUserLogged
{
    public function handle(UserLoggedEvent $event)
    {
        // Check if push notifications are enabled
        if (!shouldSendNotification()) {
            // Still update user status even if notifications are disabled
            setUserStatus($event->status);

            // Apply user's preferred locale if logging in
            if ($event->status == 'online' && $event->user->preferred_language) {
                session(['locale' => $event->user->preferred_language]);
                app()->setLocale($event->user->preferred_language);
            }
            return;
        }

        $status = $event->status ?? 'offline';

        $ablyKey = config('app.ably_key');
        if (!$ablyKey) {
            Log::warning('ABLY_KEY not configured, skipping Ably broadcast');
            return;
        }
        try {
            // Update user status
            setUserStatus($event->status);

            // Apply user's preferred locale if logging in
            if ($status == 'online' && $event->user->preferred_language) {
                session(['locale' => $event->user->preferred_language]);
                app()->setLocale($event->user->preferred_language);
            }

            $ably = new AblyRest($ablyKey);

            $message = '';
            if ($status == 'online') {
                session()->put('login_time', time()); // here
                $message = __('messages.user_logged_in', ['name' => $event->user->name]);
            } elseif ($status == 'offline') {
                $message = __('messages.user_logged_out', ['name' => $event->user->name]);
            }

            // Create notification for all users except the one who logged in/out
            // Send global notification to all users except actor
            if (!empty($message)) {
                Notification::create([
                    'user_id' => $event->user->id, // sender
                    'type' => 'success',
                    'message' => $message,
                    'is_read' => 0,
                    'is_global' => 1,
                    'data' => json_encode(['source' => 'toast', 'messageMode' => true])
                ]);
            }

            // Broadcast unified data on status-record channel
            $data = [
                'status' => 'user_' . $status,
                'record_name' => $event->user->name,
                'type' => 'user',
                'user_name' => $event->user->name,
                'message' => $message,
                'performer_id' => $event->user->id,
                'activities_logs_count' => Activity::count() ?? 0,
                'users_count' => User::count() ?? 0,
                'notification_count' => Notification::forUser(getActiveUser()->id)->count() ?? 0,
                'unread_notifications_count' => Notification::forUser(getActiveUser()->id)->unread->count() ?? 0,
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