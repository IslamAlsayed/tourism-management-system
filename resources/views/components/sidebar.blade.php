<div class="aside-menu flex-column-fluid">
    <!--begin::Aside Menu-->
    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
        data-kt-scroll-offset="0">
        <!--begin::Menu-->
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
            id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

            @foreach ($menuItems as $item)
                @if ($checkPermission($item['permission'] ?? null))
                    @if (isset($item['children']))
                        {{-- Menu with Children --}}
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $hasActiveChild($item['children']) ? 'show here' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="{{ $item['icon'] }} fs-2"></i>
                                </span>
                                <span class="menu-title">{{ $item['title'] }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                @include('components.sidebar-submenu', ['children' => $item['children'], 'level' => 1])
                            </div>
                        </div>
                    @else
                        {{-- Simple Menu Item --}}
                        <div class="menu-item">
                            <a class="menu-link {{ $isActiveRoute($item['route'] ?? '') ? 'active' : '' }}"
                                href="{{ isset($item['route']) ? route($item['route']) : '#' }}">
                                <span class="menu-icon">
                                    <i class="{{ $item['icon'] }} fs-2"></i>
                                </span>
                                <span class="menu-title">{{ $item['title'] }}</span>
                            </a>
                        </div>
                    @endif
                @endif
            @endforeach

            {{-- Separator --}}
            <div class="menu-item">
                <div class="menu-content pt-8 pb-2">
                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">الأدوات المساعدة</span>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="menu-item">
                <a class="menu-link" href="{{ route('dashboard.core.users.create') }}">
                    <span class="menu-icon">
                        <i class="fa-duotone fa-solid fa-user-plus fs-2"></i>
                    </span>
                    <span class="menu-title">إضافة مستخدم سريع</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link" href="{{ route('dashboard.core.profile.edit') }}">
                    <span class="menu-icon">
                        <i class="fa-duotone fa-solid fa-id-card fs-2"></i>
                    </span>
                    <span class="menu-title">تحديث البروفايل</span>
                </a>
            </div>

            {{-- Logout --}}
            <div class="menu-item">
                <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                    @csrf
                </form>
                <a class="menu-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="menu-icon">
                        <i class="fa-duotone fa-solid fa-right-from-bracket fs-2"></i>
                    </span>
                    <span class="menu-title">تسجيل الخروج</span>
                </a>
            </div>

        </div>
        <!--end::Menu-->
    </div>
    <!--end::Aside Menu-->
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize menu
            KTMenu.init();

            // Auto expand active menu items
            const activeItems = document.querySelectorAll('.menu-item.here');
            activeItems.forEach(item => {
                const accordion = item.querySelector('[data-kt-menu-trigger="click"]');
                if (accordion) {
                    KTMenu.expand(accordion);
                }
            });
        });
    </script>
@endpush
