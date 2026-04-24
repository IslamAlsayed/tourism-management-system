#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
تقرير جودة الترجمات - Assessment Report
"""
import re
from pathlib import Path
from collections import defaultdict

OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")
LANG_DIR = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system/resources/lang")
ENGLISH_DIR = LANG_DIR / "en"

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

def extract_php_array(php_content):
    """استخراج المفاتيح والقيم من ملف PHP"""
    translations = {}
    try:
        match = re.search(r'return\s*\[\s*(.*?)\s*\];', php_content, re.DOTALL)
        if match:
            array_content = match.group(1)
            pattern = r"['\"]([^'\"]+)['\"]\s*=>\s*['\"]([^'\"]*)['\"]"
            matches = re.findall(pattern, array_content)
            for key, value in matches:
                translations[key] = value
    except:
        pass
    return translations

print("=" * 100)
print("📊 تقرير جودة الترجمات الشامل")
print("=" * 100)
print()

# قراءة الملفات الإنجليزية
print("📖 قراءة الملفات المرجعية...")
english_files = {}
total_en_keys = 0

for filename in REQUIRED_FILES:
    filepath = ENGLISH_DIR / filename
    if filepath.exists():
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            translations = extract_php_array(content)
            english_files[filename] = translations
            total_en_keys += len(translations)

print(f"✅ تم قراءة {len(english_files)} ملفات إنجليزية = {total_en_keys} مفتاح\n")

# تحليل كل لغة
languages = {'fr': 'French', 'de': 'German', 'it': 'Italian', 'ja': 'Japanese', 
             'ru': 'Russian', 'tr': 'Turkish', 'he': 'Hebrew', 'es': 'Spanish'}

results = {}

for lang_code, lang_name in languages.items():
    print(f"🔍 تحليل {lang_code} ({lang_name})...")
    
    lang_dir = OUTPUT_DIR / lang_code
    
    stats = {
        'total': 0,
        'translated': 0,
        'english_fallback': 0,
        'empty': 0,
        'partial': 0,
        'files': {}
    }
    
    for filename in REQUIRED_FILES:
        filepath = lang_dir / filename
        if filepath.exists():
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
                translations = extract_php_array(content)
                
                english_dict = english_files.get(filename, {})
                file_stats = {
                    'total': len(translations),
                    'translated': 0,
                    'english_fallback': 0,
                    'empty': 0
                }
                
                for key, value in translations.items():
                    en_value = english_dict.get(key, '')
                    file_stats['total'] += 1
                    stats['total'] += 1
                    
                    if not value or len(value.strip()) == 0:
                        file_stats['empty'] += 1
                        stats['empty'] += 1
                    elif value == en_value:
                        file_stats['english_fallback'] += 1
                        stats['english_fallback'] += 1
                    else:
                        file_stats['translated'] += 1
                        stats['translated'] += 1
                
                stats['files'][filename] = file_stats
    
    results[lang_code] = stats
    
    coverage = (stats['translated'] / stats['total'] * 100) if stats['total'] > 0 else 0
    print(f"  ✅ {lang_code}: {stats['translated']}/{stats['total']} ({coverage:.1f}%) مترجم")

print("\n" + "=" * 100)
print("📈 تقرير التغطية الإجمالي")
print("=" * 100)
print()

# جدول الملخص
print(f"{'اللغة':<15} {'الاسم':<15} {'مترجم':<15} {'نسبة':<10}")
print("-" * 55)

for lang_code, lang_name in languages.items():
    stats = results[lang_code]
    coverage = (stats['translated'] / stats['total'] * 100) if stats['total'] > 0 else 0
    print(f"{lang_code:<15} {lang_name:<15} {stats['translated']}/{stats['total']:<12} {coverage:>7.1f}%")

print()
print("=" * 100)
print("📋 تقرير التفاصيل")
print("=" * 100)

for lang_code, lang_name in languages.items():
    stats = results[lang_code]
    coverage = (stats['translated'] / stats['total'] * 100) if stats['total'] > 0 else 0
    
    print(f"\n🌍 {lang_code.upper()} ({lang_name}) - التغطية: {coverage:.1f}%")
    print("─" * 80)
    
    for filename, file_stats in stats['files'].items():
        file_coverage = (file_stats['translated'] / file_stats['total'] * 100) if file_stats['total'] > 0 else 0
        print(f"  {filename:<25} {file_stats['translated']:>4}/{file_stats['total']:<4} ({file_coverage:>6.1f}%)")

print("\n" + "=" * 100)
print("✅ تقرير الجودة")
print("=" * 100)
print()

for lang_code, lang_name in languages.items():
    stats = results[lang_code]
    coverage = (stats['translated'] / stats['total'] * 100) if stats['total'] > 0 else 0
    
    if coverage >= 70:
        status = "✅ ممتاز"
    elif coverage >= 50:
        status = "🟡 جيد"
    elif coverage >= 30:
        status = "🟠 معقول"
    else:
        status = "❌ ضعيف"
    
    print(f"{lang_code:<5} {status:<15} {coverage:>6.1f}% ({stats['translated']}/{stats['total']})")

print()
print("=" * 100)
print("📊 الإحصائيات الكلية")
print("=" * 100)
print()

total_all_lang = sum(r['total'] for r in results.values())
total_translated_all = sum(r['translated'] for r in results.values())
avg_coverage = (total_translated_all / total_all_lang * 100) if total_all_lang > 0 else 0

print(f"مجموع الملفات المترجمة: {len(languages)} لغة × {len(REQUIRED_FILES)} ملف = {len(languages) * len(REQUIRED_FILES)} ملف")
print(f"مجموع المفاتيح: {total_all_lang}")
print(f"مجموع الترجمات: {total_translated_all}")
print(f"متوسط التغطية: {avg_coverage:.1f}%")

print()
print("=" * 100)
print("💡 التوصيات")
print("=" * 100)
print()

if avg_coverage >= 70:
    print("✅ جودة الترجمات جيدة - يمكن استخدامها")
elif avg_coverage >= 50:
    print("🟡 جودة الترجمات معقولة - لكن يُنصح بتحسينها")
elif avg_coverage >= 30:
    print("🟠 جودة الترجمات منخفضة - يُنصح بتحسين القاموس")
else:
    print("❌ جودة الترجمات ضعيفة جداً - يتطلب تحسين كبير")

print()
print("=" * 100)
