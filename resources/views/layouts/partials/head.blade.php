<title>@yield('title', 'MixJo Tourism') - World's Largest Geographic Database</title>
<base href="../../">
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.USERID = "{{ getActiveUser()?->id }}";
    window.APP_LANG = "{{ app()->getLocale() }}";
    window.APP_DEBUG = {{ config('app.debug') ? 'true' : 'false' }};
</script>
<meta content="follow, index" name="robots" />
<link href="{{ url(request()->path()) }}" rel="canonical" />
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
<meta content="Sign in page using Tailwind CSS" name="description" />

<meta content="@mixjo" name="twitter:site" />
<meta content="@mixjo" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />
<meta content="Metronic - Tailwind CSS" name="twitter:title" />
<meta content="Sign in page using Tailwind CSS" name="twitter:description" />
<meta content="{{ asset('metronic/media/app/og-image.png') }}" name="twitter:image" />

<meta content="{{ url(request()->path()) }}" property="og:url" />
<meta content="en_US" property="og:locale" />
<meta content="website" property="og:type" />
<meta content="@mixjo" property="og:site_name" />
<meta content="Metronic - Tailwind CSS" property="og:title" />
<meta content="Sign in page using Tailwind CSS" property="og:description" />
<meta content="{{ asset('metronic/media/app/og-image.png') }}" property="og:image" />

<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="apple-touch-icon" sizes="180x180" />
<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="icon" sizes="32x32" type="image/png" />
<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="icon" sizes="16x16" type="image/png" />

{{-- <link href="{{ asset('metronic/media/app/favicon.ico') }}" rel="shortcut icon" /> --}}
<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="shortcut icon" />

<link href="{{ asset('assets/plugins/fonts/inter.css') }}" rel="stylesheet" />
{{-- Fontawesome icons pro --}}
<link href="{{ asset('assets/plugins/fontawesome-icons/css/all.min.css') }}" rel="stylesheet" />

<link href="{{ asset('metronic/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
<link href="{{ asset('metronic/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/checkbox-input.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/toggle-input.css') }}" rel="stylesheet" />

{{-- Multi Select CSS --}}
<link href="{{ asset('assets/css/multi-select.css') }}" rel="stylesheet">
<link href="{{ asset('metronic/css/styles.css') }}" rel="stylesheet" />

{{-- Dynamic Sidebar Width - Must come after styles.css to override --}}
@php
    $sidebarWidth = $settings->app_sidebar_width ?? (config('app.app_sidebar_width') ?? 310);
    $sidebarWidth = $settings->app_sidebar_width ?? (config('app.app_sidebar_width') ?? 310);
@endphp
<style>
    .demo1 {
        --sidebar-width: {{ $sidebarWidth }}px;
        --sidebar-default-width: {{ $sidebarWidth }}px;
    }
</style>

{{-- Text editor --}}
<link href="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.css') }}" rel="stylesheet" />

<!-- Compiled App Styles -->
@vite(['resources/css/app.css'])

{{-- Trix Editor Custom Styles --}}
<style>
    trix-editor,
    trix-toolbar {
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    trix-editor {
        overflow-x: hidden !important;
        width: 100% !important;
    }

    trix-toolbar {
        overflow-x: auto !important;
        width: 100% !important;
    }

    trix-toolbar .trix-button-group {
        flex-wrap: wrap !important;
    }
</style>

@yield('styles')
@stack('styles')

{{-- Theme Mode --}}
@include('components.script-theme')
