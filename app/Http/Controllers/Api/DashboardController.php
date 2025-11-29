<?php

namespace App\Http\Controllers\Api;

use Ably\AblyRest;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\UserLoggedEvent;
use App\Mail\TestNotificationMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    // For testing: Get references for a given model based on foreign key and its value(s)
    public function getReferencesForTest(Request $request)
    {
        // $request['model'] = 'city';
        $request['model'] = 'subregion';
        // $request['foreignKey'] = 'state_id';
        $request['foreignKey'] = 'region_id';
        $request['foreignKeyValue'] = [2];

        $validated = $request->validate([
            'model' => 'required|string',
            'foreignKey' => 'required|string',
            'foreignKeyValue' => 'required'
        ]);

        $modelName = ucwords($validated['model']);
        $modelClass = "App\\Models\\$modelName";

        if (!class_exists($modelClass)) {
            return response()->json(['error' => __('messages.invalid_model_specified')], 400);
        }

        $query = $modelClass::query()->select('id', 'name')->orderBy('name');

        // Handle both array and string/single value
        $foreignKeyValue = $validated['foreignKeyValue'];

        if (is_array($foreignKeyValue)) {
            // Already an array, use it directly
            $query->whereIn($validated['foreignKey'], $foreignKeyValue);
        } elseif (is_string($foreignKeyValue) && strpos($foreignKeyValue, ',') !== false) {
            // String with commas, split it
            $values = explode(',', $foreignKeyValue);
            $query->whereIn($validated['foreignKey'], $values);
        } else {
            // Single value
            $query->where($validated['foreignKey'], $foreignKeyValue);
        }

        $references = $query->get();

        return response()->json(['count' => $references->count(), 'keys' => $validated, 'data' => $references]);
    }

    // Get references for a given model based on foreign key and its value(s)
    public function getReferences(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string',
            'foreignKey' => 'required|string',
            'foreignKeyValue' => 'required'
        ]);

        $modelName = ucwords($validated['model']);
        $modelClass = "App\\Models\\$modelName";

        if (!class_exists($modelClass)) {
            return response()->json(['error' => __('messages.invalid_model_specified')], 400);
        }

        $query = $modelClass::query()->select('id', 'name')->orderBy('name');

        // Handle both array and string/single value
        $foreignKeyValue = $validated['foreignKeyValue'];

        if (is_array($foreignKeyValue)) {
            // Already an array, use it directly
            $query->whereIn($validated['foreignKey'], $foreignKeyValue);
        } elseif (is_string($foreignKeyValue) && strpos($foreignKeyValue, ',') !== false) {
            // String with commas, split it
            $values = explode(',', $foreignKeyValue);
            $query->whereIn($validated['foreignKey'], $values);
        } else {
            // Single value
            $query->where($validated['foreignKey'], $foreignKeyValue);
        }

        $references = $query->get();

        return response()->json(['data' => $references, 'keys' => [$validated['model'], $validated['foreignKey'], $validated['foreignKeyValue']]]);
    }

    // Set user status to offline on logout
    public function userOfflineStatus(Request $request)
    {
        $user = getActiveUser();
        if ($user) {
            event(new UserLoggedEvent($user, 'offline'));
            activity()->causedBy($user)->performedOn($user)->useLog('models')->event('logout')->withProperties([
                'ip_address' => $request->ip(),
                'logout_time' => now()->toDateTimeString(),
                'expired' => true
            ])->log(__('messages.user_logged_out', ['name' => $user->name]));
        }
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['success' => true]);
    }

    // Translate record event message
    public function translateRecordEvent(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];
        $type = studyCapitalCaseName($data['type']);
        $user_name = $data['user_name'];
        $record_name = $data['record_name'];
        $message = __('messages.type_' . $status . '_by', [
            'record_name' => $record_name,
            'type_name' => __('main.' . strtolower($type)),
            'user_name' => $user_name,
        ]);
        return response()->json(['message' => $message]);
    }

    // Test send notifications
    public function webPushNotifications(Request $request)
    {
        $request->validate([
            'all_users' => 'nullable|boolean',
            'recipient_user_id' => 'nullable|exists:users,id',
            'notification_type.email' => 'nullable|boolean',
            'notification_type.sms' => 'nullable|boolean',
            'notification_type.notification' => 'nullable|boolean',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $recipientUser = $request->filled('recipient_user_id') ? User::find($request->recipient_user_id) : null;
        $selectedTypes = array_keys(array_filter($request->notification_type ?? []));

        if (empty($selectedTypes)) {
            return response()->json(['message' => __('messages.select_at_least_one_notification_type')], 422);
        }

        $userName = getActiveUser() ? getActiveUser()->name : 'Guest';

        // --- إرسال الإيميلات ---
        if (!empty($request->notification_type['email']) && shouldSendEmail()) {
            if ($request->input('all_users') == 1) {
                $users = User::pluck('email');
                foreach ($users as $email) {
                    Mail::to($email)->send(new TestNotificationMail($request));
                }
            } elseif ($recipientUser) {
                Mail::to($recipientUser->email)->send(new TestNotificationMail($request));
            }
        }

        // --- إرسال Push Notification عبر Ably ---
        if (!empty($request->notification_type['notification']) && shouldSendNotification()) {
            $ablyKey = config('app.ably_key');
            if (!$ablyKey) {
                Log::warning('ABLY_KEY not configured, skipping Ably broadcast');
                return response()->json(['message' => __('messages.ably_key_not_configured')], 500);
            }

            // Create notification: global or targeted
            if (!empty($request->message)) {
                if ($request->input('all_users') == '1') {
                    Notification::create([
                        'user_id' => getActiveUser()?->id, // sender
                        'type' => 'success',
                        'message' => $request->message,
                        'is_read' => 0,
                        'is_global' => 1,
                        'data' => json_encode(['source' => 'toast', 'messageMode' => true])
                    ]);
                } elseif ($recipientUser) {
                    Notification::create([
                        'user_id' => getActiveUser()?->id, // sender
                        'recipient_user_id' => $recipientUser->id,
                        'type' => 'success',
                        'message' => $request->message,
                        'is_read' => 0,
                        'is_global' => 0,
                        'data' => json_encode(['source' => 'toast', 'messageMode' => true])
                    ]);
                }
            }

            $ably = new AblyRest($ablyKey);
            $data = [
                'subject' => $request->subject,
                'message' => $request->message,
                'sent_by' => $userName,
                'performer_id' => getActiveUser()->id,
                'activities_logs_count' => Activity::count() ?? 0,
                'users_count' => User::count() ?? 0,
                'notification_count' => Notification::count() ?? 0,
                'unread_notifications_count' => Notification::where('is_read', 0)->count() ?? 0,
            ];
            $ably->channel('web-push-notifications')->publish('web.push.notifications', $data);
        }

        // --- SMS Placeholder ---
        if (!empty($request->notification_type['sms'])) {
            // TODO: integrate your SMS service
        }

        return response()->json([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
    }
}