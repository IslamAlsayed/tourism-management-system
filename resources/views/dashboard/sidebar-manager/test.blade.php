<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار SortableJS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sortable-item {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 15px;
            cursor: move;
            transition: all 0.3s ease;
        }

        .sortable-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #0d6efd;
            transform: translateY(-2px);
        }

        .sortable-item.sortable-chosen {
            background: #e7f3ff;
            border-color: #0d6efd;
            transform: scale(1.02);
        }

        .sortable-item.sortable-ghost {
            opacity: 0.5;
            background: #f8f9fa;
            border: 2px dashed #0d6efd;
        }

        .drag-handle {
            cursor: grab;
            color: #6c757d;
            font-size: 20px;
            margin-right: 10px;
        }

        .drag-handle:hover {
            color: #0d6efd;
        }

        .drag-handle:active {
            cursor: grabbing;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h3>اختبار السحب والإفلات</h3>
                <div class="alert alert-info">
                    <strong>تعليمات:</strong> اسحب العناصر من المقبض ⋮⋮⋮ لإعادة ترتيبها
                </div>

                <div id="sortable-list">
                    <div class="sortable-item" data-id="1">
                        <span class="drag-handle">⋮⋮⋮</span>
                        <i class="bi bi-house-door"></i>
                        <strong>لوحة التحكم</strong>
                        <small class="text-muted">Dashboard</small>
                    </div>

                    <div class="sortable-item" data-id="2">
                        <span class="drag-handle">⋮⋮⋮</span>
                        <i class="bi bi-people"></i>
                        <strong>المستخدمين</strong>
                        <small class="text-muted">Users</small>
                    </div>

                    <div class="sortable-item" data-id="3">
                        <span class="drag-handle">⋮⋮⋮</span>
                        <i class="bi bi-gear"></i>
                        <strong>الإعدادات</strong>
                        <small class="text-muted">Settings</small>
                    </div>

                    <div class="sortable-item" data-id="4">
                        <span class="drag-handle">⋮⋮⋮</span>
                        <i class="bi bi-graph-up"></i>
                        <strong>التقارير</strong>
                        <small class="text-muted">Reports</small>
                    </div>

                    <div class="sortable-item" data-id="5">
                        <span class="drag-handle">⋮⋮⋮</span>
                        <i class="bi bi-shield-check"></i>
                        <strong>الحماية</strong>
                        <small class="text-muted">Security</small>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary" onclick="saveOrder()">حفظ الترتيب</button>
                    <button class="btn btn-secondary" onclick="showOrder()">عرض الترتيب الحالي</button>
                </div>
            </div>

            <div class="col-md-6">
                <h3>سجل الأحداث</h3>
                <div id="log" class="border rounded p-3 bg-light" style="height: 400px; overflow-y: auto;">
                    <!-- سيتم ملء هذا القسم بسجل الأحداث -->
                </div>
            </div>
        </div>
    </div>

    <!-- SortableJS Library -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        // تسجيل الأحداث
        function addLog(message) {
            const log = document.getElementById('log');
            const time = new Date().toLocaleTimeString('ar-SA');
            log.innerHTML += `<div class="mb-1"><small class="text-muted">${time}</small> - ${message}</div>`;
            log.scrollTop = log.scrollHeight;
        }

        // تهيئة SortableJS
        document.addEventListener('DOMContentLoaded', function() {
            addLog('تم تحميل الصفحة بنجاح');

            const sortableList = document.getElementById('sortable-list');

            if (!sortableList) {
                addLog('❌ خطأ: لم يتم العثور على القائمة');
                return;
            }

            addLog('🔧 جاري تهيئة SortableJS...');

            const sortable = new Sortable(sortableList, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onStart: function(evt) {
                    addLog(`🚀 بدء السحب: العنصر رقم ${evt.oldIndex + 1}`);
                },
                onMove: function(evt) {
                    console.log('نقل العنصر...');
                    return true;
                },
                onEnd: function(evt) {
                    addLog(`✅ انتهاء السحب: من الموضع ${evt.oldIndex + 1} إلى ${evt.newIndex + 1}`);

                    if (evt.oldIndex !== evt.newIndex) {
                        addLog(`🔄 تم تغيير الترتيب بنجاح`);
                    } else {
                        addLog(`ℹ️ لم يتم تغيير الترتيب`);
                    }
                },
                onUpdate: function(evt) {
                    addLog(`📝 تم تحديث ترتيب القائمة`);
                },
                onError: function(evt) {
                    addLog(`❌ حدث خطأ في السحب والإفلات`);
                }
            });

            if (sortable) {
                addLog('✅ تم تهيئة SortableJS بنجاح');
                addLog('📋 يمكنك الآن سحب العناصر لإعادة ترتيبها');
            } else {
                addLog('❌ فشل في تهيئة SortableJS');
            }
        });

        // حفظ الترتيب
        function saveOrder() {
            const items = document.querySelectorAll('.sortable-item');
            const order = [];

            items.forEach((item, index) => {
                order.push({
                    id: item.dataset.id,
                    position: index + 1,
                    text: item.querySelector('strong').textContent
                });
            });

            addLog(`💾 تم حفظ الترتيب الجديد`);
            console.log('الترتيب الحالي:', order);
        }

        // عرض الترتيب
        function showOrder() {
            const items = document.querySelectorAll('.sortable-item');
            let orderText = 'الترتيب الحالي:<br>';

            items.forEach((item, index) => {
                const title = item.querySelector('strong').textContent;
                orderText += `${index + 1}. ${title}<br>`;
            });

            addLog(orderText);
        }
    </script>
</body>
</html>
