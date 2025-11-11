<?php

namespace App\Livewire\Notifications;

use App\Models\Notification as ModelsNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination;

    public $filter = 'all'; // all, unread, read
    public $type = '';
    public $unreadCount = 0;

    protected $listeners = [
        'notificationMarkedAsRead' => 'refreshNotifications',
        'allNotificationsMarkedAsRead' => 'refreshNotifications',
        'notificationDeleted' => 'refreshNotifications',
    ];

    protected $queryString = ['filter', 'type'];

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function refreshNotifications()
    {
        $this->unreadCount = ModelsNotification::forUser(Auth::id())->unread()->count();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function setType($type)
    {
        $this->type = $type;
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        $notification = ModelsNotification::find($notificationId);

        if ($notification && $notification->user_id === Auth::id()) {
            $notification->markAsRead();
            $this->refreshNotifications();

            // Emit event to update other notification components
            $this->dispatch('notificationMarkedAsRead', $notificationId);

            session()->flash('success', __('main.notification_marked_as_read'));
        }
    }

    public function markAsUnread($notificationId)
    {
        $notification = ModelsNotification::find($notificationId);

        if ($notification && $notification->user_id === Auth::id()) {
            $notification->markAsUnread();
            $this->refreshNotifications();

            // Emit event to update other notification components
            $this->dispatch('notificationMarkedAsUnread', $notificationId);

            session()->flash('success', __('main.notification_marked_as_unread'));
        }
    }

    public function markAllAsRead()
    {
        ModelsNotification::forUser(Auth::id())->unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        $this->refreshNotifications();

        // Emit event to update other notification components
        $this->dispatch('allNotificationsMarkedAsRead');

        session()->flash('success', __('main.all_notifications_marked_as_read'));
    }

    public function deleteNotification($notificationId)
    {
        $notification = ModelsNotification::find($notificationId);

        if ($notification && $notification->user_id === Auth::id()) {
            $notification->delete();
            $this->refreshNotifications();

            // Emit event to update other notification components
            $this->dispatch('notificationDeleted', $notificationId);

            session()->flash('success', __('main.notification_deleted'));
        }
    }

    public function getNotificationsProperty()
    {
        $query = ModelsNotification::forUser(Auth::id())->orderBy('created_at', 'desc');

        // Filter by read status
        if ($this->filter === 'unread') {
            $query->unread();
        } elseif ($this->filter === 'read') {
            $query->read();
        }

        // Filter by type
        if (!empty($this->type)) {
            $query->ofType($this->type);
        }

        return $query->paginate(20);
    }

    public function getNotificationTypesProperty()
    {
        return ModelsNotification::forUser(Auth::id())->select('type')->distinct()->pluck('type')->filter()->toArray();
    }

    public function render()
    {
        return view('livewire.notifications.notifications', [
            'notifications' => $this->notifications,
            'notificationTypes' => $this->notificationTypes
        ]);
    }
}