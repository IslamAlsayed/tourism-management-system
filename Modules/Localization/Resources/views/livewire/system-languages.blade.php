<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'allColumns' => $allColumns ?? [],
        'pendingColumns' => $pendingColumns ?? [],
        'relations' => $relations ?? [],
        'hasCustomColumns' => $hasCustomColumns ?? false,
        'title' => __('main.system_languages'),
        'entityName' => __('main.language'),
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

    <div class="kt-card-content" id="pageContent" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,toggleGridLength">

        {{-- Bulk Action Buttons --}}
        <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0"
                class="mb-4 flex flex-shrink flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary" x-text="$wire.selectedIds.length"></span>
                </span>

                <div x-data="{
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
                                $wire.call('deleteSelected');
                            }
                        })
                    },
                    confirmForceDelete() {
                        Swal.fire({
                            title: '{{ __('messages.are_you_sure') }}',
                            text: `{{ __('messages.confirm_force_delete_bulk') ?? __('messages.confirm_bulk_delete') }}`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: '{{ __('main.yes') }}',
                            cancelButtonText: '{{ __('main.no') }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $wire.call('forceDeleteSelected');
                            }
                        })
                    }
                }" class="flex flex-wrap gap-2 items-center">
                    <button type="button" wire:click.prevent="bulkActivate" class="kt-btn kt-btn-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                        <i class="fas fa-check me-1"></i> {{ __('main.activate') }}
                    </button>
                    <button type="button" wire:click.prevent="bulkDeactivate" class="kt-btn kt-btn-sm text-white bg-yellow-500 hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-ban me-1"></i> {{ __('main.deactivate') }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmDelete" class="kt-btn kt-btn-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash me-1"></i> {{ __('main.delete') }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmForceDelete" class="kt-btn kt-btn-sm text-white bg-red-800 hover:bg-red-900 transition-colors" title="{{ __('main.force_delete') }}">
                        <i class="fas fa-radiation me-1"></i> {{ __('main.force_delete') }}
                    </button>
                    <button type="button" wire:click.prevent="clearSelected" class="kt-btn kt-btn-sm text-gray-700 bg-gray-200 hover:bg-gray-300 transition-colors border border-gray-300">
                        <i class="fas fa-times me-1"></i> {{ __('main.cancel_selection') }}
                    </button>
                </div>
            </div>

        @if ($view == 'grid')
            <div class="kt-cards p-4" wire:key="{{ $view ? $view : '' }}-view">
                <div class="inline-flex text-nowrap items-center gap-2 text-center mb-2 cursor-pointer">
                    @include('components.elements.all-checkbox-button', [
                        'name' => 'selectAllItems',
                        'id' => 'selectAllItems',
                        'label' => __('main.select_type', ['type' => __('main.all')]),
                    ])

                    {{-- Grid length --}}
                    <div>
                        <select wire:change="toggleGridLength($event.target.value,'system_languages')"
                            wire:model.live="gridLength" class="kt-select">
                            @for ($length = 1; $length <= 10; $length++)
                                <option value="{{ $length }}">{{ $length }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="grid gap-6 mb-4" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="sortable-languages-grid">
                    @foreach ($data as $language)
                        <div wire:key="{{ $language->id }}" 
                             data-id="{{ $language->id }}"
                             class="kt-card relative flex flex-col justify-between p-0 overflow-hidden shadow-sm {{ getCurrentLocale() == $language->code ? 'border border-primary bg-primary-light' : 'hover:shadow-md transition-shadow group' }}">

                            @if($language->photo)
                                <!-- Background Watermark from request -->
                                <div class="absolute inset-0 opacity-10 pointer-events-none bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat transition-opacity duration-300 group-hover:opacity-15"
                                     style="background-image: url('{{ str_contains($language->photo, '/') ? asset('storage/' . $language->photo) : asset('assets/media/flags/' . $language->photo) }}'); z-index: 0;"></div>
                            @endif
                            
                            {{-- Drag Handle & Checkbox --}}
                            <div class="absolute top-3 right-3 flex items-center gap-2 z-10">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'selectedItems[]',
                                    'id' => 'selectedItems' . $language->id,
                                    'value' => $language->id,
                                ])
                                <div class="cursor-move p-1 text-gray-400 hover:text-gray-700 drag-handle" title="{{ __('main.drag_to_reorder') }}">
                                    <i class="fa-duotone fa-solid fa-grip-lines text-lg"></i>
                                </div>
                            </div>

                            {{-- Header section: Avatar + Text --}}
                            <div class="p-5 flex flex-col items-center justify-center w-full gap-3 mt-4">
                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-dashed border-gray-300 flex items-center justify-center p-1">
                                    @if($language->photo)
                                        <img src="{{ str_contains($language->photo, '/') ? asset('storage/' . $language->photo) : asset('assets/media/flags/' . $language->photo) }}" class="w-full h-full rounded-full object-cover" alt="{{ $language->code }} flag">
                                    @else
                                        <div class="w-full h-full rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-lg uppercase">
                                            {{ substr($language->code, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <div class="text-base font-semibold text-gray-900">{!! highlightSearch($language->name ?? '--', $search) !!}</div>
                                    <div class="text-sm font-medium text-gray-500 mt-1 uppercase tracking-wider">{!! highlightSearch($language->code ?? '--', $search) !!}</div>
                                </div>
                            </div>

                            {{-- Body section: Details (Arabic Name, Native, Dir & Status Toggle) --}}
                            <div class="px-5 py-3 border-t border-gray-100 flex flex-col gap-2">
                                @if ($language->name_ar)
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">{{ __('main.arabic_name') }}</span>
                                        <span class="text-sm font-medium">{!! highlightSearch($language->name_ar, $search) !!}</span>
                                    </div>
                                @endif
                                @if ($language->native)
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-xs text-gray-500">{{ __('main.native_name') }}</span>
                                        <span class="text-sm font-medium">{!! highlightSearch($language->native, $search) !!}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-500">{{ __('main.direction') }}</span>
                                    <span class="text-sm font-medium uppercase">{{ $language->dir }}</span>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-500">{{ __('main.status') }}</span>
                                    <label>
                                        <input class="kt-switch kt-switch-sm" type="checkbox" wire:click="toggleActive({{ $language->id }})" {{ $language->is_active ? 'checked' : '' }} value="1" {{ $language->is_default ? 'disabled' : '' }} />
                                    </label>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-500">{{ __('main.default_language') }}</span>
                                    @if ($language->is_default)
                                        <span class="kt-badge kt-badge-sm kt-badge-warning kt-badge-outline">
                                            <i class="fas fa-star text-yellow-500 me-1"></i> {{ __('main.default') }}
                                        </span>
                                    @else
                                        <button wire:click="setAsDefault({{ $language->id }})" class="kt-btn kt-btn-xs kt-btn-outline text-gray-500 hover:text-yellow-500 transition-colors" title="{{ __('main.set_as_default') }}">
                                            <i class="far fa-star"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- Footer section: Actions --}}
                            <div class="p-3 border-t border-gray-100 bg-gray-50/50 rounded-b-lg flex flex-wrap items-center justify-center gap-2"
                                x-data
                                x-show="!$store.filtersVisibility || 
                                       $store.filtersVisibility.filters['show'] !== false || 
                                       $store.filtersVisibility.filters['edit'] !== false || 
                                       $store.filtersVisibility.filters['delete'] !== false || 
                                       $store.filtersVisibility.filters['force_delete'] !== false"
                                x-transition x-cloak>
                                @if (getCurrentLocale() != $language->code)
                                    <a href="{{ route('dashboard.localization.system-languages.change', $language->code) }}"
                                        class="kt-btn kt-btn-sm kt-btn-light-success px-3">
                                        {{ __('main.active') }}
                                    </a>
                                @else
                                    <span class="kt-btn kt-btn-sm kt-btn-outline kt-btn-primary">
                                        <i class="fa-duotone fa-solid fa-check-circle me-1"></i> {{ __('main.currently') }}
                                    </span>
                                @endif
                                
                                <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['show'] !== false" x-transition x-cloak>
                                    @include('components.elements.show-button', [
                                        'models' => 'dashboard.localization.system-languages',
                                        'id' => $language->id,
                                    ])
                                </div>
                                
                                <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['edit'] !== false" x-transition x-cloak>
                                    @include('components.elements.edit-button', [
                                        'models' => 'dashboard.localization.system-languages',
                                        'id' => $language->id,
                                    ])
                                </div>
                                
                                <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['delete'] !== false" x-transition x-cloak>
                                    @include('components.elements.delete-button', [
                                        'id' => $language->id,
                                    ])
                                </div>
                                
                                <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['force_delete'] !== false" x-transition x-cloak>
                                    @include('components.elements.forceDelete-button', [
                                        'id' => $language->id,
                                    ])
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div wire:key="{{ $view ? $view : '' }}-view" data-kt-datatable="true" data-kt-datatable-state-save="false"
                id="team_crew_table"
                x-data="{
                    init() {
                        setTimeout(() => this.updateWidth(), 200);
                        window.addEventListener('resize', () => { setTimeout(() => this.updateWidth(), 100); });
                        const observer = new MutationObserver(() => this.updateWidth());
                        if (this.$refs.actualTable) observer.observe(this.$refs.actualTable, { childList: true, subtree: true });
                    },
                    syncTop(e) { this.$refs.bottomScroll.scrollLeft = e.target.scrollLeft; },
                    syncBottom(e) { this.$refs.topScroll.scrollLeft = e.target.scrollLeft; },
                    updateWidth() {
                        if(this.$refs.actualTable && this.$refs.dummyContent) {
                            this.$refs.dummyContent.style.width = this.$refs.actualTable.scrollWidth + 'px';
                        }
                    }
                }">
                
                {{-- Top Scrollbar --}}
                <div x-ref="topScroll" @scroll="syncTop" class="top-scroll w-full overflow-x-auto overflow-y-hidden custom-scrollbar" wire:ignore style="scrollbar-color: #2563eb rgba(37,99,235,0.08);">
                    <div class="top-scroll-inner" x-ref="dummyContent" style="height: 1px;"></div>
                </div>

                {{-- Actual Table Container --}}
                <div x-ref="bottomScroll" @scroll="syncBottom" class="table-wrapper w-full overflow-x-auto custom-scrollbar" wire:loading.class="loading"
                    wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel">
                    <table x-ref="actualTable" class="kt-table w-full text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-10 px-4 py-3 text-center"></th>
                                <th class="w-[60px] px-4 py-3 text-center">
                                    @include('components.elements.all-checkbox-button', [
                                        'name' => 'selectAllItems',
                                        'id' => 'selectAllItems',
                                    ])
                                </th>
                                @foreach ($columns as $column)
                                    @if (!in_array($column, ['is_active', 'is_default']))
                                        <th
                                            class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('main.' . $column) }}
                                        </th>
                                    @endif
                                @endforeach
                                <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('main.status') }}</th>
                                <th class="px-4 py-3"
                                    x-data
                                    x-show="!$store.filtersVisibility || 
                                           $store.filtersVisibility.filters['show'] !== false || 
                                           $store.filtersVisibility.filters['edit'] !== false || 
                                           $store.filtersVisibility.filters['delete'] !== false || 
                                           $store.filtersVisibility.filters['force_delete'] !== false"
                                    x-transition x-cloak>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sortable-languages-table">
                            @foreach ($data as $language)
                                <tr wire:key="{{ $language->id }}"
                                    data-id="{{ $language->id }}"
                                    class="group {{ getCurrentLocale() == $language->code ? 'bg-gray-100' : 'hover:bg-gray-100 transition-colors' }}">
                                    <td class="px-4 py-2 text-center align-middle">
                                        <div class="flex flex-col items-center gap-1">
                                            @if(!$loop->first)
                                                <button type="button" wire:click.prevent="moveUp({{ $language->id }})" class="p-1 text-gray-400 hover:text-blue-600 focus:outline-none" title="{{ __('main.move_up') }}">
                                                    <i class="fas fa-chevron-up text-xs"></i>
                                                </button>
                                            @endif
                                            
                                            <div class="cursor-move p-1 text-gray-400 hover:text-gray-700 drag-handle" title="{{ __('main.drag_to_reorder') }}">
                                                <i class="fa-duotone fa-solid fa-grip-lines text-lg"></i>
                                            </div>

                                            @if(!$loop->last)
                                                <button type="button" wire:click.prevent="moveDown({{ $language->id }})" class="p-1 text-gray-400 hover:text-blue-600 focus:outline-none" title="{{ __('main.move_down') }}">
                                                    <i class="fas fa-chevron-down text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'selectedItems[]',
                                            'id' => 'selectedItems' . $language->id,
                                            'value' => $language->id,
                                        ])
                                    </td>
                                    @foreach ($columns as $column)
                                        @if (!in_array($column, ['is_active', 'is_default']))
                                            @if ($column == 'name')
                                                <td class="px-4 py-2">
                                                    <div class="flex items-center gap-2">
                                                        @if($language->photo)
                                                            <img src="{{ str_contains($language->photo, '/') ? asset('storage/' . $language->photo) : asset('assets/media/flags/' . $language->photo) }}" class="w-6 h-4 rounded shadow-sm object-cover" alt="{{ $language->code }} flag">
                                                        @endif
                                                        <span>{!! highlightSearch($language->name, $search) !!}</span>
                                                    </div>
                                                </td>
                                            @else
                                                @include('components.static-columns', [
                                                    'column' => $column,
                                                    'model' => $language,
                                                    'models' => 'system-languages',
                                                    'search' => $search,
                                                ])
                                            @endif
                                        @endif
                                    @endforeach
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-2">
                                            <label>
                                                <input class="kt-switch kt-switch-sm" type="checkbox" wire:click="toggleActive({{ $language->id }})" {{ $language->is_active ? 'checked' : '' }} value="1" {{ $language->is_default ? 'disabled' : '' }} />
                                            </label>
                                            @if ($language->is_default)
                                                <span class="kt-badge kt-badge-xs kt-badge-warning kt-badge-outline" title="{{ __('main.default_language') }}">
                                                    <i class="fas fa-star text-yellow-500"></i>
                                                </span>
                                            @else
                                                <button wire:click="setAsDefault({{ $language->id }})" class="text-gray-400 hover:text-yellow-500 transition-colors" title="{{ __('main.set_as_default') }}">
                                                    <i class="far fa-star text-sm"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-end">
                                        <div class="flex items-center justify-end gap-2"
                                            x-data
                                            x-show="!$store.filtersVisibility || 
                                                   $store.filtersVisibility.filters['show'] !== false || 
                                                   $store.filtersVisibility.filters['edit'] !== false || 
                                                   $store.filtersVisibility.filters['delete'] !== false || 
                                                   $store.filtersVisibility.filters['force_delete'] !== false"
                                            x-transition x-cloak>
                                            @if (getCurrentLocale() != $language->code)
                                                <a href="{{ route('dashboard.localization.system-languages.change', $language->code) }}"
                                                    class="kt-btn kt-btn-sm kt-btn-outline bg-success text-white">
                                                    {{ __('main.active') }}
                                                </a>
                                            @else
                                                <span style="padding-inline: 17px"
                                                    class="kt-btn kt-btn-sm bg-yellow-500 text-white">
                                                    {{ __('main.currently') }}
                                                </span>
                                            @endif
                                            
                                            <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['show'] !== false" x-transition x-cloak>
                                                @include('components.elements.show-button', [
                                                    'models' => 'dashboard.localization.system-languages',
                                                    'id' => $language->id,
                                                ])
                                            </div>
                                            
                                            <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['edit'] !== false" x-transition x-cloak>
                                                @include('components.elements.edit-button', [
                                                    'models' => 'dashboard.localization.system-languages',
                                                    'id' => $language->id,
                                                ])
                                            </div>
                                            
                                            <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['delete'] !== false" x-transition x-cloak>
                                                @include('components.elements.delete-button', [
                                                    'id' => $language->id,
                                                ])
                                            </div>
                                            
                                            <div x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['force_delete'] !== false" x-transition x-cloak>
                                                @include('components.elements.forceDelete-button', [
                                                    'id' => $language->id,
                                                ])
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('includes.pagination', ['data' => $data])
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const initSortable = (id) => {
            const el = document.getElementById(id);
            if (el) {
                Sortable.create(el, {
                    animation: 150,
                    delay: 50,
                    delayOnTouchOnly: true,
                    handle: '.drag-handle',
                    ghostClass: 'opacity-50',
                    onEnd: function (evt) {
                        const orderIds = Array.from(el.children).map(item => item.getAttribute('data-id')).filter(id => id);
                        $wire.call('updateOrder', orderIds);
                    }
                });
            }
        };

        const initAllSortables = () => {
            initSortable('sortable-languages-grid');
            initSortable('sortable-languages-table');
        };

        initAllSortables();

        Livewire.hook('morph.updated', ({ el, component }) => {
            initAllSortables();
        });
    });
</script>
@endpush

