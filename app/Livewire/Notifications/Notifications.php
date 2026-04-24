<?php

namespace App\Livewire\Notifications;

use Ably\AblyRest;
use Livewire\Component;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;
use Illuminate\Support\Facades\Log;
use App\Models\Notification as ModelsNotification;

class Notifications extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

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

        $this->typeUsers = ModelsNotification::targetMe(getActiveUserId())->select('user_id')->distinct()->with([
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
        $this->allCount = ModelsNotification::targetMe(getActiveUserId())->count();
        $this->unreadCount = ModelsNotification::targetMe(getActiveUserId())->unread()->count();
        $this->readCount = ModelsNotification::targetMe(getActiveUserId())->read()->count();
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

        if ($notification && $notification->user_id == getActiveUserId()) {
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

        if ($notification && $notification->user_id == getActiveUserId()) {
            $notification->markAsUnread();
            $this->refreshNotifications();

            // Emit event to update other notification components
            $this->dispatch('notificationMarkedAsUnread', $notificationId);

            session()->flash('success', __('main.notification_marked_as_unread'));
        }
    }

    public function markAllAsRead()
    {
        ModelsNotification::targetMe(getActiveUserId())->unread()->update([
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

        if ($notification && $notification->user_id == getActiveUserId()) {
            $notification->delete();
            $this->refreshNotifications();

            // Emit event to update other notification components
            $this->dispatch('notificationDeleted', $notificationId);

            session()->flash('success', __('main.notification_deleted'));
        }
    }

    public function updatedSelectPage($value)
    {
        $this->selectedIds = $value ? $this->currentPageDataIds()->toArray() : [];
    }

    public function updatedSelectedIds()
    {
        $this->selectPage = count($this->selectedIds) === $this->currentPageDataIds()->count();
    }

    protected function currentPageDataIds()
    {
        $query = ModelsNotification::targetMe(getActiveUserId());

        // Apply same filters as getNotificationsProperty
        if ($this->filter == 'unread') {
            $query->unread();
        } elseif ($this->filter == 'read') {
            $query->read();
        }

        if (!empty($this->type) && $this->type !== 'all') {
            $query->ofType($this->type);
        }

        if (!empty($this->notificationType) && $this->notificationType !== 'all') {
            $query->ofNotificationType($this->notificationType);
        }

        if ($this->filterTypeUserId && $this->filterTypeUserId !== 'all') {
            $query->where('target_user_id', (int) $this->filterTypeUserId);
        }

        $paginator = $query->paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        // Security: Only delete notifications owned by the current user
        $deletedCount = ModelsNotification::whereIn('id', $this->selectedIds)
            ->where('user_id', getActiveUserId())
            ->delete();

        $this->selectedIds = [];
        $this->selectPage = false;
        $this->refreshNotifications();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.notifications'), 'count' => $deletedCount]),
        ]);
    }

    public function exportSelectedPDF()
    {
        // Security: Filter to only export notifications owned by the current user
        $ownedIds = ModelsNotification::whereIn('id', $this->selectedIds ?? [])
            ->where('user_id', getActiveUserId())
            ->pluck('id')
            ->toArray();

        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($ownedIds, ModelsNotification::class, $cols, 'notifications');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        // Security: Filter to only export notifications owned by the current user
        $ownedIds = ModelsNotification::whereIn('id', $this->selectedIds ?? [])
            ->where('user_id', getActiveUserId())
            ->pluck('id')
            ->toArray();

        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($ownedIds, ModelsNotification::class, $cols, 'notifications', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, ModelsNotification::class, 'notification');
    }

    public function getNotificationsProperty()
    {
        $query = ModelsNotification::targetMe(getActiveUserId())->with([
            'user' => fn($query) => $query->select('id', 'name'),
        ])->orderBy('created_at', 'desc');

        if ($this->filterTypeUserId && $this->filterTypeUserId !== 'all') {
            $query->where('target_user_id', (int) $this->filterTypeUserId);
        }

        // Filter by read status
        if ($this->filter == 'unread') {
            $query->unread();
        } elseif ($this->filter == 'read') {
            $query->read();
        }

        // Filter by type
        if (!empty($this->type) && $this->type !== 'all') {
            $query->ofType($this->type);
        }
        // Filter by notification_type (system, push, ...)
        if (!empty($this->notificationType) && $this->notificationType !== 'all') {
            $query->ofNotificationType($this->notificationType);
        }

        return $query->paginate(getPaginate());
    }

    public function getNotificationTypesProperty()
    {
        return ModelsNotification::notMe(getActiveUserId())->select('type')->distinct()->pluck('type')->filter()->toArray();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterTypeUserId', 'notificationType', 'type']);
        $this->resetSort();
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
