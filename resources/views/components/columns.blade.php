<div id="parentColumnsModal">

    @if (isset($view) && $view)
        <button wire:click="toggleView" class="kt-btn kt-btn-icon kt-btn-outline bg-secondary text-white h-[45px] w-[45px] cursor-pointer hover:bg-opacity-80 transition-colors" title="{{ $view == 'grid' ? __('main.list') : __('main.grid') }}">
            <i class="ki-outline ki-{{ $view == 'grid' ? 'row-horizontal' : 'element-11' }} fs-2"></i>
        </button>
    @endif

    <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" class="flex items-center gap-2">
        <!-- Empty placeholder to ensure kt-menu initializes correctly if needed, or just start directly -->
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
                    <span>{{ __('main.delete') }} (<span x-text="$wire.selectedIds.length"></span> {{ __('main.items') }})</span>
                </span>
            </button>
        </div>
    </div>

    {{-- Global Export Dropdown --}}
    @if(!isset($hideExport) || !$hideExport)
    <div class="kt-menu" data-kt-menu="true">
        <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-end"
            data-kt-menu-item-placement-rtl="bottom-start" data-kt-menu-item-toggle="dropdown"
            data-kt-menu-item-trigger="click">
            <button
                class="user-action relative kt-menu-toggle kt-btn kt-btn-outline bg-primary text-white px-3 h-[45px] cursor-pointer">
                <span class="kt-menu-title flex items-center gap-2">
                    <i class="fas fa-file-export"></i>
                    <span>{{ __('main.export') }} <span x-show="$wire.selectedIds && $wire.selectedIds.length > 0">(<span x-text="$wire.selectedIds.length"></span>)</span></span>
                </span>
                <span class="hidden absolute top-50 left-50 translate-50" id="loading-spinner">
                    @include('components.load-data', ['color' => 'var(--color-white)'])
                </span>
            </button>
            <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]" data-kt-menu-dismiss="true">
                {{-- Export Full / Selected Data --}}
                <div class="kt-menu-item">
                    <button class="kt-menu-link" wire:click="exportSelectedPDF" wire:loading.attr="disabled" wire:target="exportSelectedPDF" :disabled="!$wire.selectedIds || $wire.selectedIds.length === 0">
                        <span class="kt-menu-title flex items-center gap-2">
                            <i class="fas fa-file-pdf text-danger"></i>
                            <span>{{ __('main.pdf') }}</span>
                        </span>
                        <span wire:loading wire:target="exportSelectedPDF">
                            <i class="fas fa-spinner fa-spin ms-2"></i>
                        </span>
                    </button>
                </div>
                <div class="kt-menu-item">
                    <button class="kt-menu-link" wire:click="exportSelectedExcel('csv')" wire:loading.attr="disabled" wire:target="exportSelectedExcel" :disabled="!$wire.selectedIds || $wire.selectedIds.length === 0">
                        <span class="kt-menu-title flex items-center gap-2">
                            <i class="fas fa-file-csv text-success"></i>
                            <span>{{ __('main.csv') }}</span>
                        </span>
                        <span wire:loading wire:target="exportSelectedExcel">
                            <i class="fas fa-spinner fa-spin ms-2"></i>
                        </span>
                    </button>
                </div>
                <div class="kt-menu-item">
                    <button class="kt-menu-link" wire:click="exportSelectedExcel('xlsx')" wire:loading.attr="disabled" wire:target="exportSelectedExcel" :disabled="!$wire.selectedIds || $wire.selectedIds.length === 0">
                        <span class="kt-menu-title flex items-center gap-2">
                            <i class="fas fa-file-excel text-success"></i>
                            <span>{{ __('main.xlsx') }}</span>
                        </span>
                        <span wire:loading wire:target="exportSelectedExcel">
                            <i class="fas fa-spinner fa-spin ms-2"></i>
                        </span>
                    </button>
                </div>
                <div class="kt-menu-separator my-1"></div>
                {{-- Export Template --}}
                <div class="kt-menu-item">
                    <a href="{{ route('import.template', ['models' => $routePrefix ?? preg_replace('/^([a-z])/', '$1', strtolower(class_basename($this)))]) }}" class="kt-menu-link" target="_blank">
                        <span class="kt-menu-title flex items-center gap-2">
                            <i class="fas fa-download text-primary"></i>
                            <span>{{ __('main.export_template') }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Column Picker Toggle Button --}}
    <button @click="$store.colPicker.toggle()" type="button"
        class="kt-btn kt-btn-sm flex items-center gap-1.5 px-3 h-[38px] border rounded-lg transition-all duration-200"
        :class="$store.colPicker.open ? 'bg-primary text-white border-primary shadow-md' : 'btn-light border-gray-300 text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800'"
        title="{{ __('main.columns') }}">
        <i class="ki-filled ki-screen text-red-500 text-base"></i>
        <span class="text-sm font-medium hidden sm:inline">{{ __('main.columns') }}</span>
        
        <span x-data
            class="flex items-center justify-center min-w-[20px] h-[20px] text-[11px] font-bold rounded-full px-1.5 ms-1"
            :class="$store.colPicker.open ? 'bg-white text-primary' : 'bg-primary text-white'" 
            x-text="$store.colPicker.count || {{ count($pendingColumns ?? []) }}">{{ count($pendingColumns ?? []) }}</span>
            
        <i class="ki-outline ki-down text-xs ms-0.5 transition-transform duration-200" :class="$store.colPicker.open && 'rotate-180'"></i>
    </button>
</div>

<script>
    // Register Alpine store for column picker state (shared across components)
    document.addEventListener('alpine:init', () => {
        Alpine.store('colPicker', {
            open: false,
            count: 0,
            toggle() { this.open = !this.open; },
            close() { this.open = false; }
        });

        Alpine.store('filtersVisibility', {
            filters: JSON.parse(localStorage.getItem('systemFiltersVisibility')) || {},
            toggle(key) {
                let currentVal = typeof this.filters[key] === 'undefined' ? true : this.filters[key];
                this.filters = { ...this.filters, [key]: !currentVal };
                localStorage.setItem('systemFiltersVisibility', JSON.stringify(this.filters));
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Sortable === 'undefined') return;

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

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(m) {
                m.addedNodes.forEach(function(node) {
                    if (node.nodeType !== 1) return;
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
