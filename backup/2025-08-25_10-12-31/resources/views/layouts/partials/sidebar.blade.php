{{-- begin::Sidebar --}}
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    {{-- begin::Logo --}}
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        {{-- begin::Logo image --}}
        {{-- <a href="{{ route('home') }}"> --}}
        <a href="#">
            <img alt="Logo" src="{{ asset('assets/media/logos/mixjo-logo.svg') }}"
                class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('assets/media/logos/mixjo-logo-small.svg') }}"
                class="h-20px app-sidebar-logo-minimize" />
        </a>
        {{-- end::Logo image --}}
    </div>
    {{-- end::Logo --}}

    {{-- begin::sidebar menu --}}
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        {{-- begin::Menu wrapper --}}
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            {{-- begin::Menu --}}
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                {{-- Dashboard --}}
                <div class="menu-item">
                    {{-- <a class="menu-link active" href="{{ route('home') }}"> --}}
                    <a class="menu-link active" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-element-11 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                {{-- Geographic Database --}}
                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Geographic Database</span>
                    </div>
                </div>

                {{-- Countries --}}
                <div class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-flag fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Countries</span>
                        <span class="menu-badge">
                            <span class="badge badge-success">245</span>
                        </span>
                    </a>
                </div>

                {{-- Cities --}}
                <div class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-abstract-46 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Cities</span>
                        <span class="menu-badge">
                            <span class="badge badge-primary">88,092</span>
                        </span>
                    </a>
                </div>

                {{-- Currencies --}}
                <div class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-dollar fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                        <span class="menu-title">Currencies</span>
                        <span class="menu-badge">
                            <span class="badge badge-warning">49</span>
                        </span>
                    </a>
                </div>

                {{-- User Management --}}
                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">User Management</span>
                    </div>
                </div>

                {{-- Users --}}
                <div class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-profile-user fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Users</span>
                    </a>
                </div>

            </div>
            {{-- end::Menu --}}
        </div>
        {{-- end::Menu wrapper --}}
    </div>
    {{-- end::sidebar menu --}}
</div>
{{-- end::Sidebar --}}
