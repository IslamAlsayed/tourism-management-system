<?php

namespace App\Listeners;

use Ably\AblyRest;
use App\Events\UserLoggedEvent;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class HandleUserLogged
{
    public function handle(UserLoggedEvent $event)
    {
        $status = $event->status ?? 'offline';

        $ablyKey = env('ABLY_KEY');
        if (!$ablyKey) {
            Log::warning('ABLY_KEY not configured, skipping Ably broadcast');
            return;
        }
        try {
            $event->user->update(['user_status' => $status ?? 'offline']);
            $ably = new AblyRest($ablyKey);
            $currentUserId = getActiveUser()?->id;
            $isCurrentUser = $currentUserId == $event->user->id;

            $message = '';
            if ($status == 'online' && !$isCurrentUser) {
                $message = __('main.messages.user_logged_in', ['name' => $event->user->name]);
            } elseif ($status == 'offline' && !$isCurrentUser) {
                $message = __('main.messages.user_logged_out', ['name' => $event->user->name]);
            }

            $ably->channel('status-user-logged')->publish('user.logged', [
                'id' => $event->user->id,
                'status' => $status,
                'message' => $message,
            ]);

            if (!empty($message)) {
                Notification::create([
                    'user_id' => $event->user->id,
                    'type' => 'success',
                    'message' => $message,
                    'is_read' => $isCurrentUser ? 1 : 0,
                    'data' => json_encode(['source' => 'toast', 'messageMode' => true])
                ]);
            }

            if (env('APP_ENV') != 'production') {
                Log::info("Broadcasted user status via Ably", ['user_id' => $event->user->id, 'status' => $status]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to broadcast to Ably: ' . $e->getMessage());
        }
    }
}