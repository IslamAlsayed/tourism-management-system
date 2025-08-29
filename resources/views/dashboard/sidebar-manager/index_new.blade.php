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
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
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
  box-shadow: inset 0 2px 6px rgba(0,0,0,0.1);
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
  box-shadow: 0 3px 8px rgba(0,0,0,0.15), 0 1px 3px rgba(0,0,0,0.1);
}

input:checked + .slider {
  background: linear-gradient(135deg, #50cd89 0%, #3f9f6b 100%);
  box-shadow: inset 0 2px 6px rgba(0,0,0,0.1), 0 0 15px rgba(80, 205, 137, 0.3);
}

input:checked + .slider:before {
  transform: translateX(30px);
  box-shadow: 0 3px 8px rgba(0,0,0,0.2), 0 1px 3px rgba(0,0,0,0.15);
}

/* Enhanced Card Styling */
.card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    backdrop-filter: blur(10px);
}

.card:hover {
    box-shadow: 0 8px 35px rgba(0,0,0,0.12);
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
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
}

.shimmer {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite linear;
}

/* Activity Log Styling */
.activity-log {
    max-height: 400px;
    overflow-y: auto;
    background: linear-gradient(135deg, #f8f9fb 0%, #f1f3f6 100%);
    border-radius: 8px;
    padding: 12px;
}

.log-entry {
    background: white;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 6px;
    border-left: 3px solid #e1e5e9;
    font-size: 0.9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.log-success { border-left-color: #50cd89; }
.log-info { border-left-color: #3699ff; }
.log-warning { border-left-color: #ffc700; }
.log-error { border-left-color: #f1416c; }
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
                <div class="stats-number text-success" id="visibleItems">{{ count(array_filter($menuItems, function($item) { return $item['is_visible'] ?? true; })) }}</div>
                <div class="text-muted fw-semibold">العناصر المرئية</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-number text-warning" id="hiddenItems">{{ count($menuItems) - count(array_filter($menuItems, function($item) { return $item['is_visible'] ?? true; })) }}</div>
                <div class="text-muted fw-semibold">العناصر المخفية</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-number text-info" id="childItems">{{ collect($menuItems)->sum(function($item) { return count($item['children'] ?? []); }) }}</div>
                <div class="text-muted fw-semibold">العناصر الفرعية</div>
            </div>
        </div>
    </div>

    <!-- Control Panel -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="ki-filled ki-setting-3 text-primary me-2"></i>
                            لوحة التحكم
                        </h3>
                        <button class="btn btn-primary" id="saveOrder" onclick="saveMenuOrder()">
                            <i class="ki-filled ki-check me-2"></i>
                            حفظ الترتيب
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert">
                        <i class="ki-filled ki-information-2 me-2"></i>
                        <strong>تعليمات الاستخدام:</strong>
                        اسحب العناصر من المقبض <span style="font-size: 18px; color: #3699ff;">⋮⋮⋮</span> لإعادة ترتيبها، واستخدم المفاتيح لإظهار/إخفاء العناصر.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Menu Structure -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="ki-filled ki-menu text-primary me-2"></i>
                        هيكل القائمة الحالي
                        <span class="badge badge-light-primary ms-2">{{ count($menuItems) }} عنصر</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div id="menuContainer" class="p-3" style="background: linear-gradient(135deg, #fafbfc 0%, #f8f9fb 100%); border-radius: 12px; border: 1px solid #e1e5e9;">
                        <div id="sortableMenu" class="menu-list">
                            @forelse($menuItems as $index => $item)
                                <div class="menu-item" data-key="{{ $item['key'] ?? 'item_'.$index }}" data-order="{{ $index }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="drag-handle" title="اسحب لإعادة الترتيب">
                                                ⋮⋮⋮
                                            </div>

                                            <div class="menu-icon">
                                                @if(!empty($item['icon']))
                                                    <i class="{{ $item['icon'] }} fs-3 text-primary"></i>
                                                @else
                                                    <i class="ki-filled ki-abstract-26 fs-3 text-gray-400"></i>
                                                @endif
                                            </div>

                                            <div class="menu-content">
                                                <div class="menu-title">
                                                    {{ $item['title']['ar'] ?? $item['title']['en'] ?? 'بدون عنوان' }}
                                                </div>
                                                @if(!empty($item['title']['en']) && !empty($item['title']['ar']))
                                                    <div class="menu-subtitle">
                                                        {{ $item['title']['en'] }}
                                                    </div>
                                                @endif
                                                @if(!empty($item['route']))
                                                    <div class="menu-url">
                                                        <i class="ki-filled ki-directbox-default me-1"></i>
                                                        {{ $item['route'] }}
                                                    </div>
                                                @endif
                                                @if(!empty($item['children']))
                                                    <div class="mt-2">
                                                        <span class="badge badge-light-info">
                                                            <i class="ki-filled ki-element-7 me-1"></i>
                                                            {{ count($item['children']) }} عنصر فرعي
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-3">
                                            <div class="form-check form-switch">
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           class="visibility-toggle"
                                                           data-key="{{ $item['key'] ?? 'item_'.$index }}"
                                                           {{ ($item['is_visible'] ?? true) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                    <i class="ki-filled ki-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="editMenuItem('{{ $item['key'] ?? 'item_'.$index }}')">
                                                        <i class="ki-filled ki-pencil me-2"></i>
                                                        تعديل
                                                    </a>
                                                    <a class="dropdown-item" href="#" onclick="duplicateMenuItem('{{ $item['key'] ?? 'item_'.$index }}')">
                                                        <i class="ki-filled ki-copy me-2"></i>
                                                        نسخ
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteMenuItem('{{ $item['key'] ?? 'item_'.$index }}')">
                                                        <i class="ki-filled ki-trash me-2"></i>
                                                        حذف
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if(!empty($item['children']))
                                        <div class="children-container mt-3 ps-5">
                                            @foreach($item['children'] as $childIndex => $child)
                                                <div class="child-menu-item p-3 mb-2" style="background: rgba(54, 153, 255, 0.05); border: 1px solid rgba(54, 153, 255, 0.1); border-radius: 8px; border-left: 3px solid #3699ff;">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="{{ $child['icon'] ?? 'ki-filled ki-arrow-right' }} text-muted"></i>
                                                        <span class="fw-semibold">{{ $child['title']['ar'] ?? $child['title']['en'] ?? 'عنصر فرعي' }}</span>
                                                        @if(!empty($child['route']))
                                                            <span class="badge badge-light-primary ms-auto">{{ $child['route'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="ki-filled ki-file-deleted fs-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">لا توجد عناصر في القائمة</h5>
                                    <p class="text-muted">قم بإضافة عناصر جديدة للقائمة الجانبية</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ki-filled ki-chart-pie-simple text-primary me-2"></i>
                        إحصائيات سريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>العناصر المرئية:</span>
                        <span class="badge badge-light-success fs-6" id="visibleCount">{{ count(array_filter($menuItems, function($item) { return $item['is_visible'] ?? true; })) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>العناصر المخفية:</span>
                        <span class="badge badge-light-warning fs-6" id="hiddenCount">{{ count($menuItems) - count(array_filter($menuItems, function($item) { return $item['is_visible'] ?? true; })) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>آخر تحديث:</span>
                        <span class="text-muted fs-7" id="lastUpdate">الآن</span>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ki-filled ki-document text-primary me-2"></i>
                        سجل النشاط
                    </h5>
                </div>
                <div class="card-body">
                    <div class="activity-log" id="activityLog">
                        <div class="log-entry log-info">
                            <i class="ki-filled ki-information-2 me-2"></i>
                            تم تحميل القائمة بنجاح
                            <div class="text-muted fs-8 mt-1">{{ now()->format('H:i:s') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Initialize Sortable
let sortable;

document.addEventListener('DOMContentLoaded', function() {
    initializeSortable();
    initializeVisibilityToggles();
    logActivity('تم تحميل واجهة إدارة القائمة الجانبية', 'info');
});

function initializeSortable() {
    const menuList = document.getElementById('sortableMenu');

    if (menuList) {
        sortable = Sortable.create(menuList, {
            handle: '.drag-handle',
            animation: 300,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',

            onStart: function() {
                logActivity('بدء إعادة ترتيب العناصر', 'info');
            },

            onEnd: function() {
                updateOrderNumbers();
                logActivity('تم تغيير ترتيب العناصر', 'warning');
            }
        });
    }
}

function initializeVisibilityToggles() {
    document.querySelectorAll('.visibility-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const menuKey = this.dataset.key;
            const isVisible = this.checked;

            toggleMenuVisibility(menuKey, isVisible);
        });
    });
}

function toggleMenuVisibility(menuKey, isVisible) {
    fetch('{{ route("admin.sidebar.toggle-visibility") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            menu_key: menuKey,
            is_visible: isVisible
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateStats();
            logActivity(data.message, 'success');
        } else {
            logActivity('خطأ في تغيير حالة العرض: ' + data.message, 'error');
        }
    })
    .catch(error => {
        logActivity('خطأ في الاتصال: ' + error.message, 'error');
    });
}

function saveMenuOrder() {
    const menuItems = document.querySelectorAll('.menu-item');
    const menuData = [];

    menuItems.forEach((item, index) => {
        menuData.push({
            key: item.dataset.key,
            order: index
        });
    });

    const saveButton = document.getElementById('saveOrder');
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="ki-filled ki-loading me-2"></i>جاري الحفظ...';
    saveButton.disabled = true;

    fetch('{{ route("admin.sidebar.update-order") }}', {
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
            logActivity('تم حفظ ترتيب القائمة بنجاح', 'success');

            // Success animation
            saveButton.innerHTML = '<i class="ki-filled ki-check me-2"></i>تم الحفظ!';
            saveButton.classList.remove('btn-primary');
            saveButton.classList.add('btn-success');

            setTimeout(() => {
                saveButton.innerHTML = originalText;
                saveButton.classList.remove('btn-success');
                saveButton.classList.add('btn-primary');
                saveButton.disabled = false;
            }, 2000);
        } else {
            logActivity('خطأ في حفظ الترتيب: ' + data.message, 'error');
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        }
    })
    .catch(error => {
        logActivity('خطأ في الاتصال: ' + error.message, 'error');
        saveButton.innerHTML = originalText;
        saveButton.disabled = false;
    });
}

function updateOrderNumbers() {
    document.querySelectorAll('.menu-item').forEach((item, index) => {
        item.dataset.order = index;
    });
}

function updateStats() {
    const visibleItems = document.querySelectorAll('.visibility-toggle:checked').length;
    const totalItems = document.querySelectorAll('.visibility-toggle').length;
    const hiddenItems = totalItems - visibleItems;

    document.getElementById('visibleItems').textContent = visibleItems;
    document.getElementById('hiddenItems').textContent = hiddenItems;
    document.getElementById('visibleCount').textContent = visibleItems;
    document.getElementById('hiddenCount').textContent = hiddenItems;
    document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString('ar-SA');
}

function logActivity(message, type = 'info') {
    const log = document.getElementById('activityLog');
    const entry = document.createElement('div');
    entry.className = `log-entry log-${type}`;

    const icons = {
        success: 'ki-filled ki-check-circle',
        error: 'ki-filled ki-cross-circle',
        warning: 'ki-filled ki-warning',
        info: 'ki-filled ki-information-2'
    };

    entry.innerHTML = `
        <i class="${icons[type]} me-2"></i>
        ${message}
        <div class="text-muted fs-8 mt-1">${new Date().toLocaleTimeString('ar-SA')}</div>
    `;

    log.insertBefore(entry, log.firstChild);

    // Keep only last 10 entries
    while (log.children.length > 10) {
        log.removeChild(log.lastChild);
    }
}

function resetToDefault() {
    if (confirm('هل أنت متأكد من إعادة تعيين القائمة للإعدادات الافتراضية؟')) {
        fetch('{{ route("admin.sidebar.reset") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                logActivity('تم إعادة تعيين القائمة للإعدادات الافتراضية', 'success');
                location.reload();
            } else {
                logActivity('خطأ في إعادة التعيين: ' + data.message, 'error');
            }
        });
    }
}

function exportConfig() {
    fetch('{{ route("admin.sidebar.export") }}', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'sidebar-config.json';
        a.click();
        logActivity('تم تصدير إعدادات القائمة', 'success');
    })
    .catch(error => {
        logActivity('خطأ في التصدير: ' + error.message, 'error');
    });
}

function editMenuItem(key) {
    logActivity(`طلب تعديل العنصر: ${key}`, 'info');
    // TODO: Implement edit functionality
}

function duplicateMenuItem(key) {
    logActivity(`طلب نسخ العنصر: ${key}`, 'info');
    // TODO: Implement duplicate functionality
}

function deleteMenuItem(key) {
    if (confirm('هل أنت متأكد من حذف هذا العنصر؟')) {
        logActivity(`طلب حذف العنصر: ${key}`, 'warning');
        // TODO: Implement delete functionality
    }
}
</script>
@endpush
@endsection
