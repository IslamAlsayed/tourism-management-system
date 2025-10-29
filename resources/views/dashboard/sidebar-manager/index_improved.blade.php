@extends('layouts.master')

@section('title', 'إدارة القائمة الجانبية')

@push('styles')
<style>
.menu-item {
    background: white;
    border: 1px solid #e1e5e9;
    border-radius: 8px;
    margin-bottom: 12px;
    padding: 16px;
    cursor: move;
    transition: all 0.3s ease;
    position: relative;
}

.menu-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #3699ff;
    transform: translateY(-2px);
}

.menu-item.sortable-chosen {
    background: #e7f3ff;
    border-color: #3699ff;
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(54, 153, 255, 0.15);
}

.menu-item.sortable-ghost {
    opacity: 0.5;
    background: #f8f9fa;
    border: 2px dashed #3699ff;
}

.drag-handle {
    cursor: grab;
    color: #a1a5b7;
    font-size: 20px;
    padding: 8px;
    border-radius: 4px;
    transition: all 0.3s ease;
    margin-left: 10px;
}

.drag-handle:hover {
    color: #3699ff;
    background: #f1f3f6;
}

.drag-handle:active {
    cursor: grabbing;
}

.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
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
  background-color: #e4e6ef;
  transition: .4s;
  border-radius: 12px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

input:checked + .slider {
  background-color: #50cd89;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

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
        <div class="col-12">
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
                        <strong>تعليمات الاستخدام:</strong> اسحب العناصر من المقبض <span style="font-size: 18px;">⋮⋮⋮</span> لإعادة ترتيبها، واستخدم المفاتيح لإظهار/إخفاء العناصر.
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
                                        <div class="menu-item" data-key="{{ $item['key'] ?? 'item_'.$index }}" data-order="{{ $index }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="drag-handle" title="اسحب لإعادة الترتيب">
                                                        ⋮⋮⋮
                                                    </div>
                                                    <div class="menu-icon">
                                                        @if(!empty($item['icon']))
                                                            <i class="{{ $item['icon'] }} fs-4 text-primary"></i>
                                                        @else
                                                            <i class="ki-filled ki-abstract-26 fs-4 text-gray-400"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold fs-6">
                                                            {{ $item['title']['ar'] ?? $item['title']['en'] ?? 'بدون عنوان' }}
                                                        </div>
                                                        @if(!empty($item['title']['en']) && !empty($item['title']['ar']))
                                                            <div class="text-muted fs-7">
                                                                {{ $item['title']['en'] }}
                                                            </div>
                                                        @endif
                                                        @if(!empty($item['url']))
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
                                                    @if(!empty($item['children']))
                                                        <span class="badge badge-light-info">
                                                            {{ count($item['children']) }} فرعي
                                                        </span>
                                                    @endif
                                                    <label class="switch" title="إظهار/إخفاء العنصر">
                                                        <input type="checkbox" {{ ($item['is_visible'] ?? true) ? 'checked' : '' }}
                                                               onchange="toggleVisibility(this, '{{ $item['key'] ?? 'item_'.$index }}')">
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8 text-muted">
                                            <i class="ki-filled ki-file-deleted fs-3x mb-3 d-block text-gray-300"></i>
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
                                    <small class="text-muted">${new Date().toLocaleTimeString('ar-SA')}</small> - تم تحميل مدير القائمة الجانبية
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
                    addLog(`✅ تم نقل "${itemText}" من الموضع ${evt.oldIndex + 1} إلى ${evt.newIndex + 1}`, 'success');
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

        fetch('{{ route("admin.sidebar.reset") }}', {
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

        fetch('{{ route("admin.sidebar.export") }}')
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `sidebar-config-${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.json`;
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
        const itemText = checkbox.closest('.menu-item').querySelector('.fw-semibold').textContent.trim();
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
