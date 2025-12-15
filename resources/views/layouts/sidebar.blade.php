{{-- Sidebar --}}
<div class="kt-sidebar bg-background border-e border-e-border fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 [--kt-drawer-enable:true] lg:[--kt-drawer-enable:false]"
    data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">
    {{-- Sidebar Header --}}
    <div class="kt-sidebar-header hidden lg:flex text-center justify-center relative px-3 lg:px-4 shrink-0 py-2"
        id="sidebar_header">
        <a class="dark:hidden flex items-center justify-center" href="{{ route('dashboard') }}">
            <img class="default-logo h-[45px] w-auto max-w-none"
                src="{{ $settings->app_light_photo ? asset('storage/' . $settings->app_light_photo) : asset('assets/images/logos/default-logo.svg') }}" />
            <img class="small-logo h-[45px] w-auto max-w-none"
                src="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('assets/images/logos/mini-logo.svg') }}" />
        </a>
        <a class="light:hidden flex items-center justify-center" href="{{ route('dashboard') }}">
            <img class="default-logo h-[45px] w-auto max-w-none"
                src="{{ $settings->app_dark_photo ? asset('storage/' . $settings->app_dark_photo) : asset('assets/images/logos/default-logo.svg') }}" />
            <img class="small-logo h-[45px] w-auto max-w-none"
                src="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('assets/images/logos/mini-logo.svg') }}" />
        </a>
        <button
            class="kt-btn kt-btn-outline kt-btn-icon size-[30px] absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
            data-kt-toggle="body" data-kt-toggle-class="kt-sidebar-collapse" id="sidebar_toggle">
            <i
                class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:kt-toggle-active:rotate-0">
            </i>
        </button>
    </div>

    {{-- Sidebar Content --}}
    <div class="kt-sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
        <div class="kt-scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3" style="padding-inline-end: 0"
            data-kt-scrollable="true" data-kt-scrollable-dependencies="#sidebar_header" data-kt-scrollable-height="auto"
            data-kt-scrollable-offset="0px" data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">

            {{-- Dynamic Sidebar Menu --}}
            <div class="kt-menu flex flex-col grow gap-1" data-kt-menu="true" id="sidebar_menu">
                @php
                    $menuItems = config('sidebar.menu');
                    $currentRoute = Route::currentRouteName();
                    $currentParameters = request()->route()->parameters();
                @endphp

                @foreach ($menuItems as $item)
                    @php
                        $hasChildren = isset($item['children']);
                        $isActive = isset($item['route'])
                            ? isActive($item['route'], $item['parameters'] ?? [], $currentRoute, $currentParameters)
                            : false;
                        $hasActiveChild = $hasChildren
                            ? hasActiveChild($item['children'], $currentRoute, $currentParameters)
                            : false;
                    @endphp

                    @if ($hasChildren)
                        {{-- Menu with Children --}}
                        <div class="kt-menu-item {{ $hasActiveChild ? 'show' : '' }}"
                            data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                            <div
                                class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[15px] py-[6px] {{ $hasActiveChild ? 'bg-accent/60 rounded-[9px]' : '' }} hover:bg-accent/60 hover:rounded-[9px]">
                                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                    <i
                                        class="{{ $item['icon'] ?? 'ki-filled ki-folder' }} text-lg {{ $hasActiveChild ? 'text-primary' : '' }}"></i>
                                </span>

                                <span
                                    class="kt-menu-title text-sm font-medium text-foreground {{ $hasActiveChild ? 'text-primary font-semibold' : '' }}">
                                    {{ __('sidebar.' . $item['title']) }}
                                    @if (isset($item['status']) && env('DB_MODE') != 'production')
                                        <span
                                            class="inline-block {{ $item['status'] == 'inprogress' ? 'bg-yellow-500 text-white' : 'bg-primary/10 text-primary' }} text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                            {{ __('sidebar.' . $item['status']) }}
                                        </span>
                                    @endif

                                    @if (isset($item['fixed']) && env('DB_MODE') != 'production')
                                        <span
                                            class="inline-block bg-primary/10 text-red-600 text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                            @if (gettype($item['fixed']) == 'boolean')
                                                <i class="fas fa-xmark"></i>
                                            @elseif (preg_match('/\d/', $item['fixed']))
                                                {{ __('sidebar.' . $item['fixed']) }}
                                            @else
                                                {{ __('sidebar.' . $item['fixed']) }}
                                            @endif
                                        </span>
                                    @endif
                                </span>
                                <span
                                    class="kt-menu-arrow text-muted-foreground shrink-0 justify-end ms-1 me-[-10px] {{ $hasActiveChild ? 'text-primary' : '' }}">
                                    <span class="inline-flex kt-menu-item-show:hidden">
                                        <i class="ki-filled ki-plus text-[11px]"></i>
                                    </span>
                                    <span class="hidden kt-menu-item-show:inline-flex">
                                        <i class="ki-filled ki-minus text-[11px]"></i>
                                    </span>
                                </span>
                            </div>

                            {{-- Children --}}
                            <div
                                class="kt-menu-accordion gap-1 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-border {{ $hasActiveChild ? 'show' : '' }}">
                                @foreach ($item['children'] as $child)
                                    @php
                                        $childHasChildren = isset($child['children']);
                                        $childIsActive = isActive(
                                            $child['route'] ?? null,
                                            $child['parameters'] ?? [],
                                            $currentRoute,
                                            $currentParameters,
                                        );
                                        $childHasActiveChild = $childHasChildren
                                            ? hasActiveChild($child['children'], $currentRoute, $currentParameters)
                                            : false;
                                    @endphp

                                    @if ($childHasChildren)
                                        {{-- Nested submenu --}}
                                        <div class="kt-menu-item {{ $childHasActiveChild ? 'kt-menu-item-show show' : '' }} px-2"
                                            data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                                            <div
                                                class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[15px] py-[6px] {{ $childHasActiveChild ? 'bg-accent/60 rounded-[9px]' : '' }} hover:bg-accent/60 hover:rounded-[9px]">
                                                @if (isset($child['icon']))
                                                    <span
                                                        class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                                        <i
                                                            class="{{ $child['icon'] }} {{ $childHasActiveChild ? 'text-primary' : '' }}"></i>
                                                    </span>
                                                @endif

                                                <span
                                                    class="kt-menu-title text-sm font-medium text-foreground {{ $childHasActiveChild ? 'text-primary font-semibold' : '' }}">
                                                    {{ __('sidebar.' . $child['title']) }}
                                                    @if (isset($child['status']) && env('DB_MODE') != 'production')
                                                        <span
                                                            class="inline-block {{ $child['status'] == 'inprogress' ? 'bg-yellow-500 text-white' : 'bg-primary/10 text-primary' }} text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                                            {{ __('sidebar.' . $child['status']) }}
                                                        </span>
                                                    @endif

                                                    @if (isset($child['fixed']) && env('DB_MODE') != 'production')
                                                        <span
                                                            class="inline-block bg-primary/10 text-red-600 text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                                            @if (gettype($child['fixed']) == 'boolean')
                                                                <i class="fas fa-xmark"></i>
                                                            @else
                                                                {{ __('sidebar.' . $child['fixed']) }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                </span>
                                                <span
                                                    class="kt-menu-arrow text-muted-foreground shrink-0 justify-end ms-1 me-[-10px] {{ $childHasActiveChild ? 'text-primary' : '' }}">
                                                    <span class="inline-flex kt-menu-item-show:hidden">
                                                        <i class="ki-filled ki-plus text-[11px]"></i>
                                                    </span>
                                                    <span class="hidden kt-menu-item-show:inline-flex">
                                                        <i class="ki-filled ki-minus text-[11px]"></i>
                                                    </span>
                                                </span>
                                            </div>

                                            {{-- SubChildren --}}
                                            <div
                                                class="kt-menu-accordion gap-1 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-border">
                                                @foreach ($child['children'] as $subChild)
                                                    @php $subChildIsActive = isActive($subChild['route'] ?? null, $subChild['parameters'] ?? [], $currentRoute, $currentParameters); @endphp
                                                    <div class="kt-menu-item px-2">
                                                        <a class="kt-menu-link border border-transparent items-center grow {{ $subChildIsActive ? 'bg-accent/60 rounded-[9px]' : '' }} hover:bg-accent/60 hover:rounded-[9px] gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                                            href="{{ isset($subChild['route']) && $subChild['route'] !== '#' ? route($subChild['route'], isset($subChild['parameters']) ? $subChild['parameters'] : []) : 'javascript:void(0)' }}"
                                                            {{ ($subChild['route'] ?? '') === '#' ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}>
                                                            {{-- <span
                                                                class="kt-menu-bullet flex w-[6px] -start-[3px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full {{ $subChildIsActive ? 'before:bg-primary' : '' }}">
                                                            </span> --}}

                                                            <span
                                                                class="kt-menu-icon items-start text-muted-foreground w-[10px]">
                                                                <i
                                                                    class="{{ $subChild['icon'] ?? 'ki-filled ki-folder' }} text-sm {{ $subChildIsActive ? 'text-primary' : '' }}"></i>
                                                            </span>

                                                            <span
                                                                class="kt-menu-title text-2sm font-normal {{ $subChildIsActive ? 'text-primary font-semibold' : '' }}">
                                                                {{ __('sidebar.' . $subChild['title']) }}

                                                                @if (isset($subChild['status']) && env('DB_MODE') != 'production')
                                                                    <span
                                                                        class="inline-block {{ $subChild['status'] == 'inprogress' ? 'bg-yellow-500 text-white' : 'bg-primary/10 text-primary' }} text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                                                        {{ __('sidebar.' . $subChild['status']) }}
                                                                    </span>
                                                                @endif

                                                                @if (isset($subChild['fixed']) && env('DB_MODE') != 'production')
                                                                    <span
                                                                        class="inline-block bg-primary/10 text-red-600 text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                                                        @if (gettype($subChild['fixed']) == 'boolean')
                                                                            <i class="fas fa-xmark"></i>
                                                                        @else
                                                                            {{ __('sidebar.' . $subChild['fixed']) }}
                                                                        @endif
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        {{-- Simple child --}}
                                        <div class="kt-menu-item px-2">
                                            <a class="kt-menu-link border border-transparent items-center grow {{ $childIsActive ? 'bg-accent/60 rounded-[9px]' : '' }} hover:bg-accent/60 hover:rounded-[9px] gap-[14px] ps-[10px] pe-[10px] py-[8px]"
                                                href="{{ isset($child['route']) && $child['route'] !== '#' ? route($child['route'], isset($child['parameters']) ? $child['parameters'] : []) : 'javascript:void(0)' }}"
                                                {{ ($child['route'] ?? '') === '#' ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}>
                                                {{-- <span
                                                    class="kt-menu-bullet flex w-[6px] -start-[3px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full {{ $childIsActive ? 'before:bg-primary' : '' }}">
                                                </span> --}}

                                                <span class="kt-menu-icon items-start text-muted-foreground w-[10px]">
                                                    <i
                                                        class="{{ $child['icon'] ?? 'ki-filled ki-folder' }} text-sm {{ $childIsActive ? 'text-primary' : '' }}"></i>
                                                </span>

                                                <span
                                                    class="kt-menu-title text-2sm font-normal {{ $childIsActive ? 'text-primary font-semibold' : '' }}">
                                                    {{ __('sidebar.' . $child['title']) }}

                                                    @if (isset($child['status']) && env('DB_MODE') != 'production')
                                                        <span
                                                            class="inline-block {{ $child['status'] == 'inprogress' ? 'bg-yellow-500 text-white' : 'bg-primary/10 text-primary' }} text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                                            {{ __('sidebar.' . $child['status']) }}
                                                        </span>
                                                    @endif

                                                    @if (isset($child['fixed']) && env('DB_MODE') != 'production')
                                                        <span
                                                            class="inline-block bg-primary/10 text-red-600 text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                                            @if (gettype($child['fixed']) == 'boolean')
                                                                <i class="fas fa-xmark"></i>
                                                            @else
                                                                {{ __('sidebar.' . $child['fixed']) }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                </span>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        {{-- Simple Menu Item --}}
                        <div class="kt-menu-item">
                            <a class="kt-menu-link flex items-center grow border border-transparent gap-[10px] ps-[10px] pe-[15px] py-[6px] {{ $isActive ? 'bg-accent/60 rounded-[9px]' : '' }} hover:bg-accent/60 hover:rounded-[9px]"
                                href="{{ isset($item['route']) && $item['route'] !== '#' ? route($item['route'], isset($item['parameters']) ? $item['parameters'] : []) : 'javascript:void(0)' }}"
                                {{ ($item['route'] ?? '') === '#' ? 'onclick="alert(\'هذه الصفحة قيد الإنشاء - Page under construction\')"' : '' }}>
                                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                    <i
                                        class="{{ $item['icon'] ?? 'ki-filled ki-folder' }} {{ $isActive ? 'text-primary' : '' }}"></i>
                                </span>

                                <span
                                    class="kt-menu-title text-sm font-medium {{ $isActive ? 'text-primary font-semibold' : '' }}">
                                    {{ __('sidebar.' . $item['title']) }}

                                    @if (isset($item['status']) && env('DB_MODE') != 'production')
                                        <span
                                            class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                            {{ __('sidebar.' . $item['status']) }}
                                        </span>
                                    @endif

                                    @if (isset($item['fixed']) && env('DB_MODE') != 'production')
                                        <span
                                            class="inline-block bg-primary/10 text-red-600 text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                            @if (gettype($item['fixed']) == 'boolean')
                                                <i class="fas fa-xmark"></i>
                                            @else
                                                {{ __('sidebar.' . $item['fixed']) }}
                                            @endif
                                        </span>
                                    @endif
                                </span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
