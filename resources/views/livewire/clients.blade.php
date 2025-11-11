<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.clients'),
        'entityName' => __('main.client'),
        'sortField' => $sortField,
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
            <div class="mb-4 ps-4 grid grid-cols-1 md-grid-cols-2 gap-4" id="filterClient" wire:target="search"
                wire:loading.class="loading">
                <div>
                    <label for="gender" style="font-size: 14px;">{{ __('main.gender') }}</label>
                    <select wire:model.live="filterClientGender" id="gender" class="kt-input h-[40px] w-48 max-w-full">
                        <option value="">--</option>
                        <option value="male">{{ __('main.male') }}</option>
                        <option value="female">{{ __('main.female') }}</option>
                    </select>
                </div>

                <div>
                    <label for="status" style="font-size: 14px;">{{ __('main.status') }}</label>
                    <select wire:model.live="filterClientStatus" id="status" class="kt-input h-[40px] w-48">
                        <option value="">--</option>
                        <option value="active">{{ __('main.active') }}</option>
                        <option value="inactive">{{ __('main.inactive') }}</option>
                        <option value="blacklisted">{{ __('main.blacklisted') }}</option>
                    </select>
                </div>

                {{-- <select wire:model.live="filterClientStatus" class="kt-input h-[40px] w-48">
                    <option value="">{{ __('main.status') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                    <option value="blacklisted">{{ __('main.blacklisted') }}</option>
                </select> --}}
            </div>
        @endif

        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="clients_table">
            <div class="kt-scrollable-x-auto" wire:target="search,filterClientGender,filterClientStatus"
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
