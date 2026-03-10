<div id="parentColumnsModal">

    @if (isset($view) && $view)
        <button wire:click="toggleView" class="kt-btn kt-btn-icon kt-btn-outline bg-secondary text-white h-[45px] w-[45px] cursor-pointer hover:bg-opacity-80 transition-colors" title="{{ $view == 'grid' ? __('main.list') : __('main.grid') }}">
            <i class="ki-outline ki-{{ $view == 'grid' ? 'row-horizontal' : 'element-11' }} fs-2"></i>
        </button>
    @endif

    @if ($selectedIds && count($selectedIds) > 0)
        <div class="kt-menu" data-kt-menu="true" x-data="{
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
            }
        }">
            <button
                class="user-action relative kt-menu-toggle kt-btn kt-btn-outline bg-danger text-white px-3 h-[45px] cursor-pointer hover:bg-red-700 transition-colors"
                x-on:click.prevent="confirmDelete">
                <span class="kt-menu-title flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    {{ __('main.delete') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                </span>
            </button>
        </div>

        <div class="kt-menu" data-kt-menu="true">
            <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-end"
                data-kt-menu-item-placement-rtl="bottom-start" data-kt-menu-item-toggle="dropdown"
                data-kt-menu-item-trigger="click">
                <button
                    class="user-action relative kt-menu-toggle kt-btn kt-btn-outline bg-primary text-white px-3 h-[45px] cursor-default">
                    <span class="kt-menu-title">
                        {{ __('main.export') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                    </span>
                    <span class="hidden absolute top-50 left-50 translate-50" id="loading-spinner">
                        @include('components.load-data', ['color' => 'var(--color-white)'])
                    </span>
                </button>
                <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]" data-kt-menu-dismiss="true">
                    <div class="kt-menu-item">
                        <button
                            class="kt-menu-link {{ $pendingColumns && count($pendingColumns) > 7 ? 'disabled' : '' }}"
                            {{ $pendingColumns && count($pendingColumns) > 7 ? 'style=background: var(--color-yellow-100);' : '' }}
                            wire:click="exportSelectedPDF" wire:loading.attr="disabled" wire:target="exportSelectedPDF">
                            <span class="kt-menu-title">
                                {{ __('main.pdf') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                            </span>
                            @if ($pendingColumns && count($pendingColumns) > 7)
                                <span class="text-yellow-600" style="font-size: 14px;">
                                    {{ __('main.less_than_count_columns', ['count' => 7]) }}
                                </span>
                            @endif
                            <span wire:loading wire:target="exportSelectedPDF">
                                <i class="fas fa-spinner fa-spin ms-2"></i>
                            </span>
                        </button>
                    </div>
                    <div class="kt-menu-item">
                        <button class="kt-menu-link" wire:click="exportSelectedExcel('csv')"
                            wire:loading.attr="disabled" wire:target="exportSelectedExcel">
                            <span class="kt-menu-title">
                                {{ __('main.csv') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                            </span>
                            <span wire:loading wire:target="exportSelectedExcel">
                                <i class="fas fa-spinner fa-spin ms-2"></i>
                            </span>
                        </button>
                    </div>
                    <div class="kt-menu-item">
                        <button class="kt-menu-link" wire:click="exportSelectedExcel('xlsx')"
                            wire:loading.attr="disabled" wire:target="exportSelectedExcel">
                            <span class="kt-menu-title">
                                {{ __('main.xlsx') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                            </span>
                            <span wire:loading wire:target="exportSelectedExcel">
                                <i class="fas fa-spinner fa-spin ms-2"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Column Picker — Alpine.js Slide Panel --}}
    <div x-data="{ open: false }" class="relative">
        {{-- Trigger Button --}}
        <button @click="open = true" type="button"
            class="kt-btn kt-btn-sm kt-btn-light kt-btn-outline flex items-center gap-1.5 px-3 h-[38px] border border-border rounded-lg hover:bg-muted transition-colors"
            title="{{ __('main.columns') }}">
            <i class="ki-outline ki-setting-2 text-muted-foreground text-base"></i>
            <span class="text-sm font-medium text-foreground hidden sm:inline">{{ __('main.columns') }}</span>
            <span
                class="kt-badge kt-badge-xs kt-badge-primary rounded-full ms-1">{{ count($pendingColumns ?? []) }}</span>
        </button>

        {{-- Teleport to body to avoid container overflow clipping --}}
        <template x-teleport="body">
            <div>
                {{-- Backdrop --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
                    class="fixed inset-0 z-[99998] bg-black/60 backdrop-blur-sm" style="display: none;"></div>

                {{-- Modal Panel (Wide) --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95" x-cloak
                    class="fixed inset-0 top-0 left-0 z-[99999] flex items-center justify-center p-4 sm:p-6"
                    style="display: none;">
            
            <div @click.away="open = false" class="bg-white dark:bg-[#1e1e2d] border border-gray-200 dark:border-gray-700 shadow-2xl rounded-xl flex flex-col w-full max-w-4xl max-h-[90vh]">

            {{-- Panel Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-[#1e1e2d] shrink-0 rounded-t-xl">
                <div class="flex items-center gap-3">
                    <i class="ki-filled ki-setting-2 text-primary text-xl"></i>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('main.manage_columns') }}</h3>
                    <span
                        class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary rounded-full">{{ count($pendingColumns ?? []) }}/{{ count($allColumns ?? []) }}</span>
                </div>
                <button @click="open = false" type="button"
                    class="kt-btn kt-btn-sm kt-btn-icon kt-btn-light rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="ki-filled ki-cross text-sm"></i>
                </button>
            </div>

            {{-- Panel Content — Categorized Tabs --}}
            @php
                // Pre-categorize columns for the tabs
                $categories = [
                    'general' => [],
                    'geographic' => [],
                    'relationships' => [],
                    'dates' => [],
                    'other' => []
                ];

                if (isset($allColumns) && count($allColumns) > 0) {
                    foreach ($allColumns as $column) {
                        if ($column == 'uuid' && optional($settings)->app_show_uuid_column == 0) continue;
                        
                        $colStr = strtolower((string)$column);
                        
                        // Intelligent routing of columns to categories
                        if (in_array($colStr, ['id', 'name', 'title', 'status', 'email', 'phone', 'code', 'is_active', 'is_default', 'is_visible', 'order', 'sort', 'description', 'notes', 'price', 'cost', 'amount'])) {
                            $categories['general'][] = $column;
                        } elseif (str_contains($colStr, 'country') || str_contains($colStr, 'region') || str_contains($colStr, 'city') || str_contains($colStr, 'state') || str_contains($colStr, 'address') || str_contains($colStr, 'location') || str_contains($colStr, 'lat') || str_contains($colStr, 'lng') || str_contains($colStr, 'zip')) {
                            $categories['geographic'][] = $column;
                        } elseif (in_array($column, $relations ?? []) || str_contains($colStr, '_id') || str_contains($colStr, 'type') || str_contains($colStr, 'category') || str_contains($colStr, 'user') || str_contains($colStr, 'parent') || str_contains($colStr, 'group')) {
                            $categories['relationships'][] = $column;
                        } elseif (str_contains($colStr, 'date') || str_contains($colStr, 'time') || str_contains($colStr, 'created_at') || str_contains($colStr, 'updated_at') || str_contains($colStr, 'deleted_at') || str_contains($colStr, 'start') || str_contains($colStr, 'end')) {
                            $categories['dates'][] = $column;
                        } else {
                            $categories['other'][] = $column;
                        }
                    }
                }
                
                // Hide empty tabs
                $activeCategories = array_filter($categories, fn($cat) => count($cat) > 0);

                // Helper to get translated or fall back to capitalized name
                $getTabName = function($key) {
                    $trans = __('main.' . $key);
                    return (!is_string($trans) || $trans === 'main.'.$key) ? ucfirst($key) : $trans;
                };
            @endphp

            <div class="flex-1 overflow-hidden flex flex-col min-h-0" x-data="{ activeTab: '{{ array_key_first($activeCategories) ?? 'general' }}' }">
                
                {{-- Tabs Header --}}
                <div class="px-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 shrink-0 overflow-x-auto">
                    <div class="flex items-center gap-6 min-w-max">
                        @foreach($activeCategories as $key => $catColumns)
                            <button @click="activeTab = '{{ $key }}'" 
                                :class="{ 'border-primary text-primary': activeTab === '{{ $key }}', 'border-transparent text-gray-500 hover:text-gray-800 dark:hover:text-gray-200 hover:border-gray-300': activeTab !== '{{ $key }}' }"
                                class="py-3.5 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                                @if($key === 'general') <i class="ki-outline ki-document text-base"></i> {{ $getTabName('general') }}
                                @elseif($key === 'geographic') <i class="ki-outline ki-geolocation text-base"></i> {{ $getTabName('geographic') }}
                                @elseif($key === 'relationships') <i class="ki-outline ki-abstract-26 text-base"></i> {{ $getTabName('relationships') }}
                                @elseif($key === 'dates') <i class="ki-outline ki-calendar text-base"></i> {{ $getTabName('dates') }}
                                @else <i class="ki-outline ki-element-11 text-base"></i> {{ $getTabName('other') }}
                                @endif
                                <span class="kt-badge kt-badge-xs kt-badge-light ml-1 rounded-full">{{ count($catColumns) }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Tabs Content (Scrollable) --}}
                <div class="flex-1 overflow-y-auto p-6 bg-gray-50/50 dark:bg-gray-900/20">
                    <div class="sortable-columns-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($activeCategories as $key => $catColumns)
                            <template x-if="activeTab === '{{ $key }}'">
                                <div class="contents" id="sortable-{{ $key }}">
                                    @foreach($catColumns as $column)
                                        @php
                                            $translated = __('main.' . (string) $column);
                                            $labelText = is_array($translated) || $translated === 'main.' . (string) $column ? ucfirst(str_replace('_', ' ', (string) $column)) : $translated;
                                            $isChecked = in_array((string) $column, $pendingColumns ?? []);
                                        @endphp
                                        <div class="sortable-column-item flex items-center gap-3 px-4 py-3 rounded-xl border {{ $isChecked ? 'border-primary bg-primary/5 shadow-sm' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800' }} hover:border-primary/40 hover:bg-primary/5 transition-all cursor-pointer"
                                            title="{{ $labelText }}" wire:key="col-{{ (string) $column }}"
                                            data-column="{{ (string) $column }}">
                                            
                                            <label for="col-{{ (string) $column }}" class="flex items-center gap-3 cursor-pointer flex-1 min-w-0">
                                                <input type="checkbox" wire:model="pendingColumns" value="{{ (string) $column }}"
                                                    id="col-{{ (string) $column }}"
                                                    class="kt-checkbox kt-checkbox-sm peer shrink-0 rounded">
                                                <span class="text-sm font-semibold truncate {{ $isChecked ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }} peer-checked:text-primary transition-colors">
                                                    {{ ucfirst($labelText) }}
                                                </span>
                                            </label>
                                            <span class="drag-handle cursor-grab active:cursor-grabbing text-gray-400 dark:text-gray-500 hover:text-primary shrink-0 opacity-40 hover:opacity-100 transition-opacity">
                                                <i class="ki-filled ki-burger-menu-2 text-md"></i>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </template>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Panel Footer --}}
            <div
                class="flex items-center justify-between gap-2 px-5 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/80 shrink-0 rounded-b-xl">
                <div class="flex items-center gap-2">
                    {{-- All Columns toggle --}}
                    <form method="POST" action="{{ route('columns.toggle-all') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="model_class" value="{{ $modelClass ?? '' }}">
                        <input type="hidden" name="is_all_selected" value="0">
                        <button type="submit"
                            class="kt-btn kt-btn-xs kt-btn-light flex items-center gap-1.5 px-3 py-1.5 rounded-md">
                            <i class="ki-filled ki-element-equal text-xs"></i>
                            {{ __('main.all_columns') }}
                        </button>
                    </form>

                    {{-- Reset to Default --}}
                    @if (isset($hasCustomColumns) && $hasCustomColumns)
                        <button type="button" wire:click="resetColumns" wire:loading.attr="disabled"
                            onclick="setTimeout(() => window.location.reload(), 50)"
                            class="kt-btn kt-btn-xs kt-btn-light-danger flex items-center gap-1.5 px-3 py-1.5 rounded-md">
                            <span wire:loading.remove wire:target="resetColumns">
                                <i class="ki-filled ki-arrows-circle text-xs"></i>
                                {{ __('main.reset_to_default') }}
                            </span>
                            <span wire:loading wire:target="resetColumns">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    @endif
                </div>

                {{-- Apply --}}
                <button type="button" wire:click="applyColumns"
                    onclick="setTimeout(() => window.location.reload(), 50)" wire:loading.attr="disabled"
                    class="kt-btn kt-btn-sm kt-btn-primary flex items-center gap-1.5 px-4 py-2 rounded-md shadow-sm">
                    <span wire:loading.remove wire:target="applyColumns">
                        <i class="ki-filled ki-check text-xs"></i>
                        {{ __('main.apply') }}
                    </span>
                    <span wire:loading wire:target="applyColumns">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            </div>
            </div>
            </div>
        </template>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Sortable === 'undefined') return;

        // Helper: initialize sortable on a single tab container
        function initSortable(container) {
            if (!container || container._sortable) return;
            container._sortable = Sortable.create(container, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-primary/5',
                chosenClass: 'bg-primary/10',
                onEnd: function() {
                    const items = container.querySelectorAll('.sortable-column-item');
                    const newOrder = [];
                    items.forEach(function(item) {
                        const checkbox = item.querySelector('input[type="checkbox"]');
                        if (checkbox && checkbox.checked) {
                            newOrder.push(checkbox.value);
                        }
                    });
                    if (newOrder.length > 0) {
                        @this.set('pendingColumns', newOrder);
                    }
                }
            });
        }

        // Watch for Alpine-rendered tab containers and init Sortable
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(m) {
                m.addedNodes.forEach(function(node) {
                    if (node.nodeType !== 1) return;
                    // Check if the node itself or any descendant is a sortable container
                    const containers = node.classList && node.classList.contains('contents')
                        ? [node]
                        : node.querySelectorAll ? node.querySelectorAll('.contents') : [];
                    containers.forEach(initSortable);
                    if (node.classList && node.classList.contains('contents')) {
                        initSortable(node);
                    }
                });
            });
        });

        observer.observe(document.getElementById('parentColumnsModal') || document.body, {
            childList: true,
            subtree: true
        });
    });
</script>
