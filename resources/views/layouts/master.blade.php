<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="{{ config('app.app_theme', 'light') }}"
    dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    @livewireStyles
    @include('layouts.partials.head')
    @stack('styles')

    {{-- FontAwesome Icons --}}
    <link rel="stylesheet" href="{{ asset('vendor/toasts/css/all.min.css') }}">
    {{-- Toasts Styles --}}
    <link rel="stylesheet" href="{{ asset('vendor/toasts/css/toasts.css') }}">
    {{-- Toasts Scripts --}}
    <script type="module" src="{{ asset('vendor/toasts/js/toasts.js') }}"></script>
</head>

<body class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
    @if (view()->exists('vendor/toasts/toasts'))
        @include('vendor.toasts.toasts')
    @endif

    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        @include('layouts.sidebar')

        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col">
            @include('layouts.header')

            <!-- Content -->
            <main class="grow" id="content" role="content">
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

    <script>
        // Listen for toast events from Livewire components
        // document.addEventListener('livewire:init', () => {
        //     Livewire.on('show-toast', (event) => {
        //         const data = event[0] || event;
        //         const type = data.type || 'info';
        //         const message = data.message || 'Action completed';

        //         // Use existing showToast system
        //         if (typeof window.showToast === 'function') {
        //             window.showToast({
        //                 type: type,
        //                 title: type === 'success' ? '{{ __('main.success') }}' : '{{ __('main.error') }}',
        //                 message: message
        //             });
        //         } else {
        //             alert(message);
        //         }
        //     });

        //     // Listen for toggle loading events
        //     Livewire.on('toggle-loading-start', () => {
        //         const tableContent = document.querySelector('.kt-card-content');
        //         if (tableContent) {
        //             tableContent.classList.add('loading');
        //         }
        //     });

        //     Livewire.on('toggle-loading-end', () => {
        //         const tableContent = document.querySelector('.kt-card-content');
        //         if (tableContent) {
        //             tableContent.classList.remove('loading');
        //         }
        //     });
        // });
    </script>

    @include('layouts.partials.scripts')
</body>

</html>
