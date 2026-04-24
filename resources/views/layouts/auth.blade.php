<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="{{ config('app.app_theme', 'light') }}"
    dir="{{ getLocaleDirection() }}" lang="{{ app()->getLocale() }}">

<head>
    <title>@yield('title', 'MixJo Tourism')</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="follow, index" name="robots" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />

    {{-- Favicon --}}
    <link href="{{ asset('metronic/media/app/favicon.ico') }}" rel="shortcut icon" />

    {{-- Keenicons removed: fully migrated to Font Awesome Pro --}}
    <link href="{{ asset('assets/plugins/fontawesome-icons/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('metronic/css/styles.css') }}" rel="stylesheet" />

    {{-- Custom Auth CSS (light overrides only) --}}
    <link href="{{ asset('css/custom-auth.css') }}" rel="stylesheet" />
    {{-- @vite('resources/css/app.css') --}}

    {{-- Page-specific styles --}}
    @stack('styles')
    {{-- Custom RTL Fixes --}}
    @if(getLocaleDirection() === 'rtl')
        <link href="{{ asset('css/custom-rtl.css') }}" rel="stylesheet" />
    @endif
</head>

<body class="antialiased flex h-full text-base text-foreground bg-background">
    {{-- Theme mode initializer (must run before page renders) --}}
    <script>
        const defaultThemeMode = '{{ config('app.app_theme', 'light') }}';
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (document.documentElement.hasAttribute('data-kt-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>

    @yield('content')

    {{-- Metronic Core JS --}}
    <script src="{{ asset('metronic/js/core.bundle.js') }}"></script>
    {{-- KTUI loaded via Vite in app.js to avoid double initialization --}}

    {{-- App JS --}}
    @vite('resources/js/app.js')

    @stack('scripts')
</body>

</html>
