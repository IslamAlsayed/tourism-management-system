<div id="parentColumnsModal">

    @if (isset($view) && $view)
        <button wire:click="toggleView" class="kt-btn kt-btn-icon kt-btn-outline bg-secondary text-white h-[38px] w-[38px] cursor-pointer hover:bg-opacity-80 transition-colors" title="{{ $view == 'grid' ? __('main.list') : __('main.grid') }}">
            <i class="fa-duotone fa-solid fa-{{ $view == 'grid' ? 'list' : 'grid-2' }} text-base"></i>
        </button>
    @endif

    <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" class="flex items-center gap-2">
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
                        @this.call('deleteSelected');
                    }
                })
            }
        }">
            <button
                class="user-action relative kt-btn kt-btn-outline kt-btn-sm bg-danger text-white px-3 h-[38px] cursor-pointer hover:bg-red-700 transition-colors"
                x-on:click.prevent="confirmDelete">
                <span class="flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    <span>{{ __('main.delete') }} (<span x-text="$wire.selectedIds.length"></span> {{ __('main.items') }})</span>
                </span>
            </button>
        </div>
    </div>

    {{-- Global Export Dropdown (Alpine.js + position:fixed — avoids z-index/overflow without leaving Livewire DOM) --}}
    @if(!isset($hideExport) || !$hideExport)
    <div class="relative" x-data="{
            exportOpen: false,
            fixedTop: 0,
            fixedLeft: 0,
            toggle(btn) {
                if (this.exportOpen) { this.exportOpen = false; return; }
                const rect = btn.getBoundingClientRect();
                this.fixedTop = rect.bottom + 6;
                this.fixedLeft = rect.right - 220;
                if (this.fixedLeft < 10) this.fixedLeft = 10;
                this.exportOpen = true;
            },
            close() { this.exportOpen = false; }
        }">
        <button
            @click="toggle($el)"
            class="user-action relative kt-btn kt-btn-outline kt-btn-sm bg-primary text-white px-3 h-[38px] cursor-pointer hover:bg-primary/90 transition-colors">
            <span class="flex items-center gap-2">
                <i class="fas fa-file-export"></i>
                <span>{{ __('main.export') }} <span x-show="$wire.selectedIds && $wire.selectedIds.length > 0">(<span x-text="$wire.selectedIds.length"></span>)</span></span>
                <i class="fas fa-chevron-down text-[10px] ms-0.5 transition-transform duration-200" :class="exportOpen && 'rotate-180'"></i>
            </span>
            <span class="hidden absolute top-50 left-50 translate-50" id="loading-spinner">
                @include('components.load-data', ['color' => 'var(--color-white)'])
            </span>
        </button>

        {{-- Export Dropdown Menu (position:fixed escapes overflow without leaving Livewire DOM) --}}
        <div x-show="exportOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.outside="close()"
             x-cloak
             :style="`position:fixed; top:${fixedTop}px; left:${fixedLeft}px; z-index:99999; width:220px; background-color: var(--popover); color: var(--popover-foreground); border: 1px solid var(--border);`"
             class="rounded-lg shadow-md py-1.5">
            {{-- PDF --}}
            <button class="kt-dropdown-menu-link w-full flex items-center justify-between px-4 py-2.5 text-sm transition-colors hover:bg-accent" style="color: var(--foreground); border-radius: calc(var(--radius) - 2px);"
                    wire:click="exportSelectedPDF" wire:loading.attr="disabled" wire:target="exportSelectedPDF"
                    @click="close()">
                <span class="flex items-center gap-2.5">
                    <i class="fas fa-file-pdf text-red-500 w-4 text-center"></i>
                    <span class="font-medium">{{ __('main.pdf') }}</span>
                </span>
                <span wire:loading wire:target="exportSelectedPDF">
                    <i class="fas fa-spinner fa-spin text-xs text-primary"></i>
                </span>
            </button>
            {{-- CSV --}}
            <button class="kt-dropdown-menu-link w-full flex items-center justify-between px-4 py-2.5 text-sm transition-colors hover:bg-accent" style="color: var(--foreground); border-radius: calc(var(--radius) - 2px);"
                    wire:click="exportSelectedExcel('csv')" wire:loading.attr="disabled" wire:target="exportSelectedExcel"
                    @click="close()">
                <span class="flex items-center gap-2.5">
                    <i class="fas fa-file-csv text-green-500 w-4 text-center"></i>
                    <span class="font-medium">{{ __('main.csv') }}</span>
                </span>
                <span wire:loading wire:target="exportSelectedExcel">
                    <i class="fas fa-spinner fa-spin text-xs text-primary"></i>
                </span>
            </button>
            {{-- Excel --}}
            <button class="kt-dropdown-menu-link w-full flex items-center justify-between px-4 py-2.5 text-sm transition-colors hover:bg-accent" style="color: var(--foreground); border-radius: calc(var(--radius) - 2px);"
                    wire:click="exportSelectedExcel('xlsx')" wire:loading.attr="disabled" wire:target="exportSelectedExcel"
                    @click="close()">
                <span class="flex items-center gap-2.5">
                    <i class="fas fa-file-excel text-green-600 w-4 text-center"></i>
                    <span class="font-medium">{{ __('main.xlsx') }}</span>
                </span>
                <span wire:loading wire:target="exportSelectedExcel">
                    <i class="fas fa-spinner fa-spin text-xs text-primary"></i>
                </span>
            </button>
            <div class="my-1" style="height: 1px; background-color: var(--border); margin-inline: -0.5rem;"></div>
            {{-- Export Template --}}
            <a href="{{ route('import.template', ['models' => $routePrefix ?? preg_replace('/^([a-z])/', '$1', strtolower(class_basename($this)))]) }}"
               class="kt-dropdown-menu-link w-full flex items-center gap-2.5 px-4 py-2.5 text-sm transition-colors" style="color: var(--foreground); border-radius: calc(var(--radius) - 2px);"
               target="_blank" @click="close()">
                <i class="fas fa-download text-primary w-4 text-center"></i>
                <span class="font-medium">{{ __('main.export_template') }}</span>
            </a>
        </div>
    </div>
    @endif

    {{-- Column Picker Toggle Button --}}
    <button @click="$store.colPicker.toggle()" type="button"
        class="kt-btn kt-btn-sm flex items-center gap-1.5 px-3 h-[38px] border rounded-lg transition-all duration-200"
        :class="$store.colPicker.open ? 'bg-primary text-white border-primary shadow-md' : 'kt-btn-outline border-border text-foreground hover:bg-accent'"
        title="{{ __('main.columns') }}">
        <i class="fa-duotone fa-solid fa-desktop text-base" :class="$store.colPicker.open ? 'text-white' : 'text-primary'"></i>
        <span class="text-sm font-medium hidden sm:inline">{{ __('main.columns') }}</span>
        
        <span x-data
            class="flex items-center justify-center min-w-[20px] h-[20px] text-[11px] font-bold rounded-full px-1.5 ms-1"
            :class="$store.colPicker.open ? 'bg-white text-primary' : 'bg-primary text-white'" 
            x-text="$store.colPicker.count || {{ count($pendingColumns ?? []) }}">{{ count($pendingColumns ?? []) }}</span>
            
        <i class="fa-solid fa-chevron-down text-xs ms-0.5 transition-transform duration-200" :class="$store.colPicker.open && 'rotate-180'"></i>
    </button>
</div>

<script>
    // Register Alpine store for column picker state (shared across components)
    // NOTE: Primary registration is in master.blade.php — this is a fallback guard
    document.addEventListener('alpine:init', () => {
        if (!Alpine.store('colPicker')) {
            Alpine.store('colPicker', {
                open: false,
                count: 0,
                toggle() { this.open = !this.open; },
                close() { this.open = false; }
            });
        }

        if (!Alpine.store('filtersVisibility')) {
            Alpine.store('filtersVisibility', {
                filters: JSON.parse(localStorage.getItem('systemFiltersVisibility')) || {},
                toggle(key) {
                    let currentVal = typeof this.filters[key] === 'undefined' ? true : this.filters[key];
                    this.filters = { ...this.filters, [key]: !currentVal };
                    localStorage.setItem('systemFiltersVisibility', JSON.stringify(this.filters));
                }
            });
        }
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
