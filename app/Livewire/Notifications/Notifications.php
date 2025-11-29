<?php

namespace App\Livewire\Notifications;

use Ably\AblyRest;
use Livewire\Component;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use Illuminate\Support\Facades\Log;
use App\Models\Notification as ModelsNotification;
use Maatwebsite\Excel\Concerns\ToArray;

class Notifications extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;

    public $search = '';
    public $filter = 'all'; // all, unread, read
    public $type = '';
    public $notificationType = '';
    public $typeUsers = [];
    public $allCount = 0;
    public $unreadCount = 0;
    public $readCount = 0;
    public $filterTypeUserId = '';

    protected $listeners = [
        'notificationMarkedAsRead' => 'refreshNotifications',
        'allNotificationsMarkedAsRead' => 'refreshNotifications',
        'notificationDeleted' => 'refreshNotifications',
    ];

    protected $queryString = ['filter', 'type'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->refreshNotifications();
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(ModelsNotification::class);

        $this->typeUsers = ModelsNotification::targetMe(getActiveUser()->id)->select('user_id')->distinct()->with([
            'user' => fn($query) => $query->select('id', 'name'),
        ])->get()->map(function ($notification) {
            return [
                'id' => $notification->user->id,
                'name' => $notification->user->name,
            ];
        });
    }

    public function refreshNotifications()
    {
        $this->allCount = ModelsNotification::targetMe(getActiveUser()->id)->count();
        $this->unreadCount = ModelsNotification::targetMe(getActiveUser()->id)->unread()->count();
        $this->readCount = ModelsNotification::targetMe(getActiveUser()->id)->read()->count();
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

        if ($notification && $notification->user_id == getActiveUser()?->id) {
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

        if ($notification && $notification->user_id == getActiveUser()?->id) {
            $notification->markAsUnread();
            $this->refreshNotifications();

            // Emit event to update other notification components
            $this->dispatch('notificationMarkedAsUnread', $notificationId);

            session()->flash('success', __('main.notification_marked_as_unread'));
        }
    }

    public function markAllAsRead()
    {
        ModelsNotification::targetMe(getActiveUser()->id)->unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        $this->refreshNotifications();

        // Emit event to update other notification components
        $this->dispatch('allNotificationsMarkedAsRead');

        $ablyKey = config('app.ably_key');
        if (!$ablyKey) {
            Log::warning('ABLY_KEY not configured, skipping Ably broadcast');
            return;
        }
        $ably = new AblyRest($ablyKey);
        $ably->channel('notifications')->publish('marked_as_read_all', [
            'status' => 'marked_as_read_all',
        ]);

        session()->flash('success', __('main.all_notifications_marked_as_read'));
    }

    public function deleteNotification($notificationId)
    {
        $notification = ModelsNotification::find($notificationId);

        if ($notification && $notification->user_id == getActiveUser()?->id) {
            $notification->delete();
            $this->refreshNotifications();

            // Emit event to update other notification components
            $this->dispatch('notificationDeleted', $notificationId);

            session()->flash('success', __('main.notification_deleted'));
        }
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'notification');
    }

    public function getNotificationsProperty()
    {
        $query = ModelsNotification::targetMe(getActiveUser()->id)->with([
            'user' => fn($query) => $query->select('id', 'name'),
        ])->orderBy('created_at', 'desc');

        if ($this->filterTypeUserId) {
            $query->where('target_user_id', (int) $this->filterTypeUserId);
        }

        // Filter by read status
        if ($this->filter == 'unread') {
            $query->unread();
        } elseif ($this->filter == 'read') {
            $query->read();
        }

        // Filter by type
        if (!empty($this->type)) {
            $query->ofType($this->type);
        }
        // Filter by notification_type (system, push, ...)
        if (!empty($this->notificationType)) {
            $query->ofNotificationType($this->notificationType);
        }

        return $query->paginate(getPaginate());
    }

    public function getNotificationTypesProperty()
    {
        return ModelsNotification::notMe(getActiveUser()?->id)->select('type')->distinct()->pluck('type')->filter()->toArray();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterTypeUserId', 'notificationType', 'type']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        return view('livewire.notifications.notifications', [
            'data' => $this->notifications,
            'notificationTypes' => $this->notificationTypes
        ]);
    }
}