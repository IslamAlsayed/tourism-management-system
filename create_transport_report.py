from docx import Document
from docx.shared import Pt, Cm, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.oxml.ns import qn
import os

doc = Document()

for section in doc.sections:
    section.top_margin = Cm(2)
    section.bottom_margin = Cm(2)
    section.left_margin = Cm(2.5)
    section.right_margin = Cm(2.5)

style = doc.styles['Normal']
font = style.font
font.name = 'Calibri'
font.size = Pt(11)
font.color.rgb = RGBColor(0x33, 0x33, 0x33)

DARK_RED = RGBColor(0x8B, 0x00, 0x00)
GRAY = RGBColor(0x55, 0x55, 0x55)
RED = RGBColor(0xCC, 0x00, 0x00)
GREEN = RGBColor(0x00, 0x80, 0x00)
ORANGE = RGBColor(0xCC, 0x66, 0x00)
BLUE = RGBColor(0x00, 0x00, 0x80)
WHITE = RGBColor(0xFF, 0xFF, 0xFF)

def add_heading(text, level=1):
    h = doc.add_heading(text, level=level)
    for run in h.runs:
        run.font.color.rgb = DARK_RED
    return h

def add_label(label, value, bold_val=False):
    p = doc.add_paragraph()
    r = p.add_run(label)
    r.bold = True
    r.font.color.rgb = DARK_RED
    r = p.add_run(value)
    if bold_val:
        r.bold = True
    return p

def add_code(text):
    p = doc.add_paragraph()
    p.paragraph_format.left_indent = Cm(1)
    p.paragraph_format.space_before = Pt(4)
    p.paragraph_format.space_after = Pt(4)
    r = p.add_run(text)
    r.font.name = 'Consolas'
    r.font.size = Pt(9)
    r.font.color.rgb = BLUE
    return p

def add_diff(old, new):
    p = doc.add_paragraph()
    p.paragraph_format.left_indent = Cm(1)
    p.paragraph_format.space_before = Pt(4)
    p.paragraph_format.space_after = Pt(4)
    for line in old:
        r = p.add_run('- ' + line + '\n')
        r.font.name = 'Consolas'
        r.font.size = Pt(9)
        r.font.color.rgb = RED
    for line in new:
        r = p.add_run('+ ' + line + '\n')
        r.font.name = 'Consolas'
        r.font.size = Pt(9)
        r.font.color.rgb = GREEN

def add_table(headers, rows):
    table = doc.add_table(rows=1 + len(rows), cols=len(headers))
    table.style = 'Table Grid'
    table.alignment = WD_TABLE_ALIGNMENT.CENTER
    for i, h in enumerate(headers):
        cell = table.rows[0].cells[i]
        cell.text = ''
        p = cell.paragraphs[0]
        r = p.add_run(h)
        r.bold = True
        r.font.size = Pt(10)
        r.font.color.rgb = WHITE
        shd = cell._element.get_or_add_tcPr()
        elem = shd.makeelement(qn('w:shd'), {qn('w:val'): 'clear', qn('w:color'): 'auto', qn('w:fill'): '8B0000'})
        shd.append(elem)
    for ri, row in enumerate(rows):
        for ci, val in enumerate(row):
            cell = table.rows[ri + 1].cells[ci]
            cell.text = str(val)
            for p in cell.paragraphs:
                for r in p.runs:
                    r.font.size = Pt(10)
    return table

def add_warn(text):
    p = doc.add_paragraph()
    p.paragraph_format.left_indent = Cm(0.5)
    r = p.add_run('⚠ ' + text)
    r.bold = True
    r.font.size = Pt(10)
    r.font.color.rgb = ORANGE

# ============================================================
# TITLE PAGE
# ============================================================
for _ in range(5):
    doc.add_paragraph('')

t = doc.add_paragraph()
t.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = t.add_run('Part 03\n')
r.bold = True; r.font.size = Pt(28); r.font.color.rgb = DARK_RED
r = t.add_run('Transportation Module\n')
r.bold = True; r.font.size = Pt(24); r.font.color.rgb = DARK_RED
r = t.add_run('Full Technical Audit Report\n')
r.font.size = Pt(16); r.font.color.rgb = GRAY
r = t.add_run('\nتقرير الفحص التقني الشامل\n')
r.bold = True; r.font.size = Pt(20); r.font.color.rgb = DARK_RED
r = t.add_run('وحدة المواصلات — Transportation Module\n')
r.font.size = Pt(14); r.font.color.rgb = GRAY
r = t.add_run('\nأسباب الأخطاء الناتجة عن تحويل الأقسام إلى Modules')
r.font.size = Pt(13); r.font.color.rgb = ORANGE

doc.add_paragraph('')
info = doc.add_paragraph()
info.alignment = WD_ALIGN_PARAGRAPH.CENTER
for label, value in [
    ('Website: ', 'https://mixjo.top'),
    ('\nProject: ', 'tourism-management-system'),
    ('\nDate: ', '14 February 2026'),
    ('\nPrepared for: ', 'Mr. Islam (Lead Developer)'),
    ('\nModule: ', 'Modules/Transportation (103 files audited)'),
]:
    r = info.add_run(label); r.bold = True; r.font.size = Pt(11); r.font.color.rgb = DARK_RED
    r = info.add_run(value); r.font.size = Pt(11)

doc.add_page_break()

# ============================================================
# EXECUTIVE SUMMARY
# ============================================================
add_heading('1. Executive Summary / ملخص تنفيذي')

doc.add_paragraph(
    'A comprehensive technical audit was performed on the Transportation module (Modules/Transportation) '
    'which contains 103 files across 7 controllers, 9 entities, 8 Livewire components, 7 policies, '
    '47 Blade views, and 8 database migrations.'
)
doc.add_paragraph(
    'تم إجراء فحص تقني شامل على وحدة المواصلات (Transportation Module) التي تحتوي على 103 ملف '
    'تتضمن 7 متحكمات، 9 كيانات، 8 مكونات Livewire، 7 سياسات صلاحيات، 47 واجهة عرض، و8 ملفات ترحيل قاعدة بيانات.'
)

doc.add_paragraph('')
doc.add_paragraph(
    'Root Cause Analysis: Mr. Islam converted all sections from the original monolithic architecture '
    'into a modular architecture using nwidart/laravel-modules. This conversion changed the route naming '
    'convention from short names (e.g., "transportation.companies.index") to full prefixed names '
    '(e.g., "dashboard.transportation.companies.index"). However, the controller redirect statements '
    'were NOT updated to match the new naming convention, causing 500 errors on the server.'
)
doc.add_paragraph(
    'تحليل السبب الجذري: قام السيد إسلام بتحويل جميع الأقسام من البنية الأصلية (Monolithic) إلى بنية '
    'وحدات (Modules) باستخدام nwidart/laravel-modules. هذا التحويل غيّر اصطلاح تسمية الـ Routes من أسماء '
    'مختصرة إلى أسماء كاملة بالبادئة dashboard. لكن أوامر redirect في المتحكمات لم يتم تحديثها لتتوافق '
    'مع الاصطلاح الجديد، مما يسبب أخطاء 500 على السيرفر.'
)

doc.add_paragraph('')
add_table(
    ['#', 'Bug Category', 'Severity', 'Files Affected', 'References'],
    [
        ['1', 'Wrong Route Names in Controllers\nأسماء Routes خاطئة في المتحكمات', '🔴 Critical', '5 controllers', '30 references'],
        ['2', 'dd() Debug Left in Production\nكود debug في الإنتاج', '🔴 Critical', 'JeepController', '1 reference'],
        ['3', 'Wrong Import Namespace\nاستيراد خاطئ', '🟡 Medium', 'JeepController', '2 imports'],
        ['4', 'API Route Not In Module\nRoute في ملف API قديم', '🟡 Medium', 'api.php + 4 views', '7 references'],
        ['5', 'Missing Database Tables\nجداول مفقودة', '🟡 Medium', '8 migrations', 'Server DB'],
        ['6', 'Missing Permissions\nصلاحيات مفقودة', '🟡 Medium', '7 policies', '7 permissions'],
        ['7', 'Unused Controller Scaffold\nمتحكم غير مستخدم', '🟢 Low', 'TransportationController', '1 file'],
        ['8', 'Table Name Conflict Risk\nتعارض محتمل في أسماء الجداول', '🟢 Low', 'Company model', 'companies table'],
    ]
)

doc.add_page_break()

# ============================================================
# BUG #1: WRONG ROUTE NAMES
# ============================================================
add_heading('2. Bug #1: Wrong Route Names in Controllers (🔴 CRITICAL)')
add_heading('أسماء Routes خاطئة في المتحكمات — 30 مرجع خاطئ', level=2)

add_label('Impact: ', 'All store/update/destroy operations in 5 controllers fail with 500 error on server', True)

doc.add_paragraph(
    'The routes file (web.php) defines routes with prefix "dashboard.transportation." but 5 out of 6 controllers '
    'use the short prefix "transportation." (missing "dashboard."). Only JeepController uses the correct prefix.'
)
doc.add_paragraph(
    'ملف Routes يعرّف Routes بالبادئة "dashboard.transportation." لكن 5 من أصل 6 متحكمات تستخدم البادئة '
    'المختصرة "transportation." (بدون "dashboard."). فقط JeepController يستخدم البادئة الصحيحة.'
)

add_heading('Route Definition (web.php):', level=3)
add_code(
    "Route::prefix('dashboard/transportation')\n"
    "    ->name('dashboard.transportation.')  // ← prefix is 'dashboard.transportation.'\n"
    "    ->middleware('auth')\n"
    "    ->group(function () {\n"
    "        Route::resource('companies', CompanyController::class)->names('companies');\n"
    "        // Final route name: 'dashboard.transportation.companies.index'\n"
    "    });"
)

add_heading('Affected Controllers:', level=3)

controllers = [
    ('CompanyController.php', 'transportation.companies.index', 'dashboard.transportation.companies.index', '6 references'),
    ('RouteController.php', 'transportation.routes.index', 'dashboard.transportation.routes.index', '6 references'),
    ('VehicleTypeController.php', 'transportation.vehicle-types.index', 'dashboard.transportation.vehicle-types.index', '6 references'),
    ('PricingController.php', 'transportation.pricings.index', 'dashboard.transportation.pricings.index', '6 references'),
    ('RouteAssignmentController.php', 'transportation.route-assignments.index', 'dashboard.transportation.route-assignments.index', '6 references'),
]

add_table(
    ['Controller', 'Wrong Route (❌)', 'Correct Route (✅)', 'Count'],
    [[c[0], c[1], c[2], c[3]] for c in controllers]
)

doc.add_paragraph('')
doc.add_paragraph('Note: JeepController.php uses the CORRECT prefix (dashboard.transportation.jeeps.index) ✅')
doc.add_paragraph('ملاحظة: JeepController يستخدم البادئة الصحيحة ✅')

add_heading('Fix Required:', level=3)
doc.add_paragraph('Replace ALL occurrences in each controller:')
add_diff(
    ["redirect()->route('transportation.companies.index')"],
    ["redirect()->route('dashboard.transportation.companies.index')"]
)
doc.add_paragraph('Apply the same pattern to all 5 controllers listed above.')
doc.add_paragraph('طبّق نفس النمط على جميع المتحكمات الخمسة المذكورة أعلاه.')

doc.add_page_break()

# ============================================================
# BUG #2: dd() DEBUG
# ============================================================
add_heading('3. Bug #2: dd() Debug Statement Left in Production (🔴 CRITICAL)')
add_heading('كود debug متروك في الإنتاج', level=2)

add_label('File: ', 'Modules/Transportation/Http/Controllers/JeepController.php')
add_label('Line: ', '35')

doc.add_paragraph(
    'The JeepController::store() method contains a dd() (dump and die) statement that stops '
    'ALL execution when creating a new Jeep. This means NO new Jeep records can be saved — the request '
    'will dump the data and terminate immediately.'
)
doc.add_paragraph(
    'دالة store() في JeepController تحتوي على أمر dd() (عرض البيانات وإيقاف التنفيذ) الذي يمنع حفظ '
    'أي سجل جيب جديد. عند محاولة إنشاء جيب جديد، يتم عرض البيانات ويتوقف التنفيذ فوراً.'
)

add_heading('Current Code (line 35):', level=3)
add_code(
    "public function store(StoreRequest $request)\n"
    "{\n"
    "    $validated = $request->validated();\n"
    "    dd($request->all(), $validated);  // ← BLOCKS ALL EXECUTION!\n"
    "    \n"
    "    $validated['created_by'] = getActiveUserId();\n"
    "    // ... rest of code never runs\n"
    "}"
)

add_heading('Fix:', level=3)
add_diff(
    ["    dd($request->all(), $validated);"],
    ["    // dd($request->all(), $validated);  // REMOVED debug statement"]
)

add_warn(
    'This is a blocking bug. NO Jeep records can be created until this line is removed.\n'
    'هذا خطأ يمنع العمل تماماً. لا يمكن إنشاء أي سجل جيب حتى يتم حذف هذا السطر.'
)

doc.add_page_break()

# ============================================================
# BUG #3: WRONG IMPORT NAMESPACE
# ============================================================
add_heading('4. Bug #3: Wrong Import Namespace in JeepController (🟡 MEDIUM)')
add_heading('استيراد خاطئ للـ Namespace في JeepController', level=2)

add_label('File: ', 'Modules/Transportation/Http/Controllers/JeepController.php')
add_label('Lines: ', '9-10')

doc.add_paragraph(
    'JeepController imports StoreRequest and UpdateRequest from the old App namespace instead '
    'of the module namespace. This means the Jeep form requests may not be using the correct '
    'validation rules if there are module-specific request classes.'
)
doc.add_paragraph(
    'يستورد JeepController كلاسات StoreRequest و UpdateRequest من الـ namespace القديم (App) '
    'بدلاً من الـ namespace الخاص بالوحدة (Modules). هذا يعني أن قواعد التحقق قد لا تكون صحيحة.'
)

add_diff(
    [
        "use App\\Http\\Requests\\Jeep\\StoreRequest;",
        "use App\\Http\\Requests\\Jeep\\UpdateRequest;",
    ],
    [
        "use Modules\\Transportation\\Http\\Requests\\Jeep\\StoreRequest;   // if exists",
        "use Modules\\Transportation\\Http\\Requests\\Jeep\\UpdateRequest;  // if exists",
    ]
)

doc.add_paragraph(
    'Note: Check if Jeep-specific request files exist in Modules/Transportation/Http/Requests/Jeep/. '
    'If not, either create them or keep the App import. Currently, only Company, Pricing, Route, '
    'RouteAssignment, and VehicleType have module-level request classes.'
)
doc.add_paragraph(
    'ملاحظة: تحقق من وجود ملفات request خاصة بالجيب في المسار المحدد. إذا لم تكن موجودة، '
    'إما أنشئها أو أبقِ الاستيراد من App.'
)

doc.add_page_break()

# ============================================================
# BUG #4: API ROUTE NOT IN MODULE
# ============================================================
add_heading('5. Bug #4: API Route Defined Outside Module (🟡 MEDIUM)')
add_heading('Route معرف خارج الوحدة', level=2)

add_label('Route: ', "routes.cities")
add_label('Defined in: ', 'routes/api.php (line 34) — NOT in module routes')

doc.add_paragraph(
    'The route "routes.cities" is used in 7 Blade view files for AJAX city autocompletion '
    'but is defined in the main routes/api.php file, NOT inside the Transportation module. '
    'This breaks the modular architecture principle and may cause issues if the main API routes '
    'are not loaded or have different middleware.'
)
doc.add_paragraph(
    'Route المسمى "routes.cities" يُستخدم في 7 ملفات Blade لبحث المدن بالـ AJAX لكنه '
    'معرف في ملف routes/api.php الرئيسي وليس داخل وحدة المواصلات. هذا يخالف مبدأ البنية الوحداتية.'
)

add_heading('Affected View Files:', level=3)
views_affected = [
    'routes/create.blade.php (2 references)',
    'routes/edit.blade.php (1 reference)',
    'jeeps/create.blade.php (2 references)',
    'jeeps/edit.blade.php (2 references)',
]
for v in views_affected:
    doc.add_paragraph(f'• {v}')

add_heading('Recommendation:', level=3)
doc.add_paragraph(
    'Move this API route to Modules/Transportation/Routes/api.php and update the route name to '
    '"dashboard.transportation.routes.cities" for consistency.'
)

doc.add_page_break()

# ============================================================
# BUG #5: MISSING DATABASE TABLES
# ============================================================
add_heading('6. Bug #5: Missing Database Tables on Server (🟡 MEDIUM)')
add_heading('جداول قاعدة بيانات مفقودة على السيرفر', level=2)

doc.add_paragraph(
    'The Transportation module has 8 migration files that create the following tables. '
    'These migrations have NOT been run on the production server.'
)
doc.add_paragraph(
    'وحدة المواصلات لديها 8 ملفات migration تنشئ الجداول التالية. هذه الـ migrations '
    'لم يتم تشغيلها على سيرفر الإنتاج.'
)

add_table(
    ['Migration File', 'Table Name', 'Main Purpose'],
    [
        ['2026_02_08_203603', 'companies', 'Transportation companies'],
        ['2026_02_08_203605', 'company_contacts', 'Company contact info'],
        ['2026_02_08_203608', 'vehicle_types', 'Vehicle type definitions'],
        ['2026_02_08_203613', 'routes', 'Transportation routes'],
        ['2026_02_08_203621', 'route_assignments', 'Route-to-company assignments'],
        ['2026_02_08_203628', 'pricings', 'Transportation pricing'],
        ['2026_02_08_203630', 'jeeps', 'Jeep vehicles'],
        ['2026_02_08_203640', 'jeep_pricing_tables', 'Jeep season pricing'],
    ]
)

doc.add_paragraph('')
add_heading('Important Note — Table Name Conflict:', level=3)
doc.add_paragraph(
    'The server error log shows: "Table transportations_companies doesn\'t exist". '
    'But the migration creates a table named "companies" (without "transportations_" prefix). '
    'This suggests either: (a) there was a previous version of migrations with different table names, '
    'or (b) there is old code somewhere still referencing the old table name "transportations_companies".'
)
doc.add_paragraph(
    'سجل أخطاء السيرفر يظهر: "Table transportations_companies doesn\'t exist". '
    'لكن الـ migration ينشئ جدول باسم "companies" (بدون بادئة "transportations_"). '
    'هذا يشير إلى وجود كود قديم في مكان ما يشير إلى اسم الجدول القديم.'
)

add_warn(
    'Action Required: Search the ENTIRE codebase for "transportations_companies" to find any '
    'remaining references to the old table name and update them.\n'
    'إجراء مطلوب: ابحث في كامل الكود عن "transportations_companies" لإيجاد أي مراجع متبقية.'
)

add_heading('Fix:', level=3)
add_code(
    'cd /home/mixtop/project_root\n'
    'php artisan migrate --path=Modules/Transportation/Database/Migrations'
)

doc.add_page_break()

# ============================================================
# BUG #6: MISSING PERMISSIONS
# ============================================================
add_heading('7. Bug #6: Missing Permissions for Superadmin (🟡 MEDIUM)')
add_heading('صلاحيات مفقودة لدور superadmin', level=2)

doc.add_paragraph(
    'The Transportation module defines 7 policies that check for specific permissions. '
    'These permissions must be assigned to the superadmin role for the dashboard to work properly.'
)
doc.add_paragraph(
    'وحدة المواصلات تعرف 7 سياسات صلاحيات تتحقق من صلاحيات محددة. '
    'يجب إسناد هذه الصلاحيات لدور superadmin ليعمل لوحة التحكم بشكل صحيح.'
)

add_table(
    ['Policy File', 'Required Permission', 'Used For'],
    [
        ['CompanyPolicy.php', 'manage_companies', 'Companies CRUD + buttons'],
        ['CompanyContactPolicy.php', 'manage_company_contacts', 'Company contacts'],
        ['VehicleTypePolicy.php', 'manage_vehicle_types', 'Vehicle types CRUD'],
        ['RoutePolicy.php', 'manage_routes', 'Routes CRUD'],
        ['RouteAssignmentPolicy.php', 'manage_route_assignments', 'Route assignments'],
        ['PricingPolicy.php', 'manage_pricings', 'Pricing CRUD'],
        ['JeepPolicy.php', 'manage_jeeps', 'Jeeps CRUD + buttons'],
    ]
)

doc.add_paragraph('')
add_heading('Fix:', level=3)
add_code(
    "php artisan tinker\n"
    ">>> $role = \\Spatie\\Permission\\Models\\Role::findByName('superadmin');\n"
    ">>> $role->givePermissionTo([\n"
    "    'manage_companies',\n"
    "    'manage_company_contacts',\n"
    "    'manage_vehicle_types',\n"
    "    'manage_routes',\n"
    "    'manage_route_assignments',\n"
    "    'manage_pricings',\n"
    "    'manage_jeeps'\n"
    "]);"
)

doc.add_paragraph(
    'If the permissions do not exist yet, create them first:'
)
add_code(
    ">>> $permissions = [\n"
    "    'manage_companies', 'manage_company_contacts', 'manage_vehicle_types',\n"
    "    'manage_routes', 'manage_route_assignments', 'manage_pricings', 'manage_jeeps'\n"
    "];\n"
    ">>> foreach ($permissions as $p) { \\Spatie\\Permission\\Models\\Permission::firstOrCreate(['name' => $p]); }\n"
    ">>> $role->givePermissionTo($permissions);"
)

doc.add_page_break()

# ============================================================
# BUG #7: UNUSED CONTROLLER
# ============================================================
add_heading('8. Bug #7: Unused Controller Scaffold (🟢 LOW)')
add_heading('متحكم غير مستخدم — كود scaffold', level=2)

add_label('File: ', 'Modules/Transportation/Http/Controllers/TransportationController.php')

doc.add_paragraph(
    'This is an auto-generated scaffold controller from the module creation command. It contains '
    'empty method stubs and is NOT used by any route. It should be deleted to keep the codebase clean.'
)
doc.add_paragraph(
    'هذا متحكم scaffold تم إنشاؤه تلقائياً عند إنشاء الوحدة. يحتوي على دوال فارغة ولا يستخدمه أي Route. '
    'يجب حذفه للحفاظ على نظافة الكود.'
)

add_heading('Recommendation:', level=3)
add_code('Delete file: Modules/Transportation/Http/Controllers/TransportationController.php')

doc.add_page_break()

# ============================================================
# STRUCTURE OVERVIEW
# ============================================================
add_heading('9. Module Structure Overview / نظرة عامة على هيكل الوحدة')

doc.add_paragraph('The Transportation module follows the nwidart/laravel-modules architecture:')

add_table(
    ['Component', 'Count', 'Details'],
    [
        ['Controllers', '7 (1 unused)', 'Company, Jeep, Pricing, Route, RouteAssignment, VehicleType, Transportation(unused)'],
        ['Entities/Models', '9', 'Company, CompanyContact, Jeep, JeepSeason, JeepSeasonNationalityPrice, Pricing, Route, RouteAssignment, VehicleType'],
        ['Livewire Components', '8', 'Companies, Jeeps, Pricings, PricingSteps, Routes, RouteAssignment, RouteAssignments, VehicleTypes'],
        ['Policies', '7', 'One per entity (Company, CompanyContact, Jeep, Pricing, Route, RouteAssignment, VehicleType)'],
        ['Blade Views', '47', 'CRUD views + Livewire views + import views'],
        ['Migrations', '8', 'One per table'],
        ['Form Requests', '10', '2 per entity (Store + Update) for 5 entities; Jeep uses App-level requests'],
        ['Seeders', '4', 'Company, Jeep, Route, TransportationDatabase'],
    ]
)

doc.add_page_break()

# ============================================================
# FINDINGS COMPARISON
# ============================================================
add_heading('10. Views vs Controllers — Route Naming Comparison')
add_heading('مقارنة أسماء Routes بين الواجهات والمتحكمات', level=2)

doc.add_paragraph(
    'An interesting finding: The Blade view files use the CORRECT route names '
    '(with "dashboard.transportation." prefix), but the controllers use the WRONG route names '
    '(without "dashboard." prefix). This means:'
)
doc.add_paragraph(
    'اكتشاف مهم: ملفات Blade تستخدم الأسماء الصحيحة للـ Routes (مع بادئة "dashboard.transportation.") '
    'لكن المتحكمات تستخدم الأسماء الخاطئة (بدون بادئة "dashboard."). هذا يعني:'
)

doc.add_paragraph('• All page LINKS work correctly ✅ (generated by Blade views)')
doc.add_paragraph('  جميع الروابط في الصفحات تعمل بشكل صحيح ✅')
doc.add_paragraph('• All REDIRECTS after form submission fail ❌ (generated by controllers)')
doc.add_paragraph('  جميع عمليات إعادة التوجيه بعد إرسال النماذج تفشل ❌')
doc.add_paragraph('• Users can NAVIGATE to pages but cannot SAVE/UPDATE/DELETE ❌')
doc.add_paragraph('  المستخدمين يمكنهم التنقل للصفحات لكن لا يمكنهم الحفظ أو التحديث أو الحذف ❌')

doc.add_paragraph('')
doc.add_paragraph(
    'This is a classic symptom of converting from monolithic to modular architecture '
    'without updating all redirect routes to match the new naming convention.'
)
doc.add_paragraph(
    'هذا عَرَض كلاسيكي لتحويل البنية من monolithic إلى modular بدون تحديث جميع '
    'أوامر redirect لتتطابق مع اصطلاح التسمية الجديد.'
)

doc.add_page_break()

# ============================================================
# COMPLETE FIX LIST
# ============================================================
add_heading('11. Complete Fix List / قائمة الإصلاحات الكاملة')

add_heading('Step 1: Fix Controller Routes (5 files, 30 changes)', level=3)
doc.add_paragraph('In EACH of these 5 controllers, replace ALL redirect route names:')
for ctrl, wrong, correct, _ in controllers:
    add_label(f'{ctrl}: ', f'"{wrong}" → "{correct}"')

add_heading('Step 2: Remove dd() from JeepController (1 file, 1 change)', level=3)
add_code('Delete line 35: dd($request->all(), $validated);')

add_heading('Step 3: Run Migrations on Server', level=3)
add_code('php artisan migrate --path=Modules/Transportation/Database/Migrations')

add_heading('Step 4: Create & Assign Permissions', level=3)
add_code(
    "php artisan tinker\n"
    ">>> $permissions = ['manage_companies', 'manage_company_contacts', 'manage_vehicle_types',\n"
    "    'manage_routes', 'manage_route_assignments', 'manage_pricings', 'manage_jeeps'];\n"
    ">>> foreach ($permissions as $p) { \\Spatie\\Permission\\Models\\Permission::firstOrCreate(['name'=>$p]); }\n"
    ">>> \\Spatie\\Permission\\Models\\Role::findByName('superadmin')->givePermissionTo($permissions);"
)

add_heading('Step 5: Clear Cache', level=3)
add_code('php artisan optimize:clear')

add_heading('Step 6: Optional Cleanup', level=3)
doc.add_paragraph('• Delete TransportationController.php (unused scaffold)')
doc.add_paragraph('• Move routes.cities from api.php to module routes')
doc.add_paragraph('• Fix JeepController imports if module-level requests exist')
doc.add_paragraph('• Search for "transportations_companies" references and update')

doc.add_page_break()

# ============================================================
# RECOMMENDATIONS
# ============================================================
add_heading('12. General Recommendations / التوصيات العامة')

recs = [
    ('Consistent Route Naming / تسمية Routes متسقة',
     'Establish a strict naming convention: ALL module routes must use format '
     '"dashboard.{module}.{resource}.{action}". Create a checklist for this during code review.'),
    ('Module Migration Script / سكريبت ترحيل الوحدات',
     'Create a deployment script that automatically runs ALL module migrations: '
     'php artisan module:migrate Transportation'),
    ('Permission Seeder / بذر الصلاحيات',
     'Create a TransportationSeeder that creates all 7 permissions and assigns them to superadmin. '
     'This ensures permissions are always available after deployment.'),
    ('Remove Debug Statements / حذف أوامر Debug',
     'Add a CI/CD check that scans for dd(), dump(), var_dump() in production deployments. '
     'Consider using Laravel Debugbar instead.'),
    ('Linux Testing / اختبار على Linux',
     'Test on Linux (Docker/WSL) before deploying to catch case-sensitivity issues.'),
    ('Code Review Checklist / قائمة مراجعة الكود',
     'After converting any section to a module, verify:\n'
     '1. All route names in controllers use full prefix\n'
     '2. All imports use module namespace\n'
     '3. Migrations are run on server\n'
     '4. Permissions are created and assigned\n'
     '5. No debug statements left'),
]

for title, desc in recs:
    add_heading(title, level=3)
    doc.add_paragraph(desc)

# ============================================================
# SAVE
# ============================================================
output_dir = r'G:\Report Mixjo Top\technical_report'
os.makedirs(output_dir, exist_ok=True)
output_path = os.path.join(output_dir, 'Part 03 Transportation_Module_Audit_Report.docx')
doc.save(output_path)

print(f'\n=== Report created successfully! ===')
print(f'File: {output_path}')
print('Done!')
