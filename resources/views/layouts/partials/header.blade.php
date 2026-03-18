{{-- begin::Header --}}
<div id="kt_app_header" class="app-header">
    {{-- begin::Header container --}}
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between">
        {{-- begin::Sidebar mobile toggle --}}
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="kt-btn kt-btn-icon kt-btn-light kt-btn-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        {{-- end::Sidebar mobile toggle --}}

        {{-- begin::Mobile logo --}}
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/media/logos/default.svg') }}" class="h-30px" />
            </a>
        </div>
        {{-- end::Mobile logo --}}

        {{-- begin::Header wrapper --}}
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            {{-- begin::Menu wrapper --}}
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch">
                {{-- begin::Menu --}}
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                    id="kt_app_header_menu">
                    {{-- begin::Menu item --}}
                    <div class="menu-item">
                        {{-- begin::Menu link --}}
                        <span class="menu-link">
                            <span class="menu-title">MixJo Tourism Dashboard</span>
                        </span>
                        {{-- end::Menu link --}}
                    </div>
                    {{-- end::Menu item --}}
                </div>
                {{-- end::Menu --}}
            </div>
            {{-- end::Menu wrapper --}}

            {{-- begin::Navbar --}}
            <div class="app-navbar flex-shrink-0">
                {{-- begin::User menu --}}
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    {{-- begin::Menu wrapper --}}
                    <div class="cursor-pointer symbol symbol-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-{{ app()->getLocale() == 'ar' ? 'start' : 'end' }}">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/blank.png') }}"
                            alt="{{ $user->name }}" class="size-full object-cover">
                    </div>
                    {{-- begin::User account menu --}}
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        {{-- begin::Menu item --}}
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/blank.png') }}"
                                        alt="{{ $user->name }}" class="size-full object-cover">
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{ $activeUser->name }}</div>
                                    <a href="#"
                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ $activeUser->email }}</a>
                                </div>
                            </div>
                        </div>
                        {{-- end::Menu item --}}

                        {{-- begin::Menu separator --}}
                        <div class="separator my-2"></div>
                        {{-- end::Menu separator --}}

                        {{-- begin::Menu item --}}
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">My Profile</a>
                        </div>
                        {{-- end::Menu item --}}

                        {{-- begin::Menu separator --}}
                        <div class="separator my-2"></div>
                        {{-- end::Menu separator --}}

                        {{-- begin::Menu item --}}
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">Sign Out</a>
                        </div>
                        {{-- end::Menu item --}}
                    </div>
                    {{-- end::Menu --}}
                </div>
                {{-- end::User menu --}}
            </div>
            {{-- end::Navbar --}}
        </div>
        {{-- end::Header wrapper --}}
    </div>
    {{-- end::Header container --}}
</div>
{{-- end::Header --}}
