<!-- Sidebar -->
<div class="kt-sidebar bg-background border-e border-e-border fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 [--kt-drawer-enable:true] lg:[--kt-drawer-enable:false]"
    data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">
    <div class="kt-sidebar-header hidden lg:flex items-center relative px-3 lg:px-4 shrink-0 py-2"
        id="sidebar_header">
        <a class="dark:hidden flex items-center" href="{{ route('dashboard') }}">
            <img class="default-logo h-[45px] w-auto max-w-none" src="{{ asset('metronic/media/app/default-logo.svg') }}" />
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
    <div class="kt-sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
        <div class="kt-scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3" data-kt-scrollable="true"
            data-kt-scrollable-dependencies="#sidebar_header" data-kt-scrollable-height="auto"
            data-kt-scrollable-offset="0px" data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">

            <!-- Dynamic Sidebar Menu -->
            <div class="kt-menu flex flex-col grow gap-1" data-kt-menu="true" data-kt-menu-accordion-expand-all="false" id="sidebar_menu">
                @php
                    $menuItems = config('sidebar.menu');
                    $currentRoute = Route::currentRouteName();
                @endphp

                @foreach($menuItems as $item)
                    @php
                        $hasPermission = true; // يمكنك إضافة منطق التحقق من الصلاحيات هنا
                        $hasChildren = isset($item['children']);
                        $isActive = isset($item['route']) && $currentRoute === $item['route'];
                        $hasActiveChild = false;
                        $itemTitle = function_exists('getLocalizedText') ? getLocalizedText($item['title']) : (is_array($item['title']) ? ($item['title']['en'] ?? '') : $item['title']);

                        if ($hasChildren) {
                            foreach ($item['children'] as $child) {
                                if (isset($child['route']) && $currentRoute === $child['route']) {
                                    $hasActiveChild = true;
                                    break;
                                }
                                if (isset($child['children'])) {
                                    foreach ($child['children'] as $subChild) {
                                        if (isset($subChild['route']) && $currentRoute === $subChild['route']) {
                                            $hasActiveChild = true;
                                            break 2;
                                        }
                                    }
                                }
                            }
                        }
                    @endphp

                    @if($hasPermission)
                        @if($hasChildren)
                            <!-- Menu with Children -->
                            <div class="kt-menu-item {{ $hasActiveChild ? 'kt-menu-item-show' : '' }}"
                                 data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                                <div class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                                    <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                        <i class="{{ $item['icon'] }} text-lg"></i>
                                    </span>
                                    <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                                        {{ $itemTitle }}
                                    </span>
                                    <span class="kt-menu-arrow text-muted-foreground w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                                        <span class="inline-flex kt-menu-item-show:hidden">
                                            <i class="ki-filled ki-plus text-[11px]"></i>
                                        </span>
                                        <span class="hidden kt-menu-item-show:inline-flex">
                                            <i class="ki-filled ki-minus text-[11px]"></i>
                                        </span>
                                    </span>
                                </div>
                                <div class="kt-menu-accordion gap-1 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-border">
                                    @foreach($item['children'] as $child)
                                        @php
                                            $childIsActive = isset($child['route']) && $currentRoute === $child['route'];
                                            $childHasChildren = isset($child['children']);
                                            $childHasActiveChild = false;
                                            $childTitle = function_exists('getLocalizedText') ? getLocalizedText($child['title']) : (is_array($child['title']) ? ($child['title']['en'] ?? '') : $child['title']);

                                            if ($childHasChildren) {
                                                foreach ($child['children'] as $subChild) {
                                                    if (isset($subChild['route']) && $currentRoute === $subChild['route']) {
                                                        $childHasActiveChild = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp

                                        @if($childHasChildren)
                                            <!-- Nested submenu -->
                                            <div class="kt-menu-item {{ $childHasActiveChild ? 'kt-menu-item-show' : '' }}"
                                                 data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                                                <div class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                                                    @if(isset($child['icon']))
                                                        <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                                            <i class="{{ $child['icon'] }} text-lg"></i>
                                                        </span>
                                                    @endif
                                                    <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                                                        {{ $childTitle }}
                                                    </span>
                                                    <span class="kt-menu-arrow text-muted-foreground w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                                                        <span class="inline-flex kt-menu-item-show:hidden">
                                                            <i class="ki-filled ki-plus text-[11px]"></i>
                                                        </span>
                                                        <span class="hidden kt-menu-item-show:inline-flex">
                                                            <i class="ki-filled ki-minus text-[11px]"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="kt-menu-accordion gap-1 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-border">
                                                    @foreach($child['children'] as $subChild)
                                                        @php
                                                            $subChildIsActive = isset($subChild['route']) && $currentRoute === $subChild['route'];
                                                            $subChildTitle = function_exists('getLocalizedText') ? getLocalizedText($subChild['title']) : (is_array($subChild['title']) ? ($subChild['title']['en'] ?? '') : $subChild['title']);
                                                        @endphp
                                                        <div class="kt-menu-item">
                                                            <a class="kt-menu-link border border-transparent items-center grow {{ $subChildIsActive ? 'kt-menu-item-active:bg-accent/60' : '' }} hover:bg-accent/60 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                                                href="{{ isset($subChild['route']) && $subChild['route'] !== '#' && $subChild['route'] !== 'placeholder' ? route($subChild['route']) : 'javascript:void(0)' }}"
                                                                {{ ($subChild['route'] === '#' || $subChild['route'] === 'placeholder') ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}
                                                                tabindex="0">
                                                                <span class="kt-menu-bullet flex w-[6px] -start-[3px] rtl:start-0 relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 {{ $subChildIsActive ? 'before:bg-primary' : '' }} kt-menu-item-hover:before:bg-primary"></span>
                                                                <span class="kt-menu-title text-2sm font-normal text-foreground {{ $subChildIsActive ? 'text-primary font-semibold' : '' }} kt-menu-link-hover:!text-primary">
                                                                    {{ $subChildTitle }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <!-- Simple submenu item -->
                                            <div class="kt-menu-item">
                                                <a class="kt-menu-link border border-transparent items-center grow {{ $childIsActive ? 'kt-menu-item-active:bg-accent/60' : '' }} hover:bg-accent/60 hover:rounded-lg gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                                   href="{{ isset($child['route']) && $child['route'] !== '#' && $child['route'] !== 'placeholder' ? route($child['route']) : 'javascript:void(0)' }}"
                                                   {{ ($child['route'] === '#' || $child['route'] === 'placeholder') ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}
                                                   tabindex="0">
                                                    <span class="kt-menu-bullet flex w-[6px] -start-[3px] rtl:start-0 relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 {{ $childIsActive ? 'before:bg-primary' : '' }} kt-menu-item-hover:before:bg-primary"></span>
                                                    <span class="kt-menu-title text-2sm font-normal text-foreground {{ $childIsActive ? 'text-primary font-semibold' : '' }} kt-menu-link-hover:!text-primary">
                                                        {{ $childTitle }}
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
                                   href="{{ isset($item['route']) && $item['route'] !== '#' && $item['route'] !== 'placeholder' ? route($item['route']) : 'javascript:void(0)' }}"
                                   {{ ($item['route'] === '#' || $item['route'] === 'placeholder') ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}
                                   tabindex="0">
                                    <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                        <i class="{{ $item['icon'] }} text-lg"></i>
                                    </span>
                                    <span class="kt-menu-title text-sm font-medium text-foreground {{ $isActive ? 'text-primary' : '' }} kt-menu-link-hover:!text-primary">
                                        {{ $itemTitle }}
                                    </span>
                                </a>
                            </div>
                        @endif
                    @endif
                @endforeach

                <!-- Separator -->
                @php
                    $quickActions = config('sidebar.quick_actions');
                    $quickTitle = function_exists('getLocalizedText') ? getLocalizedText($quickActions['title']) : (is_array($quickActions['title']) ? ($quickActions['title']['en'] ?? 'Quick Tools') : 'Quick Tools');
                @endphp
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span class="kt-menu-heading uppercase text-xs font-medium text-muted-foreground ps-[10px] pe-[10px]">
                        {{ $quickTitle }}
                    </span>
                </div>

                <!-- Quick Actions -->
                @foreach($quickActions['items'] as $quickItem)
                    @php
                        $quickItemTitle = function_exists('getLocalizedText') ? getLocalizedText($quickItem['title']) : (is_array($quickItem['title']) ? ($quickItem['title']['en'] ?? '') : $quickItem['title']);
                        $quickItemClass = $quickItem['class'] ?? '';
                    @endphp
                    <div class="kt-menu-item">
                        @if(isset($quickItem['action']) && $quickItem['action'] === 'logout')
                            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                                @csrf
                            </form>
                            <a class="kt-menu-link flex items-center grow border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px] hover:rounded-lg {{ $quickItemClass }}"
                               href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" tabindex="0">
                                <span class="kt-menu-icon items-start w-[20px]">
                                    <i class="{{ $quickItem['icon'] }} text-lg"></i>
                                </span>
                                <span class="kt-menu-title text-sm font-medium">
                                    {{ $quickItemTitle }}
                                </span>
                            </a>
                        @else
                            <a class="kt-menu-link flex items-center grow border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px] hover:bg-accent/60 hover:rounded-lg {{ $quickItemClass }}"
                               href="{{ isset($quickItem['route']) ? route($quickItem['route']) : '#' }}" tabindex="0">
                                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                    <i class="{{ $quickItem['icon'] }} text-lg"></i>
                                </span>
                                <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-link-hover:!text-primary">
                                    {{ $quickItemTitle }}
                                </span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            <!-- End of Sidebar Menu -->
        </div>
    </div>
</div>
<!-- End of Sidebar -->
