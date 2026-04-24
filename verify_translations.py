#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
✅ أداة التحقق من جودة الترجمات
Translation Quality Verification Tool
"""

import re
from pathlib import Path
from collections import defaultdict

PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")

def extract_php_array(php_content):
    """استخراج البيانات """
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

def verify_translations():
    """التحقق من الترجمات"""
    print("=" * 80)
    print("✅ أداة التحقق من جودة الترجمات")
    print("=" * 80)
    print()
    
    # قراءة الملفات الإنجليزية والعربية
    english_files = {}
    arabic_files = {}
    
    for filepath in (LANG_DIR / "en").glob("*.php"):
        with open(filepath, 'r', encoding='utf-8') as f:
            english_files[filepath.name] = extract_php_array(f.read())
    
    for filepath in (LANG_DIR / "ar").glob("*.php"):
        with open(filepath, 'r', encoding='utf-8') as f:
            arabic_files[filepath.name] = extract_php_array(f.read())
    
    print(f"📖 الملفات الموجودة:")
    print(f"  • الإنجليزية: {len(english_files)} ملف")
    print(f"  • العربية: {len(arabic_files)} ملف")
    print()
    
    # التحقق من الترجمات
    languages = ['fr', 'de', 'it', 'ja', 'ru', 'tr', 'he', 'es']
    stats = defaultdict(lambda: {'total': 0, 'translated': 0, 'empty': 0})
    
    for lang in languages:
        lang_dir = OUTPUT_DIR / lang
        if not lang_dir.exists():
            continue
        
        print(f"🔍 التحقق من {lang}:")
        
        for filename in english_files.keys():
            filepath = lang_dir / filename
            if not filepath.exists():
                print(f"  ❌ {filename} - غير موجود!")
                continue
            
            with open(filepath, 'r', encoding='utf-8') as f:
                translated = extract_php_array(f.read())
            
            en_data = english_files[filename]
            stats[lang]['total'] += len(en_data)
            stats[lang]['translated'] += len(translated)
            
            empty_keys = [k for k, v in translated.items() if not v or v.strip() == '']
            if empty_keys:
                stats[lang]['empty'] += len(empty_keys)
                print(f"  ⚠️  {filename}: {len(empty_keys)} مفتاح فارغ")
            else:
                print(f"  ✓ {filename}: {len(translated)}/{len(en_data)} مفتاح")
        
        print()
    
    # الملخص
    print("=" * 80)
    print("📊 ملخص الجودة:")
    print("=" * 80)
    
    for lang in languages:
        if lang in stats:
            total = stats[lang]['total']
            trans = stats[lang]['translated']
            empty = stats[lang]['empty']
            completion = (trans / total * 100) if total > 0 else 0
            
            status = "✅" if empty == 0 and trans == total else "⚠️ "
            print(f"{status} {lang}: {trans}/{total} مفتاح ({completion:.1f}%) - {empty} فارغ")
    
    print()
    print("=" * 80)
    print("📁 الموقع: G:\\Translate mixjo VS Code\\Translate VSCODE 2")
    print("=" * 80)

if __name__ == '__main__':
    verify_translations()
