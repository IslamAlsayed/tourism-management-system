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
            @include('components.columns', ['allColumns' => $allColumns ?? []])
        @endif
    @endcomponent

    <div class="kt-card-content" wire:target="search,destroy" wire:loading.class="loading">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'users',
                ])
                @endcomponent
            </div>

            @if (isset($data) && !empty($data) && $data->count() > 0)
                {{-- Enhanced Pagination Controls --}}
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const statusUserLogged = ably.channels.get('status-user-logged');
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
