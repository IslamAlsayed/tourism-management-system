@php
    $currentRoute = Route::currentRouteName();
@endphp

<!--Megamenu Contaoner-->
<div class="flex items-stretch" id="megaMenuContainer">
    <!--Megamenu Inner-->
    <div class="flex items-stretch [--kt-reparent-mode:prepend] [--kt-reparent-target:body] lg:[--kt-reparent-mode:prepend] lg:[--kt-reparent-target:#megaMenuContainer]"
        data-kt-reparent="true">
        <!--Megamenu Wrapper-->
        <div class="hidden [--kt-drawer-enable:true] lg:flex lg:items-stretch lg:[--kt-drawer-enable:false]"
            data-kt-drawer="true"
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
                <!--Megamenu Item-->
                <div class="kt-menu-item" data-kt-menu-item-placement="bottom-start"
                    data-kt-menu-item-placement-rtl="bottom-end" data-kt-menu-item-toggle="accordion|lg:dropdown"
                    data-kt-menu-item-trigger="click">
                    <!-- data-kt-menu-item-trigger="click|lg:hover" -->
                    <div
                        class="kt-menu-link bg-transparent! lg:background kt-menu-link-hover:text-primary kt-menu-item-active:text-mono kt-menu-item-show:text-primary kt-menu-item-here:text-mono kt-menu-item-active:font-medium kt-menu-item-here:font-medium text-sm text-foreground">
                        <span class="kt-menu-title text-nowrap">
                            Shortcuts
                            <!-- icon arrow down drop menu -->
                            <i class="ki-filled ki-down fs-5 ms-1 mt-1"></i>
                        </span>
                        <span class="kt-menu-arrow flex lg:hidden">
                            <span class="kt-menu-item-show:hidden text-muted-foreground">
                                <i class="ki-filled ki-plus text-xs">
                                </i>
                            </span>
                            <span class="kt-menu-item-show:inline-flex hidden">
                                <i class="ki-filled ki-minus text-xs">
                                </i>
                            </span>
                        </span>
                    </div>
                    <!-- <div class="kt-menu-dropdown w-full gap-0 lg:max-w-[900px]"> -->
                    <div class="kt-menu-dropdown w-fit gap-0">
                        <div class="pb-2 pt-4 lg:p-7.5">
                            <div class="kt-menu kt-menu-default kt-menu-fit flex-col">
                                <h3 class="mb-2 ps-2.5 text-sm font-semibold leading-none text-foreground lg:mb-5">
                                    Popular Items
                                </h3>
                                <div class="grid lg:grid-cols-2 lg:gap-5">
                                    <div class="flex flex-col gap-2">
                                        <div
                                            class="kt-menu-item {{ isActive('tours.guides.index', [], $currentRoute) ? 'active' : '' }}">
                                            <a class="kt-menu-link" href="{{ route('tours.guides.index') }}"
                                                tabindex="0">
                                                <span class="kt-menu-icon">
                                                    <i class="fas fa-map"></i>
                                                </span>
                                                <span class="kt-menu-title grow-0">
                                                    Tours Guides
                                                </span>
                                            </a>
                                        </div>
                                        <div
                                            class="kt-menu-item {{ isActive('restaurants.index', [], $currentRoute) ? 'active' : '' }}">
                                            <a class="kt-menu-link" href="{{ route('restaurants.index') }}"
                                                tabindex="0">
                                                <span class="kt-menu-icon">
                                                    <i class="fas fa-utensils"></i>
                                                </span>
                                                <span class="kt-menu-title grow-0">
                                                    Restaurant
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <div
                                            class="kt-menu-item {{ isActive('transportations.companies.index', [], $currentRoute) ? 'active' : '' }}">
                                            <a class="kt-menu-link"
                                                href="{{ route('transportations.companies.index') }}" tabindex="0">
                                                <span class="kt-menu-icon">
                                                    <i class="fas fa-car"></i>
                                                </span>
                                                <span class="kt-menu-title grow-0">
                                                    Transportation
                                                </span>
                                            </a>
                                        </div>
                                        <div
                                            class="kt-menu-item {{ isActive('reports.index', [], $currentRoute) ? 'active' : '' }}">
                                            <a class="kt-menu-link" href="{{ route('reports.index') }}" tabindex="0">
                                                <span class="kt-menu-icon">
                                                    <i class="fas fa-chart-line"></i>
                                                </span>
                                                <span class="kt-menu-title grow-0">
                                                    Reports
                                                </span>
                                            </a>
                                        </div>
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
                        href="{{ route('settings.general') }}">
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
