@extends('layouts.metronic')
{{-- @extends('layouts.metronic-cdn') --}}
{{-- @extends('layouts.metronic-correct') --}}

@section('content')
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}"
                data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}"
                data-kt-sticky-animation="false">
                <!--begin::Header container-->
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <!--begin::Sidebar mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <!--end::Sidebar mobile toggle-->

                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="/" class="d-lg-none">
                            <img alt="Logo" src="{{ asset('metronic/media/app/default-logo.svg') }}" class="h-30px" />
                        </a>
                    </div>
                    <!--end::Mobile logo-->

                    <!--begin::Header wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <!--begin::Menu-->
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                            data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                            <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                                id="kt_app_header_menu" data-kt-menu="true">
                                <div class="menu-item me-0 me-lg-2">
                                    <span class="menu-link">
                                        <span class="menu-title">🏆 MixJo Tourism Dashboard</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Menu-->

                        <!--begin::Navbar-->
                        <div class="app-navbar flex-shrink-0">
                            <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                                <div class="cursor-pointer symbol symbol-35px"
                                    data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <img src="{{ asset('metronic/media/avatars/300-3.png') }}" class="rounded-3"
                                        alt="user" />
                                </div>
                            </div>
                        </div>
                        <!--end::Navbar-->
                    </div>
                    <!--end::Header wrapper-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->

            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    <h1
                                        class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        Tourism Dashboard</h1>
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        <li class="breadcrumb-item text-muted">
                                            <a href="/" class="text-muted text-hover-primary">Home</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <li class="breadcrumb-item text-muted">Dashboard</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-xxl">

                                <!-- Statistics Cards -->
                                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                    <!-- Countries -->
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                                            style="background-color: #F1416C; background-image:url('{{ asset('metronic/media/patterns/grid.svg') }}')">
                                            {{-- style="background-color: #F1416C; background-image:url('{{ asset('metronic/media/patterns/vector-1.png') }}')"> --}}
                                            <div class="card-header pt-5">
                                                <div class="card-title d-flex flex-column">
                                                    <span
                                                        class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($stats['countries']) }}</span>
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">🌍 Countries
                                                        Worldwide</span>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                        <span class="fw-bolder fs-6 text-white opacity-75">Coverage</span>
                                                        <span class="fw-bold fs-6 text-white">100%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar"
                                                            style="width: 100%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cities -->
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                                            style="background-color: #7239EA; background-image:url('{{ asset('metronic/media/patterns/grid.svg') }}')">
                                            {{-- style="background-color: #7239EA; background-image:url('{{ asset('metronic/media/patterns/vector-1.png') }}')"> --}}
                                            <div class="card-header pt-5">
                                                <div class="card-title d-flex flex-column">
                                                    <span
                                                        class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($stats['cities']) }}</span>
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">🏙️ Cities
                                                        Database</span>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                        <span class="fw-bolder fs-6 text-white opacity-75">World's
                                                            Largest</span>
                                                        <span class="fw-bold fs-6 text-white">88K+</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar"
                                                            style="width: 95%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Currencies -->
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                                            style="background-color: #17C653; background-image:url('{{ asset('metronic/media/patterns/grid.svg') }}')">
                                            {{-- style="background-color: #17C653; background-image:url('{{ asset('metronic/media/patterns/vector-1.png') }}')"> --}}
                                            <div class="card-header pt-5">
                                                <div class="card-title d-flex flex-column">
                                                    <span
                                                        class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($stats['currencies']) }}</span>
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">💰 Global
                                                        Currencies</span>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                        <span class="fw-bolder fs-6 text-white opacity-75">Exchange
                                                            Rates</span>
                                                        <span class="fw-bold fs-6 text-white">Live</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar"
                                                            style="width: 80%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Users -->
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                                            {{-- style="background-color: #FFC700; background-image:url('{{ asset('metronic/media/patterns/grid.svg') }}')"> --}} {{-- style="background-color: #FFC700; background-image:url('{{ asset('metronic/media/patterns/vector-1.png') }}')"> --}} <div class="card-header pt-5">
                                            <div class="card-title d-flex flex-column">
                                                <span
                                                    class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($stats['users']) }}</span>
                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">👥 Active
                                                    Users</span>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex align-items-end pt-0">
                                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                    <span class="fw-bolder fs-6 text-white opacity-75">Growth</span>
                                                    <span class="fw-bold fs-6 text-white">+15%</span>
                                                </div>
                                                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                    <div class="bg-white rounded h-8px" role="progressbar"
                                                        style="width: 70%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Welcome Card -->
                            <div class="card mb-5 mb-xl-10">
                                <div class="card-body pt-9 pb-0">
                                    <div class="d-flex flex-wrap flex-sm-nowrap">
                                        <div class="me-7 mb-4">
                                            <div
                                                class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                                <img src="{{ asset('metronic/media/avatars/300-1.png') }}"
                                                    alt="image" />
                                                <div
                                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <a href="#"
                                                            class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">Welcome
                                                            to MixJo Tourism!</a>
                                                        <a href="#">
                                                            <i class="ki-duotone ki-verify fs-1 text-primary">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                        <a href="#"
                                                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>Tourism Administrator
                                                        </a>
                                                        <a href="#"
                                                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <i class="ki-duotone ki-geolocation fs-4 me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>Global Database Manager
                                                        </a>
                                                        <a href="#"
                                                            class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                            <i class="ki-duotone ki-sms fs-4 me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>admin@mixjo.com
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap flex-stack">
                                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                                    <div class="d-flex flex-wrap">
                                                        <div
                                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <div class="fs-2 fw-bold counted">
                                                                    {{ number_format($stats['countries']) }}</div>
                                                            </div>
                                                            <div class="fw-semibold fs-6 text-gray-400">Countries</div>
                                                        </div>
                                                        <div
                                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <div class="fs-2 fw-bold counted">88K+</div>
                                                            </div>
                                                            <div class="fw-semibold fs-6 text-gray-400">Cities</div>
                                                        </div>
                                                        <div
                                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <div class="fs-2 fw-bold counted">
                                                                    {{ number_format($stats['currencies']) }}</div>
                                                            </div>
                                                            <div class="fw-semibold fs-6 text-gray-400">Currencies
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="d-flex overflow-auto h-55px">
                                        <ul
                                            class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 active"
                                                    href="#">Overview</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5"
                                                    href="#">Countries</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5"
                                                    href="#">Cities</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->
            </div>
            <!--end::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::App-->
@endsection
