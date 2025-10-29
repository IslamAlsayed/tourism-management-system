<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    lang="{{ app()->getLocale() }}">

<head>
    @livewireStyles
    @include('layouts.partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


{{-- <body class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased kt-sidebar-collapse"> --}}

<body class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
    @include('partials.theme-toggle')

    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        @include('layouts.sidebar')

        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col">
            @include('layouts.header')

            <!-- Content -->
            <main class="grow" id="content" role="content">
                @include('components.elements.display-alert')

                @yield('content')
            </main>
            <!-- End of Content -->

            @include('layouts.footer')
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->

    <!-- Scripts -->
    @livewireScripts
    @include('layouts.partials.scripts')
</body>

</html>
