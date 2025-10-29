<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.subregions'),
        'entityName' => __('main.subregion'),
        'showSearch' => true,
    ])
        @include('components.columns', ['allColumns' => $allColumns ?? []])
    @endcomponent

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'subregions',
                ])
                @endcomponent
            </div>

            {{-- Enhanced Pagination Controls --}}
            @include('includes.pagination', ['data' => $data])
        </div>
    </div>
</div>
