<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.users'),
        'entityName' => __('main.user'),
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

    <div class="kt-card-content" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel">
        <div data-kt-datatable-state-save="false" id="users_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'users',
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
    </script>
@endpush
