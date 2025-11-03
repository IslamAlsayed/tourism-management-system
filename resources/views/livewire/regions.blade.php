<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.regions'),
        'entityName' => __('main.region'),
        'searchValue' => $search,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('components.columns', ['allColumns' => $allColumns ?? []])
        @endif
    @endcomponent

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto" wire:target="search" wire:loading.class="loading">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'regions',
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
