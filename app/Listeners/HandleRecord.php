<?php

namespace App\Listeners;

use Ably\AblyRest;
use App\Models\User;
use App\Models\Setting;
use App\Events\RecordEvent;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;
use Spatie\Activitylog\Models\Activity;

class HandleRecord
{
    public function handle(RecordEvent $event)
    {
        // لا تنفّذ على Notifications نفسها
        if ($event->record instanceof Notification) {
            return;
        }

        // جلب إعدادات الإشعارات
        if (!\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            return;
        }
        $settings = Setting::first();
        if (!$settings)
            return;

        $status = $event->status ?? null;
        $record = $event->record ?? null;
        $type = $event->type ?? null;

        $statusToSetting = [
            'created' => 'app_notifications_new_record',
            'updated' => 'app_notifications_data_updates',
            'deleted' => 'app_notifications_data_deletes',
            'system_report' => 'app_notifications_system_reports',
            'security_update' => 'app_notifications_security_updates',
        ];
        $settingKey = $statusToSetting[$status] ?? null;
        if (!$settingKey || !$settings->$settingKey) {
            return;
        }

        // أنشئ رسالة الإشعار
        $message = __('messages.type_' . $status . '_by', [
            'record_name' => $record->name ?? class_basename($record),
            'type_name' => __('main.' . strtolower($type ?? class_basename($record))),
            'user_name' => getActiveUser()->name
        ]);

        // احصل على المستخدمين المستهدفين
        $users = collect();

        // إذا كان الموديل هو User والتحديث فقط لحقول الحالة/تسجيل الدخول
        if ($record instanceof User && $status == 'updated') {
            $changes = method_exists($record, 'getChanges') ? $record->getChanges() : [];
            $changeKeys = array_keys($changes);
            // Ignore automatic timestamp changes
            $changeKeys = array_values(array_diff($changeKeys, ['updated_at', 'created_at']));
            $interestingFields = ['user_status', 'last_login_at'];
            $interesting = array_intersect($changeKeys, $interestingFields);
            $onlyInteresting = !empty($interesting) && count($changeKeys) === count($interesting);

            if ($onlyInteresting) {
                // Only notify admins
                $admins = User::where('is_admin', 1)->get();
                if ($admins->isEmpty()) {
                    try {
                        $admins = User::whereHas('roles', function ($q) {
                            $q->where('name', 'admin');
                        })->get();
                    } catch (\Exception $e) {
                        $admins = collect();
                    }
                }
                $users = $admins;
            }
        }

        // إذا لم يتم تحديد مستخدمين مستهدفين بعد، فاستهدف الجميع ما عدا المستخدم الحالي
        if ($users->isEmpty()) {
            $users = User::where('id', '!=', getActiveUser()->id)->get();
        }

        foreach ($users as $notifyUser) {
            try {
                $notify = Notification::create([
                    'performer_id' => getActiveUser()->id,
                    'target_user_id' => $notifyUser->id,
                    'type' => 'success',
                    'notification_type' => 'system',
                    'title' => __('main.' . strtolower(class_basename($record ?? $type ?? 'record'))),
                    'message' => $message,
                    'is_read' => false,
                    'data' => json_encode(['source' => 'toast', 'messageMode' => true, 'event_type' => $status]),
                    'is_global' => false,
                ]);

                $notify['human_created_at'] = $notify?->human_created_at;
            } catch (\Exception $e) {
                Log::error('Failed to create Notification: ' . $e->getMessage());
                continue;
            }

            // إرسال عبر Ably إذا مفعّل
            if ($settings->app_ably_key && $settings->app_push_notifications) {
                try {
                    // total notifications for user
                    $notification_count = Notification::targetMe($notifyUser->id)->count() ?? 0;
                    // explicit unread count (guard against any scope issues)
                    $unread_notifications_count = Notification::targetMe($notifyUser->id)->unread()->count() ?? 0;

                    $ably = new AblyRest($settings->app_ably_key);
                    $data = [
                        'status' => $status,
                        'record_name' => $record->name ?? class_basename($record),
                        'type' => $type ?? class_basename($record),
                        'user_name' => getActiveUser()->name,
                        'message' => $message,
                        'performer_id' => getActiveUser()->id,
                        'notification_id' => $notify->id,
                        'target_user_id' => $notifyUser->id,
                        'is_global' => false,
                        'activities_logs_count' => Activity::count() ?? 0,
                        'users_count' => User::count() ?? 0,
                        'notification_count' => $notification_count,
                        'unread_notifications_count' => $unread_notifications_count,
                        'notification' => $notify ?? null,
                    ];

                    // Log channel information to console
                    // Log::info('=== Broadcasting Channel Debug ===');
                    // Log::info('Channel: web.push.notifications');
                    // Log::info('Event Type: ' . $status);
                    // Log::info('Model Type: ' . ($type ?? class_basename($record)));
                    // Log::info('Target User ID: ' . $notifyUser->id);
                    // Log::info('Performer: ' . getActiveUser()->name . ' (ID: ' . getActiveUser()->id . ')');
                    // Log::info('===================================');

                    $ably->channel('web.push.notifications')->publish('web.push.notifications', $data);
                } catch (\Exception $e) {
                    Log::error('Failed to broadcast notification via Ably: ' . $e->getMessage());
                }
            }

            // إرسال عبر البريد إذا مفعّل (ملاحظة: لا ينفّذ هنا، فقط تعليق/مكان للإضافة)
            if ($settings->app_email_notifications) {
                // dispatch(new \App\Jobs\SendNotificationEmailJob($notifyUser, $notification));
            }
        }
    }
}