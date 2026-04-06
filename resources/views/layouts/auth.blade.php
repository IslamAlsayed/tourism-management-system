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

    {{-- Metronic Core CSS --}}
    <link href="{{ asset('metronic/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('metronic/css/styles.css') }}" rel="stylesheet" />

    {{-- Custom Auth CSS (Direct Link to bypass stale build) --}}
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

    {{-- Theme Toggle (floating) --}}
    <style>
        #kt_auth_theme_toggle {
            position: fixed;
            top: 18px;
            right: 20px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 8px;
            color: inherit;
        }
    </style>
    <div id="kt_auth_theme_toggle">
        <i class="text-base fa-duotone fa-solid fa-moon" id="icon-theme-mode"></i>
        <input class="kt-switch" id="switch-theme-mode" type="checkbox" value="1" />
    </div>

    @yield('content')

    {{-- Metronic Core JS --}}
    <script src="{{ asset('metronic/js/core.bundle.js') }}"></script>
    <script src="{{ asset('metronic/vendors/ktui/ktui.min.js') }}"></script>

    {{-- App JS --}}
    @vite('resources/js/app.js')

    {{-- Theme toggle JS --}}
    <script>
        (() => {
            const switchEl = document.getElementById('switch-theme-mode');
            const iconEl = document.getElementById('icon-theme-mode');

            const getTheme = () => localStorage.getItem('kt-theme') || '{{ config('app.app_theme', 'light') }}';

            const applyTheme = (mode) => {
                const resolved = mode === 'system' ?
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') :
                    mode;

                document.documentElement.classList.remove('dark', 'light');
                document.documentElement.classList.add(resolved);
                document.documentElement.setAttribute('data-kt-theme-mode', resolved);

                if (switchEl) switchEl.checked = resolved === 'dark';
                if (iconEl) iconEl.className = resolved === 'dark' ?
                    'text-base fa-duotone fa-solid fa-moon' :
                    'text-base fa-duotone fa-solid fa-sun';

                localStorage.setItem('kt-theme', mode);
            };

            // Init
            applyTheme(getTheme());

            // Toggle
            if (switchEl) {
                switchEl.addEventListener('change', () => {
                    applyTheme(switchEl.checked ? 'dark' : 'light');
                });
            }
        })();
    </script>

    @stack('scripts')
</body>

</html>
