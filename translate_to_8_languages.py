#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 نظام الترجمة الشامل - ترجمة إلى 8 لغات
Comprehensive Translation System - Translate to 8 Languages
"""

import os
import sys
import json
from pathlib import Path
from googletrans import Translator

# إعدادات المشروع
PROJECT_ROOT = Path(__file__).parent / "resources" / "lang"
ENGLISH_DIR = PROJECT_ROOT / "en"

# اللغات المطلوبة (8 لغات)
LANGUAGES_TO_TRANSLATE = {
    'fr': 'French',      # الفرنسية
    'de': 'German',      # الألمانية
    'it': 'Italian',     # الإيطالية
    'ja': 'Japanese',    # اليابانية
    'ru': 'Russian',     # الروسية
    'tr': 'Turkish',     # التركية
    'he': 'Hebrew',      # العبرية
    'es': 'Spanish',     # الإسبانية (لإكمالها)
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

def extract_php_array(php_content):
    """استخراج المفاتيح والقيم من ملف PHP"""
    translations = {}
    
    # البحث عن نمط return [ ... ];
    lines = php_content.split('\n')
    in_array = False
    current_key = None
    
    for line in lines:
        line = line.strip()
        
        if 'return [' in line or 'return[' in line:
            in_array = True
            continue
        
        if in_array and line.startswith('];'):
            break
        
        if in_array and '=>' in line:
            # استخراج المفتاح والقيمة
            try:
                # مثال: 'key' => 'value',
                parts = line.split('=>', 1)
                key_part = parts[0].strip().strip("'\"")
                
                value_part = parts[1].strip().rstrip(',')
                # إزالة الاقتباسات
                value = value_part.strip().strip("'\"")
                
                if key_part and value:
                    translations[key_part] = value
            except:
                pass
    
    return translations

def build_php_array(translations):
    """بناء محتوى ملف PHP من المفاتيح والقيم"""
    php_content = "<?php\n\nreturn [\n"
    
    for key, value in translations.items():
        # تجنب الأخطاء في الترجمة
        value = value.replace("'", "\\'").replace('"', '\\"')
        php_content += f"    '{key}' => '{value}',\n"
    
    php_content += "];\n"
    return php_content

def translate_text(text, target_lang):
    """ترجمة نص واحد"""
    try:
        translator = Translator()
        translation = translator.translate(text, src_language='en', dest_language=target_lang)
        return translation.text
    except Exception as e:
        print(f"❌ خطأ في الترجمة: {e}")
        return text

def translate_translations_dict(translations_dict, target_lang):
    """ترجمة قاموس كامل"""
    translated = {}
    
    for key, value in translations_dict.items():
        translated[key] = translate_text(value, target_lang)
        print(f"  ✓ {key}: {value[:50]}... → {translated[key][:50]}...")
    
    return translated

def main():
    """البرنامج الرئيسي"""
    print("=" * 70)
    print("🌍 نظام الترجمة الشامل")
    print("=" * 70)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد الإنجليزية غير موجود: {ENGLISH_DIR}")
        return
    
    # قراءة الملفات الإنجليزية
    print("📖 جاري قراءة الملفات الإنجليزية...")
    english_files = {}
    
    for filename in REQUIRED_FILES:
        filepath = ENGLISH_DIR / filename
        if filepath.exists():
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
                english_files[filename] = extract_php_array(content)
                print(f"  ✓ {filename}: {len(english_files[filename])} مفتاح")
        else:
            print(f"  ⚠️ {filename}: غير موجود")
    
    print()
    
    # الترجمة إلى اللغات المطلوبة
    for lang_code, lang_name in LANGUAGES_TO_TRANSLATE.items():
        print(f"🔄 ترجمة إلى {lang_name} ({lang_code})...")
        
        lang_dir = PROJECT_ROOT / lang_code
        lang_dir.mkdir(exist_ok=True)
        
        for filename, translations_dict in english_files.items():
            print(f"\n  📄 {filename}:")
            
            # ترجمة المفاتيح
            translated_dict = translate_translations_dict(translations_dict, lang_code)
            
            # كتابة الملف
            php_content = build_php_array(translated_dict)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            print(f"  ✅ تم حفظ: {output_path}")
        
        print(f"\n✅ اكتملت ترجمة {lang_name}")
        print("-" * 70)
        print()
    
    print("=" * 70)
    print("✅ جميع الترجمات اكتملت بنجاح!")
    print("=" * 70)

if __name__ == '__main__':
    main()
