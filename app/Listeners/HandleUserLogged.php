<?php

namespace App\Listeners;

use Ably\AblyRest;
use Modules\Core\Entities\User;
use Modules\Core\Entities\Setting;
use App\Models\Notification;
use App\Events\UserLoggedEvent;
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

            // Send notifications only to admins (create per-admin notification and publish targeted Ably message)
            $admins = User::where('role', 'admin')->orWhere('role', 'superadmin')->get();
            if ($admins->isEmpty()) {
                try {
                    $admins = User::whereHas('roles', function ($q) {
                        $q->where('name', 'admin');
                    })->get();
                } catch (\Exception $e) {
                    $admins = collect();
                }
            }

            foreach ($admins as $admin) {
                try {
                    // Disable activity logging temporarily to prevent infinite loop
                    activity()->disableLogging();

                    $notify = [];
                    // $notify = Notification::create([
                    //     'performer_id' => getActiveUserId(),
                    //     'target_user_id' => $admin->id,
                    //     'type' => 'info',
                    //     'notification_type' => 'system',
                    //     'title' => __('main.user_status'),
                    //     'message' => $message,
                    //     'is_read' => false,
                    //     'data' => json_encode(['source' => 'status', 'messageMode' => true]),
                    //     'is_global' => false,
                    // ]);

                    // Re-enable activity logging
                    activity()->enableLogging();

                    $notify['human_created_at'] = $notify?->human_created_at ?? null;
                } catch (\Exception $e) {
                    Log::error('Failed to create Notification: ' . $e->getMessage());
                    continue;
                }

                $settings = Setting::first();
                if (!$settings)
                    return;

                // إرسال عبر Ably إذا مفعّل
                if ($settings->app_ably_key && $settings->app_push_notifications) {
                    try {
                        $notification_count = Notification::targetMe($admin->id)->read()->count() ?? 0;
                        $unread_notifications_count = Notification::targetMe($admin->id)->unread()->count() ?? 0;

                        if ($unread_notifications_count > 0) {
                            $ably = new AblyRest($settings->app_ably_key);
                            $data = [
                                'status' => 'user_' . $status,
                                'record_name' => $event->user->name,
                                'type' => 'user',
                                'user_name' => $event->user->name,
                                'message' => $message,
                                'performer_id' => getActiveUserId(),
                                'notification_id' => $notify?->id ?? null,
                                'target_user_id' => $admin->id,
                                'is_global' => false,
                                'activities_logs_count' => Activity::count() ?? 0,
                                'users_count' => User::count() ?? 0,
                                'notification_count' => $notification_count,
                                'unread_notifications_count' => $unread_notifications_count,
                                'notification' => $notify ?? null,
                            ];
                            $ably->channel('web.push.notifications')->publish('web.push.notifications', $data);
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to create/broadcast admin status notification: ' . $e->getMessage());
                    }
                }
            }

            if (config('app.env') != 'production') {
                Log::info("Broadcasted user status via Ably", ['user_id' => $event->user->id, 'status' => $status]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to broadcast to Ably: ' . $e->getMessage());
        }
    }
}
