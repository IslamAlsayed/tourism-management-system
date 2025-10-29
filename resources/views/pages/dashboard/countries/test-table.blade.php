@extends('layouts.master')

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">تجربة جدول الدول (Metronic Demo1)</h1>
        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">تصدير</button>
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">تعديل جماعي</button>
            <button class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" id="toggle-columns-btn">إظهار/إخفاء الأعمدة</button>
        </div>
    </div>
    <div class="mb-4 flex gap-2">
        <input type="text" id="searchInput" class="border px-3 py-2 rounded w-1/3" placeholder="بحث...">
        <select class="border px-3 py-2 rounded">
            <option>كل القارات</option>
            <option>آسيا</option>
            <option>أوروبا</option>
            <option>أفريقيا</option>
            <option>أمريكا الشمالية</option>
            <option>أمريكا الجنوبية</option>
            <option>أوقيانوسيا</option>
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow" id="countriesTable">
            <thead>
                <tr>
                    <th class="px-4 py-2"><input type="checkbox" id="selectAll"></th>
                    <th class="px-4 py-2">العلم</th>
                    <th class="px-4 py-2">الدولة</th>
                    <th class="px-4 py-2">العملة</th>
                    <th class="px-4 py-2">العاصمة</th>
                    <th class="px-4 py-2">كود الهاتف</th>
                    <th class="px-4 py-2">القارة</th>
                    <th class="px-4 py-2">عدد السكان</th>
                    <th class="px-4 py-2">المساحة</th>
                    <th class="px-4 py-2">نشط؟</th>
                    <th class="px-4 py-2">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <!-- بيانات تجريبية فقط -->
                <tr>
                    <td class="px-4 py-2"><input type="checkbox"></td>
                    <td class="px-4 py-2"><img src="https://flagcdn.com/w40/sa.png" alt="SA" class="w-8 h-5"></td>
                    <td class="px-4 py-2">السعودية</td>
                    <td class="px-4 py-2">ريال سعودي</td>
                    <td class="px-4 py-2">الرياض</td>
                    <td class="px-4 py-2">+966</td>
                    <td class="px-4 py-2">آسيا</td>
                    <td class="px-4 py-2">35,000,000</td>
                    <td class="px-4 py-2">2,149,690 كم²</td>
                    <td class="px-4 py-2"><span class="inline-block px-2 py-1 bg-green-200 text-green-800 rounded">نشط</span></td>
                    <td class="px-4 py-2">
                        <div class="relative inline-block text-left">
                            <button class="actions-btn bg-gray-200 px-2 py-1 rounded">...</button>
                            <div class="actions-menu hidden absolute left-0 mt-2 w-32 bg-white border rounded shadow z-10">
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">تعديل</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">حذف</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">تفعيل/تعطيل</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2"><input type="checkbox"></td>
                    <td class="px-4 py-2"><img src="https://flagcdn.com/w40/eg.png" alt="EG" class="w-8 h-5"></td>
                    <td class="px-4 py-2">مصر</td>
                    <td class="px-4 py-2">جنيه مصري</td>
                    <td class="px-4 py-2">القاهرة</td>
                    <td class="px-4 py-2">+20</td>
                    <td class="px-4 py-2">أفريقيا</td>
                    <td class="px-4 py-2">104,000,000</td>
                    <td class="px-4 py-2">1,010,408 كم²</td>
                    <td class="px-4 py-2"><span class="inline-block px-2 py-1 bg-red-200 text-red-800 rounded">غير نشط</span></td>
                    <td class="px-4 py-2">
                        <div class="relative inline-block text-left">
                            <button class="actions-btn bg-gray-200 px-2 py-1 rounded">...</button>
                            <div class="actions-menu hidden absolute left-0 mt-2 w-32 bg-white border rounded shadow z-10">
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">تعديل</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">حذف</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">تفعيل/تعطيل</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- نهاية البيانات التجريبية -->
            </tbody>
        </table>
    </div>
    <!-- قائمة إظهار/إخفاء الأعمدة -->
    <div id="columnsMenu" class="hidden bg-white border rounded shadow p-4 mt-2 w-64">
        <label class="block"><input type="checkbox" class="column-toggle" data-col="1" checked> العلم</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="2" checked> الدولة</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="3" checked> العملة</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="4" checked> العاصمة</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="5" checked> كود الهاتف</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="6" checked> القارة</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="7" checked> عدد السكان</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="8" checked> المساحة</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="9" checked> نشط؟</label>
        <label class="block"><input type="checkbox" class="column-toggle" data-col="10" checked> إجراءات</label>
    </div>
</div>
<script>
// إظهار/إخفاء قائمة الأعمدة
const toggleBtn = document.getElementById('toggle-columns-btn');
const columnsMenu = document.getElementById('columnsMenu');
toggleBtn.addEventListener('click', () => {
    columnsMenu.classList.toggle('hidden');
});
// إظهار/إخفاء الأعمدة
const toggles = document.querySelectorAll('.column-toggle');
toggles.forEach(toggle => {
    toggle.addEventListener('change', function() {
        const colIndex = parseInt(this.dataset.col) + 1; // +1 لتخطي عمود التحديد
        const table = document.getElementById('countriesTable');
        for (let row of table.rows) {
            if (row.cells[colIndex]) {
                row.cells[colIndex].style.display = this.checked ? '' : 'none';
            }
        }
    });
});
// قائمة الإجراءات
const actionBtns = document.querySelectorAll('.actions-btn');
actionBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = this.nextElementSibling;
        document.querySelectorAll('.actions-menu').forEach(m => m.classList.add('hidden'));
        menu.classList.toggle('hidden');
    });
});
document.addEventListener('click', () => {
    document.querySelectorAll('.actions-menu').forEach(m => m.classList.add('hidden'));
});
// تحديد الكل
const selectAll = document.getElementById('selectAll');
selectAll.addEventListener('change', function() {
    document.querySelectorAll('#countriesTable tbody input[type="checkbox"]').forEach(cb => {
        cb.checked = this.checked;
    });
});
// بحث بسيط
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    document.querySelectorAll('#countriesTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>
@endsection
