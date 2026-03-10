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
BLACK = RGBColor(0x00, 0x00, 0x00)

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

def add_bullet(text, bold_prefix=None):
    p = doc.add_paragraph(style='List Bullet')
    if bold_prefix:
        r = p.add_run(bold_prefix)
        r.bold = True
        r.font.color.rgb = DARK_RED
        p.add_run(text)
    else:
        p.add_run(text)
    return p

# ============================================================
# TITLE PAGE
# ============================================================
for _ in range(4):
    doc.add_paragraph('')

t = doc.add_paragraph()
t.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = t.add_run('Full Technical Audit Report\n')
r.bold = True; r.font.size = Pt(28); r.font.color.rgb = DARK_RED
r = t.add_run('تقرير الفحص التقني الشامل\n')
r.bold = True; r.font.size = Pt(24); r.font.color.rgb = DARK_RED

doc.add_paragraph('')

t2 = doc.add_paragraph()
t2.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = t2.add_run('Tourism Management System\n')
r.font.size = Pt(18); r.font.color.rgb = GRAY
r = t2.add_run('نظام إدارة السياحة\n')
r.font.size = Pt(16); r.font.color.rgb = GRAY

doc.add_paragraph('')

t3 = doc.add_paragraph()
t3.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = t3.add_run('Modules Covered: Core (Roles) • EntryPoints • Transportation\n')
r.font.size = Pt(13); r.font.color.rgb = ORANGE
r = t3.add_run('الوحدات المشمولة: الأساسي (الأدوار) • نقاط الدخول • المواصلات\n')
r.font.size = Pt(12); r.font.color.rgb = ORANGE

doc.add_paragraph('')

t4 = doc.add_paragraph()
t4.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = t4.add_run('15 Bugs Found — أسباب الأخطاء الناتجة عن تحويل الأقسام إلى Modules + إعدادات الخادم')
r.font.size = Pt(13); r.font.color.rgb = RED; r.bold = True

doc.add_paragraph('')
doc.add_paragraph('')

info = doc.add_paragraph()
info.alignment = WD_ALIGN_PARAGRAPH.CENTER
for label, value in [
    ('Website: ', 'https://mixjo.top'),
    ('\nProject: ', 'tourism-management-system'),
    ('\nDate: ', '14 February 2026'),
    ('\nPrepared for: ', 'Mr. Islam (Lead Developer)'),
    ('\nPrepared by: ', 'AI Technical Audit System'),
    ('\nTotal Files Audited: ', '150+ files across 3 modules'),
]:
    r = info.add_run(label); r.bold = True; r.font.size = Pt(11); r.font.color.rgb = DARK_RED
    r = info.add_run(value); r.font.size = Pt(11)

doc.add_page_break()

# ============================================================
# TABLE OF CONTENTS
# ============================================================
add_heading('Table of Contents / جدول المحتويات')

toc_items = [
    '1. Executive Summary / ملخص تنفيذي',
    '2. Root Cause Analysis / تحليل السبب الجذري',
    '',
    '— SECTION A: Core & EntryPoints Modules (5 Bugs) —',
    '3. Bug #1: Incorrect Route Names in Roles Module (🔴 CRITICAL)',
    '4. Bug #2: Case Sensitivity in EntryPoints Routes (🔴 CRITICAL)',
    '5. Bug #3: Missing Buttons in Transportation Companies (🟡 MEDIUM)',
    '6. Bug #4: XLSX Export Not Working (🟡 MEDIUM)',
    '7. Bug #5: Missing Database Tables (🟡 MEDIUM)',
    '',
    '— SECTION B: Transportation Module Full Audit (8 Bugs) —',
    '8. Bug #6: Wrong Route Names in 5 Controllers (🔴 CRITICAL)',
    '9. Bug #7: dd() Debug Left in Production (🔴 CRITICAL)',
    '10. Bug #8: Wrong Import Namespace in JeepController (🟡 MEDIUM)',
    '11. Bug #9: API Route Defined Outside Module (🟡 MEDIUM)',
    '12. Bug #10: Missing Database Tables — Transportation (🟡 MEDIUM)',
    '13. Bug #11: Missing 7 Permissions for Superadmin (🟡 MEDIUM)',
    '14. Bug #12: Unused Controller Scaffold (🟢 LOW)',
    '15. Bug #13: Table Name Conflict Risk (🟢 LOW)',
    '',
    '— SECTION C: Server Configuration Issues (1 Bug) —',
    '16. Bug #14: MySQL Strict Mode / GROUP BY Error (🔴 CRITICAL)',
    '',
    '— SECTION D: Server Operations (1 Bug) —',
    '17. Bug #15: Missing Laravel Cron Job / Scheduler (🔴 CRITICAL)',
    '',
    '18. Transportation Module Structure Overview',
    '19. Views vs Controllers Route Comparison',
    '20. Complete Fix Checklist',
    '21. General Recommendations',
]

for item in toc_items:
    if item == '':
        doc.add_paragraph('')
    elif item.startswith('—'):
        p = doc.add_paragraph()
        r = p.add_run(item)
        r.bold = True
        r.font.color.rgb = DARK_RED
        r.font.size = Pt(11)
    else:
        p = doc.add_paragraph(item)
        p.paragraph_format.left_indent = Cm(0.5)

doc.add_page_break()

# ============================================================
# 1. EXECUTIVE SUMMARY
# ============================================================
add_heading('1. Executive Summary / ملخص تنفيذي')

doc.add_paragraph(
    'A comprehensive technical audit was performed on three modules of the Tourism Management System: '
    'Core (Roles), EntryPoints, and Transportation. Over 150 files were examined across controllers, '
    'entities, policies, Livewire components, Blade views, and migrations.'
)
doc.add_paragraph(
    'تم إجراء فحص تقني شامل على ثلاث وحدات من نظام إدارة السياحة: الأساسي (الأدوار)، نقاط الدخول، '
    'والمواصلات. تم فحص أكثر من 150 ملف تشمل المتحكمات والكيانات والسياسات ومكونات Livewire وواجهات العرض وملفات الترحيل.'
)

doc.add_paragraph('')

add_table(
    ['#', 'Bug Description\nوصف الخطأ', 'Module\nالوحدة', 'Severity\nالخطورة', 'Files'],
    [
        ['1', 'Incorrect Route Names in Roles\nأسماء Routes خاطئة في الأدوار', 'Core', '🔴 Critical', '3'],
        ['2', 'Case Sensitivity in EntryPoints\nحساسية حالة الأحرف', 'EntryPoints', '🔴 Critical', '1'],
        ['3', 'Missing Action Buttons\nأزرار مفقودة', 'Transportation', '🟡 Medium', '1'],
        ['4', 'XLSX Export Not Working\nتصدير Excel لا يعمل', 'Core Trait', '🟡 Medium', '1'],
        ['5', 'Missing DB Tables (EntryPoints)\nجداول مفقودة', 'EntryPoints', '🟡 Medium', '1'],
        ['6', 'Wrong Routes in 5 Controllers\n30 Route خاطئ في 5 متحكمات', 'Transportation', '🔴 Critical', '5'],
        ['7', 'dd() Debug in Production\nكود debug في الإنتاج', 'Transportation', '🔴 Critical', '1'],
        ['8', 'Wrong Import Namespace\nاستيراد خاطئ', 'Transportation', '🟡 Medium', '1'],
        ['9', 'API Route Outside Module\nRoute خارج الوحدة', 'Transportation', '🟡 Medium', '5'],
        ['10', 'Missing DB Tables (Transport)\nجداول مفقودة', 'Transportation', '🟡 Medium', '8'],
        ['11', 'Missing 7 Permissions\n7 صلاحيات مفقودة', 'Transportation', '🟡 Medium', '7'],
        ['12', 'Unused Controller Scaffold\nمتحكم غير مستخدم', 'Transportation', '🟢 Low', '1'],
        ['13', 'Table Name Conflict\nتعارض أسماء جداول', 'Transportation', '🟢 Low', '1'],
        ['14', 'MySQL Strict Mode / GROUP BY\nوضع MySQL الصارم', 'Server Config', '🔴 Critical', '1'],
    ]
)

doc.add_paragraph('')
p = doc.add_paragraph()
r = p.add_run('Summary: '); r.bold = True; r.font.color.rgb = DARK_RED
p.add_run('6 Critical • 7 Medium • 2 Low = 15 Total Bugs')

doc.add_page_break()

# ============================================================
# 2. ROOT CAUSE ANALYSIS
# ============================================================
add_heading('2. Root Cause Analysis / تحليل السبب الجذري')

doc.add_paragraph(
    'Mr. Islam converted all sections from the original monolithic architecture into a modular '
    'architecture using nwidart/laravel-modules. This conversion introduced systematic issues:'
)
doc.add_paragraph(
    'قام السيد إسلام بتحويل جميع الأقسام من البنية الأصلية (Monolithic) إلى بنية وحدات (Modules). '
    'هذا التحويل أدخل مشاكل منهجية:'
)

doc.add_paragraph('')

issues = [
    ('Route Naming Convention Change / تغيير اصطلاح التسمية: ',
     'Routes changed from short names (e.g., "roles.index") to full prefixed names '
     '(e.g., "dashboard.core.roles.index"). Controllers were NOT updated to match.'),
    ('Case Sensitivity / حساسية حالة الأحرف: ',
     'Import statements in route files had incorrect casing (e.g., LandCrossingController vs '
     'LandcrossingController). Works on Windows but fails on Linux servers.'),
    ('Database Migrations / ترحيل قاعدة البيانات: ',
     'Module migrations were NOT run on the production server, causing missing tables.'),
    ('Permissions Not Seeded / الصلاحيات لم تُبذر: ',
     'Module-specific permissions were not created or assigned to roles after conversion.'),
    ('Debug Code Left / كود debug متروك: ',
     'Development debug statements (dd()) were left in production code.'),
    ('MySQL Strict Mode / وضع MySQL الصارم: ',
     'The production MySQL server has ONLY_FULL_GROUP_BY enabled (strict mode). '
     'Laravel\'s search with orWhereHas generates queries that violate this rule, '
     'causing 500 errors when loading pages with relational data.'),
]

for label, desc in issues:
    p = doc.add_paragraph()
    r = p.add_run(label)
    r.bold = True
    r.font.color.rgb = DARK_RED
    p.add_run(desc)

doc.add_page_break()

# ============================================================
# SECTION A HEADER
# ============================================================
sa = doc.add_paragraph()
sa.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = sa.add_run('\n\n\nSECTION A\n')
r.bold = True; r.font.size = Pt(28); r.font.color.rgb = DARK_RED
r = sa.add_run('Core & EntryPoints Modules\n')
r.font.size = Pt(20); r.font.color.rgb = GRAY
r = sa.add_run('القسم أ — وحدات الأساسي ونقاط الدخول\n\n')
r.font.size = Pt(16); r.font.color.rgb = GRAY
r = sa.add_run('5 Bugs Found')
r.bold = True; r.font.size = Pt(16); r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #1: ROLES ROUTE NAMES
# ============================================================
add_heading('3. Bug #1: Incorrect Route Names in Roles Module (🔴 CRITICAL)')
add_heading('أسماء Routes خاطئة في وحدة الأدوار', level=2)

add_label('Impact: ', '/dashboard/core/roles pages return 500 Server Error', True)
add_label('Modules Affected: ', 'Core (Roles)')

doc.add_paragraph(
    'Three files in the Roles section used short route names instead of the full prefixed names. '
    'This caused 500 errors on the Linux server.'
)
doc.add_paragraph(
    'ثلاث ملفات في قسم الأدوار استخدمت أسماء routes مختصرة بدلاً من الأسماء الكاملة بالبادئة. '
    'هذا سبب أخطاء 500 على سيرفر Linux.'
)

add_heading('Affected Files & Fixes:', level=3)

add_label('File 1: ', 'Modules/Core/Http/Controllers/RoleController.php')
add_diff(
    ["redirect()->route('roles.index')"],
    ["redirect()->route('dashboard.core.roles.index')"]
)
doc.add_paragraph('Applied to store(), update(), destroy() methods (3 changes)')

add_label('File 2: ', 'Modules/Core/Resources/views/roles/show.blade.php')
add_diff(
    ["route('roles.edit', ...)", "route('roles.index')"],
    ["route('dashboard.core.roles.edit', ...)", "route('dashboard.core.roles.index')"]
)

add_label('File 3: ', 'Modules/Core/Resources/views/livewire/roles1.blade.php')
add_diff(
    ["route('roles.show', ...)", "route('roles.edit', ...)"],
    ["route('dashboard.core.roles.show', ...)", "route('dashboard.core.roles.edit', ...)"]
)

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = GREEN
r = p.add_run('✅ FIXED — All 3 files corrected locally')
r.font.color.rgb = GREEN

doc.add_page_break()

# ============================================================
# BUG #2: CASE SENSITIVITY
# ============================================================
add_heading('4. Bug #2: Case Sensitivity in EntryPoints Routes (🔴 CRITICAL)')
add_heading('حساسية حالة الأحرف في routes نقاط الدخول', level=2)

add_label('Impact: ', 'EntryPoints pages return 500 Server Error on Linux', True)
add_label('File: ', 'Modules/EntryPoints/Routes/web.php')

doc.add_paragraph(
    'The import statements in EntryPoints routes had incorrect casing that works on Windows '
    '(case-insensitive) but fails on Linux (case-sensitive).'
)
doc.add_paragraph(
    'عبارات الاستيراد في routes نقاط الدخول كانت بأحرف خاطئة تعمل على Windows '
    '(غير حساس لحالة الأحرف) لكن تفشل على Linux (حساس لحالة الأحرف).'
)

add_diff(
    [
        "use Modules\\EntryPoints\\Http\\Controllers\\LandCrossingController;  // uppercase C",
        "use Modules\\EntryPoints\\Http\\Controllers\\SeaPortController;       // uppercase P",
    ],
    [
        "use Modules\\EntryPoints\\Http\\Controllers\\LandcrossingController;  // lowercase c ✅",
        "use Modules\\EntryPoints\\Http\\Controllers\\SeaportController;       // lowercase p ✅",
    ]
)

doc.add_paragraph(
    'Also: EntryPoints controllers use short route names "entrypoints.index" instead of '
    '"dashboard.entrypoints.entrypoints.index" — same pattern as Bug #1.'
)

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = GREEN
r = p.add_run('✅ FIXED — Case sensitivity corrected locally')
r.font.color.rgb = GREEN

doc.add_page_break()

# ============================================================
# BUG #3: MISSING BUTTONS
# ============================================================
add_heading('5. Bug #3: Missing Action Buttons in Companies (🟡 MEDIUM)')
add_heading('أزرار مفقودة (عرض، تعديل، حذف) في صفحة الشركات', level=2)

add_label('Impact: ', 'Show/Edit/Delete buttons not visible for Companies')
add_label('File: ', 'Modules/Transportation/Policies/CompanyPolicy.php')

doc.add_paragraph(
    'The data table component dynamically shows/hides action buttons based on user permissions. '
    'The CompanyPolicy requires "manage_companies" permission, which is not assigned to any role.'
)
doc.add_paragraph(
    'مكون جدول البيانات يعرض/يخفي أزرار الإجراءات بناءً على صلاحيات المستخدم. سياسة الشركات '
    'تتطلب صلاحية "manage_companies" غير المسندة لأي دور.'
)

add_heading('Fix:', level=3)
add_code(
    "php artisan tinker\n"
    ">>> $role = \\Spatie\\Permission\\Models\\Role::findByName('superadmin');\n"
    ">>> $role->givePermissionTo('manage_companies');"
)

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = ORANGE
r = p.add_run('⏳ PENDING — Requires server action')
r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #4: XLSX EXPORT
# ============================================================
add_heading('6. Bug #4: XLSX Export Not Working (🟡 MEDIUM)')
add_heading('تصدير Excel لا يعمل', level=2)

add_label('Impact: ', 'Export to XLSX produces invalid file')
add_label('File: ', 'app/Traits/ExportsData.php')

doc.add_paragraph(
    'The ExportsData trait uses Spatie\\SimpleExcel\\SimpleExcelWriter which relies on '
    'openspout/openspout package. This dependency may be missing on the server.'
)
doc.add_paragraph(
    'خاصية ExportsData تستخدم Spatie SimpleExcel التي تعتمد على حزمة openspout. '
    'هذه التبعية قد تكون مفقودة على السيرفر.'
)

add_heading('Fix:', level=3)
add_code('composer require openspout/openspout')

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = ORANGE
r = p.add_run('⏳ PENDING — Requires server action')
r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #5: MISSING TABLES (ENTRYPOINTS)
# ============================================================
add_heading('7. Bug #5: Missing Database Tables — EntryPoints (🟡 MEDIUM)')
add_heading('جداول قاعدة بيانات مفقودة — نقاط الدخول', level=2)

add_label('Impact: ', 'EntryPoints pages crash with "table not found" errors')

doc.add_paragraph(
    'The entry_points table does not exist on the production server because EntryPoints '
    'module migrations were not run after deployment.'
)
doc.add_paragraph(
    'جدول entry_points غير موجود على سيرفر الإنتاج لأن migrations وحدة نقاط الدخول '
    'لم يتم تشغيلها بعد النشر.'
)

add_heading('Fix:', level=3)
add_code('php artisan migrate --path=Modules/EntryPoints/Database/Migrations')

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = ORANGE
r = p.add_run('⏳ PENDING — Requires server action')
r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# SECTION B HEADER
# ============================================================
sb = doc.add_paragraph()
sb.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = sb.add_run('\n\n\nSECTION B\n')
r.bold = True; r.font.size = Pt(28); r.font.color.rgb = DARK_RED
r = sb.add_run('Transportation Module Full Audit\n')
r.font.size = Pt(20); r.font.color.rgb = GRAY
r = sb.add_run('القسم ب — فحص شامل لوحدة المواصلات\n\n')
r.font.size = Pt(16); r.font.color.rgb = GRAY
r = sb.add_run('103 Files Audited • 8 Bugs Found + 1 Server Config')
r.bold = True; r.font.size = Pt(16); r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #6: WRONG ROUTE NAMES IN CONTROLLERS
# ============================================================
add_heading('8. Bug #6: Wrong Route Names in 5 Controllers (🔴 CRITICAL)')
add_heading('أسماء Routes خاطئة في 5 متحكمات — 30 مرجع خاطئ', level=2)

add_label('Impact: ', 'ALL store/update/destroy operations fail with 500 error', True)

doc.add_paragraph(
    'The routes file (web.php) defines routes with prefix "dashboard.transportation." but 5 out of 6 '
    'controllers use short prefix "transportation." (missing "dashboard."). Only JeepController is correct.'
)
doc.add_paragraph(
    'ملف Routes يعرّف بالبادئة "dashboard.transportation." لكن 5 من 6 متحكمات تستخدم البادئة '
    'المختصرة "transportation." (بدون "dashboard."). فقط JeepController صحيح.'
)

add_heading('Route Definition (web.php):', level=3)
add_code(
    "Route::prefix('dashboard/transportation')\n"
    "    ->name('dashboard.transportation.')  // ← prefix is 'dashboard.transportation.'\n"
    "    ->middleware('auth')\n"
    "    ->group(function () { ... });"
)

add_heading('Affected Controllers:', level=3)

controllers = [
    ('CompanyController.php', 'transportation.companies.index', 'dashboard.transportation.companies.index', '6'),
    ('RouteController.php', 'transportation.routes.index', 'dashboard.transportation.routes.index', '6'),
    ('VehicleTypeController.php', 'transportation.vehicle-types.index', 'dashboard.transportation.vehicle-types.index', '6'),
    ('PricingController.php', 'transportation.pricings.index', 'dashboard.transportation.pricings.index', '6'),
    ('RouteAssignmentController.php', 'transportation.route-assignments.index', 'dashboard.transportation.route-assignments.index', '6'),
]

add_table(
    ['Controller', 'Wrong Route (❌)', 'Correct Route (✅)', 'Count'],
    [[c[0], c[1], c[2], c[3]] for c in controllers]
)

doc.add_paragraph('')
doc.add_paragraph('✅ JeepController.php uses the CORRECT prefix (dashboard.transportation.jeeps.index)')

add_heading('Fix — Apply to ALL 5 controllers:', level=3)
add_diff(
    ["redirect()->route('transportation.companies.index')"],
    ["redirect()->route('dashboard.transportation.companies.index')"]
)

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = ORANGE
r = p.add_run('⏳ PENDING — 30 changes needed in 5 files')
r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #7: dd() DEBUG
# ============================================================
add_heading('9. Bug #7: dd() Debug Statement in Production (🔴 CRITICAL)')
add_heading('كود debug متروك في الإنتاج — يمنع إنشاء الجيبات', level=2)

add_label('File: ', 'Modules/Transportation/Http/Controllers/JeepController.php')
add_label('Line: ', '35')

doc.add_paragraph(
    'The JeepController::store() method contains a dd() (dump and die) statement that BLOCKS '
    'ALL execution when creating a new Jeep. No new Jeep records can be saved.'
)
doc.add_paragraph(
    'دالة store() في JeepController تحتوي على أمر dd() يمنع حفظ أي سجل جيب جديد تماماً. '
    'عند محاولة إنشاء جيب، يتم عرض البيانات ويتوقف التنفيذ فوراً.'
)

add_heading('Current Code (line 35):', level=3)
add_code(
    "public function store(StoreRequest $request)\n"
    "{\n"
    "    $validated = $request->validated();\n"
    "    dd($request->all(), $validated);  // ← BLOCKS ALL EXECUTION!\n"
    "    $validated['created_by'] = getActiveUserId();\n"
    "    // ... rest of code never runs\n"
    "}"
)

add_heading('Fix:', level=3)
add_diff(
    ["    dd($request->all(), $validated);"],
    ["    // REMOVED: dd() debug statement"]
)

add_warn('BLOCKING BUG — NO Jeep records can be created until removed!')

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = ORANGE
r = p.add_run('⏳ PENDING — Delete line 35')
r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #8: WRONG IMPORT
# ============================================================
add_heading('10. Bug #8: Wrong Import Namespace in JeepController (🟡 MEDIUM)')
add_heading('استيراد خاطئ للـ Namespace', level=2)

add_label('File: ', 'Modules/Transportation/Http/Controllers/JeepController.php')
add_label('Lines: ', '9-10')

doc.add_paragraph(
    'JeepController imports StoreRequest and UpdateRequest from the old App namespace instead '
    'of the module namespace.'
)
doc.add_paragraph(
    'يستورد JeepController كلاسات Request من الـ namespace القديم بدل الوحدة.'
)

add_diff(
    ["use App\\Http\\Requests\\Jeep\\StoreRequest;",
     "use App\\Http\\Requests\\Jeep\\UpdateRequest;"],
    ["use Modules\\Transportation\\Http\\Requests\\Jeep\\StoreRequest;",
     "use Modules\\Transportation\\Http\\Requests\\Jeep\\UpdateRequest;"]
)

doc.add_paragraph('Note: Verify module-level request classes exist before changing.')

p = doc.add_paragraph()
r = p.add_run('Status: '); r.bold = True; r.font.color.rgb = ORANGE
r = p.add_run('⏳ PENDING — Verify and fix')
r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #9: API ROUTE OUTSIDE MODULE
# ============================================================
add_heading('11. Bug #9: API Route Defined Outside Module (🟡 MEDIUM)')
add_heading('Route معرف خارج الوحدة', level=2)

add_label('Route: ', 'routes.cities')
add_label('Defined in: ', 'routes/api.php (line 34) — NOT in module')

doc.add_paragraph(
    'The route "routes.cities" is used in 7 Blade view files for city autocompletion '
    'but is defined in main routes/api.php, not inside the Transportation module.'
)

add_heading('Used in:', level=3)
for v in ['routes/create.blade.php (2x)', 'routes/edit.blade.php (1x)',
           'jeeps/create.blade.php (2x)', 'jeeps/edit.blade.php (2x)']:
    doc.add_paragraph(f'  • {v}')

add_heading('Recommendation:', level=3)
doc.add_paragraph('Move to Modules/Transportation/Routes/api.php with proper naming.')

doc.add_page_break()

# ============================================================
# BUG #10: MISSING TABLES (TRANSPORTATION)
# ============================================================
add_heading('12. Bug #10: Missing Database Tables — Transportation (🟡 MEDIUM)')
add_heading('جداول قاعدة بيانات مفقودة — المواصلات', level=2)

doc.add_paragraph(
    'The Transportation module has 8 migration files not run on the production server.'
)

add_table(
    ['Migration', 'Table', 'Purpose'],
    [
        ['2026_02_08_203603', 'companies', 'Transportation companies'],
        ['2026_02_08_203605', 'company_contacts', 'Contact info'],
        ['2026_02_08_203608', 'vehicle_types', 'Vehicle types'],
        ['2026_02_08_203613', 'routes', 'Routes'],
        ['2026_02_08_203621', 'route_assignments', 'Route assignments'],
        ['2026_02_08_203628', 'pricings', 'Pricing'],
        ['2026_02_08_203630', 'jeeps', 'Jeep vehicles'],
        ['2026_02_08_203640', 'jeep_pricing_tables', 'Jeep pricing'],
    ]
)

doc.add_paragraph('')
add_warn(
    'Server error shows "transportations_companies" but migration creates "companies". '
    'Search codebase for old table name references.'
)

add_heading('Fix:', level=3)
add_code('php artisan migrate --path=Modules/Transportation/Database/Migrations')

doc.add_page_break()

# ============================================================
# BUG #11: MISSING PERMISSIONS
# ============================================================
add_heading('13. Bug #11: Missing 7 Permissions for Superadmin (🟡 MEDIUM)')
add_heading('7 صلاحيات مفقودة لدور superadmin', level=2)

add_table(
    ['Policy', 'Permission Required', 'Controls'],
    [
        ['CompanyPolicy', 'manage_companies', 'Companies CRUD'],
        ['CompanyContactPolicy', 'manage_company_contacts', 'Contacts'],
        ['VehicleTypePolicy', 'manage_vehicle_types', 'Vehicle types'],
        ['RoutePolicy', 'manage_routes', 'Routes CRUD'],
        ['RouteAssignmentPolicy', 'manage_route_assignments', 'Assignments'],
        ['PricingPolicy', 'manage_pricings', 'Pricing'],
        ['JeepPolicy', 'manage_jeeps', 'Jeeps CRUD'],
    ]
)

add_heading('Fix:', level=3)
add_code(
    "php artisan tinker\n"
    ">>> $perms = ['manage_companies','manage_company_contacts','manage_vehicle_types',\n"
    "    'manage_routes','manage_route_assignments','manage_pricings','manage_jeeps'];\n"
    ">>> foreach ($perms as $p) { \\Spatie\\Permission\\Models\\Permission::firstOrCreate(['name'=>$p]); }\n"
    ">>> \\Spatie\\Permission\\Models\\Role::findByName('superadmin')->givePermissionTo($perms);"
)

doc.add_page_break()

# ============================================================
# BUG #12: UNUSED CONTROLLER
# ============================================================
add_heading('14. Bug #12: Unused Controller Scaffold (🟢 LOW)')
add_heading('متحكم غير مستخدم', level=2)

add_label('File: ', 'Modules/Transportation/Http/Controllers/TransportationController.php')

doc.add_paragraph(
    'Auto-generated scaffold controller with empty methods. Not used by any route. Delete it.'
)

add_heading('Fix:', level=3)
add_code('Delete: Modules/Transportation/Http/Controllers/TransportationController.php')

# ============================================================
# BUG #13: TABLE NAME CONFLICT
# ============================================================
add_heading('15. Bug #13: Table Name Conflict Risk (🟢 LOW)')
add_heading('تعارض محتمل في أسماء الجداول', level=2)

doc.add_paragraph(
    'The Company model has no explicit $table property and relies on Laravel auto-detection '
    '("companies"). But server errors reference "transportations_companies". This suggests '
    'old code or a previous migration version may still reference the old name.'
)

add_heading('Fix:', level=3)
doc.add_paragraph('Search entire codebase for "transportations_companies" and update references.')

doc.add_page_break()

# ============================================================
# SECTION C HEADER
# ============================================================
sc = doc.add_paragraph()
sc.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = sc.add_run('\n\n\nSECTION C\n')
r.bold = True; r.font.size = Pt(28); r.font.color.rgb = DARK_RED
r = sc.add_run('Server Configuration Issues\n')
r.font.size = Pt(20); r.font.color.rgb = GRAY
r = sc.add_run('القسم ج — مشاكل إعدادات السيرفر\n\n')
r.font.size = Pt(16); r.font.color.rgb = GRAY
r = sc.add_run('1 Critical Bug Found from Server Logs')
r.bold = True; r.font.size = Pt(16); r.font.color.rgb = ORANGE

doc.add_page_break()

# ============================================================
# BUG #14: MYSQL STRICT MODE / GROUP BY
# ============================================================
add_heading('16. Bug #14: MySQL Strict Mode / GROUP BY Error (🔴 CRITICAL)')
add_heading('وضع MySQL الصارم — خطأ GROUP BY يمنع تحميل الصفحات', level=2)

add_label('Impact: ', 'Pages with relational data return 500 Server Error', True)
add_label('File: ', 'config/database.php (line 58)')
add_label('Server Log: ', 'storage/logs/laravel-2026-02-14.log')

doc.add_paragraph(
    'This bug was discovered from the production server error logs. When loading pages like '
    '/dashboard/transportation/companies, the server returns 500 because MySQL rejects '
    'the query generated by Laravel\'s search system.'
)
doc.add_paragraph(
    'تم اكتشاف هذا الخطأ من سجلات أخطاء السيرفر. عند تحميل صفحات مثل '
    '/dashboard/transportation/companies، السيرفر يرجع 500 لأن MySQL يرفض '
    'الاستعلام الذي ينشئه نظام البحث في Laravel.'
)

add_heading('Server Error Log:', level=3)
add_code(
    'SQLSTATE[42000]: Syntax error or access violation: 1055\n'
    'Expression #1 of SELECT list is not in GROUP BY clause\n'
    'and contains nonaggregated column...\n'
    'this is incompatible with sql_mode=only_full_group_by\n\n'
    'SQL: select * from companies group by name'
)

add_heading('What is ONLY_FULL_GROUP_BY?', level=3)
doc.add_paragraph(
    'MySQL 5.7+ enables ONLY_FULL_GROUP_BY by default. This means when you use GROUP BY, '
    'every column in SELECT must either be in the GROUP BY clause or inside an aggregate '
    'function (COUNT, SUM, etc). Using "SELECT * ... GROUP BY name" violates this rule '
    'because * includes columns NOT in the GROUP BY.'
)
doc.add_paragraph(
    'MySQL 5.7+ يفعّل وضع ONLY_FULL_GROUP_BY تلقائياً. هذا يعني عند استخدام GROUP BY، '
    'كل عمود في SELECT يجب أن يكون في GROUP BY أو داخل دالة تجميع. '
    'استخدام "SELECT * ... GROUP BY name" يخالف هذه القاعدة.'
)

add_heading('Why it works locally but fails on server:', level=3)
doc.add_paragraph(
    '• Local development uses SQLite — which does NOT enforce GROUP BY rules\n'
    '• Production server uses MySQL 5.7+ with strict mode enabled\n'
    '• The HasSearch trait uses orWhereHas() which can trigger implicit GROUP BY\n'
    '• config/database.php line 58: strict => true (enables ONLY_FULL_GROUP_BY)'
)
doc.add_paragraph(
    '• التطوير المحلي يستخدم SQLite — لا يفرض قواعد GROUP BY\n'
    '• سيرفر الإنتاج يستخدم MySQL 5.7+ مع الوضع الصارم مفعّل\n'
    '• خاصية HasSearch تستخدم orWhereHas() التي قد تنتج GROUP BY ضمني\n'
    '• config/database.php سطر 58: strict => true (تفعّل ONLY_FULL_GROUP_BY)'
)

add_heading('Fix (Option 1 — Quick Fix):', level=3)
doc.add_paragraph('Change strict mode to false in config/database.php:')
add_diff(
    ["    'strict' => true,"],
    ["    'strict' => false,"]
)
add_warn('This disables ALL MySQL strict mode checks. It fixes the immediate issue but reduces data integrity enforcement.')

add_heading('Fix (Option 2 — Precise Fix):', level=3)
doc.add_paragraph('Keep strict mode but disable only ONLY_FULL_GROUP_BY:')
add_code(
    "// In config/database.php, mysql connection:\n"
    "'strict' => true,\n"
    "'modes' => [\n"
    "    'STRICT_TRANS_TABLES',\n"
    "    'NO_ZERO_IN_DATE',\n"
    "    'NO_ZERO_DATE',\n"
    "    'ERROR_FOR_DIVISION_BY_ZERO',\n"
    "    'NO_ENGINE_SUBSTITUTION',\n"
    "    // ONLY_FULL_GROUP_BY removed from this list\n"
    "],"
)

add_heading('Fix (Option 3 — Best Practice):', level=3)
doc.add_paragraph(
    'Modify the HasSearch trait to avoid GROUP BY conflicts. '
    'Use subqueries instead of orWhereHas, or add ->select() with specific columns '
    'before any groupBy operation.'
)

p = doc.add_paragraph()
r = p.add_run('Recommended: '); r.bold = True; r.font.color.rgb = GREEN
r = p.add_run('Option 2 (Precise Fix) — keeps most strict checks while fixing the issue')
r.font.color.rgb = GREEN

doc.add_page_break()

# ============================================================
# 17. MODULE STRUCTURE
# ============================================================
add_heading('17. Transportation Module Structure Overview')

add_table(
    ['Component', 'Count', 'Details'],
    [
        ['Controllers', '7 (1 unused)', 'Company, Jeep, Pricing, Route, RouteAssignment, VehicleType + unused scaffold'],
        ['Entities', '9', 'Company, CompanyContact, Jeep, JeepSeason, JeepSeasonNationalityPrice, Pricing, Route, RouteAssignment, VehicleType'],
        ['Livewire', '8', 'Companies, Jeeps, Pricings, PricingSteps, Routes, RouteAssignment(s), VehicleTypes'],
        ['Policies', '7', 'One per entity'],
        ['Views', '47', 'CRUD + Livewire + import'],
        ['Migrations', '8', 'One per table'],
        ['Requests', '10', '2 per entity (5 entities); Jeep uses App-level'],
        ['Seeders', '4', 'Company, Jeep, Route, TransportationDB'],
    ]
)

doc.add_page_break()

# ============================================================
# 18. VIEWS VS CONTROLLERS COMPARISON
# ============================================================
add_heading('18. Views vs Controllers — Route Naming Comparison')
add_heading('مقارنة أسماء Routes بين الواجهات والمتحكمات', level=2)

doc.add_paragraph('Key Finding:')
doc.add_paragraph('• Blade views use CORRECT routes (dashboard.transportation.X) ✅')
doc.add_paragraph('• Controllers use WRONG routes (transportation.X) ❌')
doc.add_paragraph('')
doc.add_paragraph('This means:')
doc.add_paragraph('• ✅ Page links/navigation works (generated by views)')
doc.add_paragraph('• ❌ Redirects after save/update/delete FAIL (generated by controllers)')
doc.add_paragraph('• Users can browse pages but cannot perform any data operations')
doc.add_paragraph('')
doc.add_paragraph(
    'المستخدمين يمكنهم التنقل بين الصفحات لكن لا يمكنهم حفظ أو تعديل أو حذف أي بيانات.'
)

doc.add_page_break()

# ============================================================
# 19. COMPLETE FIX CHECKLIST
# ============================================================
add_heading('19. Complete Fix Checklist / قائمة الإصلاحات الكاملة')

add_heading('✅ Already Fixed Locally (upload to server):', level=3)
doc.add_paragraph('□ RoleController.php — route names corrected')
doc.add_paragraph('□ roles/show.blade.php — route names corrected')
doc.add_paragraph('□ livewire/roles1.blade.php — route names corrected')
doc.add_paragraph('□ EntryPoints/Routes/web.php — case sensitivity fixed')

doc.add_paragraph('')

add_heading('⏳ Pending Code Fixes:', level=3)
doc.add_paragraph('□ CompanyController.php — fix 6 route names')
doc.add_paragraph('□ RouteController.php — fix 6 route names')
doc.add_paragraph('□ VehicleTypeController.php — fix 6 route names')
doc.add_paragraph('□ PricingController.php — fix 6 route names')
doc.add_paragraph('□ RouteAssignmentController.php — fix 6 route names')
doc.add_paragraph('□ JeepController.php — remove dd() on line 35')
doc.add_paragraph('□ JeepController.php — fix import namespace (verify first)')
doc.add_paragraph('□ Delete TransportationController.php (unused)')

doc.add_paragraph('')

add_heading('⏳ Server Actions Required:', level=3)
doc.add_paragraph('□ Run: php artisan migrate --path=Modules/EntryPoints/Database/Migrations')
doc.add_paragraph('□ Run: php artisan migrate --path=Modules/Transportation/Database/Migrations')
doc.add_paragraph('□ Run: composer require openspout/openspout')
doc.add_paragraph('□ Create & assign 7 permissions to superadmin (see Bug #11)')
doc.add_paragraph('□ Fix MySQL strict mode: add modes array to config/database.php (see Bug #14)')
doc.add_paragraph('□ Run: php artisan optimize:clear')
doc.add_paragraph('□ Search for "transportations_companies" references')

doc.add_page_break()

# ============================================================
# SECTION D: SERVER OPERATIONS
# ============================================================
p = doc.add_paragraph()
r = p.add_run('— SECTION D: Server Operations (1 Bug) —')
r.bold = True; r.font.color.rgb = DARK_RED; r.font.size = Pt(14)

doc.add_paragraph('')

# Bug #15
add_heading('17. Bug #15: Missing Laravel Cron Job / Scheduler', level=2)
add_heading('عدم وجود مهام مجدولة (Cron Job) على الخادم', level=2)

add_label('Impact: ', 'Laravel Scheduler not running — background jobs, session cleanup, and notifications disabled', True)
add_label('Environment: ', 'Production Server (mixjo.top)')
add_label('Severity: ', '🔴 CRITICAL')

doc.add_paragraph('')
add_heading('What is a Cron Job? / ما هو الـ Cron Job؟', level=3)

doc.add_paragraph(
    'A Cron Job is a scheduled task that runs automatically at defined intervals on the server. '
    'Laravel requires a Cron Job to execute its Task Scheduler, which handles:\n'
    '• Session cleanup (removing expired user sessions)\n'
    '• Cache management (clearing old cached data)\n'
    '• Notification dispatch (sending queued emails/notifications)\n'
    '• Backup execution (if configured)\n'
    '• Log rotation and cleanup\n\n'
    'الـ Cron Job هو مهمة مجدولة تعمل تلقائياً على الخادم. Laravel يحتاج Cron Job لتشغيل:\n'
    '• تنظيف الجلسات المنتهية\n'
    '• إدارة الكاش\n'
    '• إرسال الإشعارات المجدولة\n'
    '• تنفيذ النسخ الاحتياطي\n'
    '• تنظيف وأرشفة السجلات'
)

doc.add_paragraph('')
add_heading('Current Status / الحالة الحالية', level=3)

add_warn('⚠ Server Terminal Output: "no crontab for mixtop" — No cron jobs exist!')
add_warn('⚠ مخرجات Terminal: "no crontab for mixtop" — لا توجد أي مهام مجدولة!')

doc.add_paragraph('')
add_heading('Fix Required / الإصلاح المطلوب', level=3)

doc.add_paragraph('Go to cPanel → Cron Jobs → Add New Cron Job:')
doc.add_paragraph('اذهب إلى cPanel → Cron Jobs → أضف Cron Job جديد:')

doc.add_paragraph('')
add_label('Frequency: ', 'Every Minute (Once Per Minute) / كل دقيقة')
add_label('Command: ', '')
add_code('* * * * * cd /home/mixtop/project_root && php artisan schedule:run >> /dev/null 2>&1')

doc.add_paragraph('')
add_heading('Steps in cPanel / الخطوات في cPanel:', level=3)

steps = [
    'Login to cPanel at https://mixjo.top:2083/',
    'Search for "Cron Jobs" in the search bar',
    'Under "Add New Cron Job", set timing to: * * * * * (every minute)',
    'In the Command field, paste: cd /home/mixtop/project_root && php artisan schedule:run >> /dev/null 2>&1',
    'Click "Add New Cron Job"',
    'Verify by running: crontab -l (should show the new job)',
]

for i, step in enumerate(steps, 1):
    add_bullet(step, bold_prefix=f'Step {i}: ')

doc.add_paragraph('')
add_warn('Without this Cron Job, any scheduled tasks defined in app/Console/Kernel.php will NOT execute.')
add_warn('بدون هذا الـ Cron Job، أي مهام مجدولة معرّفة في app/Console/Kernel.php لن تعمل.')

doc.add_page_break()

# ============================================================
# 21. RECOMMENDATIONS
# ============================================================
add_heading('21. General Recommendations / التوصيات العامة')

recs = [
    ('1. Consistent Route Naming',
     'ALL module routes must use: dashboard.{module}.{resource}.{action}. '
     'Create a checklist for code review.'),
    ('2. Module Migration Script',
     'Create deployment script: php artisan module:migrate Transportation'),
    ('3. Permission Seeder',
     'Create TransportationSeeder that auto-creates all 7 permissions and assigns to superadmin.'),
    ('4. Remove Debug Statements',
     'Add CI/CD check scanning for dd(), dump(), var_dump() before deployment.'),
    ('5. Linux Testing',
     'Test on Linux (Docker/WSL) before deploying to catch case-sensitivity issues.'),
    ('6. Post-Conversion Checklist',
     'After converting any section to a module:\n'
     '  1. All route names use full prefix\n'
     '  2. All imports use module namespace\n'
     '  3. Migrations run on server\n'
     '  4. Permissions created and assigned\n'
     '  5. No debug statements left\n'
     '  6. Table names consistent'),
]

for title, desc in recs:
    add_heading(title, level=3)
    doc.add_paragraph(desc)

# ============================================================
# SAVE
# ============================================================
output_dir = r'G:\Report Mixjo Top\technical_report'
os.makedirs(output_dir, exist_ok=True)
output_path = os.path.join(output_dir, 'Full_Technical_Audit_Report_All_Modules.docx')
doc.save(output_path)

print(f'\n=== Unified Report Created Successfully! ===')
print(f'File: {output_path}')
print(f'Contains: 15 bugs across 3 modules (Core, EntryPoints, Transportation) + Server Config + Server Ops')
print('Done!')
