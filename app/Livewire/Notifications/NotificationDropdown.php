<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public $isOpen = false;
    public $notifications = [];
    public $unreadNotificationsCount = 0;

    protected $listeners = [
        'notificationAdded' => 'refreshNotifications',
        'notificationMarkedAsRead' => 'refreshNotifications',
        'allNotificationsMarkedAsRead' => 'refreshNotifications',
        'notificationDeleted' => 'refreshNotifications',
    ];

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function refreshNotifications()
    {
        if (Auth::check()) {
            $this->notifications = Notification::forUser(Auth::id())->orderBy('created_at', 'desc')->limit(10)->get();
            $this->unreadNotificationsCount = Notification::forUser(Auth::id())->unread()->count();
        } else {
            $this->notifications = collect();
            $this->unreadNotificationsCount = 0;
        }
    }

    public function markAsRead(int $notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            if ($notification && $notification->user_id == Auth::id()) {
                $notification->markAsRead();
                $this->refreshNotifications();

                // Emit event to update other notification components
                // $this->dispatch('notificationMarkedAsRead', id: $notificationId);

                $this->dispatch('notification-readed', id: $notificationId);
            } else {
                Log::error('Notification not found or unauthorized for ID: ' . $notificationId);
            }
        } catch (\Exception $e) {
            Log::error('Error marking notification as read for ID: ' . $notificationId . ' - ' . $e->getMessage());
        }
    }

    public function markAllAsRead()
    {
        try {
            $updated = Notification::forUser(Auth::id())->unread()->update([
                'is_read' => true,
                'read_at' => now()
            ]);


            if ($updated > 0) {
                $this->refreshNotifications();
                $this->dispatch('notification-readed', id: 'all');
            } else {
                Log::info('No unread notifications to mark');
            }
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
        }
    }

    public function markAllAsReadWhenOpened()
    {
        if ($this->unreadNotificationsCount > 0) {
            Notification::forUser(Auth::id())->unread()->update(['is_read' => true, 'read_at' => now()]);
            $this->refreshNotifications();

            // Emit event to update other notification components
            // $this->dispatch('allNotificationsMarkedAsRead');
        }
    }

    public function deleteNotification(int $notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            if ($notification && $notification->user_id == Auth::id()) {
                $notification->delete();
                $this->refreshNotifications();

                // Emit event to delete notification by id
                $this->dispatch('notification-deleted', id: $notificationId);
                Log::info(__('main.notification_deleted'));
            } else {
                Log::error('Error deleting notification: Notification not found or unauthorized for ID: ' . $notificationId);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.notifications.notification-dropdown', [
            'notifications' => $this->notifications,
            'unreadNotificationsCount' => $this->unreadNotificationsCount
        ]);
    }
}