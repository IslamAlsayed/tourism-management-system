<div id="parentColumnsModal">

    @if (isset($view) && $view)
        <button wire:click="toggleView" class="kt-btn kt-btn-icon kt-btn-outline bg-secondary text-white h-[45px] w-[45px] cursor-pointer hover:bg-opacity-80 transition-colors" title="{{ $view == 'grid' ? __('main.list') : __('main.grid') }}">
            <i class="ki-outline ki-{{ $view == 'grid' ? 'row-horizontal' : 'element-11' }} fs-2"></i>
        </button>
    @endif

    @if ($selectedIds && count($selectedIds) > 0)
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
                        <button class="kt-menu-link" wire:click="exportSelectedPDF" wire:loading.attr="disabled" wire:target="exportSelectedPDF">
                            <span class="kt-menu-title">
                                {{ __('main.pdf') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                            </span>
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

    {{-- Column Picker Toggle Button --}}
    <button @click="$store.colPicker.toggle()" type="button"
        class="kt-btn kt-btn-sm flex items-center gap-1.5 px-3 h-[38px] border rounded-lg transition-all duration-200"
        :class="$store.colPicker.open ? 'bg-primary text-white border-primary shadow-md' : 'btn-light border-gray-300 text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800'"
        title="{{ __('main.columns') }}">
        <i class="ki-outline ki-setting-2 text-base"></i>
        <span class="text-sm font-medium hidden sm:inline">{{ __('main.columns') }}</span>
        <span class="flex items-center justify-center min-w-[20px] h-[20px] text-[11px] font-bold rounded-full px-1.5 ms-1"
            :class="$store.colPicker.open ? 'bg-white text-primary' : 'bg-primary text-white'">{{ count($pendingColumns ?? []) }}</span>
        <i class="ki-outline ki-down text-xs ms-0.5 transition-transform duration-200" :class="$store.colPicker.open && 'rotate-180'"></i>
    </button>
</div>

<script>
    // Register Alpine store for column picker state (shared across components)
    document.addEventListener('alpine:init', () => {
        Alpine.store('colPicker', {
            open: false,
            toggle() { this.open = !this.open; },
            close() { this.open = false; }
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
