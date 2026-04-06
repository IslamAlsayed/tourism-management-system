<!DOCTYPE html>
<html class="h-full" dir="{{ getLocaleDirection() }}" lang="{{ app()->getLocale() }}">

<head>
    @include('layouts.partials.head')
    <script>
        window.livewire_app_url = '{{ url('/') }}';
    </script>
    @livewireStyles
    @stack('css')
    {{-- Custom RTL Fixes --}}
    @if(getLocaleDirection() === 'rtl')
        <link href="{{ asset('css/custom-rtl.css') }}?v={{ filemtime(public_path('css/custom-rtl.css')) }}" rel="stylesheet" />
    @endif
    <style>
        /* Fix FontAwesome misalignment in collapsed sidebar */
        body.kt-sidebar-collapse .kt-sidebar .kt-menu-icon i.fas,
        body.kt-sidebar-collapse .kt-sidebar .kt-menu-icon i.fab,
        body.kt-sidebar-collapse .kt-sidebar .kt-menu-icon i.fa-regular,
        body.kt-sidebar-collapse .kt-sidebar .kt-menu-icon i.fa-solid {
            font-size: 1.5rem !important;
            line-height: 1 !important;
            margin: 0 auto !important;
            text-align: center !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
        }
        body.kt-sidebar-collapse .kt-sidebar .kt-menu-link {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    </style>
</head>

<body class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        @include('layouts.sidebar')

        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col">
            @include('layouts.header')

            @php
                $activeBanner = \App\Models\PageBanner::getCurrentBanner();
            @endphp

            @if($activeBanner)
                <div class="px-5 mt-5">
                    <div class="card bg-transparent border-0 shadow-none">
                        
                        @if($activeBanner->banner_type === 'image' && $activeBanner->image_path)
                            <div class="card-body p-0 rounded overflow-hidden relative border border-gray-200" style="height: 120px;">
                                <img src="{{ asset('storage/' . $activeBanner->image_path) }}" alt="{{ $activeBanner->title ?? 'Banner' }}" class="w-full h-full object-cover">
                                @if($activeBanner->title)
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                        <h2 class="text-white text-2xl font-bold">{{ $activeBanner->title }}</h2>
                                    </div>
                                @endif
                            </div>
                        @elseif($activeBanner->banner_type === 'text_color')
                            <div class="card-body p-0 rounded overflow-hidden relative border border-gray-200 d-flex align-items-center justify-content-center w-100" 
                                 style="height: 120px; background-color: {{ $activeBanner->bg_color ?? '#f8f9fa' }};">
                                <span style="
                                    color: {{ $activeBanner->text_color ?? '#333333' }}; 
                                    font-family: '{{ $activeBanner->font_family ?? 'Tajawal' }}', sans-serif; 
                                    font-size: {{ $activeBanner->font_size ?? '24px' }};
                                    text-align: center;
                                    padding: 0 20px;
                                    max-width: 100%;
                                ">
                                    {!! nl2br(e($activeBanner->text_content)) !!}
                                </span>
                            </div>
                        @endif

                    </div>
                </div>
            @endif

            <!-- Content -->
            <main class="grow p-6 lg:p-8" id="content" role="content">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
            <!-- End of Content -->

            @include('layouts.footer')
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->
    
    <x-map-popup />

    <!-- Scripts -->
    {{-- SweetAlert2 (Global for Bulk Actions) - loaded at end to prevent render-blocking --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- SortableJS (Column Drag & Drop) - loaded at end to prevent render-blocking --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    @livewireScripts
    @include('layouts.partials.scripts')
</body>

</html>
