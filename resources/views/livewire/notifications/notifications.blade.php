<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.notifications'),
        'entityName' => __('main.notification'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
            @include('components.columns', [
                'allColumns' => $allColumns ?? [],
                'selectedIds' => $selectedIds ?? [],
            ])
        @endif
    @endcomponent

    <div class="kt-card-content px-2" wire:loading.class="loading"
        wire:target="search,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,paginate,setFilter,filterTypeUserId">
        <!-- Filters -->
        <div class="flex flex-wrap gap-2 mb-6 filterTable">
            <button wire:click="setFilter('all')"
                class="kt-btn btn-sm {{ $filter == 'all' ? 'bg-gray-300 text-block user-select-none' : 'bg-primary' }}"
                toggle-button>
                {{ __('main.all') }} ({{ $allCount }})
            </button>

            <button wire:click="setFilter('unread')"
                class="kt-btn btn-sm {{ $filter == 'unread' ? 'bg-gray-300 text-block user-select-none' : 'bg-primary' }}"
                toggle-button>
                {{ __('main.unread') }} ({{ $unreadCount }})
            </button>

            <button wire:click="setFilter('read')"
                class="kt-btn btn-sm {{ $filter == 'read' ? 'bg-gray-300 text-block user-select-none' : 'bg-primary' }}"
                toggle-button>
                {{ __('main.read') }} ({{ $readCount }})
            </button>

            <div>
                <select wire:model.live="filterTypeUserId" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.users') }}">
                    <option value="">--</option>
                    @foreach ($typeUsers as $user)
                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select wire:model.live="notificationType" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.notification_type') }}">
                    <option value="">--</option>
                    <option value="system">{{ __('main.system') }}</option>
                    <option value="push">{{ __('main.push') }}</option>
                    <option value="custom">{{ __('main.custom') }}</option>
                </select>
            </div>

            <div>
                <select wire:model.live="type" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.type') }}">
                    <option value="">--</option>
                    <option value="booking">{{ __('main.booking') }}</option>
                    <option value="payment">{{ __('main.payment') }}</option>
                    <option value="trip">{{ __('main.trip') }}</option>
                    <option value="system">{{ __('main.system') }}</option>
                    <option value="push">{{ __('main.push') }}</option>
                </select>
            </div>

            {{-- Reset Sort Button --}}
            @if ($filterTypeUserId || $notificationType || $type)
                <div>
                    <button type="button" wire:click="resetFilters" title="{{ __('main.reset_validate') }}"
                        toggle-button class="kt-btn kt-btn-outline bg-white px-3hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                        <span class="text-sm">{{ __('main.reset_sort') }}</span>
                    </button>
                </div>
            @endif
        </div>

        <div class="kt-card-content" wire:loading.class="loading"
            wire:target="search,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,paginate">
            <div data-kt-datatable-state-save="false" id="notifications_table">
                <div class="kt-scrollable-x-auto">
                    @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'notifications',
                        'selectedIds' => $selectedIds ?? [],
                    ])
                    @endcomponent
                </div>

                @if (isset($data) && !empty($data) && $data->count() > 0)
                    @include('includes.pagination', ['data' => $data])
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const statusUserLogged = ably.channels.get('web-push-notifications');
        statusUserLogged.subscribe('marked_as_read_all', (message) => {
            if (!message.data) return;
            if (message.data.status == 'marked_as_read_all') {
                @this.call('refreshNotifications');
            }
        });
        statusUserLogged.subscribe('web.push.notifications', (message) => {
            if (!message.data) return;
            @this.call('refreshNotifications');
        });

        window.addEventListener('notification-readed', (e) => {
            if (e.detail.id == 'all') {
                @this.call('refreshNotifications');
            }
        });
    </script>
@endpush
