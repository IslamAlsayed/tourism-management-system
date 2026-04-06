<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.users2'),
        'entityName' => __('main.user'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
        <div class="d-flex gap-2">
            {{-- <button wire:click="refreshData" class="kt-btn btn-icon kt-btn-sm btn-light-primary" toggle-button
                title="{{ __('main.refresh') }}">
                <i class="fa-duotone fa-solid fa-arrows-rotate fs-2"></i>
            </button> --}}
            @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
                @include('components.columns', [
                    'allColumns' => $allColumns ?? [],
                    'selectedIds' => $selectedIds ?? [],
                ])
            @endif
        </div>
    @endcomponent

    <div class="kt-card-content" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,refreshData">
        <div data-kt-datatable-state-save="false" id="users_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.core.users',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

            @if (isset($data) && !empty($data) && $data->count() > 0)
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let statusUserLogged = ably.channels.get('status-user-logged');
        statusUserLogged.subscribe('user.logged', (message) => {
            if (!message.data) return;
            let userHeart = document.querySelector('.user-heartbeat-' + message.data.id);
            let notificationCount = document.querySelector('.notification-count');
            let newNotification = document.querySelector('.new-notification');

            if (!userHeart) return;
            if (message.data.status == 'online') {
                userHeart.classList.add('active', 'heartbeat');
                if (notificationCount) {
                    let count = parseInt(notificationCount.innerText) || 0;
                    notificationCount.innerText = count + 1;
                    notificationCount.classList.add('bounce-in');
                    setTimeout(() => notificationCount.classList.remove('bounce-in'), 150);
                }
                if (newNotification) {
                    newNotification.classList.remove('hidden');
                    setTimeout(() => newNotification.classList.add('hidden'), 1000);
                }
            } else {
                userHeart.classList.remove('active', 'heartbeat');
            }
        });

        let switchUserActive = ably.channels.get('switch.user.active');
        switchUserActive.subscribe('switch.user.active', (message) => {
            if (!message.data) return;
            @this.dispatch('recordUpdated');
        });
    </script>
@endpush
