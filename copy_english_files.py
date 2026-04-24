#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
⚡ نظام النسخ السريع - نسخ الملفات الإنجليزية إلى مجلدات اللغات
Fast Copy System - Copy English Files to Language Folders
"""

import shutil
from pathlib import Path

# إعدادات المشروع
PROJECT_ROOT = Path(__file__).parent
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"

# اللغات المطلوبة (8 لغات)
LANGUAGES_TO_COPY = {
    'fr': 'French',      # الفرنسية
    'de': 'German',      # الألمانية
    'it': 'Italian',     # الإيطالية
    'ja': 'Japanese',    # اليابانية
    'ru': 'Russian',     # الروسية
    'tr': 'Turkish',     # التركية
    'he': 'Hebrew',      # العبرية
    'es': 'Spanish',     # الإسبانية
}

# الملفات المطلوبة
REQUIRED_FILES = [
    'auth.php',
    'automation.php',
    'activity.php',
    'languages.php',
    'messages.php',
    'sidebar.php',
    'en.php',
    'main.php'
]

def main():
    """البرنامج الرئيسي"""
    print("=" * 80)
    print("⚡ نسخ سريع للملفات الإنجليزية إلى مجلدات اللغات")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد الإنجليزية غير موجود: {ENGLISH_DIR}")
        return
    
    print("📖 جاري نسخ الملفات...")
    print()
    
    total_copied = 0
    
    # نسخ الملفات إلى كل لغة
    for lang_code, lang_name in LANGUAGES_TO_COPY.items():
        print(f"📋 {lang_name} ({lang_code}):")
        
        lang_dir = LANG_DIR / lang_code
        lang_dir.mkdir(exist_ok=True, parents=True)
        
        for filename in REQUIRED_FILES:
            src = ENGLISH_DIR / filename
            dst = lang_dir / filename
            
            if src.exists():
                try:
                    shutil.copy2(src, dst)
                    print(f"  ✓ {filename}")
                    total_copied += 1
                except Exception as e:
                    print(f"  ❌ {filename}: {e}")
            else:
                print(f"  ⚠️ {filename}: غير موجود في الإنجليزية")
        
        print()
    
    print("=" * 80)
    print(f"✅ تم نسخ {total_copied} ملف بنجاح!")
    print("=" * 80)
    print()
    print("📁 الملفات المنسوخة:")
    for lang in LANGUAGES_TO_COPY.keys():
        print(f"  • {LANG_DIR / lang} (8 ملفات)")
    print()
    print("💡 ملاحظة: الملفات الآن نسخة من الإنجليزية")
    print("   يمكنك الآن تعديل هذه الملفات بالترجمات المطلوبة")

if __name__ == '__main__':
    main()
