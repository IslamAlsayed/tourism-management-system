@foreach ($children as $child)
    @if ($checkPermission($child['permission'] ?? null))
        @if (isset($child['children']))
            {{-- Nested submenu --}}
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ $hasActiveChild($child['children']) ? 'show here' : '' }}">
                <span class="menu-link">
                    @if (isset($child['icon']))
                        <span class="menu-icon">
                            <i class="{{ $child['icon'] }} fs-3"></i>
                        </span>
                    @endif
                    <span class="menu-title">{{ $child['title'] }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    @include('components.sidebar-submenu', [
                        'children' => $child['children'],
                        'level' => ($level ?? 1) + 1,
                    ])
                </div>
            </div>
        @else
            {{-- Simple submenu item --}}
            <div class="menu-item">
                <a class="menu-link {{ $isActiveRoute($child['route'] ?? '') ? 'active' : '' }}"
                    href="{{ isset($child['route']) ? route($child['route'], $child['parameters'] ?? ($child['params'] ?? [])) : '#' }}">
                    @if (isset($child['icon']))
                        <span class="menu-icon">
                            <i class="{{ $child['icon'] }} fs-3"></i>
                        </span>
                    @endif
                    <span class="menu-title">{{ $child['title'] }}</span>
                    @if (isset($child['badge']))
                        <span class="menu-badge">
                            <span
                                class="badge badge-{{ $child['badge']['type'] ?? 'secondary' }} badge-circle">{{ $child['badge']['text'] }}</span>
                        </span>
                    @endif
                </a>
            </div>
        @endif
    @endif
@endforeach
