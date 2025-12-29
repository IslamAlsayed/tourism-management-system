<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.crossings-ports'),
        'entityName' => __('main.crossing-port'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,filterType,filterIsActive,filterOperatingDays,resetFilter">
        <!-- Filters -->
        <div class="mb-4 px-4 grid grid-cols-1 md-grid-cols-2 gap-4 filterTable">
            <div>
                <select wire:model.live="filterType" id="type" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.type') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach (config('helpers.crossing_port_types') as $typeValue => $typeLabel)
                        <option value="{{ $typeValue }}" {{ $this->filterType == $typeValue ? 'selected' : '' }}>
                            {{ __('main.' . $typeLabel) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select wire:model.live="filterIsActive" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.status') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active" {{ $this->filterIsActive == 'active' ? 'selected' : '' }}>
                        {{ __('main.active') }}</option>
                    <option value="inactive" {{ $this->filterIsActive == 'inactive' ? 'selected' : '' }}>
                        {{ __('main.inactive') }}</option>
                </select>
            </div>

            <div>
                <select wire:model.live="filterOperatingDays" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.operating_days') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="sunday" {{ $this->filterOperatingDays == 'sunday' ? 'selected' : '' }}>
                        {{ __('main.sunday') }}</option>
                    <option value="monday" {{ $this->filterOperatingDays == 'monday' ? 'selected' : '' }}>
                        {{ __('main.monday') }}</option>
                    <option value="tuesday" {{ $this->filterOperatingDays == 'tuesday' ? 'selected' : '' }}>
                        {{ __('main.tuesday') }}</option>
                    <option value="wednesday" {{ $this->filterOperatingDays == 'wednesday' ? 'selected' : '' }}>
                        {{ __('main.wednesday') }}</option>
                    <option value="thursday" {{ $this->filterOperatingDays == 'thursday' ? 'selected' : '' }}>
                        {{ __('main.thursday') }}</option>
                    <option value="friday" {{ $this->filterOperatingDays == 'friday' ? 'selected' : '' }}>
                        {{ __('main.friday') }}</option>
                    <option value="saturday" {{ $this->filterOperatingDays == 'saturday' ? 'selected' : '' }}>
                        {{ __('main.saturday') }}</option>
                </select>
            </div>

            {{-- Reset Button --}}
            @include('components.elements.reset-button')
        </div>

        <div data-kt-datatable-state-save="false" id="crossings-ports_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'crossings-ports',
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
