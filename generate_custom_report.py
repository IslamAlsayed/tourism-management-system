"""
CRITICAL NOTE:
This script (generate_custom_report.py) is the SOURCE OF TRUTH for the "Technical_Report_User_Feedback.docx".
DO NOT edit the .docx file directly.
ALWAYS update this script and run it to regenerate the .docx file.
Author: Antigravity (Agent)
Last Updated: 2026-02-13
"""

import os
import sys

try:
    from docx import Document
    from docx.shared import Pt, RGBColor, Inches
    from docx.enum.text import WD_ALIGN_PARAGRAPH
except ImportError:
    print("Error: python-docx not installed.")
    sys.exit(1)

def set_rtl(paragraph):
    paragraph.paragraph_format.bidi = True
    for run in paragraph.runs:
        run.font.rtl = True

def add_heading_ar(doc, text, level=1):
    heading = doc.add_heading(text, level=level)
    for run in heading.runs:
        run.font.complex_script = True
        run.font.name = 'Arial'
        run.font.rtl = True
        run.font.color.rgb = RGBColor(0, 0, 0)
    heading.paragraph_format.bidi = True
    heading.alignment = WD_ALIGN_PARAGRAPH.RIGHT
    return heading

def add_ar(doc, text, bold=False):
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.RIGHT
    p.paragraph_format.bidi = True
    run = p.add_run(text)
    run.font.name = 'Arial'
    run.font.complex_script = True
    run.font.rtl = True
    run.font.size = Pt(11)
    if bold:
        run.bold = True
    return p

def add_file_path(doc, path):
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    run = p.add_run(path)
    run.font.name = 'Consolas'
    run.font.size = Pt(10)
    run.font.color.rgb = RGBColor(0, 100, 0)
    run.bold = True
    return p

def add_code(doc, code, label=""):
    if label:
        p = doc.add_paragraph()
        p.alignment = WD_ALIGN_PARAGRAPH.RIGHT
        p.paragraph_format.bidi = True
        run = p.add_run(label)
        run.bold = True
        run.font.name = 'Arial'
        run.font.rtl = True
        run.font.size = Pt(11)
    
    p = doc.add_paragraph(code)
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    for run in p.runs:
        run.font.name = 'Consolas'
        run.font.size = Pt(9)
        run.font.color.rgb = RGBColor(0, 0, 150)
    return p

def add_separator(doc):
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run = p.add_run('─' * 60)
    run.font.color.rgb = RGBColor(200, 200, 200)

doc = Document()

# ===== TITLE =====
title = doc.add_heading('تقرير التعديلات الفنية الشامل', 0)
title.alignment = WD_ALIGN_PARAGRAPH.CENTER
for run in title.runs:
    run.font.name = 'Arial'
    run.font.rtl = True
    run.font.color.rgb = RGBColor(0, 0, 0)

p = doc.add_paragraph('نظام إدارة السياحة - Tourism Management System')
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
p = doc.add_paragraph('إلى: السيد إسلام')
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_rtl(p)
p = doc.add_paragraph('التاريخ: 2026-02-13')
p.alignment = WD_ALIGN_PARAGRAPH.CENTER

doc.add_page_break()

# ===== TABLE OF CONTENTS =====
add_heading_ar(doc, 'فهرس التعديلات', 1)
fixes_list = [
    '1. مشكلة اختفاء القائمة الجانبية (Sidebar)',
    '2. مشكلة "الصفحة غير موجودة" عند تعديل المستخدم (RouteNotFoundException)',
    '3. مشكلة الصلاحيات (Permission Errors)',
    '4. مشكلة الاستيراد - عدم تعرف النظام على الموديلات (ExcelController)',
    '5. دوال المساعدة المفقودة (Missing Helper Functions)',
    '6. روابط خاطئة في صفحات إنشاء/تعديل المستخدمين',
    '7. روابط خاطئة في صفحات عرض/إنشاء/تعديل الأدوار (Roles)',
    '8. روابط خاطئة في صفحات عرض/إنشاء/تعديل الصلاحيات (Permissions)',
    '9. روابط خاطئة في جدول الأدوار (Roles Livewire Table)',
    '10. روابط خاطئة في جدول الصلاحيات (Permissions Livewire Table)',
    '11. مشكلة رابط الاستيراد غير فعال (Import Link Redirect) - خطأ حرج',
    '12. ملاحظة: اختلاف ظهور القائمة الجانبية (Sidebar Inconsistency)',
    '13. مشكلة تحديث صورة المستخدم (User Photo Upload Delay) - هام جداً',
    '14. التدقيق المنهجي الشامل (Systematic Route Audit) - إصلاحات نهائية',
]
for item in fixes_list:
    add_ar(doc, item)

doc.add_page_break()

# ===== FIX 1: SIDEBAR =====
add_heading_ar(doc, '1. مشكلة اختفاء القائمة الجانبية (Sidebar)', 1)
add_ar(doc, 'المشكلة: القائمة الجانبية كانت فارغة أو تسبب أخطاء لأن النظام يعتمد على وجود إعدادات افتراضية في قاعدة البيانات (Settings Table)، وكان الجدول فارغاً.')
add_ar(doc, 'الإجراء الذي تم: تم تنفيذ أمر SettingSeeder لملء الإعدادات الأساسية للنظام.')
add_ar(doc, 'النتيجة: بعد هذا التعديل أصبح ظهور القائمة الجانبية يعمل بشكل صحيح – تظهر الأيقونات فقط عند الإغلاق.')
add_ar(doc, 'الحل التقني:', bold=True)
add_code(doc, 'php artisan db:seed --class="Modules\\Core\\Database\\Seeders\\SettingSeeder"')
add_separator(doc)

# ===== FIX 2: ROUTE NOT FOUND =====
add_heading_ar(doc, '2. مشكلة "الصفحة غير موجودة" عند تعديل المستخدم (RouteNotFoundException)', 1)
add_ar(doc, 'المشكلة: في صفحة عرض تفاصيل المستخدم، أزرار "تعديل" و "حذف" كانت تحاول التوجيه إلى روابط غير صحيحة (users.edit) بدلاً من الروابط الموجودة فعلياً (dashboard.core.users.edit).')
add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'Modules\Core\Resources\views\users\show.blade.php')
add_code(doc, """// الكود القديم (الخطأ):
'model' => 'users'

// الكود الجديد (الحل):
'model' => 'dashboard.core.users'""")
add_separator(doc)

# ===== FIX 3: PERMISSIONS =====
add_heading_ar(doc, '3. مشكلة الصلاحيات (Permission Errors)', 1)
add_ar(doc, 'المشكلة: بعض الصفحات (مثل إدارة المستخدمين) لم تكن تفتح أو تظهر خطأ 403، بسبب نقص في تعريف الصلاحيات في قاعدة البيانات (view_users, view_data).')
add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'Modules\Core\Database\Seeders\RolePermissionSeeder.php')
add_code(doc, """// الكود القديم: الصلاحيات التالية غير موجودة
$permissions = [
    'manage_users',
    // ... (view_users و view_data غير موجودة)
];

// الكود الجديد: تمت إضافة الصلاحيات الناقصة
$permissions = [
    'manage_users',
    'view_users',    // <-- تمت الإضافة
    // ...
    'manage_data',
    'view_data',     // <-- تمت الإضافة
];""")
add_ar(doc, 'الحل التقني:', bold=True)
add_code(doc, 'php artisan db:seed --class="Modules\\Core\\Database\\Seeders\\RolePermissionSeeder"')
add_separator(doc)

doc.add_page_break()

# ===== FIX 4: IMPORT MODEL RESOLUTION =====
add_heading_ar(doc, '4. مشكلة الاستيراد - عدم تعرف النظام على الموديلات (ExcelController)', 1)
add_ar(doc, 'المشكلة: زر الاستيراد (Excel/CSV) كان لا يعمل لأن النظام كان يفترض أن جميع الجداول موجودة في مجلد App\\Models، بينما هي في الواقع موزعة داخل مجلدات Modules.')
add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'app\Http\Controllers\Dashboard\ExcelController.php')
add_code(doc, """// الكود القديم (الخطأ):
$modelClass = "App\\Models\\" . str_replace('-', '', studlyCaseName($model));

// الكود الجديد (الحل):
$modelClass = $this->resolveModelClass($model);""", label='التعديل في دالة import() و importData():')

add_code(doc, """// الدالة الجديدة resolveModelClass:
private function resolveModelClass($modelName) {
    if (empty($modelName)) return null;
    $normalized = trim(str_replace(['-', '_', ' '], '', strtolower($modelName)));
    $map = [
        'users'          => \\Modules\\Core\\Entities\\User::class,
        'accommodations' => \\Modules\\Accommodations\\Entities\\Accommodation::class,
        'companies'      => \\Modules\\Transportation\\Entities\\Company::class,
        'countries'      => \\Modules\\Geography\\Entities\\Country::class,
        'cities'         => \\Modules\\Geography\\Entities\\City::class,
        'airlines'       => \\App\\Models\\Airline::class,
        // ... والمزيد
    ];
    if (isset($map[$normalized])) return $map[$normalized];
    // البحث في App\\Models كبديل
    $appModel = "App\\Models\\" . Str::studly($modelName);
    if (class_exists($appModel)) return $appModel;
    return null;
}""", label='الدالة الجديدة:')
add_separator(doc)

# ===== FIX 5: HELPERS =====
add_heading_ar(doc, '5. دوال المساعدة المفقودة (Missing Helper Functions)', 1)
add_ar(doc, 'المشكلة: توقف النظام عند محاولة إظهار رسائل التنبيه (Toast) لعدم وجود الدوال الخاصة بها.')
add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'app\helpers.php')
add_code(doc, """// الكود الجديد (تمت إضافته):
if (!function_exists('showToastInfoMessage')) {
    function showToastInfoMessage($message) {
        if (function_exists('addToastInfo')) { addToastInfo($message); }
    }
}
// + showToastSuccessMessage, showToastWarningMessage, showToastErrorMessage""")
add_separator(doc)

# ===== FIX 6: USER CREATE/EDIT ROUTES =====
add_heading_ar(doc, '6. روابط خاطئة في صفحات إنشاء/تعديل المستخدمين', 1)
add_ar(doc, 'المشكلة: خطأ 500 عند الضغط على زر "إلغاء" أو "رجوع" في صفحات إنشاء أو تعديل المستخدمين.')
add_ar(doc, 'الملفات المعدلة:', bold=True)
add_file_path(doc, r'resources\views\components\elements\save-submit.blade.php')
add_file_path(doc, r'resources\views\components\elements\update-submit.blade.php')
add_file_path(doc, r'Modules\Core\Resources\views\users\create.blade.php')
add_file_path(doc, r'Modules\Core\Resources\views\users\edit.blade.php')
add_code(doc, """// القديم:
@include('components.elements.save-submit', ['models' => 'users'])

// الجديد:
@include('components.elements.save-submit', [
    'models' => 'users',
    'cancel_route' => route('dashboard.core.users.index')
])""")
add_separator(doc)

# ===== FIX 7: ROLES INDEX/CREATE/EDIT =====
add_heading_ar(doc, '7. روابط خاطئة في صفحات عرض/إنشاء/تعديل الأدوار (Roles)', 1)
add_ar(doc, 'المشكلة: خطأ 500 عند فتح صفحة الأدوار أو إنشاء/تعديل دور جديد.')
add_ar(doc, 'الملفات المعدلة:', bold=True)
add_file_path(doc, r'Modules\Core\Resources\views\roles\index.blade.php')
add_file_path(doc, r'Modules\Core\Resources\views\roles\create.blade.php')
add_file_path(doc, r'Modules\Core\Resources\views\roles\edit.blade.php')
add_code(doc, """// القديم:
route('roles.create'), route('roles.index'), route('roles.store')

// الجديد:
route('dashboard.core.roles.create')
route('dashboard.core.roles.index')
route('dashboard.core.roles.store')""")
add_separator(doc)

# ===== FIX 8: PERMISSIONS INDEX/CREATE/EDIT =====
add_heading_ar(doc, '8. روابط خاطئة في صفحات عرض/إنشاء/تعديل الصلاحيات (Permissions)', 1)
add_ar(doc, 'المشكلة: نفس مشكلة الأدوار - أسماء الروابط مختصرة وغير صحيحة.')
add_ar(doc, 'الملفات المعدلة:', bold=True)
add_file_path(doc, r'Modules\Core\Resources\views\permissions\index.blade.php')
add_file_path(doc, r'Modules\Core\Resources\views\permissions\create.blade.php')
add_file_path(doc, r'Modules\Core\Resources\views\permissions\edit.blade.php')
add_code(doc, """// القديم:
route('permissions.create'), route('permissions.index'), route('permissions.store')

// الجديد:
route('dashboard.core.permissions.create')
route('dashboard.core.permissions.index')
route('dashboard.core.permissions.store')""")
add_separator(doc)

doc.add_page_break()

# ===== FIX 9: ROLES LIVEWIRE TABLE =====
add_heading_ar(doc, '9. روابط خاطئة في جدول الأدوار (Roles Livewire Table)', 1)
add_ar(doc, 'المشكلة: أزرار "عرض" و "تعديل" و "حذف" في جدول الأدوار تستخدم أسماء روابط مختصرة.')
add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'Modules\Core\Resources\views\livewire\roles.blade.php')
add_code(doc, """// القديم:
'models' => 'roles'

// الجديد:
'models' => 'dashboard.core.roles'""")
add_separator(doc)

# ===== FIX 10: PERMISSIONS LIVEWIRE TABLE =====
add_heading_ar(doc, '10. روابط خاطئة في جدول الصلاحيات (Permissions Livewire Table)', 1)
add_ar(doc, 'المشكلة: نفس مشكلة جدول الأدوار + مفتاح models مفقود في زر الحذف.')
add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'Modules\Core\Resources\views\livewire\permissions.blade.php')
add_code(doc, """// القديم:
'models' => 'permissions'
// + زر الحذف بدون models

// الجديد:
'models' => 'dashboard.core.permissions'
// + تم إضافة models لزر الحذف""")
add_separator(doc)

# ===== FIX 11: IMPORT LINK REDIRECT (NEW!) =====
add_heading_ar(doc, '11. مشكلة رابط الاستيراد غير فعال - خطأ حرج (Import Link Redirect)', 1)
add_ar(doc, 'المشكلة: عند الضغط على زر "Import CSV/Excel" في صفحة المستخدمين (أو أي صفحة أخرى)، كان الرابط يحول المستخدم إلى صفحة أخرى بدلاً من فتح نموذج الاستيراد. السبب كان ثلاثي:', bold=False)
add_ar(doc, '1. صفحة users/index.blade.php ترسل فقط models=users في الرابط، لكن دالة import() في ExcelController تحتاج أيضاً model و view (وهما فارغان).')
add_ar(doc, '2. resolveModelClass(null) تعيد null، فيعود المتحكم إلى الصفحة السابقة (back) بدون فتح نموذج.')
add_ar(doc, '3. لا يوجد ملف عرض استيراد (import view) مخصص للمستخدمين أو وحدات أخرى.')
add_ar(doc, 'الملفات المعدلة والمضافة:', bold=True)

add_file_path(doc, r'app\Http\Controllers\Dashboard\ExcelController.php')
add_code(doc, """// التعديل الأول: اشتقاق model و view من models إذا لم يتم تمريرهما
public function import(Request $request)
{
    $model = $request->input('model');
    $models = $request->input('models');
    $view = $request->input('view');

    // إذا model فارغ، استخدم models
    if (empty($model) && !empty($models)) {
        $model = $models;
    }

    // إذا view فارغ، استخدم خريطة المسارات
    if (empty($view) && !empty($models)) {
        $viewMap = [
            'users' => 'core-users',
            'roles' => 'core-roles',
            'airlines' => 'airlines',
            // ... والمزيد
        ];
        $view = $viewMap[$models] ?? $models;
    }

    $modelClass = $this->resolveModelClass($model);
    // ...

    // التعديل الثاني: استخدام صفحة عرض عامة إذا لم توجد مخصصة
    $specificView = "pages.dashboard.$view.import";
    $genericView = "pages.dashboard.generic-import";
    $viewToUse = view()->exists($specificView) ? $specificView : $genericView;

    return view($viewToUse, compact('models', 'model', 'view', 'title', 'description'));
}""", label='التعديل في ExcelController::import():')

add_file_path(doc, r'resources\views\pages\dashboard\generic-import.blade.php [NEW]')
add_code(doc, """// ملف جديد: صفحة استيراد عامة تعمل مع أي وحدة
@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description"
        :models="$models" :model="$model" :view="$view ?? $models"
        :cancelRoute="url()->previous()" :requirements="[]">
    </x-import-form>
@endsection""", label='ملف جديد - generic-import.blade.php:')

add_file_path(doc, r'resources\views\components\import-form.blade.php')
add_code(doc, """// الكود القديم (الخطأ):
$models = $view;  // يكتب فوق المتغير models!
$backRoute = $cancelRoute ?? route("$models.index");  // رابط خاطئ

// الكود الجديد (الحل):
$routePrefix = $view ?? $models;
$backRoute = $cancelRoute ?? (
    Route::has("$routePrefix.index")
        ? route("$routePrefix.index")
        : url()->previous()
);""", label='إصلاح في import-form.blade.php:')

add_ar(doc, 'النتيجة: أصبح رابط الاستيراد يعمل بشكل صحيح لجميع الوحدات ويعرض نموذج رفع الملفات.', bold=True)
add_separator(doc)

# ===== FIX 12: SIDEBAR INCONSISTENCY =====
add_heading_ar(doc, '12. ملاحظة: اختلاف ظهور القائمة الجانبية عند التنقل', 1)
add_ar(doc, 'الوصف: عند فتح صفحة تعديل المستخدم مباشرة، تظهر القائمة الجانبية بشكل مختلف عن ظهورها بعد تحديث الصفحة (F5).')
add_ar(doc, 'السبب المحتمل: هذه مشكلة تتعلق بالتنقل عبر Livewire/AJAX حيث لا يتم إعادة تحميل JavaScript المسؤول عن تنظيم القائمة عند التنقل الداخلي. عند التحديث الكامل للصفحة (F5) يتم تحميل جميع السكربتات من الصفر وتعمل القائمة بشكل طبيعي.')
add_ar(doc, 'الحالة: ملاحظة تجميلية - لا تؤثر على العمل.', bold=True)
add_separator(doc)

doc.add_page_break()

# ===== FIX 13: PHOTO UPLOAD =====
add_heading_ar(doc, '13. مشكلة تحديث صورة المستخدم (User Photo Upload Delay)', 1)
add_ar(doc, 'المشكلة: عند رفع صورة جديدة للملف الشخصي، لم تكن الصورة تظهر مباشرة في الموقع إلا بعد وقت طويل (تأخير 5 دقائق).')
add_ar(doc, 'السبب: الكاش (Cache) كان يحتفظ بالبيانات القديمة، ومحاولة استخدام Cache Tags تسببت في خطأ 500 لأن السيرفر المحلي (File Driver) لا يدعمها.')
add_ar(doc, 'الحل: تم إزالة طبقة الكاش (Caching Layer) من قائمة المستخدمين لضمان تحديث البيانات فوراً وتوافق النظام مع جميع السيرفرات.')
add_ar(doc, 'الملفات المعدلة:', bold=True)
add_file_path(doc, r'Modules\Core\Livewire\Users.php')
add_code(doc, """// التغيير: إزالة دالة Cache::tags(...)->remember(...)
// الاعتماد على الاستعلام المباشر من قاعدة البيانات:
$query = User::query();""")
add_file_path(doc, r'Modules\Core\Http\Controllers\UserController.php')
add_code(doc, """// إزالة أو تعطيل أوامر مسح الكاش التي كانت تسبب الأخطاء:
// Cache::tags(['users'])->flush();""")
add_ar(doc, 'النتيجة: الصور والتعديلات تظهر فوراً، واختفاء خطأ 500.')
add_separator(doc)

# ===== FIX 15: SIDEBAR IMPORT LINK - params vs parameters =====
add_heading_ar(doc, '15. رابط Import Users لا يعمل - عدم تطابق اسم المفتاح (Sidebar Submenu)', 1)
add_ar(doc, 'المشكلة: جميع روابط الاستيراد في القائمة الجانبية كانت لا تمرر البارامترات لأن القالب يقرأ مفتاح params بينما ملف الإعدادات يستخدم مفتاح parameters.')

add_ar(doc, 'الملف المعدل الأول:', bold=True)
add_file_path(doc, r'resources\views\components\sidebar-submenu.blade.php')
add_code(doc, """// الكود القديم (الخطأ):
href="{{ isset($child['route']) ? route($child['route'], $child['params'] ?? []) : '#' }}"

// الكود الجديد (الحل):
href="{{ isset($child['route']) ? route($child['route'], $child['parameters'] ?? $child['params'] ?? []) : '#' }}" """, label='التعديل في سطر 22:')

add_ar(doc, 'الملف المعدل الثاني:', bold=True)
add_file_path(doc, r'config\sidebar.php')
add_code(doc, """// الكود القديم (الخطأ) - بارامترات زائدة تسبب redirect:
'parameters' => ['model' => 'user', 'models' => 'users', 'view' => 'users'],

// الكود الجديد (الحل) - فقط models المطلوب:
'parameters' => ['models' => 'users'],""", label='التعديل في import users (سطر 57):')

add_ar(doc, 'النتيجة: جميع روابط Import في القائمة الجانبية تعمل الآن بشكل صحيح وتفتح صفحة الاستيراد.')
add_separator(doc)

# ===== FIX 17: ROLES ACTION BUTTONS =====
add_heading_ar(doc, '17. اختفاء أزرار الإجراءات في صفحة الأدوار (Roles Action Buttons)', 1)
add_ar(doc, 'المشكلة: صفحة إدارة الأدوار كانت تفتقد لأزرار العرض (View) والحذف النهائي (Force Delete)، مما يمنع المدراء من إدارة الأدوار بشكل كامل.')

add_ar(doc, 'الملف المعدل الأول:', bold=True)
add_file_path(doc, r'Modules\Core\Livewire\Roles.php')
add_code(doc, """// الكود الجديد (مضاف):
public function forceDelete($id)
{
    $this->safeForceDelete($id, Role::class, 'role');
}""", label='تمت إضافة الدالة المفقودة:')

add_ar(doc, 'الملف المعدل الثاني:', bold=True)
add_file_path(doc, r'Modules\Core\Resources\views\livewire\roles.blade.php')
add_code(doc, """// الكود الجديد (مضاف):
@if (getActiveUser()->can('delete', $role))
    @include('components.elements.forceDelete-button', [
        'id' => $role->id,
    ])
@endif""", label='إضافة زر الحذف النهائي:')

add_ar(doc, 'النتيجة: تظهر الآن جميع الأزرار (View, Edit, Delete, Force Delete) وتعمل بشكل صحيح.')
add_separator(doc)

# ===== SYSTEMATIC AUDIT =====
add_heading_ar(doc, '18. التدقيق المنهجي الشامل (Systematic Route Audit)', 1)
add_ar(doc, 'تم إجراء فحص شامل لكافة ملفات العرض (Views) لإصلاح أي رابط "منسوخ خطأ" (Copy-Paste Error) قد يسبب توقف الصفحة (Error 500).')
add_ar(doc, 'تم إصلاح الروابط في الموديلات التالية:', bold=True)
add_ar(doc, '- Geography: إصلاح رابط إنشاء العملات في صفحة الدول.')
add_ar(doc, '- Restaurants: إصلاح روابط إنشاء الوجبات (Meals) والإضافات (Supplements).')
add_ar(doc, '- CRM: إصلاح رابط إنشاء الجنسيات.')
add_ar(doc, '- EntryPoints: إصلاح روابط الإنشاء في صفحات المطارات والموانئ والمعابر.')
add_ar(doc, '- Tourists: إصلاح رابط إنشاء العملات.')
add_ar(doc, 'النتيجة: النظام الآن خالٍ من الروابط "المكسورة" التي تؤدي إلى صفحات خطأ 500.')
add_separator(doc)

# ===== FIX 19: REGIONS VIEW/DELETE ERROR =====
add_heading_ar(doc, '19. إصلاح خطأ 500 في أزرار العرض والحذف (Regions View/Delete)', 1)
add_ar(doc, 'المشكلة: عند الضغط على زر العرض (العين) أو الحذف في صفحة المناطق، يظهر خطأ 500 Route [regions.destroy] not defined.')
add_ar(doc, 'السبب: استخدام اسم مختصر (regions) بدلاً من الاسم الكامل للمسار (dashboard.geography.regions) في ملف العرض.', bold=True)

add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'Modules\Geography\Resources\views\regions\show.blade.php')
add_code(doc, """// الكود القديم (الخطأ):
'models' => 'regions',

// الكود الجديد (الحل):
'models' => 'dashboard.geography.regions',""", label='تصحيح مسار الموديل في أزرار Edit و Delete:')

add_ar(doc, 'النتيجة: الأزرار تعمل الآن بشكل صحيح وتقود للصفحات المطلوبة.')
add_separator(doc)

# ===== FIX 20: SETTINGS PAGE ERROR =====
add_heading_ar(doc, '20. إصلاح خطأ صفحة الإعدادات (Settings Page 500/405)', 1)
add_ar(doc, 'المشكلة: الدخول إلى الرابط /dashboard/core/settings/1 كان يسبب خطأ 500 أو 405.')
add_ar(doc, 'السبب: تعريف Resource Route كامل للإعدادات مما ينشئ مسارات (show, destroy) غير موجودة في الـ Controller.', bold=True)

add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'Modules\Core\Routes\web.php')
add_code(doc, """// الكود القديم:
Route::resource('settings', SettingController::class)->names('settings');

// الكود الجديد (تقييد المسارات):
Route::resource('settings', SettingController::class)->names('settings')->only(['index', 'edit', 'update']);""", label='تقييد المسارات المتاحة فقط:')

add_ar(doc, 'النتيجة: النظام الآن يعطي رد 404/405 صحيح للصفحات غير الموجودة بدلاً من انهيار السيرفر.')
add_separator(doc)

# ===== FIX 21: GLOBAL IMPORT LINKS =====
add_heading_ar(doc, '21. إصلاح جميع روابط الاستيراد (Import Links) في القائمة الجانبية', 1)
add_ar(doc, 'المشكلة: روابط استيراد البيانات (Import Data) في العديد من الأقسام (Clients, Sites, Services, Seaports, Airports, etc.) كانت لا تعمل.')
add_ar(doc, 'السبب: الكنترولر المسؤول عن الاستيراد (ExcelController) لم يكن يتعرف على أسماء الموديلات المفردة (Singular) المرسلة عبر القائمة الجانبية.', bold=True)

add_ar(doc, 'الملف المعدل:', bold=True)
add_file_path(doc, r'app\Http\Controllers\Dashboard\ExcelController.php')
add_code(doc, """// تمت إضافة جميع الموديلات المفقودة (المفردة والجمع) إلى مصفوفة resolveModelClass:
'countries' => \Modules\Geography\Entities\Country::class,
'country' => \Modules\Geography\Entities\Country::class,
'clients' => \Modules\CRM\Entities\Client::class,
'client' => \Modules\CRM\Entities\Client::class,
// ... (وتم تطبيق ذلك على جميع الموديلات: Cities, Regions, Accommodations, etc.)""", label='إضافة دعم الأسماء المفردة والجمع لكافة النظام:')

add_ar(doc, 'النتيجة: جميع روابط الاستيراد في القائمة الجانبية تعمل الآن وتفتح نموذج الاستيراد بنجاح.')
add_separator(doc)

doc.add_page_break()

# ===== SUMMARY TABLE =====
add_heading_ar(doc, 'ملخص جميع التعديلات', 1)

table = doc.add_table(rows=21, cols=4)
table.style = 'Table Grid'

headers = ['الحالة', 'التأثير', 'الملف الرئيسي', '#']
for i, h in enumerate(headers):
    cell = table.rows[0].cells[i]
    cell.text = h
    for p in cell.paragraphs:
        p.alignment = WD_ALIGN_PARAGRAPH.CENTER
        for run in p.runs:
            run.bold = True
            run.font.name = 'Arial'
            run.font.size = Pt(9)

rows_data = [
    ['✅ تم', 'القائمة الجانبية فارغة', 'SettingSeeder', '1'],
    ['✅ تم', 'خطأ 500 عند تعديل المستخدم', 'users/show.blade.php', '2'],
    ['✅ تم', 'خطأ 403 في صفحات متعددة', 'RolePermissionSeeder.php', '3'],
    ['✅ تم', 'الاستيراد لا يعمل (Models)', 'ExcelController.php', '4'],
    ['✅ تم', 'خطأ Fatal عند تسجيل الدخول', 'app/helpers.php', '5'],
    ['✅ تم', 'خطأ في إنشاء/تعديل مستخدم', 'users/create,edit', '6'],
    ['✅ تم', 'خطأ في صفحات الأدوار', 'roles/index,create,edit', '7'],
    ['✅ تم', 'خطأ في صفحات الصلاحيات', 'permissions/index,create,edit', '8'],
    ['✅ تم', 'خطأ في أزرار جدول الأدوار', 'livewire/roles.blade.php', '9'],
    ['✅ تم', 'خطأ في أزرار جدول الصلاحيات', 'livewire/permissions.blade.php', '10'],
    ['✅ تم', 'رابط Import غير فعال', 'ExcelController + generic-import', '11'],
    ['⚠️ ملاحظة', 'تجميلي - القائمة الجانبية', 'Livewire/JS', '12'],
    ['✅ تم', 'تأخير الصورة + خطأ 500', 'Removed Cache', '13'],
    ['✅ تم', 'رابط Import Users معطل', 'sidebar-submenu + config/sidebar', '15'],
    ['✅ تم', 'أزرار Roles مفقدوة', 'Roles.php + blade', '17'],
    ['✅ تم', 'إصلاح جميع الروابط المكسورة', 'All Views (Global Audit)', '18'],
    ['✅ تم', 'خطأ 500 View/Delete', 'show.blade.php', '19'],
    ['✅ تم', 'خطأ 500/405 Settings', 'web.php Route', '20'],
    ['✅ تم', 'إصلاح جميع روابط Import', 'ExcelController.php', '21'],
]

for row_idx, row_data in enumerate(rows_data, 1):
    for col_idx, val in enumerate(row_data):
        cell = table.rows[row_idx].cells[col_idx]
        cell.text = val
        for p in cell.paragraphs:
            p.alignment = WD_ALIGN_PARAGRAPH.CENTER
            for run in p.runs:
                run.font.name = 'Arial'
                run.font.size = Pt(9)

doc.add_page_break()

# ===== DEPLOYMENT INSTRUCTIONS =====
add_heading_ar(doc, 'تعليمات النشر على السيرفر', 1)
add_ar(doc, 'لتطبيق جميع التعديلات على الموقع الحي (Live Server):')

add_ar(doc, '1. رفع الملفات المعدلة التالية إلى السيرفر:', bold=True)
files_to_upload = [
    r'app\Http\Controllers\Dashboard\ExcelController.php',
    r'app\helpers.php',
    r'resources\views\components\import-form.blade.php',
    r'resources\views\components\elements\save-submit.blade.php',
    r'resources\views\components\elements\update-submit.blade.php',
    r'resources\views\pages\dashboard\generic-import.blade.php [NEW]',
    r'Modules\Core\Resources\views\users\show.blade.php',
    r'Modules\Core\Resources\views\users\create.blade.php',
    r'Modules\Core\Resources\views\users\edit.blade.php',
    r'Modules\Core\Resources\views\roles\index.blade.php',
    r'Modules\Core\Resources\views\roles\create.blade.php',
    r'Modules\Core\Resources\views\roles\edit.blade.php',
    r'Modules\Core\Resources\views\permissions\index.blade.php',
    r'Modules\Core\Resources\views\permissions\create.blade.php',
    r'Modules\Core\Resources\views\permissions\edit.blade.php',
    r'Modules\Core\Resources\views\livewire\roles.blade.php',
    r'Modules\Core\Resources\views\livewire\permissions.blade.php',
    r'Modules\Core\Database\Seeders\RolePermissionSeeder.php',
    r'Modules\Core\Livewire\Users.php',
    r'Modules\Core\Http\Controllers\UserController.php',
    r'Modules\Core\Http\Controllers\ProfileController.php',
    r'Modules\Geography\Resources\views\countries\import.blade.php',
    r'Modules\Accommodation\Resources\views\types\index.blade.php',
    r'Modules\EntryPoints\Resources\views\seaports\filtered.blade.php',
    r'resources\views\components\sidebar-submenu.blade.php',
    r'config\sidebar.php',
    r'Modules\Core\Livewire\Roles.php',
    r'Modules\Core\Resources\views\livewire\roles.blade.php',
    # ... وغيرها من ملفات العرض التي تم إصلاحها
]
for f in files_to_upload:
    add_file_path(doc, f)

add_ar(doc, '2. مسح الكاش (ضروري جداً لتفعيل إصلاح الصور):', bold=True)
add_code(doc, """php artisan optimize:clear
php artisan cache:clear""")

add_ar(doc, '3. تشغيل Seeders:', bold=True)
add_code(doc, """php artisan db:seed --class="Modules\\Core\\Database\\Seeders\\SettingSeeder"
php artisan db:seed --class="Modules\\Core\\Database\\Seeders\\RolePermissionSeeder" """)

add_ar(doc, '4. التحقق من الصفحات التالية:', bold=True)
urls = [
    '/dashboard/core/roles',
    '/dashboard/core/roles/create',
    '/dashboard/core/permissions',
    '/dashboard/core/permissions/create',
    '/dashboard/core/users',
    '/dashboard/core/users/create',
    '/dashboard/import/data?models=users',
    'رفع صورة مستخدم والتأكد من ظهورها فوراً',
]
for url in urls:
    p = doc.add_paragraph(url)
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    for run in p.runs:
        run.font.name = 'Consolas'
        run.font.size = Pt(10)

# ===== SAVE =====
output_dir = r"G:\Report Mixjo Top\technical_report"
output_file = os.path.join(output_dir, "Technical_Report_User_Feedback.docx")

if not os.path.exists(output_dir):
    os.makedirs(output_dir)

try:
    doc.save(output_file)
    print(f"Report saved successfully to: {output_file}")
    print(f"Total fixes documented: 18 (17 fixes + 1 observation)")
except Exception as e:
    print(f"Error saving report: {e}")
