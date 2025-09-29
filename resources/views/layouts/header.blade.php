<!-- Header -->
<header class="kt-header fixed end-0 start-0 top-0 z-10 flex shrink-0 items-stretch bg-background" data-kt-sticky="true"
    data-kt-sticky-class="border-b border-border" data-kt-sticky-name="header" id="header">
    <!-- Container -->
    <div class="kt-container-fixed flex items-stretch justify-between lg:gap-4" id="headerContainer">
        <!-- Mobile Logo -->
        <div class="-ms-1 flex items-center gap-2.5 lg:hidden">
            <a class="shrink-0" href="#">
                <img class="max-h-[25px] w-full" src="{{ asset('metronic/media/app/mini-logo.svg') }}" />
            </a>
            <div class="flex items-center">
                <button class="kt-btn kt-btn-icon kt-btn-ghost" data-kt-drawer-toggle="#sidebar">
                    <i class="ki-filled ki-menu">
                    </i>
                </button>
                <button class="kt-btn kt-btn-icon kt-btn-ghost" data-kt-drawer-toggle="#mega_menu_wrapper">
                    <i class="ki-filled ki-burger-menu-2">
                    </i>
                </button>
            </div>
        </div>
        <!-- End of Mobile Logo -->
        {{-- @include('partials.mega-menu') --}}
        <div></div>
        <!-- Topbar -->
        <div class="flex items-center gap-2.5">
            @if (env('DB_Mode') == 'production')
                <span class="inline-block bg-danger text-white text-red-600 font-medium px-3 py-0.5 rounded-[9px] ms-2">
                    production
                </span>
            @elseif (env('DB_Mode') == 'testing')
                <span
                    class="inline-block bg-yellow-500 text-white text-red-600 font-medium px-3 py-0.5 rounded-[9px] ms-2">
                    testing
                </span>
            @else
                <span
                    class="inline-block bg-yellow-500 text-white text-primary font-medium px-3 py-0.5 rounded-[9px] ms-2">
                    local
                </span>
            @endif

            @include('partials.topbar-search-modal')
            @include('partials.topbar-notification-dropdown')
            @include('partials.topbar-chat')
            @include('partials.topbar-apps')

            @include('partials.topbar-user-dropdown')
        </div>
        <!-- End of Topbar -->
    </div>
    <!-- End of Container -->
</header>
<!-- End of Header -->

@include('partials.modals.search')
