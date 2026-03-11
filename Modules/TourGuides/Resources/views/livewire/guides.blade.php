<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'allColumns' => $allColumns ?? [],
        'pendingColumns' => $pendingColumns ?? [],
        'modelClass' => $modelClass ?? '',
        'relations' => $relations ?? [],
        'hasCustomColumns' => $hasCustomColumns ?? false,
        'settings' => $settings ?? null,
        'title' => __('main.tours.guides'),
        'entityName' => __('main.tours.guide'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
            @include('components.columns', [
                'allColumns' => $allColumns ?? [],
                'pendingColumns' => $pendingColumns ?? [],
                'selectedIds' => $selectedIds ?? [],
                'modelClass' => $modelClass ?? '',
                'hasCustomColumns' => $hasCustomColumns ?? false,
            ])
        @endif
    @endcomponent

    <div class="kt-card-content px-2 pb-4" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,forceDeleteSelected,exportSelectedPDF,exportSelectedExcel,filterActive,filterRegionId,filterSubregionId,filterCountryId,filterStateId,filterCityId,filterTypeId">

        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 filterTable">
            {{-- Active Filter --}}
            <div>
                <label for="filterActive" class="text-sm font-medium">{{ __('main.status') }}</label>
                <select wire:model.live="filterActive" class="kt-select h-[40px] w-full max-w-full" id="filterActive">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Region Filter --}}
            <div>
                <label for="filterRegionId" class="text-sm font-medium">{{ __('main.regions') }}</label>
                <select wire:model.live="filterRegionId" class="kt-select h-[40px] w-full max-w-full" id="filterRegionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @php $regions = \Modules\Geography\Entities\Region::where('is_active', true)->pluck('name' . (app()->getLocale() == 'ar' ? '_ar' : ''), 'id'); @endphp
                    @foreach ($regions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Subregion Filter --}}
            <div>
                <label for="filterSubregionId" class="text-sm font-medium">{{ __('main.subregions') }}</label>
                <select wire:model.live="filterSubregionId" class="kt-select h-[40px] w-full max-w-full" id="filterSubregionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @php 
                        $subregionsQuery = \Modules\Geography\Entities\Subregion::where('is_active', true);
                        if ($filterRegionId && $filterRegionId !== 'all') {
                            $subregionsQuery->where('region_id', $filterRegionId);
                        }
                        $subregions = $subregionsQuery->pluck('name' . (app()->getLocale() == 'ar' ? '_ar' : ''), 'id'); 
                    @endphp
                    @foreach ($subregions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Country Filter --}}
            <div>
                <label for="filterCountryId" class="text-sm font-medium">{{ __('main.countries') }}</label>
                <select wire:model.live="filterCountryId" class="kt-select h-[40px] w-full max-w-full" id="filterCountryId">
                    <option value="all">{{ __('main.all') }}</option>
                    @php 
                        $countriesQuery = \Modules\Geography\Entities\Country::where('is_active', true);
                        if ($filterSubregionId && $filterSubregionId !== 'all') {
                            $countriesQuery->where('subregion_id', $filterSubregionId);
                        } elseif ($filterRegionId && $filterRegionId !== 'all') {
                            $countriesQuery->whereHas('subregion', function($q) use ($filterRegionId) {
                                $q->where('region_id', $filterRegionId);
                            });
                        }
                        $countries = $countriesQuery->pluck('name' . (app()->getLocale() == 'ar' ? '_ar' : ''), 'id'); 
                    @endphp
                    @foreach ($countries as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- State Filter --}}
            <div>
                <label for="filterStateId" class="text-sm font-medium">{{ __('main.states') }}</label>
                <select wire:model.live="filterStateId" class="kt-select h-[40px] w-full max-w-full" id="filterStateId">
                    <option value="all">{{ __('main.all') }}</option>
                    @php 
                        $statesQuery = \Modules\Geography\Entities\State::where('is_active', true);
                        if ($filterCountryId && $filterCountryId !== 'all') {
                            $statesQuery->where('country_id', $filterCountryId);
                        }
                        $states = $statesQuery->pluck('name' . (app()->getLocale() == 'ar' ? '_ar' : ''), 'id'); 
                    @endphp
                    @foreach ($states as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- City Filter --}}
            <div>
                <label for="filterCityId" class="text-sm font-medium">{{ __('main.cities') }}</label>
                <select wire:model.live="filterCityId" class="kt-select h-[40px] w-full max-w-full" id="filterCityId">
                    <option value="all">{{ __('main.all') }}</option>
                    @php 
                        $citiesQuery = \Modules\Geography\Entities\City::where('is_active', true);
                        if ($filterStateId && $filterStateId !== 'all') {
                            $citiesQuery->where('state_id', $filterStateId);
                        }
                        $cities = $citiesQuery->pluck('name' . (app()->getLocale() == 'ar' ? '_ar' : ''), 'id'); 
                    @endphp
                    @foreach ($cities as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type Filter --}}
            <div>
                <label for="filterTypeId" class="text-sm font-medium">{{ __('main.type') }}</label>
                <select wire:model.live="filterTypeId" class="kt-select h-[40px] w-full max-w-full" id="filterTypeId">
                    <option value="all">{{ __('main.all') }}</option>
                    @php $types = \Modules\TourGuides\Entities\TourGuideType::where('is_active', true)->pluck('type', 'id'); @endphp
                    @foreach ($types as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            <div class="flex items-end">
                @include('components.elements.reset-button', ['resetTarget' => 'filterActive,filterRegionId,filterSubregionId,filterCountryId,filterStateId,filterCityId,filterTypeId'])
            </div>
        </div>

        {{-- Bulk Action Buttons --}}
        @if (!empty($selectedIds) && count($selectedIds) > 0)
            <div
                class="mb-4 flex flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary">{{ count($selectedIds) }}</span>
                </span>

                <div class="flex flex-wrap gap-2">
                    <div x-data="{
                        confirmActivate() {
                                Swal.fire({
                                    title: '{{ __('messages.are_you_sure') }}',
                                    text: `{{ __('messages.confirm_bulk_activate') }}`,
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#059669',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __('main.yes') }}',
                                    cancelButtonText: '{{ __('main.no') }}'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('activateSelected');
                                    }
                                })
                            },
                            confirmDeactivate() {
                                Swal.fire({
                                    title: '{{ __('messages.are_you_sure') }}',
                                    text: `{{ __('messages.confirm_bulk_deactivate') }}`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#ca8a04',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __('main.yes') }}',
                                    cancelButtonText: '{{ __('main.no') }}'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('deactivateSelected');
                                    }
                                })
                            },
                            confirmDelete() {
                                Swal.fire({
                                    title: '{{ __('messages.are_you_sure') }}',
                                    text: `{{ __('messages.confirm_bulk_delete') }}`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __('main.yes') }}',
                                    cancelButtonText: '{{ __('main.no') }}'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('deleteSelected');
                                    }
                                })
                            },
                            confirmForceDelete() {
                                Swal.fire({
                                    title: '{{ __('messages.are_you_sure') }}',
                                    text: `{{ __('messages.confirm_bulk_force_delete') }}`,
                                    icon: 'error',
                                    showCancelButton: true,
                                    confirmButtonColor: '#991b1b',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __('main.yes') }}',
                                    cancelButtonText: '{{ __('main.no') }}'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('forceDeleteSelected');
                                    }
                                })
                            }
                    }" class="flex flex-wrap gap-2 items-center">
                        <button type="button" x-on:click.prevent="confirmActivate"
                            class="kt-btn kt-btn-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ __('main.activate') }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmDeactivate"
                            class="kt-btn kt-btn-sm text-white bg-yellow-600 hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-ban me-1"></i>
                            {{ __('main.deactivate') }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmDelete"
                            class="kt-btn kt-btn-sm text-white bg-red-500 hover:bg-red-600 transition-colors">
                            <i class="fas fa-trash me-1"></i>
                            {{ __('main.delete') }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmForceDelete"
                            class="kt-btn kt-btn-sm text-white bg-red-800 hover:bg-red-900 transition-colors">
                            <i class="fas fa-radiation me-1"></i>
                            {{ __('main.force_delete') }}
                        </button>
                        <button type="button" wire:click="clearSelected"
                            class="kt-btn kt-btn-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            <i class="fas fa-times me-1"></i>
                            {{ __('main.cancel_selection') ?? 'Cancel Selection' }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div data-kt-datatable-state-save="false" id="tour_guides_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.tourguides.guides',
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
