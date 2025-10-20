<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    lang="{{ app()->getLocale() }}">

<head>
    @livewireStyles
    @include('layouts.partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- <body class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased"> --}}

<body
    class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased kt-sidebar-collapse">
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
                <div class="kt-container-fixed">
                    <div class="custom-alerts" id="custom-alerts">
                        @if (Cache::has('import_message'))
                            <div class="kt-alert kt-alert-success mb-5" role="alert">
                                {{ Cache::get('import_message') }}
                            </div>
                            @php Cache::forget('import_message'); @endphp
                        @endif

                        @if (session('success'))
                            <div class="kt-alert kt-alert-success mb-5" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="kt-alert kt-alert-danger mb-5" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    @if ($errors->any())
                        <div class="kt-alert kt-alert-danger mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

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
