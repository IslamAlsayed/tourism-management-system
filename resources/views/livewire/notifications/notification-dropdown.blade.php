<div class="relative" wire:ignore>
    {{-- Notification Button --}}
    <button
        class="kt-btn kt-btn-ghost kt-btn-icon hover:bg-primary/10 hover:[&_i]:text-primary size-9 rounded-full notification-toggle">
        <i class="fas fa-bell text-xl"></i>
        @if ($unreadNotificationsCount > 0)
            <span
                class="absolute bg-red-500 bg-danger text-white text-xs rounded-full h-5 w-5 flex items-center justify-center notification-count"
                style="top: -3px; right: -3px;">
                {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
            </span>
        @endif

        <div class="new-notification hidden">new notification</div>
    </button>

    {{-- Dropdown Menu --}}
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute mt-2 w-80 background rounded-md shadow-lg z-50 border border-gray-200 hidden"
        id="notification-dropdown">

        @if (count($notifications) > 0)
            {{-- Header --}}
            <div class="p-2 border-b border-gray-200 flex items-center justify-between">
                <span class="font-semibold text-gray-600" style="font-size: 14px">{{ __('main.notifications') }}</span>
                @if ($unreadNotificationsCount > 0)
                    <button wire:click="markAllAsRead" class="text-blue-600 hover:text-blue-800 cursor-pointer"
                        style="font-size: 14px">
                        {{ __('main.mark_all_read') }}
                    </button>
                @endif
            </div>

            {{-- Notifications List --}}
            <div class="max-h-96 overflow-y-auto">
                <div style="overflow-y: scroll; overflow-X: hidden; max-height: 350px;" id="notifications">
                    @foreach ($notifications as $notification)
                        <div wire:key="notification-{{ $notification->id }}"
                            class="notification p-3 border-gray-100 hover:bg-gray-50 {{ !$notification->is_read ? 'bg-blue-50' : '' }} notification-{{ $notification->id }}">
                            <div class="flex items-start space-x-3">
                                <div class="flex-1 min-w-0">
                                    @if ($notification->title)
                                        <p class="text-sm font-medium text-gray-600 truncate">
                                            {{ $notification->title }}
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-600 {{ !$notification->title ? 'font-medium' : '' }}">
                                        {{ Str::limit($notification->message, 60) }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $notification->human_created_at }}
                                    </p>
                                </div>

                                @if (getActiveUser()?->id == $notification->recipient_user_id)
                                    <div class="flex-shrink-0 flex space-x-1">
                                        <div class="shrink-0 relative">
                                            <div class="cursor-pointer shrink-0 notification-actions-toggle"
                                                data-id="{{ $notification->id }}">
                                                <i class="fas fa-ellipsis" style="color: #4a5565"></i>
                                            </div>

                                            <div data-dropdown="{{ $notification->id }}"
                                                class="notification-actions absolute mt-2 w-[100px] bg-white rounded-md shadow-lg border border-gray-200 hidden"
                                                style="z-index: 10; top: -18px; user-select: none;">
                                                <ul class="p-1">
                                                    @if (!$notification->is_read)
                                                        <li>
                                                            <span wire:click="markAsRead({{ $notification->id }})"
                                                                style="font-size: 10px; padding: 5px 10px; border-radius: 3px;"
                                                                class="block text-gray-700 hover:bg-gray-100 cursor-pointer readNotification-{{ $notification->id }}">
                                                                {{ __('main.mark_read') }}
                                                            </span>
                                                        </li>
                                                    @endif
                                                    @if (!$notification->is_read)
                                                        <li>
                                                            <span wire:click="markAsUnread({{ $notification->id }})"
                                                                style="font-size: 10px; padding: 5px 10px; border-radius: 3px;"
                                                                class="block text-gray-700 hover:bg-gray-100 cursor-pointer unreadNotification-{{ $notification->id }}">
                                                                {{ __('main.mark_unread') }}
                                                            </span>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <span wire:click="deleteNotification({{ $notification->id }})"
                                                            style="font-size: 10px; padding: 5px 10px; border-radius: 3px;"
                                                            class="block text-red-600 hover:bg-gray-100 cursor-pointer deleteNotification-{{ $notification->id }}">
                                                            {{ __('main.delete') }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                <i class="fas fa-bell-slash text-3xl mb-2"></i>
                <p>{{ __('main.no_notifications') }}</p>
            </div>
        @endif

        @if ($notifications->count() > 10)
            {{-- Footer --}}
            <div class="p-3 border-t border-gray-200 text-center">
                <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    {{ __('main.view_all_notifications') }}
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        let wasDropdownOpen = false;
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('notification-dropdown');
            if (e.target.closest('.notification-actions-toggle')) {
                const id = e.target.closest('.notification-actions-toggle').dataset.id;
                document.querySelectorAll('.notification-actions').forEach(dd => dd.classList.add('hidden'));
                const ddDropdown = document.querySelector(`[data-dropdown="${id}"]`);
                ddDropdown?.classList.toggle('hidden');
            } else {
                document.querySelectorAll('.notification-actions').forEach(dd => dd.classList.add('hidden'));
            }

            const toggleBtn = e.target.closest('.notification-toggle');
            const insideDropdown = e.target.closest('#notification-dropdown');

            if (dropdown && !dropdown.classList.contains('hidden')) {
                wasDropdownOpen = true;
            } else {
                wasDropdownOpen = false;
            }

            if (toggleBtn) {
                @this.markAllAsRead();
                dropdown?.classList.toggle('hidden');
                wasDropdownOpen = !dropdown.classList.contains('hidden');
                return;
            }

            if (!insideDropdown) {
                dropdown?.classList.add('hidden');
                wasDropdownOpen = false;
            }
        });

        // window.addEventListener('scroll', (e) => {
        //     const dropdown = document.getElementById('notification-dropdown');
        //     dropdown?.classList.add('hidden');
        // });

        // window.addEventListener('scroll', (e) => {
        //     document.querySelectorAll('.notification-actions').forEach(dd => dd.classList.add('hidden'));
        //     document.getElementById('notification-dropdown').classList.add('hidden');
        // });
        window.addEventListener('notification-readed', (e) => {
            let notificationId = e.detail.id;
            if (notificationId != 'all') {
                document.querySelector('.notification-' + notificationId)?.classList.remove('bg-blue-50');
                document.querySelector('.readNotification-' + notificationId)?.remove();
                let notificationCount = document.querySelector('.notification-count');
                if (notificationCount) {
                    notificationCount.innerText = notificationCount.innerText > 1 ?
                        parseInt(document.querySelector('.notification-count')?.textContent) - 1 :
                        notificationCount.remove();
                }
            } else if (notificationId == 'all') {
                document.querySelectorAll('.notification').forEach(item => {
                    item.classList.remove('bg-blue-50');
                });
                document.querySelectorAll('[class*="readNotification-"]').forEach(item => item.remove());
                document.querySelector('.notification-count')?.remove();
            }
        });
        window.addEventListener('notification-deleted', (e) => {
            const notificationId = e.detail.id;
            document.querySelector('.notification-' + notificationId)?.classList.add('fade-out', 'loading');
            setTimeout(() => {
                document.querySelector('.notification-' + notificationId)?.remove();
            }, 250);
        });
    </script>
@endpush
