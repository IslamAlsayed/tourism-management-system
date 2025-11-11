{{-- هذا الملف محول إلى Livewire مع الاحتفاظ بنفس الـ structure --}}
<div class="relative">
    <!-- Notification Button -->
    <button wire:click="toggle()"
        class="relative flex items-center p-2 text-gray-600 hover:text-gray-800 focus:outline-none cursor-pointer">
        <i class="fas fa-bell text-xl"></i>
        @if ($unreadNotificationsCount > 0)
            <span
                class="absolute  bg-red-500 bg-danger text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                style="top: -3px; right: -3px;">
                {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="$wire.isOpen" @click.outside="$wire.close()" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 border border-gray-200"
        style="display: none">

        <!-- Header -->
        <div class="p-3 border-b border-gray-200 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">{{ __('main.notifications') }}</h3>
            @if ($unreadNotificationsCount > 0)
                <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800">
                    {{ __('main.mark_all_read') }}
                </button>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div
                    class="p-3 border-b border-gray-100 hover:bg-gray-50 {{ !$notification->is_read ? 'bg-blue-50' : '' }}">
                    <div class="flex items-start space-x-3">
                        <div class="flex-1 min-w-0">
                            @if ($notification->title)
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $notification->title }}
                                </p>
                            @endif
                            <p class="text-sm text-gray-600 {{ !$notification->title ? 'font-medium' : '' }}">
                                {{ Str::limit($notification->message, 60) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 flex space-x-1">
                            <div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px"
                                data-kt-dropdown-offset-rtl="-20px, 10px" data-kt-dropdown-placement="bottom-end"
                                data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
                                <div class="cursor-pointer shrink-0" data-kt-dropdown-toggle="true">
                                    <i class="fas fa-ellipsis"></i>
                                </div>

                                <div class="kt-dropdown-menu w-[300px]" data-kt-dropdown-menu="true">
                                    <ul class="kt-dropdown-menu-sub text-center">
                                        <li>
                                            @if (!$notification->is_read)
                                                <span class="kt-dropdown-menu-link"
                                                    wire:click="markAsRead({{ $notification->id }})">
                                                    {{ __('main.mark_read') }}
                                                </span>
                                            @endif
                                        </li>
                                        <li>
                                            <span class="kt-dropdown-menu-link"
                                                wire:click="deleteNotification({{ $notification->id }})"
                                                onclick="return confirm('{{ __('main.are_you_sure') }}')">
                                                {{ __('main.delete') }}
                                            </span>
                                        </li>
                                        <li>
                                            <a class="kt-dropdown-menu-link">
                                                {{ __('main.report') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-bell-slash text-3xl mb-2"></i>
                    <p>{{ __('main.no_notifications') }}</p>
                </div>
            @endforelse
        </div>

        @if ($notifications->count() > 0)
            <!-- Footer -->
            <div class="p-3 border-t border-gray-200 text-center">
                <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    {{ __('main.view_all_notifications') }}
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Success Messages --}}
@if (session()->has('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50" x-data="{ show: true }"
        x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg z-50" x-data="{ show: true }"
        x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        {{ session('error') }}
    </div>
@endif
