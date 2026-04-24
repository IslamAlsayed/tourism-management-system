<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="{{ getLocaleDirection() }}" lang="{{ app()->getLocale() }}">

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
                // Only show banner if image file actually exists or text content is non-empty
                $showBanner = false;
                if ($activeBanner) {
                    if ($activeBanner->banner_type === 'image' && $activeBanner->image_path) {
                        $showBanner = file_exists(storage_path('app/public/' . $activeBanner->image_path));
                    } elseif ($activeBanner->banner_type === 'text_color' && !empty(trim($activeBanner->text_content ?? ''))) {
                        $showBanner = true;
                    }
                }
            @endphp

            @if($showBanner)
                <div class="px-5 mt-5">
                    <div class="card bg-transparent border-0 shadow-none">
                        
                        @if($activeBanner->banner_type === 'image' && $activeBanner->image_path)
                            <div class="kt-card-body p-0 rounded overflow-hidden relative border border-gray-200" style="height: 120px;">
                                <img src="{{ asset('storage/' . $activeBanner->image_path) }}" alt="{{ $activeBanner->title ?? 'Banner' }}" class="w-full h-full object-cover">
                                @if($activeBanner->title)
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                        <h2 class="text-white text-2xl font-bold">{{ $activeBanner->title }}</h2>
                                    </div>
                                @endif
                            </div>
                        @elseif($activeBanner->banner_type === 'text_color')
                            <div class="kt-card-body p-0 rounded overflow-hidden relative border border-gray-200 d-flex align-items-center justify-content-center w-100" 
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
            <main class="grow pt-5" id="content" role="content">
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
    {{-- Alpine.js Global Stores — must be outside Livewire DOM to survive morphing --}}
    <script>
        document.addEventListener('alpine:init', () => {
            if (!Alpine.store('colPicker')) {
                Alpine.store('colPicker', {
                    open: false,
                    count: 0,
                    toggle() { this.open = !this.open; },
                    close() { this.open = false; }
                });
            }
            if (!Alpine.store('filtersVisibility')) {
                Alpine.store('filtersVisibility', {
                    filters: JSON.parse(localStorage.getItem('systemFiltersVisibility')) || {},
                    toggle(key) {
                        let currentVal = typeof this.filters[key] === 'undefined' ? true : this.filters[key];
                        this.filters = { ...this.filters, [key]: !currentVal };
                        localStorage.setItem('systemFiltersVisibility', JSON.stringify(this.filters));
                    }
                });
            }
        });
    </script>
    {{-- KT scripts MUST load BEFORE Livewire/Alpine to register DOMContentLoaded handlers first --}}
    @include('layouts.partials.scripts')
    @livewireScripts
    <script>
        // Re-initialize KT components after Livewire navigates or updates DOM
        document.addEventListener('livewire:navigated', function() {
            if (typeof KTComponents !== 'undefined') KTComponents.init();
            if (typeof KTDrawer !== 'undefined') KTDrawer.init();
            if (typeof KTToggle !== 'undefined') KTToggle.init();
            if (typeof KTScrollable !== 'undefined') KTScrollable.init();
            if (typeof KTReparent !== 'undefined') KTReparent.init();
            if (typeof KTSticky !== 'undefined') KTSticky.init();
            if (typeof KTMenu !== 'undefined') KTMenu.init();
            if (typeof KTModal !== 'undefined') KTModal.init();
            if (typeof KTTooltip !== 'undefined') KTTooltip.init();
        });
        document.addEventListener('livewire:init', function() {
            Livewire.hook('morph.updated', ({el}) => {
                if (typeof KTMenu !== 'undefined') KTMenu.init();
                if (typeof KTToggle !== 'undefined') KTToggle.init();
            });
        });

        // ---------------------------------------------------------------------
        // Critical KTMenu Accordion Fallback
        // Resolves clicks being ignored due to UMD script re-initialization 
        // ---------------------------------------------------------------------
        document.addEventListener('click', function(e) {
            var link = e.target.closest('.kt-menu-link');
            if (link) {
                var accordion = link.closest('[data-kt-menu-item-toggle="accordion"]');
                if (accordion) {
                    // Check if this link is a direct child of the accordion item
                    if (accordion.querySelector('.kt-menu-link') === link) {
                        e.preventDefault();
                        e.stopPropagation(); // Prevent broken KTMenu from interfering
                        
                        var isOpen = accordion.classList.contains('show');
                        
                        // Close other sibling accordions
                        var parent = accordion.parentElement;
                        if (parent) {
                            var siblingAccordions = parent.querySelectorAll(':scope > [data-kt-menu-item-toggle="accordion"].show');
                            siblingAccordions.forEach(function(sibling) {
                                if (sibling !== accordion) {
                                    sibling.classList.remove('show');
                                    sibling.classList.remove('kt-menu-item-show');
                                }
                            });
                        }
                        
                        // Toggle current
                        if (isOpen) {
                            accordion.classList.remove('show');
                            accordion.classList.remove('kt-menu-item-show');
                        } else {
                            accordion.classList.add('show');
                            accordion.classList.add('kt-menu-item-show');
                        }
                    }
                }
            }
        }, true); // Use capture phase
    </script>
</body>

</html>
