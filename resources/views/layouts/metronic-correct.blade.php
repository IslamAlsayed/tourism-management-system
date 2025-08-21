<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $pageTitle ?? 'MixJo Tourism' }} - World's Largest Geographic Database</title>
    <meta charset="utf-8" />
    <meta name="description" content="{{ $pageDescription ?? 'Tourism Dashboard with 88,092 cities & 245 countries' }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="shortcut icon" href="{{ asset('metronic/media/logos/favicon.ico') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" />
    <!--end::Fonts-->

    <!--begin::Vendor Stylesheets(used for this page only)-->
    @stack('vendor_css')
    <!--end::Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('metronic/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/styles.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Custom Stylesheets(optional)-->
    @stack('custom_css')
    <!--end::Custom Stylesheets-->
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            @include('layouts.partials.header')

            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                @include('layouts.partials.sidebar')

                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

                    @include('layouts.partials.toolbar')

                    <!--begin::Content wrapper-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            @yield('content')
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content wrapper-->

                    @include('layouts.partials.footer')

                </div>
                <!--end:::Main-->

            </div>
            <!--end::Wrapper-->

        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('metronic/js/core.bundle.js') }}"></script>
    <script src="{{ asset('metronic/vendors/ktui/ktui.min.js') }}"></script>
    <script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Custom Javascript(used for this page only)-->
    @stack('custom_js')
    <!--end::Custom Javascript-->

    <!--begin::Page Vendors Javascript(used for this page only)-->
    @stack('vendor_js')
    <!--end::Page Vendors Javascript-->

    <!--begin::Page Custom Javascript(used for this page only)-->
    @stack('page_js')
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>

</html>
