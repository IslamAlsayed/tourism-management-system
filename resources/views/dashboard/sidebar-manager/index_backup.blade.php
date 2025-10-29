@extends('layouts.master')

@section('title', 'إدارة القائمة الجانبية')

@push('styles')
    <style>
        /* Enhanced Menu Item Styling */
        .menu-item {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fb 100%);
            border: 1px solid #e1e5e9;
            border-radius: 12px;
            margin-bottom: 16px;
            padding: 20px;
            cursor: move;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            backdrop-filter: blur(10px);
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            box-shadow: 0 8px 30px rgba(54, 153, 255, 0.15);
            border-color: #3699ff;
            border-left-color: #3699ff;
            transform: translateY(-3px) scale(1.01);
            background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
        }

        .menu-item.sortable-chosen {
            background: linear-gradient(135deg, #e7f3ff 0%, #cce7ff 100%);
            border-color: #3699ff;
            border-left-color: #1e40af;
            transform: scale(1.02) rotate(1deg);
            box-shadow: 0 15px 40px rgba(54, 153, 255, 0.2);
            z-index: 1000;
        }

        .menu-item.sortable-ghost {
            opacity: 0.4;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed #3699ff;
            transform: scale(0.98);
        }

        .drag-handle {
            cursor: grab;
            color: #a1a5b7;
            font-size: 22px;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-left: 12px;
            background: linear-gradient(135deg, #f1f3f6 0%, #e9ecef 100%);
            border: 1px solid #e1e5e9;
        }

        .drag-handle:hover {
            color: #3699ff;
            background: linear-gradient(135deg, #e7f3ff 0%, #cce7ff 100%);
            border-color: #3699ff;
            transform: scale(1.1);
        }

        .drag-handle:active {
            cursor: grabbing;
            transform: scale(0.95);
        }

        /* Enhanced Switch Styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #e4e6ef 0%, #d1d3e0 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 15px;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 3px;
            bottom: 3px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        input:checked+.slider {
            background: linear-gradient(135deg, #50cd89 0%, #3f9f6b 100%);
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.1), 0 0 15px rgba(80, 205, 137, 0.3);
        }

        input:checked+.slider:before {
            transform: translateX(30px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2), 0 1px 3px rgba(0, 0, 0, 0.15);
        }

        /* Enhanced Card Styling */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            box-shadow: 0 8px 35px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fb 0%, #e9ecef 100%);
            border-bottom: 1px solid #e1e5e9;
            border-radius: 16px 16px 0 0 !important;
            padding: 20px 24px;
        }

        .card-body {
            padding: 24px;
        }

        /* Enhanced Alert Styling */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #e7f3ff 0%, #cce7ff 100%);
            border-left: 4px solid #3699ff;
            backdrop-filter: blur(10px);
        }

        /* Enhanced Button Styling */
        .btn {
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3699ff 0%, #1e40af 100%);
            box-shadow: 0 4px 15px rgba(54, 153, 255, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            box-shadow: 0 6px 20px rgba(54, 153, 255, 0.4);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #50cd89 0%, #059669 100%);
            box-shadow: 0 4px 15px rgba(80, 205, 137, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 6px 20px rgba(80, 205, 137, 0.4);
            transform: translateY(-2px);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc700 0%, #f59e0b 100%);
            box-shadow: 0 4px 15px rgba(255, 199, 0, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f1416c 0%, #dc2626 100%);
            box-shadow: 0 4px 15px rgba(241, 65, 108, 0.3);
        }

        /* Enhanced Statistics Cards */
        .stats-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fb 100%);
            border: 1px solid #e1e5e9;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #3699ff 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Menu Item Content Enhancement */
        .menu-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f1f3f6 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .menu-item:hover .menu-icon {
            background: linear-gradient(135deg, #e7f3ff 0%, #cce7ff 100%);
            transform: scale(1.1);
        }

        .menu-content {
            flex: 1;
            margin: 0 16px;
        }

        .menu-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #181c32;
            margin-bottom: 4px;
        }

        .menu-subtitle {
            font-size: 0.9rem;
            color: #7e8299;
        }

        .menu-url {
            font-size: 0.85rem;
            color: #50cd89;
            background: rgba(80, 205, 137, 0.1);
            padding: 2px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 4px;
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }

            100% {
                background-position: calc(200px + 100%) 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite linear;
        }
    </style>

    <!-- SortableJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fs-2 fw-bold text-gray-900 mb-2">
                            <i class="ki-filled ki-setting-2 text-primary me-3"></i>
                            إدارة القائمة الجانبية
                        </h1>
                        <p class="text-muted fs-6 mb-0">قم بإدارة وتخصيص عناصر القائمة الجانبية للنظام</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-warning" onclick="resetToDefault()">
                            <i class="ki-filled ki-arrow-circle-left me-2"></i>
                            إعادة تعيين
                        </button>
                        <button class="btn btn-success" onclick="exportConfig()">
                            <i class="ki-filled ki-file-down me-2"></i>
                            تصدير الإعدادات
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Row -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-number" id="totalItems">{{ count($menuItems) }}</div>
                    <div class="text-muted fw-semibold">إجمالي العناصر</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-number text-success" id="visibleItems">
                        {{ count(array_filter($menuItems, function ($item) {return $item['is_visible'] ?? true;})) }}</div>
                    <div class="text-muted fw-semibold">العناصر المرئية</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-number text-warning" id="hiddenItems">
                        {{ count($menuItems) -count(array_filter($menuItems, function ($item) {return $item['is_visible'] ?? true;})) }}
                    </div>
                    <div class="text-muted fw-semibold">العناصر المخفية</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-number text-info" id="childItems">
                        {{ collect($menuItems)->sum(function ($item) {return count($item['children'] ?? []);}) }}</div>
                    <div class="text-muted fw-semibold">العناصر الفرعية</div>
                </div>
            </div>
        </div>

        .log-panel {
        height: 400px;
        overflow-y: auto;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        font-size: 12px;
        }

        .log-entry {
        margin-bottom: 5px;
        padding: 5px;
        border-radius: 4px;
        }

        .log-success { background-color: #d4edda; color: #155724; }
        .log-info { background-color: #d1ecf1; color: #0c5460; }
        .log-warning { background-color: #fff3cd; color: #856404; }
        .log-error { background-color: #f8d7da; color: #721c24; }
        </style>
    @endpush

    @section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">route('
                    <!-- Header -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="mb-0">
                                <i class="ki-filled ki-design-frame text-primary me-2"></i>
                                إدارة القائمة الجانبية
                            </h2>
                            <div class="d-flex gap-2">
                                <a href="{{ route('sidebar.test') }}" class="btn btn-light-info">
                                    <i class="ki-filled ki-code me-1"></i>
                                    اختبار السحب والإفلات
                                </a>
                                <button type="button" class="btn btn-warning" id="resetToDefault">
                                    <i class="ki-filled ki-arrows-circle me-1"></i>
                                    إعادة تعيين افتراضية
                                </button>
                                <button type="button" class="btn btn-info" id="exportConfig">
                                    <i class="ki-filled ki-file-down me-1"></i>
                                    تصدير التكوين
                                </button>
                                <button type="button" class="btn btn-success" id="saveOrder">
                                    <i class="ki-filled ki-check me-1"></i>
                                    حفظ الترتيب
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="ki-filled ki-information-2 me-2"></i>
                                <strong>تعليمات الاستخدام:</strong> اسحب العناصر من المقبض <span
                                    style="font-size: 18px;">⋮⋮⋮</span> لإعادة ترتيبها، واستخدم المفاتيح لإظهار/إخفاء
                                العناصر.
                            </div>
                        </div>
                    </div>

                    <!-- Menu Manager -->
                    <div class="row">
                        <!-- Current Menu Structure -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="ki-filled ki-menu me-2"></i>
                                        هيكل القائمة الحالي ({{ count($menuItems) }} عنصر)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="menuContainer" class="border rounded p-3" style="background: #fafafa;">
                                        <div id="sortableMenu" class="menu-list">
                                            @forelse($menuItems as $index => $item)
                                                <div class="menu-item" data-key="{{ $item['key'] ?? 'item_' . $index }}"
                                                    data-order="{{ $index }}">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="drag-handle" title="اسحب لإعادة الترتيب">
                                                                ⋮⋮⋮
                                                            </div>
                                                            <div class="menu-icon">
                                                                @if (!empty($item['icon']))
                                                                    <i class="{{ $item['icon'] }} fs-4 text-primary"></i>
                                                                @else
                                                                    <i
                                                                        class="ki-filled ki-abstract-26 fs-4 text-gray-400"></i>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <div class="fw-semibold fs-6">
                                                                    {{ $item['title']['ar'] ?? ($item['title']['en'] ?? 'بدون عنوان') }}
                                                                </div>
                                                                @if (!empty($item['title']['en']) && !empty($item['title']['ar']))
                                                                    <div class="text-muted fs-7">
                                                                        {{ $item['title']['en'] }}
                                                                    </div>
                                                                @endif
                                                                @if (!empty($item['url']))
                                                                    <div class="text-muted fs-8">
                                                                        <i class="ki-filled ki-arrow-left fs-8 me-1"></i>
                                                                        {{ $item['url'] }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <span class="badge badge-light-secondary fs-8">
                                                                #{{ $index + 1 }}
                                                            </span>
                                                            @if (!empty($item['children']))
                                                                <span class="badge badge-light-info">
                                                                    {{ count($item['children']) }} فرعي
                                                                </span>
                                                            @endif
                                                            <label class="switch" title="إظهار/إخفاء العنصر">
                                                                <input type="checkbox"
                                                                    {{ $item['is_visible'] ?? true ? 'checked' : '' }}
                                                                    onchange="toggleVisibility(this, '{{ $item['key'] ?? 'item_' . $index }}')">
                                                                <span class="slider"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-8 text-muted">
                                                    <i
                                                        class="ki-filled ki-file-deleted fs-3x mb-3 d-block text-gray-300"></i>
                                                    <h4>لا توجد عناصر قائمة</h4>
                                                    <p>سيتم تحميل العناصر الافتراضية تلقائياً</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Controls Panel -->
                        <div class="col-lg-4">
                            <!-- Statistics -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="ki-filled ki-chart-simple me-2"></i>
                                        إحصائيات القائمة
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>إجمالي العناصر:</span>
                                        <strong class="text-primary" id="totalItems">{{ count($menuItems) }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>العناصر المرئية:</span>
                                        <strong class="text-success" id="visibleItems">{{ count($menuItems) }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>العناصر المخفية:</span>
                                        <strong class="text-danger" id="hiddenItems">0</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="ki-filled ki-setting-3 me-2"></i>
                                        إجراءات سريعة
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-light-primary" id="showAll">
                                            <i class="ki-filled ki-eye me-1"></i>
                                            إظهار الكل
                                        </button>
                                        <button type="button" class="btn btn-light-danger" id="hideAll">
                                            <i class="ki-filled ki-eye-slash me-1"></i>
                                            إخفاء الكل
                                        </button>
                                        <button type="button" class="btn btn-light-info" id="clearLog">
                                            <i class="ki-filled ki-trash me-1"></i>
                                            مسح السجل
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Log -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="ki-filled ki-notification-status me-2"></i>
                                        سجل النشاط
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div id="activityLog" class="log-panel">
                                        <div class="log-entry log-info">
                                            <small class="text-muted">${new Date().toLocaleTimeString('ar-SA')}</small> -
                                            تم تحميل مدير القائمة الجانبية
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <!-- SortableJS Library -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let menuData = [];
                let hasChanges = false;

                // تسجيل الأنشطة
                function addLog(message, type = 'info') {
                    const log = document.getElementById('activityLog');
                    const time = new Date().toLocaleTimeString('ar-SA');
                    const logClass = `log-${type}`;

                    const logEntry = document.createElement('div');
                    logEntry.className = `log-entry ${logClass}`;
                    logEntry.innerHTML = `<small class="text-muted">${time}</small> - ${message}`;

                    log.insertBefore(logEntry, log.firstChild);

                    // حد أقصى 50 سجل
                    while (log.children.length > 50) {
                        log.removeChild(log.lastChild);
                    }
                }

                // Initialize sortable
                initializeSortable();

                // Event listeners
                document.getElementById('saveOrder').addEventListener('click', saveMenuOrder);
                document.getElementById('resetToDefault').addEventListener('click', resetToDefault);
                document.getElementById('exportConfig').addEventListener('click', exportConfig);
                document.getElementById('showAll').addEventListener('click', () => setAllVisibility(true));
                document.getElementById('hideAll').addEventListener('click', () => setAllVisibility(false));
                document.getElementById('clearLog').addEventListener('click', clearLog);

                function initializeSortable() {
                    const menuContainer = document.getElementById('sortableMenu');
                    if (!menuContainer) {
                        addLog('خطأ: لم يتم العثور على حاوية القائمة', 'error');
                        return;
                    }

                    addLog('جاري تهيئة نظام السحب والإفلات...', 'info');

                    const sortable = new Sortable(menuContainer, {
                        group: 'menu',
                        animation: 150,
                        handle: '.drag-handle',
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        dragClass: 'sortable-drag',
                        forceFallback: false,
                        onStart: function(evt) {
                            const itemText = evt.item.querySelector('.fw-semibold').textContent.trim();
                            addLog(`🚀 بدء سحب العنصر: ${itemText}`, 'info');
                        },
                        onEnd: function(evt) {
                            const itemText = evt.item.querySelector('.fw-semibold').textContent.trim();

                            if (evt.oldIndex !== evt.newIndex) {
                                addLog(`✅ تم نقل "${itemText}" من الموضع ${evt.oldIndex + 1} إلى ${evt.newIndex + 1}`,
                                    'success');
                                hasChanges = true;
                                updateMenuData();
                                updateSaveButton();
                            } else {
                                addLog(`ℹ️ لم يتم تغيير موضع "${itemText}"`, 'info');
                            }
                        },
                        onMove: function(evt) {
                            return true;
                        }
                    });

                    if (sortable) {
                        addLog('✅ تم تهيئة نظام السحب والإفلات بنجاح', 'success');
                        addLog('📋 يمكنك الآن سحب العناصر لإعادة ترتيبها', 'info');
                    } else {
                        addLog('❌ فشل في تهيئة نظام السحب والإفلات', 'error');
                    }
                }

                function updateMenuData() {
                    const menuItems = document.querySelectorAll('#sortableMenu .menu-item');
                    menuData = [];

                    menuItems.forEach((item, index) => {
                        const key = item.dataset.key;
                        const isVisible = item.querySelector('input[type="checkbox"]').checked;

                        menuData.push({
                            key: key,
                            order: index,
                            is_visible: isVisible
                        });

                        // تحديث رقم الترتيب في البادج
                        const badge = item.querySelector('.badge-light-secondary');
                        if (badge) {
                            badge.textContent = `#${index + 1}`;
                        }
                    });

                    updateStatistics();
                }

                function saveMenuOrder() {
                    if (!hasChanges) {
                        addLog('لم يتم إجراء أي تغييرات', 'warning');
                        showAlert('لم يتم إجراء أي تغييرات', 'info');
                        return;
                    }

                    const saveBtn = document.getElementById('saveOrder');
                    const originalText = saveBtn.innerHTML;
                    saveBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-1"></i>جاري الحفظ...';
                    saveBtn.disabled = true;

                    addLog('💾 جاري حفظ ترتيب القائمة...', 'info');

                    fetch('{{ route('sidebar.update-order') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                menu_data: menuData
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                addLog('✅ تم حفظ ترتيب القائمة بنجاح', 'success');
                                showAlert(data.message, 'success');
                                hasChanges = false;
                                updateSaveButton();
                            } else {
                                addLog('❌ فشل في حفظ ترتيب القائمة', 'error');
                                showAlert(data.message || 'حدث خطأ في الحفظ', 'error');
                            }
                        })
                        .catch(error => {
                            addLog('❌ خطأ في الاتصال بالخادم', 'error');
                            showAlert('حدث خطأ في الاتصال', 'error');
                            console.error('خطأ في الحفظ:', error);
                        })
                        .finally(() => {
                            saveBtn.innerHTML = originalText;
                            saveBtn.disabled = false;
                        });
                }

                function resetToDefault() {
                    if (!confirm('هل أنت متأكد من إعادة تعيين القائمة للترتيب الافتراضي؟ سيتم فقدان جميع التخصيصات.')) {
                        return;
                    }

                    addLog('🔄 جاري إعادة تعيين القائمة للوضع الافتراضي...', 'info');

                    fetch('{{ route('sidebar.reset') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                addLog('✅ تم إعادة تعيين القائمة بنجاح', 'success');
                                showAlert(data.message, 'success');
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                addLog('❌ فشل في إعادة تعيين القائمة', 'error');
                                showAlert(data.message || 'حدث خطأ', 'error');
                            }
                        })
                        .catch(error => {
                            addLog('❌ خطأ في إعادة التعيين', 'error');
                            showAlert('حدث خطأ في الاتصال', 'error');
                            console.error('خطأ في إعادة التعيين:', error);
                        });
                }

                function exportConfig() {
                    addLog('📤 جاري تصدير تكوين القائمة...', 'info');

                    fetch('{{ route('sidebar.export') }}')
                        .then(response => response.blob())
                        .then(blob => {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download =
                                `sidebar-config-${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.json`;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                            document.body.removeChild(a);

                            addLog('✅ تم تصدير التكوين بنجاح', 'success');
                            showAlert('تم تصدير التكوين بنجاح', 'success');
                        })
                        .catch(error => {
                            addLog('❌ فشل في تصدير التكوين', 'error');
                            showAlert('حدث خطأ في التصدير', 'error');
                            console.error('خطأ في التصدير:', error);
                        });
                }

                function setAllVisibility(visible) {
                    const checkboxes = document.querySelectorAll('#sortableMenu input[type="checkbox"]');
                    let count = 0;

                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked !== visible) {
                            checkbox.checked = visible;
                            count++;
                        }
                    });

                    if (count > 0) {
                        hasChanges = true;
                        updateMenuData();
                        updateSaveButton();

                        const action = visible ? 'إظهار' : 'إخفاء';
                        addLog(`${action} ${count} عنصر`, 'info');
                        showAlert(`تم ${action} ${count} عنصر. اضغط "حفظ الترتيب" لحفظ التغييرات.`, 'info');
                    } else {
                        addLog('جميع العناصر لها نفس حالة العرض بالفعل', 'info');
                    }
                }

                function clearLog() {
                    const log = document.getElementById('activityLog');
                    log.innerHTML = '<div class="log-entry log-info"><small class="text-muted">' +
                        new Date().toLocaleTimeString('ar-SA') +
                        '</small> - تم مسح السجل</div>';
                }

                function updateSaveButton() {
                    const saveBtn = document.getElementById('saveOrder');
                    if (hasChanges) {
                        saveBtn.classList.remove('btn-success');
                        saveBtn.classList.add('btn-warning');
                        saveBtn.innerHTML = '<i class="ki-filled ki-notification-status me-1"></i>حفظ التغييرات';
                    } else {
                        saveBtn.classList.remove('btn-warning');
                        saveBtn.classList.add('btn-success');
                        saveBtn.innerHTML = '<i class="ki-filled ki-check me-1"></i>محفوظ';
                    }
                }

                function updateStatistics() {
                    const total = document.querySelectorAll('#sortableMenu .menu-item').length;
                    const visible = document.querySelectorAll('#sortableMenu input[type="checkbox"]:checked').length;
                    const hidden = total - visible;

                    document.getElementById('totalItems').textContent = total;
                    document.getElementById('visibleItems').textContent = visible;
                    document.getElementById('hiddenItems').textContent = hidden;
                }

                function showAlert(message, type) {
                    const alertClass = type === 'success' ? 'alert-success' :
                        type === 'error' ? 'alert-danger' : 'alert-info';

                    const alert = document.createElement('div');
                    alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                    alert.style.cssText = 'top: 20px; left: 20px; z-index: 9999; min-width: 350px; max-width: 500px;';
                    alert.innerHTML = `
            <i class="ki-filled ki-information-2 me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

                    document.body.appendChild(alert);

                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 5000);
                }

                // Global functions
                window.toggleVisibility = function(checkbox, key) {
                    const itemText = checkbox.closest('.menu-item').querySelector('.fw-semibold').textContent
                        .trim();
                    const action = checkbox.checked ? 'إظهار' : 'إخفاء';

                    hasChanges = true;
                    updateMenuData();
                    updateSaveButton();

                    addLog(`${action} العنصر: ${itemText}`, 'info');
                    showAlert(`تم ${action} العنصر. اضغط "حفظ الترتيب" لحفظ التغييرات.`, 'info');
                };

                // Initial data update
                updateMenuData();
                addLog(`تم تحميل ${menuData.length} عنصر في القائمة`, 'success');
            });
        </script>
    @endpush
