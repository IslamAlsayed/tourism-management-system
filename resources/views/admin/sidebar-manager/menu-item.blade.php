<div class="menu-item level-{{ $level }}" data-key="{{ $item['key'] ?? '' }}">
    <div class="level-indicator"></div>

    <div class="menu-item-header">
        <div class="menu-item-content">
            <!-- Drag Handle -->
            <div class="drag-handle">
                <i class="ki-filled ki-menu"></i>
            </div>

            <!-- Menu Icon -->
            <div class="menu-item-icon">
                @if(!empty($item['icon']))
                    <i class="{{ $item['icon'] }}"></i>
                @else
                    <i class="ki-filled ki-abstract-26"></i>
                @endif
            </div>

            <!-- Menu Titles -->
            <div class="flex-grow-1">
                <div class="menu-item-title">
                    {{ $item['title']['ar'] ?? $item['title']['en'] ?? 'بدون عنوان' }}
                </div>
                @if(!empty($item['title']['en']) && !empty($item['title']['ar']))
                    <div class="menu-item-subtitle">
                        {{ $item['title']['en'] }}
                    </div>
                @endif
                @if(!empty($item['route']) && $item['route'] !== 'placeholder')
                    <div class="menu-item-subtitle">
                        <i class="ki-filled ki-directbox-default me-1"></i>
                        {{ $item['route'] }}
                    </div>
                @endif
            </div>
        </div>

        <div class="menu-item-controls">
            <!-- Children Count -->
            @if(!empty($item['children']))
                <span class="badge badge-light-primary">
                    {{ count($item['children']) }} عنصر فرعي
                </span>
            @endif

            <!-- Visibility Toggle -->
            <div class="visibility-toggle active"
                 title="إظهار/إخفاء العنصر"
                 data-key="{{ $item['key'] ?? '' }}">
            </div>

            <!-- Collapse Toggle for children -->
            @if(!empty($item['children']))
                <div class="collapse-toggle" title="طي/توسيع العناصر الفرعية">
                    <i class="ki-filled ki-down fs-6"></i>
                </div>
            @endif
        </div>
    </div>

    <!-- Children -->
    @if(!empty($item['children']))
        <div class="menu-children">
            @foreach($item['children'] as $child)
                @include('admin.sidebar-manager.menu-item', ['item' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
