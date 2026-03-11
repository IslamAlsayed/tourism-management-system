<div class="flex-wrap gap-2 p-2">
    <div class="w-full flex justify-between items-start">
        {{-- Pagination Info --}}
        @if (isset($data) && !empty($data) && $data->count() > 0)
            <div class="pagination-showing">
                <p class="text-sm text-gray-600 p-2">
                    {{ __('main.showing') }} {{ $data->firstItem() ?? 0 }} -
                    <strong class="text-primary">{{ $data->lastItem() ?? 0 }}</strong>
                    {{ __('main.of') }} {{ $data->total() }} {{ isset($entityName) ? $entityName : __('main.items') }}
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
        <div class="flex gap-2">
            <span id="selectedCount" style="align-self: anchor-center;"></span>
            <div class="flex flex-wrap gap-2 lg:gap-5">
                <button type="button" id="deleteAllBtn" data-route="{{ route('deleteAll') }}"
                    data-model="{{ isset($entityName) ? lcfirst($entityName) : '' }}"
                    title="{{ __('main.delete_selected') }}"
                    class="deleteAllBtn hidden kt-btn kt-btn-outline bg-secondary px-3 h-[45px]">
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
                    <div class="flex items-stretch ms-0 md:ms-2 mt-2 md:mt-0 max-w-[320px] w-full bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary overflow-hidden shadow-sm transition-all" id="search-container">
                        <div class="relative flex-grow flex items-center bg-white dark:bg-gray-800">
                            <div class="ps-3 text-gray-400 pointer-events-none">
                                <i class="ki-outline ki-magnifier text-md"></i>
                            </div>
                            <input type="text"
                                wire:model.live="search"
                                id="search"
                                @keydown.enter.prevent=""
                                class="w-full bg-transparent border-none text-sm px-2 py-2.5 focus:ring-0 outline-none text-gray-700 dark:text-gray-200 min-w-0"
                                placeholder="{{ __('main.search_in') }} {{ isset($title) ? $title : __('main.items') }}..."
                                autocomplete="off" />
                            @if (isset($searchValue) && $searchValue)
                                <div class="absolute end-1 top-1/2 -translate-y-1/2 flex items-center justify-center p-2 bg-white dark:bg-gray-800 cursor-pointer group hover:text-red-500 transition-colors z-[10]" 
                                     wire:click="$set('search', '')" 
                                     title="{{ __('main.clear_search') }}">
                                    <i class="ki-outline ki-cross text-xs font-bold"></i>
                                </div>
                            @endif
                            <div class="search-load absolute end-8 top-1/2 -translate-y-1/2 pointer-events-none" wire:loading wire:target="search">
                                <span class="spinner-border spinner-border-sm text-primary opacity-50" role="status"></span>
                            </div>
                        </div>
                        <button type="button" class="bg-primary flex items-center justify-center text-white px-3 hover:bg-blue-700 transition-colors shrink-0">
                            <i class="ki-outline ki-magnifier text-md"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- Inline Column Picker Panel (WordPress-style collapsible)      --}}
    {{-- Shows between toolbar and progress bar, pushes content down   --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @if (isset($columns) && !empty($columns))
    <div x-data="{ activeTab: 'all' }" x-show="$store.colPicker && $store.colPicker.open" x-collapse x-cloak
         class="w-full mt-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800/60 dark:to-[#1e1e2d] overflow-hidden">

        @php
            $allCols = $allColumns ?? [];
            $pendCols = $pendingColumns ?? [];
            $rels = $relations ?? [];
            $cats = ['all' => $allCols, 'general' => [], 'geographic' => [], 'relationships' => [], 'dates' => [], 'other' => []];

            foreach ($allCols as $col) {
                if ($col == 'uuid' && optional($settings ?? null)->app_show_uuid_column == 0) continue;
                $c = strtolower((string)$col);
                if (in_array($c, ['id','name','title','status','email','phone','code','is_active','is_default','is_visible','order','sort','description','notes','price','cost','amount'])) {
                    $cats['general'][] = $col;
                } elseif (str_contains($c,'country') || str_contains($c,'region') || str_contains($c,'city') || str_contains($c,'state') || str_contains($c,'address') || str_contains($c,'location') || str_contains($c,'lat') || str_contains($c,'lng') || str_contains($c,'zip')) {
                    $cats['geographic'][] = $col;
                } elseif (in_array($col, $rels) || str_contains($c,'_id') || str_contains($c,'type') || str_contains($c,'category') || str_contains($c,'user') || str_contains($c,'parent') || str_contains($c,'group')) {
                    $cats['relationships'][] = $col;
                } elseif (str_contains($c,'date') || str_contains($c,'time') || str_contains($c,'created_at') || str_contains($c,'updated_at') || str_contains($c,'deleted_at') || str_contains($c,'start') || str_contains($c,'end')) {
                    $cats['dates'][] = $col;
                } else {
                    $cats['other'][] = $col;
                }
            }
            $activeCats = array_filter($cats, fn($v) => count($v) > 0);
            $getTab = function($k) { $t = __('main.'.$k); return (!is_string($t) || $t === 'main.'.$k) ? ucfirst($k) : $t; };
        @endphp

        <div class="px-4 py-3">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <i class="ki-filled ki-setting-2 text-primary text-sm"></i>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ __('main.manage_columns') }}</span>
                    <span class="kt-badge kt-badge-xs kt-badge-outline kt-badge-primary rounded-full">{{ count($pendCols) }}/{{ count($allCols) }}</span>
                </div>
                <button @click="$store.colPicker.close()" type="button"
                    class="w-6 h-6 flex items-center justify-center rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="ki-filled ki-cross text-xs text-gray-500"></i>
                </button>
            </div>

            {{-- Tabs --}}
            <div class="flex flex-wrap items-center gap-2 mb-4 bg-gray-100 dark:bg-gray-800/50 p-2 rounded-xl border border-gray-200 dark:border-gray-700">
                @foreach($activeCats as $k => $cols)
                    @php
                        $tabBtnClass = match($k) {
                            'all' => 'kt-btn-primary',
                            'general' => 'kt-btn-secondary',
                            'geographic' => 'kt-btn-secondary',
                            'relationships' => 'kt-btn-secondary',
                            'dates' => 'kt-btn-secondary',
                            'other' => 'kt-btn-mono',
                            default => 'kt-btn-secondary'
                        };
                    @endphp
                    <button @click="activeTab = '{{ $k }}'" type="button"
                        :class="activeTab === '{{ $k }}' ? '{{ $tabBtnClass }} shadow-md scale-105' : 'kt-btn-ghost text-gray-500 hover:bg-white/50 dark:hover:bg-gray-700'"
                        class="kt-btn kt-btn-sm transition-all duration-200 flex items-center gap-2 px-4 py-2 rounded-lg">
                        @if($k === 'all') 
                            <i class="ki-outline ki-element-11 text-md"></i>
                        @elseif($k === 'general') 
                            <i class="ki-outline ki-document text-md"></i>
                        @elseif($k === 'geographic') 
                            <i class="ki-outline ki-geolocation text-md"></i>
                        @elseif($k === 'relationships') 
                            <i class="ki-outline ki-abstract-26 text-md"></i>
                        @elseif($k === 'dates') 
                            <i class="ki-outline ki-calendar text-md"></i>
                        @else 
                            <i class="ki-outline ki-element-11 text-md"></i>
                        @endif
                        <span class="font-bold uppercase tracking-tight">{{ $getTab($k) }}</span>
                        <span class="flex items-center justify-center bg-black/10 dark:bg-white/10 px-2 py-0.5 rounded-full text-[10px] font-bold">{{ count($cols) }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Columns Grid (responsive) --}}
            <div class="max-h-[300px] overflow-y-auto mb-4 pr-2 custom-scrollbar">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                    @foreach($activeCats as $k => $cols)
                        <template x-if="activeTab === '{{ $k }}'">
                            <div class="contents" id="sortable-{{ $k }}">
                                @foreach($cols as $col)
                                    @php
                                        $tr = __('main.' . (string) $col);
                                        $lb = is_array($tr) || $tr === 'main.' . (string) $col ? ucfirst(str_replace('_', ' ', (string) $col)) : $tr;
                                        $chk = in_array((string) $col, $pendCols);
                                    @endphp
                                    <div class="sortable-column-item group flex items-center justify-between px-3 py-2.5 rounded-xl border {{ $chk ? 'border-primary bg-primary/5 ring-1 ring-primary/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800' }} hover:border-primary hover:bg-primary/5 transition-all duration-200 cursor-pointer"
                                        title="{{ $lb }}" wire:key="col-{{ (string) $col }}" data-column="{{ (string) $col }}">
                                        <label for="col-{{ (string) $col }}" class="flex items-center gap-3 cursor-pointer flex-1 min-w-0">
                                            <input type="checkbox" wire:model.live="pendingColumns" value="{{ (string) $col }}"
                                                id="col-{{ (string) $col }}" class="kt-checkbox kt-checkbox-sm peer shrink-0 rounded-md transition-transform active:scale-90">
                                            <span class="text-[13px] font-bold truncate {{ $chk ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }} tracking-tight">
                                                {{ $lb }}
                                            </span>
                                        </label>
                                        <span class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 group-hover:text-primary shrink-0 opacity-40 group-hover:opacity-100 ps-1 transition-opacity">
                                            <i class="ki-outline ki-burger-menu-2 text-md"></i>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </template>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex flex-wrap items-center justify-between gap-4 pt-4 mt-2 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2 flex-wrap">
                    @if (Auth::check() && getActiveUser()->hasRole('superadmin'))
                        <button type="button" wire:click="saveAsSystemDefault" wire:loading.attr="disabled"
                            title="حفظ هذه الأعمدة كإعدادات افتراضية لجميع مستخدمي النظام"
                            class="kt-btn kt-btn-sm kt-btn-outline bg-amber-50 text-amber-600 hover:bg-amber-100 border-amber-200 px-4 py-2 font-bold shadow-sm">
                            <i class="ki-outline ki-save-2 text-md"></i>
                            {{ __('main.save_as_system_default') ?? 'Set as System Default' }}
                        </button>
                    @endif

                    <button type="button" wire:click="toggleAll" wire:loading.attr="disabled"
                        class="kt-btn kt-btn-sm kt-btn-outline bg-gray-50 text-gray-700 hover:bg-gray-100 border-gray-300 px-4 py-2 font-bold shadow-sm">
                        <i class="ki-outline ki-element-equal text-md"></i>
                        {{ __('main.all_columns') }}
                    </button>
                    
                    @if (isset($hasCustomColumns) && $hasCustomColumns)
                        <button type="button" wire:click="resetColumns" wire:loading.attr="disabled"
                            title="{{ __('main.reset_to_default_desc') ?? 'يعيد الحقول إلى الإعدادات الافتراضية الخاصة بالنظام' }}"
                            class="kt-btn kt-btn-sm kt-btn-outline bg-red-50 text-red-600 hover:bg-red-100 border-red-200 px-4 py-2 font-bold shadow-sm">
                            <span wire:loading.remove wire:target="resetColumns" class="flex items-center gap-2">
                                <i class="ki-outline ki-arrows-circle text-md"></i> {{ __('main.reset_to_default') }}
                            </span>
                            <span wire:loading wire:target="resetColumns"><i class="fas fa-spinner fa-spin text-sm"></i></span>
                        </button>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <button @click="$store.colPicker.close()" type="button"
                        class="kt-btn kt-btn-sm kt-btn-ghost text-gray-500 hover:bg-gray-100 px-4 py-2 font-bold">
                        {{ __('main.close') }}
                    </button>
                    <button type="button" wire:click="applyColumns" wire:loading.attr="disabled"
                        class="kt-btn kt-btn-sm kt-btn-primary px-8 py-2 font-bold shadow-lg active:scale-95 transition-all">
                        <span wire:loading.remove wire:target="applyColumns" class="flex items-center gap-2">
                            <i class="ki-outline ki-check text-md"></i> {{ __('main.apply') }}
                        </span>
                        <span wire:loading wire:target="applyColumns"><i class="fas fa-spinner fa-spin text-sm"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Progress bar showing current page position --}}
    @if (isset($data) &&
            !empty($data) &&
            getPaginate() != config('app.paginate_max') &&
            $data->hasPages() &&
            $data->lastPage() > 1)
        <div class="w-full mt-3">
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span>{{ __('main.progress') }}:</span>
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                        style="width: {{ ($data->currentPage() / $data->lastPage()) * 100 }}%"></div>
                </div>
                <span>{{ number_format(($data->currentPage() / $data->lastPage()) * 100, 1) }}%</span>
            </div>
        </div>
    @endif
</div>
