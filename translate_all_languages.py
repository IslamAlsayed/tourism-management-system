#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 نظام الترجمة الشامل - ترجمة آلية إلى 8 لغات
Comprehensive Translation System - Auto Translation to 8 Languages
"""

import os
import sys
import json
import re
from pathlib import Path
import requests
from urllib.parse import quote

# إعدادات المشروع
PROJECT_ROOT = Path(__file__).parent
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"

# اللغات المطلوبة (8 لغات)
LANGUAGES_TO_TRANSLATE = {
    'fr': 'fr',      # الفرنسية
    'de': 'de',      # الألمانية
    'it': 'it',      # الإيطالية
    'ja': 'ja',      # اليابانية
    'ru': 'ru',      # الروسية
    'tr': 'tr',      # التركية
    'he': 'he',      # العبرية
    'es': 'es',      # الإسبانية
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

def translate_text_free(text, target_lang):
    """ترجمة نص باستخدام API مجاني"""
    try:
        # استخدام MyMemory API (مجاني وبدون API key)
        url = f"https://api.mymemory.translated.net/get"
        params = {
            'q': text[:500],  # محدودية 500 حرف
            'langpair': f'en|{target_lang}'
        }
        response = requests.get(url, params=params, timeout=5)
        data = response.json()
        
        if data.get('responseStatus') == 200:
            return data['responseData']['translatedText']
        return text
    except Exception as e:
        print(f"  ⚠️ خطأ في الترجمة: {str(e)[:50]}")
        return text

def extract_php_array(php_content):
    """استخراج المفاتيح والقيم من ملف PHP"""
    translations = {}
    
    try:
        # ابحث عن return [ ... ];
        match = re.search(r'return\s*\[\s*(.*?)\s*\];', php_content, re.DOTALL)
        if not match:
            return translations
        
        array_content = match.group(1)
        
        # استخراج الأزواج key => value
        pattern = r"['\"]([^'\"]+)['\"]\s*=>\s*['\"]([^'\"]*)['\"]"
        matches = re.findall(pattern, array_content)
        
        for key, value in matches:
            translations[key] = value
    except Exception as e:
        print(f"  ❌ خطأ في الاستخراج: {e}")
    
    return translations

def build_php_array(translations):
    """بناء محتوى ملف PHP من المفاتيح والقيم"""
    php_content = "<?php\n\nreturn [\n"
    
    for key, value in translations.items():
        # تجنب الأخطاء في الترجمة
        value = value.replace("'", "\\'").replace('"', '\\"').strip()
        if value:
            php_content += f"    '{key}' => '{value}',\n"
    
    php_content += "];\n"
    return php_content

def main():
    """البرنامج الرئيسي"""
    print("=" * 80)
    print("🌍 نظام الترجمة الشامل - ترجمة الإنجليزية إلى 8 لغات")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد الإنجليزية غير موجود: {ENGLISH_DIR}")
        return
    
    # قراءة الملفات الإنجليزية
    print("📖 جاري قراءة الملفات الإنجليزية...")
    english_files = {}
    total_keys = 0
    
    for filename in REQUIRED_FILES:
        filepath = ENGLISH_DIR / filename
        if filepath.exists():
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
                translations = extract_php_array(content)
                english_files[filename] = translations
                total_keys += len(translations)
                print(f"  ✓ {filename}: {len(translations)} مفتاح")
        else:
            print(f"  ⚠️ {filename}: غير موجود")
    
    print(f"\n📊 المجموع: {total_keys} مفتاح")
    print("\n" + "=" * 80)
    print()
    
    # الترجمة إلى اللغات المطلوبة
    for lang_code, lang_code_google in LANGUAGES_TO_TRANSLATE.items():
        print(f"🔄 جاري الترجمة إلى اللغة ({lang_code})...")
        print("-" * 80)
        
        lang_dir = LANG_DIR / lang_code
        lang_dir.mkdir(exist_ok=True)
        
        file_count = 0
        for filename, translations_dict in english_files.items():
            print(f"  📄 {filename}... ", end="", flush=True)
            
            translated_dict = {}
            
            for key, value in translations_dict.items():
                # ترجمة القيمة فقط (ليس المفتاح)
                if value.strip():
                    translated = translate_text_free(value, lang_code_google)
                    translated_dict[key] = translated
                else:
                    translated_dict[key] = value
            
            # كتابة الملف
            php_content = build_php_array(translated_dict)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            file_count += 1
            print(f"✓ ({len(translated_dict)} مفتاح)")
        
        print(f"\n✅ اكتملت ترجمة {lang_code}: {file_count} ملفات")
        print("=" * 80)
        print()
    
    print("=" * 80)
    print("✅ ✅ ✅ اكتملت جميع الترجمات بنجاح! ✅ ✅ ✅")
    print("=" * 80)
    print()
    print("📁 الملفات المُترجمة:")
    for lang in LANGUAGES_TO_TRANSLATE.keys():
        print(f"  • {LANG_DIR}/{lang}/ (8 ملفات)")
    print()

if __name__ == '__main__':
    main()
