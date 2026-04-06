<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.field-definitions'),
        'entityName' => __('main.field-definition'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,resetFilters,filterModule,filterFieldType,filterStatus">

        <!-- Filters -->
        @if (isset($data) && !empty($data) && $data->count() > 0)
            <div class="mb-4 grid grid-cols-1 md-grid-cols-3 gap-4 px-4 filterTable">
                <div>
                    <select wire:model.live="filterModule" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                        data-kt-select-placeholder="{{ __('main.module') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        @foreach (\Modules\Definitions\Entities\FieldDefinition::getModules() as $modKey => $modLabel)
                            <option value="{{ $modKey }}">{{ $modLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select wire:model.live="filterFieldType" class="kt-select h-[40px] w-48 max-w-full"
                        data-kt-select="true" data-kt-select-placeholder="{{ __('main.field_type') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        @foreach (\Modules\Definitions\Entities\FieldDefinition::getFieldTypes() as $typeKey => $typeLabel)
                            <option value="{{ $typeKey }}">{{ $typeLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select wire:model.live="filterStatus" class="kt-select h-[40px] w-48 max-w-full"
                        data-kt-select="true" data-kt-select-placeholder="{{ __('main.status') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        <option value="active">{{ __('main.active') }}</option>
                        <option value="inactive">{{ __('main.inactive') }}</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                @include('components.elements.reset-button')
            </div>
        @endif

        <div data-kt-datatable-state-save="false" id="field_definitions_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.definitions.field-definitions',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

            @if (isset($data) && !empty($data) && $data->count() > 0)
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>
    </div>
</div>
