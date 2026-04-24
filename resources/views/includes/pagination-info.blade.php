@if (!isset($onlyColumnPanel) || !$onlyColumnPanel)
<div class="flex-wrap gap-2 p-2">
    <div class="w-full flex flex-wrap justify-between items-start gap-4">
        {{-- Pagination Info --}}
        @if (isset($data) && !empty($data) && $data->count() > 0)
            <div class="pagination-showing">
                <p class="text-sm p-2" style="color: var(--muted-foreground);">
                    {{ __('main.showing') }} {{ $data->firstItem() ?? 0 }} -
                    <strong class="text-primary">{{ $data->lastItem() ?? 0 }}</strong>
                    {{ __('main.of') }} {{ $data->total() }} {{ isset($entityName) ? (app()->getLocale() === 'ar' ? $entityName : \Illuminate\Support\Str::plural($entityName)) : __('main.items') }}
                    @if ($data->hasPages())
                        <span class="text-blue-600">({{ __('main.page') }} {{ $data->currentPage() }} {{ __('main.of') }}
                            {{ $data->lastPage() }})</span>
                    @endif
                </p>
            </div>
        @else
            <div></div>
        @endif

        {{-- selected items count --}}
        <div class="flex flex-wrap gap-2 items-center">
            <span id="selectedCount" style="align-self: anchor-center;"></span>
            <div class="flex flex-wrap gap-2 lg:gap-5">
                <button type="button" id="deleteAllBtn" data-route="{{ route('deleteAll') }}"
                    data-model="{{ isset($entityName) ? lcfirst($entityName) : '' }}"
                    title="{{ __('main.delete_selected') }}"
                    class="deleteAllBtn hidden kt-btn kt-btn-outline bg-secondary px-3 h-[38px]">
                    <i class="fas fa-trash text-red-600"></i>
                </button>
            </div>

            {{-- Reset Sort Button
            @if (isset($sortField) && !empty($sortField))
                <div class="flex items-center">
                    <button type="button" wire:click="resetSort" title="{{ __('main.reset_sort') }}" toggle-button
            class="kt-btn kt-btn-outline bg-white px-3 h-[45px] hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
            <span class="text-sm">{{ __('main.reset_sort') }}</span>
            </button>
        </div>
        @endif --}}

            @isset($slot)
                {{ $slot }}
            @endisset

            {{-- Search input --}}
            {{-- Search input --}}
            @if (isset($showSearch) && $showSearch)
                <div class="flex flex-wrap gap-2 lg:gap-5">
                    <div class="flex items-stretch ms-0 md:ms-2 mt-2 md:mt-0 max-w-[320px] w-full rounded-lg border focus-within:border-primary overflow-hidden transition-all" style="background-color: var(--input); border-color: var(--border);"
                        id="search-container">
                        <div class="relative flex-grow flex items-center bg-transparent">
                            <div class="ps-3 pointer-events-none" style="color: var(--muted-foreground);">
                                <i class="fa-duotone fa-solid fa-magnifying-glass text-md"></i>
                            </div>
                            <input type="text" wire:model.live="search" id="search" @keydown.enter.prevent=""
                                class="w-full bg-transparent border-0 text-sm px-2 py-2.5 outline-none focus:outline-none focus:ring-0 focus:border-transparent shadow-none min-w-0" style="color: var(--foreground);"
                                placeholder="{{ __('main.search_in') }} {{ isset($title) ? $title : __('main.items') }}..."
                                autocomplete="off" style="box-shadow: none !important; border: none !important; outline: none !important;" />
                            @if (isset($search) && $search !== '')
                                <div class="absolute end-1 top-1/2 -translate-y-1/2 flex items-center justify-center p-2 bg-transparent cursor-pointer group hover:text-red-500 transition-colors z-[10]"
                                    wire:click="$set('search', '')" title="{{ __('main.clear_search') }}">
                                    <i class="fa-duotone fa-solid fa-xmark text-xs font-bold" style="color: var(--muted-foreground);"></i>
                                </div>
                            @endif
                            <div class="search-load absolute end-8 top-1/2 -translate-y-1/2 pointer-events-none"
                                wire:loading wire:target="search">
                                <span class="spinner-border spinner-border-sm text-primary opacity-50"
                                    role="status"></span>
                            </div>
                        </div>
                        <button type="button"
                            class="bg-primary flex items-center justify-center text-white px-3 hover:bg-blue-700 transition-colors shrink-0 border-0 outline-none ring-0">
                            <i class="fa-duotone fa-solid fa-magnifying-glass text-md"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endif {{-- End of toolbar (hidden when $onlyColumnPanel) --}}

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- Inline Column Picker Panel (WordPress-style collapsible)      --}}
    {{-- Shows between toolbar and progress bar, pushes content down   --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @php
        // Auto-resolve column data from parent Livewire component if not passed as @component params
        if (!isset($allColumns) || empty($allColumns)) {
            $allColumns = $__env->getShared('__livewire')?->allColumns ?? ($this->allColumns ?? []);
        }
        if (!isset($pendingColumns)) {
            $pendingColumns = $__env->getShared('__livewire')?->pendingColumns ?? ($this->pendingColumns ?? []);
        }
        if (!isset($hasCustomColumns)) {
            $hasCustomColumns = $__env->getShared('__livewire')?->hasCustomColumns ?? ($this->hasCustomColumns ?? false);
        }
        if (!isset($manageableFilters)) {
            $manageableFilters = $__env->getShared('__livewire')?->manageableFilters ?? ($this->manageableFilters ?? []);
        }
    @endphp
    @if (isset($allColumns) && !empty($allColumns))
        <div x-data="{ activeTab: 'all' }" x-show="$store.colPicker && $store.colPicker.open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            x-cloak
            class="relative w-full mt-2 z-[10] rounded-lg shadow-xl" style="background-color: var(--popover); color: var(--popover-foreground); border: 1px solid var(--border);">

            @php
                $allCols = array_values($allColumns ?? []);
                $pendCols = array_values($pendingColumns ?? []); 
                $mFilters = array_keys($manageableFilters ?? []); 
                $mFiltersNames = $manageableFilters ?? []; 

                // Searchable cols = all standard columns
                $searchableCols = array_filter($allCols, fn($c) => !str_starts_with($c, 'action_') && !str_starts_with($c, 'filter_'));

                $cats = [
                    'all' => [],
                    'type_1' => [],
                    'type_2' => [],
                    'actions' => []
                ];

                // Type 1: Dropdown Filters (List of columns that support dropdowns)
                foreach ($mFilters as $fKey) {
                    $cats['type_1'][] = 'type1_' . $fKey;
                }

                // Type 2: Search Filters (All standard columns get a search box inside their column header)
                // Also append the column ID so we know what they select.
                foreach ($searchableCols as $sCol) {
                    if ($sCol == 'uuid' && optional($settings ?? null)->app_show_uuid_column == 0) continue;
                    $cats['type_2'][] = 'type2_' . $sCol;
                }

                // Actions: The action buttons at the end of the row
                foreach (['show', 'edit', 'delete', 'force_delete'] as $act) {
                    $cats['actions'][] = 'action_' . $act;
                }

                // All: Combine everything for the first tab
                $cats['all'] = array_unique(array_merge($cats['type_1'], $cats['type_2'], $cats['actions']));

                $activeCats = array_filter($cats, fn($v) => count($v) > 0);

                $getTab = function ($k) {
                    if ($k === 'type_1') return __('main.type_1_filters');
                    if ($k === 'type_2') return __('main.type_2_filters');
                    if ($k === 'actions') return __('main.actions');
                    if ($k === 'all') return __('main.all');
                    return ucfirst($k);
                };
            @endphp

            <div class="px-4 py-3"
                @close-modal.window="$store.colPicker && $store.colPicker.close()"
                x-data="{
                alpinePendingCols: @entangle('pendingColumns'),
                availableCols: [],
                manageableFiltersKeys: [],
                searchFiltersKeys: [],
                actionFiltersKeys: ['show', 'edit', 'delete', 'force_delete'],
                
                updateGlobalCount() {
                    if (this.$store.colPicker) {
                        this.$store.colPicker.count = this.getTotalChecked();
                    }
                },
                init() {
                    this.availableCols = JSON.parse(this.$el.dataset.cols || '[]');
                    this.manageableFiltersKeys = JSON.parse(this.$el.dataset.filters || '[]');
                    this.searchFiltersKeys = JSON.parse(this.$el.dataset.searchfilters || '[]');
                    
                    this.$watch('alpinePendingCols', cols => {
                        this.broadcastCols(cols);
                        this.updateGlobalCount();
                    });
                    this.$watch('$store.filtersVisibility.filters', () => this.updateGlobalCount());
                    this.broadcastCols(this.alpinePendingCols);
                    this.updateGlobalCount();
                },
                broadcastCols(cols) {
                    document.dispatchEvent(new CustomEvent('live-cols-update', { detail: { cols: [...cols] } }));
                },
                getStoreVal(key) {
                    if (!this.$store.filtersVisibility) return true;
                    let v = this.$store.filtersVisibility.filters[key];
                    return typeof v === 'undefined' ? true : v;
                },
                saveStore() {
                    if (this.$store.filtersVisibility) {
                        localStorage.setItem('systemFiltersVisibility', JSON.stringify(this.$store.filtersVisibility.filters));
                        this.$store.filtersVisibility.filters = { ...this.$store.filtersVisibility.filters };
                    }
                    this.updateGlobalCount();
                },

                // Type 1 Logic (Dropdowns)
                isType1Checked(col) {
                    if (!this.alpinePendingCols.includes(col)) return false;
                    return this.getStoreVal('filter_' + col) !== false;
                },
                toggleType1(col) {
                    let isChecked = this.isType1Checked(col);
                    if (isChecked) {
                        // Uncheck
                        if(this.$store.filtersVisibility) this.$store.filtersVisibility.filters['filter_' + col] = false;
                        if (this.getStoreVal('search_filter_' + col) === false) {
                            let idx = this.alpinePendingCols.indexOf(col);
                            if (idx > -1) this.alpinePendingCols.splice(idx, 1);
                        }
                    } else {
                        // Check
                        if (!this.alpinePendingCols.includes(col)) this.alpinePendingCols.push(col);
                        if(this.$store.filtersVisibility) this.$store.filtersVisibility.filters['filter_' + col] = true;
                    }
                    this.broadcastCols(this.alpinePendingCols);
                    $wire.set('pendingColumns', this.alpinePendingCols, false);
                    this.saveStore();
                },

                // Type 2 Logic (Search Boxes)
                isType2Checked(col) {
                    if (!this.alpinePendingCols.includes(col)) return false;
                    return this.getStoreVal('search_filter_' + col) !== false;
                },
                toggleType2(col) {
                    let isChecked = this.isType2Checked(col);
                    if (isChecked) {
                        // Uncheck
                        if(this.$store.filtersVisibility) this.$store.filtersVisibility.filters['search_filter_' + col] = false;
                        let hasType1 = this.manageableFiltersKeys.includes(col);
                        if (!hasType1 || this.getStoreVal('filter_' + col) === false) {
                            let idx = this.alpinePendingCols.indexOf(col);
                            if (idx > -1) this.alpinePendingCols.splice(idx, 1);
                        }
                    } else {
                        // Check
                        if (!this.alpinePendingCols.includes(col)) this.alpinePendingCols.push(col);
                        if(this.$store.filtersVisibility) this.$store.filtersVisibility.filters['search_filter_' + col] = true;
                    }
                    this.broadcastCols(this.alpinePendingCols);
                    $wire.set('pendingColumns', this.alpinePendingCols, false);
                    this.saveStore();
                },

                // Select All / Clear All
                selectAll() {
                    let newCols = new Set(this.alpinePendingCols);
                    let newFilters = this.$store.filtersVisibility ? { ...this.$store.filtersVisibility.filters } : null;

                    if (this.activeTab === 'type_1' || this.activeTab === 'all') {
                        this.manageableFiltersKeys.forEach(f => {
                            newCols.add(f);
                            if(newFilters) newFilters['filter_' + f] = true;
                        });
                    }
                    if (this.activeTab === 'type_2' || this.activeTab === 'all') {
                        this.searchFiltersKeys.forEach(f => {
                            newCols.add(f);
                            if(newFilters) newFilters['search_filter_' + f] = true;
                        });
                    }
                    if (this.activeTab === 'actions' || this.activeTab === 'all') {
                        this.actionFiltersKeys.forEach(f => { 
                            if(newFilters) newFilters[f] = true; 
                        });
                    }

                    this.alpinePendingCols = Array.from(newCols);
                    if(newFilters) this.$store.filtersVisibility.filters = newFilters;

                    this.broadcastCols(this.alpinePendingCols);
                    // Entangle handles the sync to Livewire, no need to manually call $wire.set for every bulk toggle
                    this.saveStore();
                },
                clearAll() {
                    let newCols = new Set(this.alpinePendingCols);
                    let newFilters = this.$store.filtersVisibility ? { ...this.$store.filtersVisibility.filters } : null;

                    if (this.activeTab === 'type_1') {
                        this.manageableFiltersKeys.forEach(f => {
                            if(newFilters) newFilters['filter_' + f] = false;
                            if (!newFilters || newFilters['search_filter_' + f] === false) {
                                newCols.delete(f);
                            }
                        });
                    }
                    if (this.activeTab === 'type_2') {
                        this.searchFiltersKeys.forEach(f => {
                            if(newFilters) newFilters['search_filter_' + f] = false;
                            let hasType1 = this.manageableFiltersKeys.includes(f);
                            if (!hasType1 || (!newFilters || newFilters['filter_' + f] === false)) {
                                newCols.delete(f);
                            }
                        });
                    }
                    if (this.activeTab === 'actions') {
                        this.actionFiltersKeys.forEach(f => { 
                            if(newFilters) newFilters[f] = false; 
                        });
                    }
                    if (this.activeTab === 'all') {
                        newCols.clear();
                        if(newFilters) {
                            this.manageableFiltersKeys.forEach(f => newFilters['filter_' + f] = false);
                            this.searchFiltersKeys.forEach(f => newFilters['search_filter_' + f] = false);
                            this.actionFiltersKeys.forEach(f => newFilters[f] = false);
                        }
                    }

                    this.alpinePendingCols = Array.from(newCols);
                    if(newFilters) this.$store.filtersVisibility.filters = newFilters;

                    this.broadcastCols(this.alpinePendingCols);
                    this.saveStore();
                },
                
                getTotalChecked() {
                    let checkedType1 = this.manageableFiltersKeys.filter(f => this.isType1Checked(f)).length;
                    let checkedType2 = this.searchFiltersKeys.filter(f => this.isType2Checked(f)).length;
                    let checkedActions = this.actionFiltersKeys.filter(f => this.getStoreVal(f) !== false).length;
                    return checkedType1 + checkedType2 + checkedActions;
                },
                getTotalItems() {
                    return this.manageableFiltersKeys.length + this.searchFiltersKeys.length + this.actionFiltersKeys.length;
                }
            }"
                data-cols="{{ json_encode(array_values($searchableCols ?? [])) }}"
                data-filters="{{ json_encode(array_values($mFilters ?? [])) }}"
                data-searchfilters="{{ json_encode(array_values($searchableCols ?? [])) }}">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-gear text-primary text-sm"></i>
                        <span
                            class="text-sm font-semibold" style="color: var(--foreground);">{{ __('main.manage_columns') }}</span>
                        <span class="kt-badge kt-badge-xs kt-badge-outline kt-badge-primary rounded-full bg-blue-50"
                            x-text="getTotalChecked() + '/' + getTotalItems()"></span>
                    </div>
                    <button @click="$store.colPicker.close()" type="button"
                        class="w-6 h-6 flex items-center justify-center rounded-full transition-colors" style="color: var(--muted-foreground);" onmouseover="this.style.backgroundColor='var(--accent)';this.style.color='var(--accent-foreground)'" onmouseout="this.style.backgroundColor='transparent';this.style.color='var(--muted-foreground)'">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                {{-- Tabs --}}
                <div
                    class="nav nav-pills flex flex-wrap items-center gap-2 mb-4 p-1.5 rounded-xl" style="background-color: var(--muted); border: 1px solid var(--border);">
                    @foreach ($activeCats as $k => $cols)
                        <button @click="activeTab = '{{ $k }}'" type="button"
                            :class="activeTab === '{{ $k }}' ?
                                'shadow-sm' :
                                ''"
                            :style="activeTab === '{{ $k }}' ?
                                'background-color: var(--foreground); color: var(--background); border-color: transparent;' :
                                'background-color: var(--background); color: var(--muted-foreground); border-color: var(--border);'"
                            class="px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-200 flex items-center gap-2 border">
                            @if ($k === 'all')
                                <i class="fa-duotone fa-solid fa-grid-2 text-sm"></i>
                            @elseif($k === 'type_1')
                                <i class="fa-duotone fa-solid fa-filter text-sm"></i>
                            @elseif($k === 'type_2')
                                <i class="fa-duotone fa-solid fa-table-cells text-sm"></i>
                            @elseif($k === 'actions')
                                <i class="fa-duotone fa-solid fa-gear-2 text-sm"></i>
                            @endif
                            <span>{{ $getTab($k) }}</span>
                            <span
                                :style="activeTab === '{{ $k }}' ? 'background-color: rgba(255,255,255,0.2); color: inherit;' :
                                    'background-color: var(--accent); color: var(--accent-foreground);'"
                                class="px-2 py-0.5 rounded-md text-[10px] font-bold">{{ count($cols) }}</span>
                        </button>
                    @endforeach
                </div>

                {{-- Grid of Columns --}}
                <div class="h-[350px] overflow-y-auto overflow-x-hidden pe-2 custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 relative pb-4">
                        @foreach (array_filter($activeCats, fn($key) => $key !== 'all', ARRAY_FILTER_USE_KEY) as $k => $cols)
                            <div class="contents" id="sortable-{{ $k }}">
                                @foreach ($cols as $itemKey)
                                    @php
                                        $isType1 = str_starts_with($itemKey, 'type1_');
                                        $isType2 = str_starts_with($itemKey, 'type2_');
                                        $isAction = str_starts_with($itemKey, 'action_');
                                        
                                        $col = str_replace(['type1_', 'type2_', 'action_'], '', $itemKey);
                                        
                                        // Standardized blue styling across all types
                                        $activeBorder = 'border-primary bg-primary/5 ring-1 ring-primary/20 shadow-sm';
                                        $activeText = 'text-primary';
                                        
                                        if ($isType1) {
                                            $cleanCol = str_replace('_id', '', $col);
                                            $trObj = __('main.' . $cleanCol);
                                            $colName = (is_string($trObj) && $trObj !== 'main.' . $cleanCol) ? $trObj : ucfirst(str_replace('_', ' ', $col));
                                            $lb = __('main.type_1_filters') . ' : ' . ($mFiltersNames[$col] ?? $colName);
                                            $alpineChecked = "isType1Checked('{$col}')";
                                            $alpineToggle = "toggleType1('{$col}')";
                                        } elseif ($isType2) {
                                            $cleanCol = str_replace('_id', '', $col);
                                            $trObj = __('main.' . $cleanCol);
                                            $colName = (is_string($trObj) && $trObj !== 'main.' . $cleanCol) ? $trObj : ucfirst(str_replace('_', ' ', $col));
                                            $lb = __('main.type_2_filters') . ' : ' . $colName;
                                            $alpineChecked = "isType2Checked('{$col}')";
                                            $alpineToggle = "toggleType2('{$col}')";
                                        } else { // Action
                                            $actTranslated = __('main.' . $col);
                                            $lb = __('main.actions') . ' : ' . ((is_string($actTranslated) && $actTranslated !== 'main.' . $col) ? $actTranslated : ucfirst(str_replace('_', ' ', $col)));
                                            $alpineChecked = "(!\$store.filtersVisibility || \$store.filtersVisibility.filters['{$col}'] !== false)";
                                            $alpineToggle = "if(\$store.filtersVisibility) { \$store.filtersVisibility.toggle('{$col}'); saveStore(); }";
                                        }
                                    @endphp
                                    <div x-show="activeTab === '{{ $k }}' || activeTab === 'all'" style="display: none;">
                                        <label class="group flex items-center justify-between px-3 py-2.5 rounded-xl border transition-all duration-200 cursor-pointer mb-2"
                                            :class="{{ $alpineChecked }} ? '{{ $activeBorder }}' : ''"
                                            :style="{{ $alpineChecked }} ? '' : 'border-color: var(--border); background-color: var(--background);'"
                                            title="{{ $lb }}">
                                            
                                            <div class="flex items-center gap-3 w-full cursor-pointer flex-1 min-w-0">
                                                <input type="checkbox" 
                                                    :checked="{{ $alpineChecked }}"
                                                    @change="{{ $alpineToggle }}"
                                                    class="kt-checkbox kt-checkbox-sm peer shrink-0 rounded-md transition-transform active:scale-90"
                                                    style="border-color: currentColor;">
                                                <span class="text-[13px] font-bold truncate tracking-tight"
                                                    :style="{{ $alpineChecked }} ? 'color: var(--primary);' : 'color: var(--muted-foreground);'">
                                                    {{ $lb }}
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Footer --}}
                <div
                    class="flex flex-wrap items-center justify-between gap-4 pt-4 mt-2" style="border-top: 1px solid var(--border);">
                    <div class="flex items-center gap-2 flex-wrap">
                        @if (Auth::check() && getActiveUser()->hasRole('superadmin'))
                            <button type="button" wire:click="saveAsSystemDefault" wire:loading.attr="disabled"
                                title="حفظ هذه الأعمدة كإعدادات افتراضية لجميع مستخدمي النظام"
                                class="kt-btn kt-btn-sm bg-primary/10 text-primary hover:bg-primary/20 px-4 py-2 font-bold shadow-sm">
                                <i class="fa-duotone fa-solid fa-floppy-disk-2 text-md"></i>
                                {{ __('main.save_as_system_default') ?? 'Set as System Default' }}
                            </button>
                        @endif

                        <button type="button" wire:loading.attr="disabled" @click="selectAll()"
                            class="kt-btn kt-btn-sm px-4 py-2 font-bold shadow-sm" style="background-color: var(--accent); color: var(--accent-foreground);">
                            <i class="fa-duotone fa-solid fa-equals text-md"></i>
                            {{ __('main.all_columns') }}
                        </button>

                        <button type="button" wire:loading.attr="disabled" @click="clearAll()"
                            class="kt-btn kt-btn-sm px-4 py-2 font-bold shadow-sm" style="background-color: var(--accent); color: var(--accent-foreground);">
                            <i class="fa-duotone fa-solid fa-eraser text-md"></i>
                            {{ __('main.clear_all') ?? 'تفريغ الكل' }}
                        </button>

                        @if (isset($hasCustomColumns) && $hasCustomColumns)
                            <button type="button" wire:click="resetColumns" wire:loading.attr="disabled"
                                title="{{ __('main.reset_to_default_desc') ?? 'يعيد الحقول إلى الإعدادات الافتراضية الخاصة بالنظام' }}"
                                class="kt-btn kt-btn-sm bg-red-100 text-red-600 hover:bg-red-200 px-4 py-2 font-bold shadow-sm">
                                <span wire:loading.remove wire:target="resetColumns" class="flex items-center gap-2">
                                    <i class="fa-duotone fa-solid fa-arrows-rotate text-md"></i>
                                    {{ __('main.reset_to_default') }}
                                </span>
                                <span wire:loading wire:target="resetColumns"><i
                                        class="fas fa-spinner fa-spin text-sm"></i></span>
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="$store.colPicker.close()" type="button"
                            class="kt-btn kt-btn-sm kt-btn-ghost px-4 py-2 font-bold" style="color: var(--muted-foreground);">
                            {{ __('main.close') }}
                        </button>
                        <button type="button" wire:click="applyColumns" wire:loading.attr="disabled"
                            class="kt-btn kt-btn-sm kt-btn-primary px-8 py-2 font-bold shadow-lg active:scale-95 transition-all">
                            <span wire:loading.remove wire:target="applyColumns" class="flex items-center gap-2">
                                <i class="fa-duotone fa-solid fa-check text-md"></i> {{ __('main.apply') }}
                            </span>
                            <span wire:loading wire:target="applyColumns"><i
                                    class="fas fa-spinner fa-spin text-sm"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Progress bar showing current page position --}}
    @if (!isset($onlyColumnPanel) || !$onlyColumnPanel)
        @if (isset($data) &&
                !empty($data) &&
                getPaginate() != config('app.paginate_max') &&
                $data->hasPages() &&
                $data->lastPage() > 1)
        <div class="w-full mt-3">
                <div class="flex items-center gap-2 text-xs" style="color: var(--muted-foreground);">
                    <span>{{ __('main.progress') }}:</span>
                    <div class="flex-1 bg-primary/10 rounded-full h-2 relative">
                        <div class="absolute inset-0 h-2 rounded-full transition-all duration-300"
                            style="width: {{ ($data->currentPage() / $data->lastPage()) * 100 }}%; background: linear-gradient(90deg, var(--color-primary), var(--color-primary-light, #818cf8));"></div>
                    </div>
                    <span>{{ number_format(($data->currentPage() / $data->lastPage()) * 100, 1) }}%</span>
                </div>
            </div>
        @endif
    @endif

@if (!isset($onlyColumnPanel) || !$onlyColumnPanel)
</div>
@endif
