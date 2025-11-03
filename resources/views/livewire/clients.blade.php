<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.clients'),
        'entityName' => __('main.client'),
        'searchValue' => $search,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('components.columns', ['allColumns' => $allColumns ?? []])
        @endif
    @endcomponent

    <div class="kt-card-content">
        @if (isset($data) && !empty($data) && $data->count() > 0)
            <!-- Filters -->
            <div class="mb-4 ps-4 flex gap-4" wire:target="search" wire:loading.class="loading">
                <select wire:model.live="filterClientType" class="kt-input h-[40px] w-48">
                    <option value="">{{ __('main.all_client_types') }}</option>
                    <option value="individual">{{ __('main.individual') }}</option>
                    <option value="corporate">{{ __('main.corporate') }}</option>
                </select>

                <select wire:model.live="filterClientStatus" class="kt-input h-[40px] w-48">
                    <option value="">{{ __('main.all_status') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                    <option value="blacklisted">{{ __('main.blacklisted') }}</option>
                </select>
            </div>
        @endif

        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="clients_table">
            <div class="kt-scrollable-x-auto" wire:target="search,filterClientType,filterClientStatus"
                wire:loading.class="loading">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'clients',
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
