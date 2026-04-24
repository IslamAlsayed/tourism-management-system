{{-- Action Dropdown — KTUI/Metronic pattern with Alpine.js fixed positioning --}}
{{-- Uses project CSS custom properties (bg-background, text-foreground, border-border) --}}
{{-- These auto-switch between light/dark mode --}}
@php
    $showRoute = isset($models) ? "{$models}.show" : null;
    $editRoute = isset($models) ? "{$models}.edit" : null;
    $routeParams = [];
    if (isset($id)) $routeParams[] = $id;
    if (request()->has('type')) $routeParams['type'] = request()->query('type');
@endphp

<div class="inline-flex"
     x-data="{
         open: false,
         menuTop: '0px',
         menuLeft: '0px',
         toggle() {
             if (this.open) { this.open = false; return; }
             const btn = this.$refs.toggleBtn;
             const rect = btn.getBoundingClientRect();
             const menuW = 175;
             const menuH = 200;
             const spaceBelow = window.innerHeight - rect.bottom;
             const topPos = spaceBelow > menuH ? (rect.bottom + 4) : (rect.top - menuH - 4);
             const leftPos = Math.min(rect.right - menuW, window.innerWidth - menuW - 8);
             this.menuTop = Math.max(4, topPos) + 'px';
             this.menuLeft = Math.max(8, leftPos) + 'px';
             this.open = true;
         }
     }"
     @click.outside="open = false"
     @keydown.escape.window="open = false"
     @scroll.window="open = false">

    {{-- Trigger: 3-Dot Button --}}
    <button type="button"
            x-ref="toggleBtn"
            @click.stop="toggle()"
            class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost"
            title="{{ __('main.actions') }}">
        <i class="fa-duotone fa-solid fa-ellipsis-vertical"></i>
    </button>

    {{-- Menu Panel: Alpine-controlled, fixed position --}}
    {{-- bg-background / text-foreground / border-border = auto light/dark via CSS vars --}}
    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         :style="'position:fixed; top:' + menuTop + '; left:' + menuLeft + '; z-index:9999;'"
         class="w-[175px] py-1.5 rounded-xl shadow-lg border border-border bg-background">

        {{-- Show --}}
        @if ($showRoute && Route::has($showRoute))
            <a href="{{ route($showRoute, $routeParams) }}"
               x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['show'] !== false"
               class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] text-foreground hover:bg-mono/5 transition-colors">
                <i class="fa-duotone fa-solid fa-eye text-muted-foreground text-base leading-none"></i>
                {{ __('main.show') }}
            </a>
        @endif

        {{-- Edit --}}
        @if ((!isset($models) || $models != 'notifications') && $editRoute && Route::has($editRoute))
            <a href="{{ route($editRoute, $routeParams) }}"
               x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['edit'] !== false"
               class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] text-foreground hover:bg-mono/5 transition-colors">
                <i class="fa-duotone fa-solid fa-pen-to-square text-muted-foreground text-base leading-none"></i>
                {{ __('main.edit') }}
            </a>
        @endif

        {{-- Notification CTA --}}
        @if (isset($models) && $models == 'notifications' && isset($item) && $item->data && isset($item->data['cta_url']))
            <a href="{{ $item->data['cta_url'] }}" target="_blank"
               class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] text-foreground hover:bg-mono/5 transition-colors">
                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-muted-foreground text-base leading-none"></i>
                {{ $item->data['cta_text'] ?? __('main.view_action') }}
            </a>
        @endif

        {{-- Separator --}}
        <div class="border-t border-border my-1.5"></div>

        {{-- Delete --}}
        <button type="button"
                x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['delete'] !== false"
                class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] text-danger hover:bg-danger/10 w-full text-start transition-colors action-delete-trigger"
                data-action="delete"
                data-record-id="{{ $id ?? '' }}">
            <i class="fa-duotone fa-solid fa-trash text-base leading-none"></i>
            {{ __('main.delete') }}
        </button>

        {{-- Force Delete --}}
        <button type="button"
                x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['force_delete'] !== false"
                class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] text-red-400 hover:bg-red-500/10 w-full text-start transition-colors font-semibold action-delete-trigger"
                data-action="forceDelete"
                data-record-id="{{ $id ?? '' }}">
            <i class="fa-duotone fa-solid fa-trash-can text-base leading-none"></i>
            {{ __('main.force_delete') }}
        </button>

    </div>
</div>
