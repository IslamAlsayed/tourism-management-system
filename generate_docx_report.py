# -*- coding: utf-8 -*-
from docx.api import Document
from docx.shared import Pt, RGBColor, Mm
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.enum.section import WD_ORIENT
from docx.oxml.ns import qn
from docx.oxml import OxmlElement
import os

FONT_NAME = 'Arial'

doc = Document()

# Set Landscape Orientation
section = doc.sections[0]
section.orientation = WD_ORIENT.LANDSCAPE
new_width, new_height = section.page_height, section.page_width
section.page_width = new_width
section.page_height = new_height
section.left_margin = Mm(15)
section.right_margin = Mm(15)
section.top_margin = Mm(15)
section.bottom_margin = Mm(15)

# Simple font setup - matching working test_arabic.docx approach
style = doc.styles['Normal']
style.font.size = Pt(11)
style.font.name = FONT_NAME

def set_run_font(run, size=None):
    """Set font on a run - simple approach that works with Arabic."""
    run.font.name = FONT_NAME
    if size:
        run.font.size = size

def set_cell_shading(cell, color):
    shading = OxmlElement('w:shd')
    shading.set(qn('w:fill'), color)
    shading.set(qn('w:val'), 'clear')
    cell._tc.get_or_add_tcPr().append(shading)

def set_heading_font(heading):
    """Fix font on heading runs for Arabic support."""
    for run in heading.runs:
        set_run_font(run)

def add_table(doc, headers, rows):
    # Create table with enough rows
    table = doc.add_table(rows=1+len(rows), cols=len(headers))
    
    # Autofit Window / Page Width (100% width)
    tbl = table._tbl
    tblPr = tbl.tblPr
    tblW = OxmlElement('w:tblW')
    tblW.set(qn('w:w'), '5000') # 5000 pct = 100%
    tblW.set(qn('w:type'), 'pct')
    if tblPr.find(qn('w:tblW')) is not None:
        tblPr.remove(tblPr.find(qn('w:tblW')))
    tblPr.append(tblW)
    
    table.style = 'Table Grid'
    table.alignment = WD_TABLE_ALIGNMENT.CENTER
    table.autofit = False 
    
    # Header
    for i, header in enumerate(headers):
        cell = table.rows[0].cells[i]
        cell.text = header
        for p in cell.paragraphs:
            p.alignment = WD_ALIGN_PARAGRAPH.CENTER
            for run in p.runs:
                run.bold = True
                run.font.color.rgb = RGBColor(255, 255, 255)
                set_run_font(run, Pt(9))
        set_cell_shading(cell, '2E86C1')
    
    # Data
    for r, row_data in enumerate(rows):
        for c, val in enumerate(row_data):
            cell = table.rows[r+1].cells[c]
            cell.text = str(val)
            for p in cell.paragraphs:
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER
                for run in p.runs:
                    set_run_font(run, Pt(9))
            
            # Color coding for status
            val_str = str(val).strip().upper()
            if '500' in val_str or 'FAIL' in val_str or 'CSRF' in val_str or 'TIMEOUT' in val_str:
                set_cell_shading(cell, 'FADBD8') # Light red
            elif 'WARN' in val_str:
                set_cell_shading(cell, 'FCF3CF') # Light yellow
            elif val_str == 'OK' or val_str == 'OK - CREATED' or val_str == 'OK - UPDATED':
                set_cell_shading(cell, 'D5F5E3') # Light green
            elif 'NOT TESTED' in val_str:
                set_cell_shading(cell, 'D5DBDB') # Grey
            elif r % 2 == 0:
                set_cell_shading(cell, 'F2F3F4') # Alternating row color
    doc.add_paragraph()
    return table

def add_broken_warning(doc, text):
    p = doc.add_paragraph()
    run = p.add_run(text)
    run.bold = True
    run.font.color.rgb = RGBColor(192, 57, 43)
    set_run_font(run, Pt(12))

def add_arabic_desc(doc, text):
    p = doc.add_paragraph()
    run = p.add_run(text)
    run.font.color.rgb = RGBColor(44, 62, 80)
    # NOTE: Do NOT use italic - Arial italic has no Arabic glyphs
    set_run_font(run, Pt(10))

# ==================== TITLE ====================
title = doc.add_heading('Full Audit Report - mixjo.top', level=0)
title.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_heading_font(title)
subtitle = doc.add_paragraph()
subtitle.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = subtitle.add_run('Comprehensive Website Testing Report for Mr. Islam')
run.font.color.rgb = RGBColor(44, 62, 80)
set_run_font(run, Pt(14))

info = doc.add_paragraph()
info.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = info.add_run('Date: 2026-02-13 | Modules: 14 | Pages Tested: 93 | Errors Found: 43')
run.font.color.rgb = RGBColor(127, 140, 141)
set_run_font(run, Pt(10))

note = doc.add_paragraph()
note.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = note.add_run('Sections ordered exactly as they appear in the Dashboard Sidebar (config/sidebar.php)')
run.bold = True
run.font.color.rgb = RGBColor(41, 128, 185)
set_run_font(run, Pt(10))

# Legend
doc.add_paragraph()
legend = doc.add_heading('Color Legend / دليل الألوان', level=2)
set_heading_font(legend)
legend_table = doc.add_table(rows=5, cols=2)
legend_table.style = 'Table Grid'
legend_data = [
    ('ABEBC6', 'OK / Works = Green / أخضر'),
    ('F9E79F', 'FAIL = Yellow / أصفر'),
    ('F1948A', '500 / 419 / 404 / Timeout = Red / أحمر'),
    ('FAD7A0', 'WARNING = Orange / برتقالي'),
    ('D5DBDB', 'NOT TESTED = Grey / رمادي'),
]
for i, (color, text) in enumerate(legend_data):
    set_cell_shading(legend_table.rows[i].cells[0], color)
    legend_table.rows[i].cells[0].text = ''
    cell1 = legend_table.rows[i].cells[1]
    cell1.text = ''
    p = cell1.paragraphs[0]
    run = p.add_run(text)
    set_run_font(run, Pt(10))

doc.add_paragraph()

# ==================== EXECUTIVE SUMMARY ====================
h = doc.add_heading('Executive Summary / الملخص التنفيذي', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'ملخص شامل لنتائج الفحص على جميع أقسام الموقع. يعرض عدد الصفحات المفحوصة والأخطاء المكتشفة.')

add_table(doc,
    ['Item / البند', 'Value / القيمة'],
    [
        ['Total Pages Tested / عدد الصفحات المفحوصة', '93'],
        ['Pages Working (OK) / صفحات تعمل', '44'],
        ['Pages with Warnings / صفحات بتحذيرات', '7'],
        ['Pages with 500 Errors / صفحات بخطأ 500', '21'],
        ['Save/Update 500 Errors / أخطاء 500 عند الحفظ', '8'],
        ['Pages with 404 Errors / صفحات غير موجودة', '0'],
        ['Pages with Timeout / صفحات لا تستجيب', '2'],
        ['Pages with 419 CSRF / صفحات بخطأ CSRF', '0'],
        ['Other FAIL Pages / صفحات معطلة أخرى', '6'],
        ['Not Tested / لم تُفحص', '5'],
        ['Completely Broken Modules / أقسام معطلة بالكامل', '1 (Localization)'],
    ])

p = doc.add_paragraph()
run = p.add_run('CRITICAL / اكتشاف حرج: ')
run.bold = True
run.font.color.rgb = RGBColor(192, 57, 43)
set_run_font(run)
run = p.add_run('www.mixjo.top returns 500 Error while mixjo.top (without www) works. Fix DNS/Apache.')
set_run_font(run)
p2 = doc.add_paragraph()
run2 = p2.add_run('www.mixjo.top يعطي خطأ 500 بينما mixjo.top بدون www يعمل بشكل طبيعي. يجب إصلاح إعدادات DNS/Apache.')
run2.font.color.rgb = RGBColor(192, 57, 43)
set_run_font(run2)

doc.add_page_break()

# ==================== DETAILED BREAKDOWN / تفصيل الأخطاء ====================
h = doc.add_heading('Detailed Error Breakdown / تفصيل الأخطاء', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'فيما يلي قوائم مفصلة بالصفحات التي تحتوي على أخطاء حسب نوع الخطأ.')

# 1. Pages with Warnings (7)
h = doc.add_heading('1. Pages with Warnings / صفحات بتحذيرات (7)', level=2)
set_heading_font(h)
add_table(doc, ['Page Name / اسم الصفحة', 'Link / الرابط', 'Issue / المشكلة'], [
    ['Transportation Companies', 'https://mixjo.top/dashboard/transportation/companies', 'Edit/View buttons missing in table'],
    ['Vehicle Types', 'https://mixjo.top/dashboard/transportation/vehicle-types', 'Edit/View buttons missing in table'],
    ['Tourist Sites', 'https://mixjo.top/dashboard/tourists/sites', 'Edit/View buttons missing in table'],
    ['CRM Clients Create', 'https://mixjo.top/dashboard/crm/clients/create', 'Form loads but might need validation'],
    ['Users List', 'https://mixjo.top/dashboard/core/users', 'Column labels truncated'],
    ['Pricing Definitions', 'https://mixjo.top/dashboard/core/pricing-definitions', 'Cannot edit after creation'],
    ['Nationalities', 'https://mixjo.top/dashboard/geography/nationalities', 'Cannot edit after creation'],
])

# 2. Pages with 500 Errors (21)
h = doc.add_heading('2. Pages with 500 Errors / صفحات بخطأ 500 (21)', level=2)
set_heading_font(h)
add_table(doc, ['Page Name / اسم الصفحة', 'Link / الرابط', 'Error Cause / سبب الخطأ'], [
    ['Core Users Create', 'https://mixjo.top/dashboard/core/users/create', 'Route [users.index] not defined'],
    ['Core Users View', 'https://mixjo.top/dashboard/core/users/{id}', 'Route [users.edit] not defined'],
    ['Core Users Edit', 'https://mixjo.top/dashboard/core/users/{id}/edit', 'Route [users.index] not defined'],
    ['Core Roles Create', 'https://mixjo.top/dashboard/core/roles/create', 'Route [roles.index] not defined'],
    ['Core Roles Edit', 'https://mixjo.top/dashboard/core/roles/{id}/edit', 'Route [roles.index] not defined'],
    ['Core Permissions Create', 'https://mixjo.top/dashboard/core/permissions/create', 'Route [permissions.index] not defined'],
    ['Core Permissions Edit', 'https://mixjo.top/dashboard/core/permissions/{id}/edit', 'Route [permissions.index] not defined'],
    ['Regions View', 'https://mixjo.top/dashboard/geography/regions/{id}', 'Route [regions.edit] not defined'],
    ['Subregions View', 'https://mixjo.top/dashboard/geography/subregions/{id}', 'Route [subregions.edit] not defined'],
    ['Countries View', 'https://mixjo.top/dashboard/geography/countries/{id}', 'Missing parameter: subregion'],
    ['Languages', 'https://mixjo.top/dashboard/localization/languages', 'Route [languages.create] not defined'],
    ['System Languages', 'https://mixjo.top/dashboard/localization/system-languages', 'Route [system-languages.create] not defined'],
    ['Currencies', 'https://mixjo.top/dashboard/localization/currencies', 'Route [currencies.create] not defined'],
    ['Timezones', 'https://mixjo.top/dashboard/localization/timezones', 'Route [dashboard.core.timezones.create] not defined'],
    ['Restaurants List', 'https://mixjo.top/dashboard/restaurants', 'Server Error'],
    ['Transport Company View', 'https://mixjo.top/dashboard/transportation/companies/{id}', 'Server Error'],
    ['Transport Pricings', 'https://mixjo.top/dashboard/transportation/pricings', 'Component [core::pricings] not found'],
    ['Visa Req Create', 'https://mixjo.top/dashboard/traveldocuments/visa-requirements/create', 'Server Error'],
    ['Land Crossings', 'https://mixjo.top/dashboard/entrypoints/land-crossings', 'Class "App\\Models\\EntryPoint" not found'],
    ['Sea Ports', 'https://mixjo.top/dashboard/entrypoints/seaports', 'SeaPortController does not exist'],
    ['Airlines List', 'https://mixjo.top/dashboard/airlines', 'Server Error'],
])

# 3. Save/Update 500 Errors (8)
h = doc.add_heading('3. Save/Update 500 Errors / أخطاء 500 عند الحفظ (8)', level=2)
set_heading_font(h)
add_table(doc, ['Action / الإجراء', 'Link / الرابط', 'Issue / المشكلة'], [
    ['Save Transport Company', 'https://mixjo.top/dashboard/transportation/companies/create', '500 Error on form submit'],
    ['Update Transport Company', 'https://mixjo.top/dashboard/transportation/companies/{id}/edit', '500 Error on form submit'],
    ['Save Vehicle Type', 'https://mixjo.top/dashboard/transportation/vehicle-types/create', '500 Error on form submit'],
    ['Save Jeep Safari', 'https://mixjo.top/dashboard/transportation/jeeps/create', '500 Error on form submit'],
    ['Save Route', 'https://mixjo.top/dashboard/transportation/routes/create', '500 Error on form submit'],
    ['Update Route', 'https://mixjo.top/dashboard/transportation/routes/{id}/edit', '500 Error on form submit'],
    ['Save Route Assignment', 'https://mixjo.top/dashboard/transportation/route-assignments/create', '500 Error on form submit'],
    ['Save Travel Pass', 'https://mixjo.top/dashboard/traveldocuments/travel-passes/create', '500 Error on form submit'],
])

# 4. Pages with Timeout (2)
h = doc.add_heading('4. Pages with Timeout / صفحات لا تستجيب (2)', level=2)
set_heading_font(h)
add_table(doc, ['Page Name / اسم الصفحة', 'Link / الرابط', 'Issue / المشكلة'], [
    ['States List', 'https://mixjo.top/dashboard/geography/states', 'Too much data / يحتاج Pagination'],
    ['Cities List', 'https://mixjo.top/dashboard/geography/cities', 'Too much data / يحتاج Pagination'],
])

# 5. Other FAIL Pages (6)
h = doc.add_heading('5. Other FAIL Pages / صفحات معطلة أخرى (6)', level=2)
set_heading_font(h)
add_table(doc, ['Page Name / اسم الصفحة', 'Link / الرابط', 'Issue / المشكلة'], [
    ['Regions Import', 'https://mixjo.top/dashboard/geography/regions', 'Import button reloads page'],
    ['Accommodations Types', 'Sidebar Link', '"Not Found Accommodation" error'],
    ['Accommodations Rooms', 'Sidebar Link', '"Not Found Accommodation" error'],
    ['Accommodations Seasons', 'Sidebar Link', '"Not Found Accommodation" error'],
    ['Accommodations Meals', 'Sidebar Link', '"Not Found Accommodation" error'],
    ['Accommodations Supplements', 'Sidebar Link', '"Not Found Accommodation" error'],
])

# 6. Not Tested (5)
h = doc.add_heading('6. Not Tested / لم تُفحص (5)', level=2)
set_heading_font(h)
add_table(doc, ['Page Name / اسم الصفحة', 'Link / الرابط', 'Reason / السبب'], [
    ['User Reports', 'https://mixjo.top/dashboard/core/reports/users', 'Link exists but not tested'],
    ['Location Reports', 'https://mixjo.top/dashboard/core/reports/locations', 'Link exists but not tested'],
    ['Detailed Analytics', 'https://mixjo.top/dashboard/core/reports/analytics', 'Link exists but not tested'],
    ['Transportation Seasons', 'Shared', 'Shared component - not tested separately'],
    ['Transportation Supplements', 'Shared', 'Shared component - not tested separately'],
])

doc.add_page_break()

# ==================== WARNING: CRITICAL ISSUES ====================
h = doc.add_heading('Columns Dropdown Issues / مشاكل قائمة الأعمدة', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'عند الضغط على زر "Columns" في صفحات القوائم، تظهر أسماء بعض الأعمدة مقطوعة أو تحتوي على الحرف "R" الأحمر للإشارة إلى العلاقات. هذا يُربك المستخدم ويجب إصلاحه.')

add_table(doc,
    ['Page / الصفحة', 'Truncated Labels / أسماء مقطوعة', 'Red "R" Suffix / علامة R الحمراء', 'Notes / ملاحظات'],
    [
        ['Users / المستخدمين', 'Password Change..., Button Display...', 'Timezone R, Creator R', 'WARN - Labels cut off'],
        ['Regions / الأقاليم', 'None / لا يوجد', 'None / لا يوجد', 'OK - All labels complete'],
        ['Transportation Companies', 'None / لا يوجد', 'Currency R, Country R', 'WARN - R suffix confusing'],
        ['CRM Clients / العملاء', 'Passport Issue..., Passport Expiry..., Work Phone Exte..., Business Regist...', 'None / لا يوجد', 'FAIL - Multiple labels cut off'],
        ['Tourist Sites / المواقع', 'Entry Fee (Adul..., Entry Fee (Chil..., Entry Fee (Stud...', 'None / لا يوجد', 'FAIL - Price columns cut off'],
    ])

doc.add_page_break()

# ==================== 1. LOGIN ====================
h = doc.add_heading('1. Login / تسجيل الدخول', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'صفحات تسجيل الدخول والتسجيل. تعمل بشكل عام لكن رسائل النجاح لا تظهر بسبب دالة JavaScript غير معرفة.')

add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Notes / ملاحظات'],
    [
        ['Login', '/login', 'OK', 'Sign In, Register, Forgot Password', '-', 'OK', 'showToastSuccessMessage() undefined'],
        ['Register', '/register', 'OK', 'Register, Sign In', '-', 'OK', 'Same toast issue / نفس المشكلة'],
    ])

# ==================== 2. CORE ====================
h = doc.add_heading('2. Core Module / النظام الأساسي', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على إدارة المستخدمين والأدوار والصلاحيات وتعريفات الأسعار وسجل النشاط والإعدادات والملف الشخصي. معظم صفحات القوائم تعمل لكن صفحات الإنشاء والتعديل والعرض تعطي خطأ 500 بسبب أسماء الروابط الخاطئة.')

h = doc.add_heading('2.1 Users / المستخدمين', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Error / سبب الخطأ'],
    [
        ['List / القائمة', '/core/users', 'OK', 'Create User, Import CSV/Excel, Show, Edit, Delete', '-', 'OK', '-'],
        ['Create / إنشاء', '/core/users/create', '500', '-', '-', 'FAIL', 'Route [users.index] not defined'],
        ['View / عرض', '/core/users/{id}', '500', '-', '-', 'FAIL', 'Route [users.edit] not defined'],
        ['Edit / تعديل', '/core/users/{id}/edit', '500', '-', '-', 'FAIL', 'Route [users.index] not defined'],
    ])

h = doc.add_heading('2.2 Roles & Permissions / الأدوار والصلاحيات', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Error / سبب الخطأ'],
    [
        ['Roles List / الأدوار', '/core/roles', 'OK', 'Create Role, Edit, Delete', 'Show/View', 'OK', '-'],
        ['Create Role / إنشاء دور', '/core/roles/create', '500', '-', '-', 'FAIL', 'Route [roles.index] not defined'],
        ['Edit Role / تعديل دور', '/core/roles/{id}/edit', '500', '-', '-', 'FAIL', 'Route [roles.index] not defined'],
        ['Permissions List / الصلاحيات', '/core/permissions', 'OK', 'Create Permission, Edit, Delete', 'Show/View', 'OK', '-'],
        ['Create Permission', '/core/permissions/create', '500', '-', '-', 'FAIL', 'Route [permissions.index] not defined'],
        ['Edit Permission', '/core/permissions/{id}/edit', '500', '-', '-', 'FAIL', 'Route [permissions.index] not defined'],
    ])

h = doc.add_heading('2.3 Reports & Analytics / التقارير والتحليلات', level=2)
set_heading_font(h)
add_arabic_desc(doc, 'قسم التقارير والتحليلات موجود في القائمة الجانبية. لم يتم فحصه بعد.')
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['Reports Dashboard / لوحة التقارير', '/core/reports', 'OK', 'View Reports', '-', 'OK', 'Page loads / الصفحة تفتح'],
        ['User Reports', '/core/reports/users', 'NOT TESTED', '-', '-', 'NOT TESTED', '-'],
        ['Location Reports', '/core/reports/locations', 'NOT TESTED', '-', '-', 'NOT TESTED', '-'],
        ['Detailed Analytics', '/core/reports/analytics', 'NOT TESTED', '-', '-', 'NOT TESTED', '-'],
    ])

h = doc.add_heading('2.4 Pricing Definitions / تعريفات الأسعار', level=2)
set_heading_font(h)
add_arabic_desc(doc, 'تعريفات الأسعار. صفحة الإنشاء تعمل لكن لا يوجد أزرار تعديل أو عرض في الجدول.')
add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Notes / ملاحظات'],
    [
        ['List / القائمة', '/core/pricing-definitions', 'OK', 'Create Pricing Definition, Is Active Toggle', 'Edit, View', 'WARN', 'Cannot edit after creation / لا يمكن التعديل بعد الإنشاء'],
        ['Create / إنشاء', '/core/pricing-definitions/create', 'OK', 'Save', '-', 'OK', '-'],
    ])

h = doc.add_heading('2.5 Activity Log / سجل النشاط', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['All Activities', '/core/activity-log', 'OK', 'Search, Filter, View', '-', 'OK', '122 errors logged / 122 خطأ مسجل'],
    ])

h = doc.add_heading('2.6 Profile / الملف الشخصي', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['View Profile', '/core/profile', 'OK', 'Account Settings, View Profile, Update Photo', '-', 'OK', '-'],
    ])

h = doc.add_heading('2.7 Settings / الإعدادات', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['General', '/core/settings/general', 'OK', 'Save Changes, Add Timezone, Upload', '-', 'OK', '-'],
    ])

doc.add_page_break()

# ==================== 3. GEOGRAPHY ====================
h = doc.add_heading('3. Geography Module / الجغرافيا', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على إدارة الأقاليم والأقاليم الفرعية والدول والولايات والمدن والجنسيات. معظم صفحات الإنشاء والتعديل تعمل، لكن صفحات العرض (Show) تعطي خطأ 500. صفحات الولايات والمدن لا تفتح بسبب كثرة البيانات (Timeout).')

h = doc.add_heading('3.1 Regions / الأقاليم', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Notes / ملاحظات'],
    [
        ['List / القائمة', '/geography/regions', 'OK', 'Create Region, Import CSV/Excel, Show, Edit, Delete', '-', 'OK', '-'],
        ['Create / إنشاء', '/geography/regions/create', 'OK', 'Save Region, Cancel', '-', 'OK', 'Created successfully / تم بنجاح'],
        ['Edit / تعديل', '/geography/regions/{id}/edit', 'OK', 'Update Region, Cancel', '-', 'OK', 'Updated successfully / تم التحديث'],
        ['View / عرض', '/geography/regions/{id}', '500', '-', '-', 'FAIL', 'Route [regions.edit] not defined'],
        ['Import / استيراد', 'Import button', 'FAIL', 'Import CSV/Excel', '-', 'FAIL', 'Just reloads page / يعيد تحميل الصفحة فقط'],
    ])

h = doc.add_heading('3.2 Subregions / الأقاليم الفرعية', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['List', '/geography/subregions', 'OK', 'Create Subregion, Import CSV/Excel, Show, Edit, Delete', '-', 'OK', '-'],
        ['Create', '/geography/subregions/create', 'OK', 'Save, Cancel, Region dropdown', '-', 'OK', '-'],
        ['Edit', '/geography/subregions/{id}/edit', 'OK', 'Update, Cancel', '-', 'OK', '-'],
        ['View', '/geography/subregions/{id}', '500', '-', '-', 'FAIL', 'Route [subregions.edit] not defined'],
    ])

h = doc.add_heading('3.3 Countries / الدول', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['List', '/geography/countries', 'OK', 'Create Country, Import CSV/Excel, Show, Edit, Delete', '-', 'OK', 'Timezone column shows null'],
        ['Create', '/geography/countries/create', 'OK', 'Save, Cancel, Region/Subregion dropdowns', '-', 'OK', '-'],
        ['Edit', '/geography/countries/{id}/edit', 'OK', 'Update, Cancel', '-', 'OK', '-'],
        ['View', '/geography/countries/{id}', '500', '-', '-', 'FAIL', 'Missing parameter: subregion'],
    ])

h = doc.add_heading('3.4 States / الولايات', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['List', '/geography/states', 'TIMEOUT', '-', '-', 'FAIL', 'Too much data / بيانات كثيرة - يحتاج Pagination'],
        ['Create', '/geography/states/create', 'OK', 'Save, Cancel', '-', 'OK', '-'],
    ])

h = doc.add_heading('3.5 Cities / المدن', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['List', '/geography/cities', 'TIMEOUT (504)', '-', '-', 'FAIL', 'Too much data / بيانات كثيرة - يحتاج Pagination'],
        ['Create', '/geography/cities/create', 'OK', 'Save, Cancel', '-', 'OK', '-'],
    ])

h = doc.add_heading('3.6 Nationalities / الجنسيات', level=2)
set_heading_font(h)
add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['List', '/geography/nationalities', 'OK', 'Create Nationality, Import CSV/Excel', 'Edit, View', 'WARN', 'لا يمكن التعديل بعد الإنشاء'],
        ['Create', '/geography/nationalities/create', 'OK', 'Save, Cancel', '-', 'OK', '-'],
    ])

doc.add_page_break()

# ==================== 4. LOCALIZATION ====================
h = doc.add_heading('4. Localization Module / التوطين - COMPLETELY BROKEN / معطل بالكامل', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'قسم التوطين يحتوي على اللغات ولغات النظام والعملات والمناطق الزمنية. جميع الصفحات معطلة بالكامل بسبب أسماء روابط خاطئة في ملفات Blade.')
add_broken_warning(doc, 'ALL pages return 500 Server Error / جميع الصفحات تعطي خطأ 500')

add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Error / سبب الخطأ'],
    [
        ['Languages / اللغات', '/localization/languages', '500', '-', '-', 'FAIL', 'Route [languages.create] not defined'],
        ['System Languages / لغات النظام', '/localization/system-languages', '500', '-', '-', 'FAIL', 'Route [system-languages.create] not defined'],
        ['Currencies / العملات', '/localization/currencies', '500', '-', '-', 'FAIL', 'Route [currencies.create] not defined'],
        ['Timezones / المناطق الزمنية', '/localization/timezones', '500', '-', '-', 'FAIL', 'Route [dashboard.core.timezones.create] not defined'],
    ])

# ==================== 5. TOUR GUIDES ====================
h = doc.add_heading('5. Tour Guides Module / المرشدين السياحيين', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على إدارة المرشدين وأنواعهم والمراجعات والمواسم. صفحة المرشدين تعرض جدول خاطئ (أنواع المرشدين بدل المرشدين). إنشاء أنواع المرشدين والمراجعات يعطي خطأ 419 CSRF.')

add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Notes / ملاحظات'],
    [
        ['Guides List / المرشدين', '/tourguides/guides', 'WARN', 'Create Tours Guide, Import CSV/Excel, Delete', 'Edit, View', 'WARN', 'Shows wrong table! يعرض جدول أنواع المرشدين بدل المرشدين'],
        ['Create Guide / إنشاء', '/tourguides/guides/create', 'OK', 'Save Tours Guide, Cancel, dropdowns', '-', 'OK', '-'],
        ['Guide Types / الأنواع', '/tourguides/guides-types', 'OK', 'Create, Import CSV/Excel, Delete', 'Edit, View', 'OK', '-'],
        ['Create Type / إنشاء نوع', '/tourguides/guides-types/create', 'OK', 'Save, Cancel', '-', 'OK', '-'],
        ['Reviews / المراجعات', '/tourguides/guides-reviews', 'OK', 'View Reviews', '-', 'OK', 'الصفحة تعمل'],
    ])

doc.add_page_break()

# ==================== 6. ACCOMMODATIONS ====================
h = doc.add_heading('6. Accommodations Module / الإقامات والفنادق', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على إدارة الفنادق وأنواعها والغرف والمواسم والوجبات والملحقات. صفحة القائمة الرئيسية تعمل لكن صفحة الإنشاء تعطي 404. جميع الصفحات الفرعية (الأنواع، الغرف، المواسم، الوجبات، الملحقات) تعطي رسالة "Not Found Accommodation".')

add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Notes / ملاحظات'],
    [
        ['Main List / القائمة', '/accommodations', 'OK', 'View, Edit, Delete, Archive', '-', 'OK', 'Full buttons available'],
        ['Create / إنشاء', '/accommodations/create', '404', '-', '-', 'FAIL', 'Page not found / صفحة غير موجودة'],
        ['Types / الأنواع', 'Sidebar', 'FAIL', '-', '-', 'FAIL', '"Not Found Accommodation" error'],
        ['Rooms / الغرف', 'Sidebar', 'FAIL', '-', '-', 'FAIL', '"Not Found Accommodation" error'],
        ['Seasons / المواسم', 'Sidebar', 'FAIL', '-', '-', 'FAIL', '"Not Found Accommodation" error'],
        ['Meals / الوجبات', 'Sidebar', 'FAIL', '-', '-', 'FAIL', '"Not Found Accommodation" error'],
        ['Supplements / الملحقات', 'Sidebar', 'FAIL', '-', '-', 'FAIL', '"Not Found Accommodation" error'],
    ])

# ==================== 7. RESTAURANTS ====================
h = doc.add_heading('7. Restaurants Module / المطاعم', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'قسم المطاعم هو قسم منفصل عن الإقامات. صفحة القائمة تعطي خطأ 500. صفحة الإنشاء تعمل وتحمل بشكل صحيح مع جميع الحقول. الوجبات والملحقات مشتركة مع قسم الإقامات.')

add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Notes / ملاحظات'],
    [
        ['List / القائمة', '/restaurants', '500', '-', '-', 'FAIL', 'Server Error'],
        ['Create / إنشاء', '/restaurants/create', 'OK', 'Back, Save Restaurant, Save & Add Another, Cancel, + (Seasons), Add (Meals/Supplements)', '-', 'OK', 'Form loads / النموذج يفتح بشكل صحيح'],
        ['Meals / الوجبات', 'Shared with Accommodations', '500', '-', '-', 'FAIL', 'type=restaurant / مشتركة مع الإقامات'],
        ['Supplements / الملحقات', 'Shared with Accommodations', '500', '-', '-', 'FAIL', 'type=restaurant / مشتركة مع الإقامات'],
    ])

doc.add_page_break()

# ==================== 8. TRANSPORTATION ====================
h = doc.add_heading('8. Transportation Module / النقل', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على إدارة شركات النقل وأنواع المركبات والجيب سفاري والمسارات وتعيينات المسارات والأسعار والمواسم والملحقات. جميع صفحات القوائم تعمل لكن جميع أزرار الحفظ والتحديث تعطي خطأ 500. أزرار التعديل والعرض مفقودة من الجداول.')

add_table(doc,
    ['Page / الصفحة', 'URL', 'Status', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result', 'Notes / ملاحظات'],
    [
        ['Companies / الشركات', '/transportation/companies', 'OK', 'Create Company, Import CSV/Excel, Search', 'Edit, View in table', 'WARN', 'لا أزرار تعديل/عرض في الجدول'],
        ['Create Company', '/transportation/companies/create', 'OK', 'Save Company, Save & Add Another, Cancel', '-', 'FAIL 500 on Save', 'خطأ عند الحفظ'],
        ['Edit Company', '/transportation/companies/{id}/edit', 'OK', 'Update Company, Cancel', '-', 'FAIL 500 on Update', 'خطأ عند التحديث'],
        ['View Company', '/transportation/companies/{id}', '500', '-', '-', 'FAIL', '-'],
        ['Vehicle Types / المركبات', '/transportation/vehicle-types', 'OK', 'Create Vehicle Type, Import CSV/Excel, Search', 'Edit, View', 'WARN', '-'],
        ['Create Vehicle Type', '/transportation/vehicle-types/create', 'OK', 'Save Vehicle Type, Cancel', '-', 'FAIL 500 on Save', '-'],
        ['Jeep Safari / جيب سفاري', '/transportation/jeeps', 'OK', 'Create Jeep, Search', '-', 'OK', 'Empty list / فارغة'],
        ['Create Jeep', '/transportation/jeeps/create', 'OK', 'Save Jeep Safari, Cancel, Provider Company, Status', '-', 'FAIL 500 on Save', '-'],
        ['Routes / المسارات', '/transportation/routes', 'OK', 'Create Route, Import CSV/Excel, Search', '-', 'OK', 'Fake Data / بيانات تجريبية'],
        ['Create Route', '/transportation/routes/create', 'OK', 'Save Route, Cancel', '-', 'FAIL 500 on Save', '-'],
        ['Edit Route', '/transportation/routes/{id}/edit', 'OK', 'Update Route, Cancel', '-', 'FAIL 500 on Update', '-'],
        ['Route Assignments / التعيينات', '/transportation/route-assignments', 'OK', 'Create Assignment, Import CSV/Excel, Search', '-', 'OK', 'Fake Data'],
        ['Create Assignment', '/transportation/route-assignments/create', 'OK', 'Save Assignment, Cancel', '-', 'FAIL 500 on Save', '-'],
        ['Pricings / الأسعار', '/transportation/pricings', '500', '-', '-', 'FAIL', 'Component [core::pricings] not found'],
        ['Seasons / المواسم', 'Shared', 'NOT TESTED', '-', '-', 'NOT TESTED', 'type=transportation'],
        ['Supplements / الملحقات', 'Shared', 'NOT TESTED', '-', '-', 'NOT TESTED', 'type=transportation'],
    ])

doc.add_page_break()

# ==================== 9. TRAVEL DOCUMENTS ====================
h = doc.add_heading('9. Travel Documents Module / وثائق السفر', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على متطلبات التأشيرة وتصاريح السفر. صفحات القوائم تعمل (فارغة) لكن صفحات الإنشاء تعطي خطأ 500.')

add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['Visa Requirements / التأشيرات', '/traveldocuments/visa-requirements', 'OK', 'Create Visa Requirement, Search', '-', 'OK', 'Empty list / فارغة'],
        ['Create Visa Req.', '/traveldocuments/visa-requirements/create', '500', '-', '-', 'FAIL', 'Server Error'],
        ['Travel Passes / تصاريح السفر', '/traveldocuments/travel-passes', 'OK', 'Create Travel Pass, Search', '-', 'OK', 'Empty list / فارغة'],
        ['Create Travel Pass', '/traveldocuments/travel-passes/create', 'OK', 'Save Travel Pass, Cancel', '-', 'FAIL 500 on Save', '-'],
    ])

# ==================== 10. CRM ====================
h = doc.add_heading('10. CRM Module / إدارة العملاء', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'قسم إدارة العملاء. يعمل بشكل جيد - جميع الأزرار موجودة (إنشاء، عرض، تعديل، حذف، أرشفة). أفضل قسم من ناحية الأزرار والوظائف.')

add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['Clients List / العملاء', '/crm/clients', 'OK', 'Create Client, Import CSV/Excel, View, Edit, Delete, Archive, Reset Filters', '-', 'OK', 'All buttons present / جميع الأزرار موجودة'],
        ['View Client / عرض', '/crm/clients/{id}', 'OK', 'Edit, Back', '-', 'OK', '-'],
        ['Edit Client / تعديل', '/crm/clients/{id}/edit', 'OK', 'Update Client, Cancel', '-', 'OK', 'Updated successfully / تم التحديث'],
        ['Create Client / إنشاء', '/crm/clients/create', 'OK', 'Save Client, Cancel', '-', 'WARN', 'Form loads / قد يحتاج حقول إجبارية'],
    ])

doc.add_page_break()

# ==================== 11. TOURISTS ====================
h = doc.add_heading('11. Tourists Module / المواقع السياحية', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على إدارة المواقع السياحية والخدمات. صفحات الإنشاء تعمل لكن أزرار التعديل والعرض مفقودة من جدول المواقع.')

add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['Sites List / المواقع', '/tourists/sites', 'OK', 'Create Tourist Site, Import CSV/Excel, Delete', 'Edit, View', 'WARN', 'لا يمكن التعديل أو عرض التفاصيل'],
        ['Create Site / إنشاء', '/tourists/sites/create', 'OK', 'Save, Cancel', '-', 'OK', '-'],
        ['Services List / الخدمات', '/tourists/services', 'OK', 'Create Tourist Service, Import CSV/Excel', '-', 'OK', 'Empty / فارغة'],
        ['Create Service', '/tourists/services/create', 'OK', 'Save, Cancel', '-', 'OK', '-'],
    ])

# ==================== 12. ENTRY POINTS ====================
h = doc.add_heading('12. Entry Points Module / نقاط الدخول', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'يحتوي على المعابر البرية والموانئ البحرية والمطارات. صفحة المطارات تعمل، لكن المعابر والموانئ تعطي خطأ 500.')
add_broken_warning(doc, 'Land & Sea pages return 500 Server Error / المعابر والموانئ تعطي خطأ 500')

add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Error / سبب الخطأ'],
    [
        ['Land Crossings / المعابر البرية', '/entrypoints/land-crossings', '500', '-', '-', 'FAIL', 'Class "App\\Models\\EntryPoint" not found'],
        ['Sea Ports / الموانئ البحرية', '/entrypoints/seaports', '500', '-', '-', 'FAIL', 'SeaPortController does not exist'],
        ['Airports / المطارات', '/entrypoints/airports', 'OK', 'View Airports', '-', 'OK', 'الصفحة تعمل'],
    ])

# ==================== 13. AIRLINES ====================
h = doc.add_heading('13. Airlines Module / الخطوط الجوية', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'قسم الخطوط الجوية. صفحة القائمة تعطي خطأ 500. صفحة الإنشاء تفتح بشكل صحيح.')

add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['Airlines List / القائمة', '/airlines', '500', '-', '-', 'FAIL', 'Server Error / خطأ سيرفر'],
        ['Create Airline / إنشاء', '/airlines/create', 'OK', 'Form loads', '-', 'OK', 'Form accessible / النموذج يفتح'],
    ])

# ==================== 14. MEDIA FILES ====================
h = doc.add_heading('14. Media Files Module / الملفات الإعلامية', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'قسم إدارة الملفات الإعلامية. يعمل بشكل كامل في وضعي Grid و List. جميع الأزرار موجودة وتعمل.')

add_table(doc,
    ['Page / الصفحة', 'URL / الرابط', 'Status / الحالة', 'Buttons Found / أزرار موجودة', 'Missing Buttons / أزرار مفقودة', 'Result / النتيجة', 'Notes / ملاحظات'],
    [
        ['Media Files List', '/media-files', 'OK', 'Import CSV/Excel, Upload File, Reset Filters, View, Edit, Delete', '-', 'OK', 'Grid + List views work / يعمل بوضع الشبكة والقائمة'],
        ['Upload File', '/media-files/create', 'OK', 'Upload interface', '-', 'OK', 'Upload functional / الرفع يعمل'],
    ])

# ==================== ROOT CAUSE ANALYSIS ====================
doc.add_page_break()
h = doc.add_heading('Root Cause Analysis / تحليل الأسباب الجذرية', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'تحليل مفصل لأسباب المشاكل والأخطاء المكتشفة في الموقع مع المقترحات لحلها.')

h = doc.add_heading('Cause #1: Wrong Route Names / أسماء روابط خاطئة (affects ~30 pages)', level=2)
set_heading_font(h)
p = doc.add_paragraph()
run = p.add_run('Problem: '); run.bold = True; set_run_font(run)
run = p.add_run("Blade files use route('users.index') instead of route('dashboard.core.users.index')"); set_run_font(run)
p2 = doc.add_paragraph()
run = p2.add_run('المشكلة: '); run.bold = True; set_run_font(run)
run = p2.add_run("ملفات Blade تستخدم أسماء روابط قصيرة بدل الأسماء الكاملة"); set_run_font(run)
p3 = doc.add_paragraph()
run = p3.add_run('Solution / الحل: '); run.bold = True; set_run_font(run)
run = p3.add_run("Update route names in shared Blade components to use full prefixed names"); set_run_font(run)

add_table(doc,
    ['File / الملف', 'Impact / التأثير', 'Priority / الأولوية', 'Solution / الحل المقترح'],
    [
        ['save-submit.blade.php', 'Breaks ALL Create pages / يكسر كل صفحات الإنشاء', 'HIGH', 'Change route names to use dashboard.MODULE.resource.index format'],
        ['update-submit.blade.php', 'Breaks ALL Edit pages / يكسر كل صفحات التعديل', 'HIGH', 'Same fix as above'],
        ['edit-button.blade.php', 'Breaks Edit buttons + View pages', 'HIGH', 'Same fix'],
        ['Localization index.blade.php', 'Breaks entire Localization module', 'HIGH', 'Fix route names in each blade file'],
    ])

h = doc.add_heading('Cause #2: Missing Classes / كلاسات PHP مفقودة', level=2)
set_heading_font(h)
add_table(doc,
    ['Class / الكلاس', 'Impact / التأثير', 'Solution / الحل المقترح'],
    [
        ['App\\Models\\EntryPoint', 'Breaks Entry Points module', 'Create the model file with proper schema'],
        ['SeaPortController', 'Breaks Seaports page', 'Create the controller or rename existing one'],
        ['Component [core::pricings]', 'Breaks Transportation Pricings', 'Create Livewire/Blade pricings component'],
        ['showToastSuccessMessage()', 'No success toasts anywhere', 'Define function in app.js or helpers.js'],
    ])

h = doc.add_heading('Cause #3: www vs non-www / مشكلة www', level=2)
set_heading_font(h)
p = doc.add_paragraph()
run = p.add_run('Problem: '); run.bold = True; set_run_font(run)
run = p.add_run('www.mixjo.top gives 500, mixjo.top works.'); set_run_font(run)
p2 = doc.add_paragraph()
run = p2.add_run('Solution: '); run.bold = True; set_run_font(run)
run = p2.add_run('Add to .htaccess: RewriteCond %{HTTP_HOST} ^www\\.mixjo\\.top$ [NC] / RewriteRule ^(.*)$ https://mixjo.top/$1 [R=301,L]'); set_run_font(run)

h = doc.add_heading('Cause #4: Database Issues / مشاكل قاعدة البيانات', level=2)
set_heading_font(h)
p = doc.add_paragraph()
run = p.add_run('Problem: '); run.bold = True; set_run_font(run)
run = p.add_run('Missing "is_active" column in "settings" table.'); set_run_font(run)
p2 = doc.add_paragraph()
run = p2.add_run('Solution: '); run.bold = True; set_run_font(run)
run = p2.add_run('ALTER TABLE settings ADD COLUMN is_active TINYINT(1) DEFAULT 1;'); set_run_font(run)

h = doc.add_heading('Cause #5: CSRF Token Issues / مشاكل CSRF', level=2)
set_heading_font(h)
p = doc.add_paragraph()
run = p.add_run('Problem: '); run.bold = True; set_run_font(run)
run = p.add_run('Tour Guides Types Create and Reviews return 419 Page Expired.'); set_run_font(run)
p2 = doc.add_paragraph()
run = p2.add_run('Solution: '); run.bold = True; set_run_font(run)
run = p2.add_run('Check session driver in .env (SESSION_DRIVER), clear session cache, verify @csrf in forms.'); set_run_font(run)

h = doc.add_heading('Cause #6: Columns Dropdown / مشكلة أسماء الأعمدة', level=2)
set_heading_font(h)
p = doc.add_paragraph()
run = p.add_run('Problem: '); run.bold = True; set_run_font(run)
run = p.add_run('Column labels truncated in Columns dropdown. Red "R" suffix confusing.'); set_run_font(run)
p2 = doc.add_paragraph()
run = p2.add_run('Solution: '); run.bold = True; set_run_font(run)
run = p2.add_run('Increase column label max width in Livewire table component. Replace "R" with full word "Relation" or remove it.'); set_run_font(run)

# ==================== FIX PLAN ====================
doc.add_page_break()
h = doc.add_heading('Prioritized Fix Plan / خطة الإصلاح حسب الأولوية', level=1)
set_heading_font(h)
add_arabic_desc(doc, 'خطة مرتبة حسب الأولوية لإصلاح جميع المشاكل المكتشفة.')

h = doc.add_heading('Critical Priority / أولوية قصوى (Blocks all work)', level=2)
set_heading_font(h)
add_table(doc,
    ['#', 'Fix / الإصلاح', 'Impact / التأثير', 'How / كيفية الإصلاح'],
    [
        ['1', 'Fix save-submit.blade.php', 'Fixes ALL Create pages', 'Update route() calls to use full prefixed names'],
        ['2', 'Fix update-submit.blade.php', 'Fixes ALL Edit pages', 'Same approach'],
        ['3', 'Fix edit-button.blade.php', 'Fixes Edit/View pages', 'Same approach'],
        ['4', 'Add is_active to settings table', 'Prevents crashes', 'ALTER TABLE settings ADD COLUMN is_active TINYINT(1) DEFAULT 1'],
        ['5', 'Fix www redirect', 'Fixes www.mixjo.top', 'Add RewriteRule to .htaccess'],
        ['6', 'Fix Localization routes', 'Fixes 4 pages', 'Update route names in index.blade.php files'],
    ])

h = doc.add_heading('Medium Priority / أولوية متوسطة', level=2)
set_heading_font(h)
add_table(doc,
    ['#', 'Fix / الإصلاح', 'Impact / التأثير', 'How / كيفية الإصلاح'],
    [
        ['7', 'Create EntryPoint model', 'Fixes Entry Points', 'php artisan make:model EntryPoint -m'],
        ['8', 'Create SeaPortController', 'Fixes Seaports', 'php artisan make:controller SeaPortController -r'],
        ['9', 'Create core::pricings component', 'Fixes Transport Pricings', 'Create Blade/Livewire component'],
        ['10', 'Define showToastSuccessMessage()', 'Fixes notifications', 'Add to global JS or helpers'],
        ['11', 'Fix CSRF in Tour Guides', 'Fixes 2 pages', 'Check @csrf, session config'],
        ['12', 'Fix Restaurants list page', 'Fixes Restaurants', 'Debug 500 error in RestaurantsController'],
        ['13', 'Fix Airlines list page', 'Fixes Airlines', 'Debug 500 error in AirlinesController'],
    ])

h = doc.add_heading('Low Priority / أولوية منخفضة', level=2)
set_heading_font(h)
add_table(doc,
    ['#', 'Fix / الإصلاح', 'Impact / التأثير', 'How / كيفية الإصلاح'],
    [
        ['14', 'Add Edit/View buttons to tables', 'Nationalities, Pricing Def, Tour Guides, Tourist Sites, Transportation', 'Add action buttons in Livewire table component'],
        ['15', 'Add Pagination for States & Cities', 'Fixes timeout', 'Use server-side pagination in Livewire'],
        ['16', 'Fix Import CSV/Excel', 'All modules', 'Debug import dialog not opening'],
        ['17', 'Fix Accommodations sub-pages', 'Types/Rooms/Seasons/Meals/Supplements', 'Fix routing for accommodation sub-resources'],
        ['18', 'Fix truncated column labels', 'Users, CRM, Tourist Sites', 'Increase label max width in column config'],
        ['19', 'Remove or rename red "R" suffix', 'Confusing UI', 'Update relation column labels'],
        ['20', 'Test Reports & Analytics section', 'Complete coverage', 'Run full audit on reports pages'],
    ])

# Save
output_path = r"G:\Report Mixjo Top\Audit_Report_mixjo_top.docx"
os.makedirs(os.path.dirname(output_path), exist_ok=True)
doc.save(output_path)
print(f"Report saved to: {output_path}")

# Also save to project folder
output_path2 = r"g:\MixJo Top downlode mains by dats\for edit\tourism-management-system  13 FEB 2026 0221AM\tourism-management-system\Audit_Report_mixjo_top.docx"
doc.save(output_path2)
print(f"Report also saved to: {output_path2}")
