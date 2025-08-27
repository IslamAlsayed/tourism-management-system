<!-- Sidebar -->
<div class="kt-sidebar bg-background border-e border-e-border fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 [--kt-drawer-enable:true] lg:[--kt-drawer-enable:false]"
    data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">

    <!-- Sidebar Header -->
    <div class="kt-sidebar-header hidden lg:flex items-center relative px-3 lg:px-4 shrink-0 py-2" id="sidebar_header">
        <a class="dark:hidden flex items-center" href="{{ route('dashboard') }}">
            <img class="default-logo h-[45px] w-auto max-w-none"
                src="{{ asset('metronic/media/app/default-logo.svg') }}" />
            <img class="small-logo h-[45px] w-auto max-w-none" src="{{ asset('metronic/media/app/mini-logo.svg') }}" />
        </a>
        <a class="hidden dark:flex items-center" href="{{ route('dashboard') }}">
            <img class="default-logo h-[45px] w-auto max-w-none"
                src="{{ asset('metronic/media/app/default-logo-dark.svg') }}" />
            <img class="small-logo h-[45px] w-auto max-w-none" src="{{ asset('metronic/media/app/mini-logo.svg') }}" />
        </a>
        <button
            class="kt-btn kt-btn-outline kt-btn-icon size-[30px] absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
            data-kt-toggle="body" data-kt-toggle-class="kt-sidebar-collapse" id="sidebar_toggle">
            <i
                class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:kt-toggle-active:rotate-0">
            </i>
        </button>
    </div>

    <!-- Sidebar Content -->
    <div class="kt-sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
        <div class="kt-scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3" data-kt-scrollable="true"
            data-kt-scrollable-dependencies="#sidebar_header" data-kt-scrollable-height="auto"
            data-kt-scrollable-offset="0px" data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">

            <!-- Dynamic Sidebar Menu -->
            <div class="kt-menu flex flex-col grow gap-1" data-kt-menu="true" id="sidebar_menu">
                @php
                    $menuItems = config('sidebar.menu');
                    $currentRoute = Route::currentRouteName();
                @endphp

                @foreach ($menuItems as $item)
                    @php
                        $hasChildren = isset($item['children']);
                        $isActive = isset($item['route']) ? isActive($item['route'], $currentRoute) : false;
                        $hasActiveChild = $hasChildren ? hasActiveChild($item['children'], $currentRoute) : false;
                    @endphp

                    @if ($hasChildren)
                        <!-- Menu with Children -->
                        <div class="kt-menu-item {{ $hasActiveChild ? 'kt-menu-item-show' : '' }}"
                            data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                            <div
                                class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]">
                                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                    <i class="{{ $item['icon'] ?? 'ki-filled ki-folder' }} text-lg"></i>
                                </span>
                                <span class="kt-menu-title text-sm font-medium text-foreground">
                                    {{ __('sidebar.' . $item['title']) }}
                                </span>
                                <span
                                    class="kt-menu-arrow text-muted-foreground w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                                    <span class="inline-flex kt-menu-item-show:hidden"><i
                                            class="ki-filled ki-plus text-[11px]"></i></span>
                                    <span class="hidden kt-menu-item-show:inline-flex"><i
                                            class="ki-filled ki-minus text-[11px]"></i></span>
                                </span>
                            </div>

                            <!-- Children -->
                            <div
                                class="kt-menu-accordion gap-1 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-border">
                                @foreach ($item['children'] as $child)
                                    @php
                                        $childHasChildren = isset($child['children']);
                                        $childIsActive = isActive($child['route'] ?? null, $currentRoute);
                                        $childHasActiveChild = $childHasChildren
                                            ? hasActiveChild($child['children'], $currentRoute)
                                            : false;
                                    @endphp

                                    @if ($childHasChildren)
                                        <!-- Nested submenu -->
                                        <div class="kt-menu-item {{ $childHasActiveChild ? 'kt-menu-item-show' : '' }}"
                                            data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                                            <div
                                                class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]">
                                                @if (isset($child['icon']))
                                                    <span
                                                        class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                                        <i class="{{ $child['icon'] }}"></i>
                                                    </span>
                                                @endif
                                                <span class="kt-menu-title text-sm font-medium text-foreground">
                                                    {{ __('sidebar.' . $child['title']) }}
                                                </span>
                                                <span
                                                    class="kt-menu-arrow text-muted-foreground w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                                                    <span class="inline-flex kt-menu-item-show:hidden"><i
                                                            class="ki-filled ki-plus text-[11px]"></i></span>
                                                    <span class="hidden kt-menu-item-show:inline-flex"><i
                                                            class="ki-filled ki-minus text-[11px]"></i></span>
                                                </span>
                                            </div>

                                            <!-- SubChildren -->
                                            <div
                                                class="kt-menu-accordion gap-1 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-border">
                                                @foreach ($child['children'] as $subChild)
                                                    @php $subChildIsActive = isActive($subChild['route'] ?? null, $currentRoute); @endphp
                                                    <div class="kt-menu-item">
                                                        <a class="kt-menu-link border border-transparent items-center grow {{ $subChildIsActive ? 'kt-menu-item-active:bg-accent/60' : '' }} hover:bg-accent/60 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                                            href="{{ isset($subChild['route']) && $subChild['route'] !== '#' ? route($subChild['route']) : 'javascript:void(0)' }}"
                                                            {{ ($subChild['route'] ?? '') === '#' ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}>
                                                            <span
                                                                class="kt-menu-bullet flex w-[6px] -start-[3px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full {{ $subChildIsActive ? 'before:bg-primary' : '' }}"></span>
                                                            <span
                                                                class="kt-menu-title text-2sm font-normal {{ $subChildIsActive ? 'text-primary font-semibold' : '' }}">
                                                                {{ __('sidebar.' . $subChild['title']) }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <!-- Simple child -->
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link border border-transparent items-center grow {{ $childIsActive ? 'kt-menu-item-active:bg-accent/60' : '' }} hover:bg-accent/60 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                                href="{{ isset($child['route']) && $child['route'] !== '#' ? route($child['route']) : 'javascript:void(0)' }}"
                                                {{ ($child['route'] ?? '') === '#' ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}>
                                                <span
                                                    class="kt-menu-bullet flex w-[6px] -start-[3px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full {{ $childIsActive ? 'before:bg-primary' : '' }}"></span>
                                                <span
                                                    class="kt-menu-title text-2sm font-normal {{ $childIsActive ? 'text-primary font-semibold' : '' }}">
                                                    {{ __('sidebar.' . $child['title']) }}
                                                </span>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Simple Menu Item -->
                        <div class="kt-menu-item">
                            <a class="kt-menu-link flex items-center grow border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px] {{ $isActive ? 'kt-menu-item-active:bg-accent/60' : '' }} hover:bg-accent/60 hover:rounded-lg"
                                href="{{ isset($item['route']) && $item['route'] !== '#' ? route($item['route']) : 'javascript:void(0)' }}"
                                {{ ($item['route'] ?? '') === '#' ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}>
                                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                    <i class="{{ $item['icon'] ?? 'ki-filled ki-folder' }}"></i>
                                </span>
                                <span
                                    class="kt-menu-title text-sm font-medium {{ $isActive ? 'text-primary font-semibold' : '' }}">
                                    {{ __('sidebar.' . $item['title']) }}
                                </span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
