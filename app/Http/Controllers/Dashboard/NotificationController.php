<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display notifications for authenticated user
     */
    public function index(Request $request)
    {
        $query = Notification::orderBy('created_at', 'desc');
        // Filter by read status
        if ($request->has('filter')) {
            if ($request->get('filter') == 'unread') {
                $query->unread();
            } else if ($request->get('filter') == 'read') {
                $query->read();
            }
        }
        // Filter by type
        if ($request->has('type') && $request->get('type') != '') {
            $query->ofType($request->get('type'));
        }
        $notifications = $query->paginate(50);

        // $notifications = Notification::forUser(Auth::id())->orderBy('created_at', 'desc')->limit(10)->get();
        $unreadNotificationsCount = Notification::unread()->count();

        return view('pages.dashboard.notifications.index', compact('notifications', 'unreadNotificationsCount'));
        // return response()->json(['notifications' => $notifications, 'unread_count' => Notification::forUser(Auth::id())->unread()->count()]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        // Ensure user can only mark their own notifications
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $notification->markAsRead();
        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(Notification $notification)
    {
        // Ensure user can only mark their own notifications
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $notification->markAsUnread();
        return response()->json(['success' => true, 'message' => 'Notification marked as unread']);
    }

    /**
     * Mark all notifications as read for authenticated user
     */
    public function markAllAsRead()
    {
        Notification::forUser(Auth::id())->unread()->update(['is_read' => true, 'read_at' => now()]);
        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        // Ensure user can only delete their own notifications
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $notification->delete();
        return response()->json(['success' => true, 'message' => 'Notification deleted']);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        $count = Notification::forUser(Auth::id())->unread()->count();
        return response()->json(['unread_count' => $count]);
    }

    /**
     * Get recent notifications for dropdown
     */
    public function getRecent()
    {
        $notifications = Notification::forUser(Auth::id())->orderBy('created_at', 'desc')->limit(5)->get();
        return response()->json(['notifications' => $notifications, 'unread_count' => Notification::forUser(Auth::id())->unread()->count()]);
    }
}