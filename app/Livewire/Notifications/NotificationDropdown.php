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
        'notificationCreated' => 'newNotificationData',
    ];

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function newNotificationData()
    {
        $userId = getActiveUser()?->id;
        $lastNotification = Notification::forUser($userId)->latest()->first();
        $lastNotification['human_created_at'] = $lastNotification?->human_created_at;
        $this->dispatch('new-notification-data', notification: $lastNotification);
    }

    public function refreshNotifications()
    {
        if (Auth::check()) {
            $userId = getActiveUser()?->id;
            $this->notifications = Notification::forUser($userId)->orderBy('created_at', 'desc')->limit(10)->get();
            $this->unreadNotificationsCount = Notification::forUser($userId)->unread()->count();
        } else {
            $this->notifications = collect();
            $this->unreadNotificationsCount = 0;
        }
    }

    public function markAsRead(int $notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            if ($notification) {
                if ($notification->user_id == getActiveUser()?->id) {
                    $notification->markAsRead();
                    $this->refreshNotifications();

                    // Emit event to Read notification by id
                    $this->dispatch('notification-readed', id: $notificationId);
                    Log::info(__('main.notification_marked_as_read'));
                } else {
                    Log::error('Error reading notification: Unauthorized for ID: ' . $notificationId);
                    $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Unauthorized for ID: ' . $notificationId]);
                }
            } else {
                Log::error('Error reading notification: Notification not found');
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Notification not found']);
            }
        } catch (\Exception $e) {
            Log::error('Error reading notification: ' . $e->getMessage());
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Error reading notification: ' . $e->getMessage()]);
        }
    }

    public function markAllAsRead()
    {
        try {
            $updated = Notification::forUser(getActiveUser()?->id)->unread()->update([
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
            Notification::forUser(getActiveUser()?->id)->unread()->update(['is_read' => true, 'read_at' => now()]);
            $this->refreshNotifications();
            $this->dispatch('notification-readed', id: 'all');

            // Emit event to update other notification components
            // $this->dispatch('allNotificationsMarkedAsRead');
        }
    }

    public function deleteNotification(int $notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            if ($notification) {
                if ($notification->user_id == getActiveUser()?->id) {
                    $notification->delete();
                    $this->refreshNotifications();

                    // Emit event to delete notification by id
                    $this->dispatch('notification-deleted', id: $notificationId);
                    Log::info(__('main.notification_deleted'));
                } else {
                    Log::error('Error deleting notification: Unauthorized for ID: ' . $notificationId);
                    $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Unauthorized for ID: ' . $notificationId]);
                }
            } else {
                Log::error('Error deleting notification: Notification not found');
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Notification not found']);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Error deleting notification: ' . $e->getMessage()]);
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