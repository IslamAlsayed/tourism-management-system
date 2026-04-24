@php
    $currentRoute = Route::currentRouteName();
@endphp

<!--Megamenu Contaoner-->
<div class="flex items-stretch" id="megaMenuContainer">
    <!--Megamenu Inner-->
    <div class="flex items-stretch [--kt-reparent-mode:prepend] [--kt-reparent-target:body] lg:[--kt-reparent-mode:prepend] lg:[--kt-reparent-target:#megaMenuContainer]"
        data-kt-reparent="true">
        <!--Megamenu Wrapper-->
        <div class="hidden [--kt-drawer-enable:true] lg:flex lg:items-stretch lg:[--kt-drawer-enable:false]" data-kt-drawer="true"
            data-kt-drawer-class="kt-drawer kt-drawer-start fixed z-2002 lg:z-1000 top-0 bottom-0 w-full me-5 max-w-[250px] p-5 lg:p-0 overflow-auto"
            id="mega_menu_wrapper">
            <!--Megamenu-->
            <div class="kt-menu flex-col gap-5 lg:flex-row lg:gap-7.5" data-kt-menu="true" id="mega_menu">
                <!--Megamenu Item-->
                <div class="kt-menu-item active">
                    <a class="kt-menu-link kt-menu-item-hover:text-primary kt-menu-item-active:text-mono kt-menu-item-active:font-medium text-nowrap text-sm font-medium text-foreground"
                        href="{{ route('dashboard') }}">
                        <span class="kt-menu-title text-nowrap">
                            Home
                        </span>
                    </a>
                </div>
                <!--End of Megamenu Item-->
                <!--Megamenu Item — Shortcuts (Alpine.js dropdown, bypasses KTMenu dual-init conflict)-->
                <div class="relative" x-data="{
                        shortcutsOpen: false,
                        fixedTop: 0,
                        fixedLeft: 0,
                        toggle(btn) {
                            if (this.shortcutsOpen) { this.shortcutsOpen = false; return; }
                            const rect = btn.getBoundingClientRect();
                            this.fixedTop = rect.bottom + 6;
                            this.fixedLeft = rect.left;
                            if (this.fixedLeft + 320 > window.innerWidth) this.fixedLeft = window.innerWidth - 340;
                            this.shortcutsOpen = true;
                        },
                        close() { this.shortcutsOpen = false; }
                    }">
                    <div @click="toggle($el)"
                        class="kt-menu-link bg-transparent! lg:background cursor-pointer select-none hover:text-primary text-sm text-foreground"
                        :class="shortcutsOpen && 'text-primary font-medium'">
                        <span class="kt-menu-title text-nowrap">
                            Shortcuts
                            <i class="fa-solid fa-chevron-down fs-5 ms-1 mt-1 transition-transform duration-200"
                               :class="shortcutsOpen && 'rotate-180'"></i>
                        </span>
                    </div>
                    {{-- Shortcuts Dropdown (position:fixed — avoids overflow/z-index issues) --}}
                    <div x-show="shortcutsOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="close()"
                         x-cloak
                         :style="`position:fixed; top:${fixedTop}px; left:${fixedLeft}px; z-index:99999; min-width:320px; background-color: var(--popover, var(--background, #fff)); color: var(--popover-foreground, var(--foreground)); border: 1px solid var(--border);`"
                         class="rounded-lg shadow-lg">
                        <div class="p-5 lg:p-7.5">
                            <div class="flex flex-col">
                                <h3 class="mb-4 text-sm font-semibold leading-none text-foreground">
                                    Popular Items
                                </h3>
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div class="flex flex-col gap-1.5">
                                        <a class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-sm hover:bg-accent transition-colors {{ isActive('dashboard.tourguides.guides.index', [], $currentRoute) ? 'bg-accent font-medium' : '' }}"
                                           href="{{ route('dashboard.tourguides.guides.index') }}" @click="close()">
                                            <i class="fas fa-map text-muted-foreground w-5 text-center"></i>
                                            <span>Tours Guides</span>
                                        </a>
                                        <a class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-sm hover:bg-accent transition-colors {{ isActive('restaurants.index', [], $currentRoute) ? 'bg-accent font-medium' : '' }}"
                                           href="{{ route('dashboard.restaurants.index') }}" @click="close()">
                                            <i class="fas fa-utensils text-muted-foreground w-5 text-center"></i>
                                            <span>Restaurant</span>
                                        </a>
                                        <a class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-sm hover:bg-accent transition-colors {{ isActive('accommodations.index', [], $currentRoute) ? 'bg-accent font-medium' : '' }}"
                                           href="{{ route('dashboard.accommodations.index') }}" @click="close()">
                                            <i class="fas fa-hotel text-muted-foreground w-5 text-center"></i>
                                            <span>Accommodations</span>
                                        </a>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <a class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-sm hover:bg-accent transition-colors {{ isActive('transportation.companies.index', [], $currentRoute) ? 'bg-accent font-medium' : '' }}"
                                           href="{{ route('dashboard.transportation.companies.index') }}" @click="close()">
                                            <i class="fas fa-car text-muted-foreground w-5 text-center"></i>
                                            <span>Transportation</span>
                                        </a>
                                        <a class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-sm hover:bg-accent transition-colors {{ isActive('reports.index', [], $currentRoute) ? 'bg-accent font-medium' : '' }}"
                                           href="{{ route('dashboard.core.reports.index') }}" @click="close()">
                                            <i class="fas fa-chart-line text-muted-foreground w-5 text-center"></i>
                                            <span>Reports</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End of Megamenu Item-->
                <!--Megamenu Item-->
                <div class="kt-menu-item">
                    <a class="kt-menu-link kt-menu-item-hover:text-primary kt-menu-item-active:text-mono kt-menu-item-active:font-medium text-nowrap text-sm font-medium text-foreground"
                        href="{{ route('dashboard.core.settings.general') }}">
                        <span class="kt-menu-title text-nowrap">
                            Settings
                        </span>
                    </a>
                </div>
                <!--End of Megamenu Item-->
            </div>
            <!--End of Megamenu-->
        </div>
        <!--End of Megamenu Wrapper-->
    </div>
    <!--End of Megamenu Inner-->
</div>
<!--End of Megamenu Contaoner-->
