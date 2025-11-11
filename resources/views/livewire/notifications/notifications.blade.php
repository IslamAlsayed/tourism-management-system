<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ __('main.notifications') }}</h3>
                        <div class="card-toolbar">
                            @if ($unreadCount > 0)
                                <button wire:click="markAllAsRead" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check-double"></i>
                                    {{ __('main.mark_all_read') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <button wire:click="setFilter('all')"
                            class="btn btn-sm {{ $filter === 'all' ? 'btn-primary' : 'btn-light' }}">
                            {{ __('main.all') }}
                        </button>
                        <button wire:click="setFilter('unread')"
                            class="btn btn-sm {{ $filter === 'unread' ? 'btn-primary' : 'btn-light' }}">
                            {{ __('main.unread') }} ({{ $unreadCount }})
                        </button>
                        <button wire:click="setFilter('read')"
                            class="btn btn-sm {{ $filter === 'read' ? 'btn-primary' : 'btn-light' }}">
                            {{ __('main.read') }}
                        </button>
                    </div>

                    @if (count($notificationTypes) > 0)
                        <div class="mb-4">
                            <select wire:model="type" wire:change="setType($event.target.value)"
                                class="form-select w-auto">
                                <option value="">{{ __('main.all_types') }}</option>
                                @foreach ($notificationTypes as $notificationType)
                                    <option value="{{ $notificationType }}">{{ ucfirst($notificationType) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Notifications List -->
                    <div class="notifications-list">
                        @forelse($notifications as $notification)
                            <div
                                class="notification-item border rounded p-3 mb-3 {{ !$notification->is_read ? 'bg-light-primary' : '' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        @if ($notification->title)
                                            <h5 class="mb-2 fw-bold">{{ $notification->title }}</h5>
                                        @endif
                                        <p class="mb-2 {{ !$notification->title ? 'fw-bold' : '' }}">
                                            {{ $notification->message }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                            @if ($notification->type)
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($notification->type) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if (!$notification->is_read)
                                                <li>
                                                    <button wire:click="markAsRead({{ $notification->id }})"
                                                        class="dropdown-item">
                                                        <i class="fas fa-check me-2"></i>
                                                        {{ __('main.mark_read') }}
                                                    </button>
                                                </li>
                                            @else
                                                <li>
                                                    <button wire:click="markAsUnread({{ $notification->id }})"
                                                        class="dropdown-item">
                                                        <i class="fas fa-envelope me-2"></i>
                                                        {{ __('main.mark_unread') }}
                                                    </button>
                                                </li>
                                            @endif
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <button wire:click="deleteNotification({{ $notification->id }})"
                                                    class="dropdown-item text-danger"
                                                    onclick="return confirm('{{ __('main.are_you_sure') }}')">
                                                    <i class="fas fa-trash me-2"></i>
                                                    {{ __('main.delete') }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash text-muted mb-3" style="font-size: 4rem;"></i>
                                <h4 class="text-muted">{{ __('main.no_notifications') }}</h4>
                                <p class="text-muted">{{ __('main.no_notifications_description') }}</p>
                            </div>
                        @endforelse

                        <!-- Pagination -->
                        @if ($notifications->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $notifications->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
