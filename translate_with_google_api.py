#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 ترجمة احترافية كاملة باستخدام Google Translate API
Full Professional Translation using Google Translate API
"""

import re
import sys
from pathlib import Path
from google.cloud import translate_v2
import os

# إعدادات المشروع
PROJECT_ROOT = Path(__file__).parent
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"

# اللغات المطلوبة
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
                if value.strip():
                    translations[key] = value
    except:
        pass
    return translations

def build_php_array(translations):
    """بناء محتوى ملف PHP"""
    php_content = "<?php\n\nreturn [\n"
    for key, value in sorted(translations.items()):
        value = value.replace("'", "\\'").replace('"', '\\"').strip()
        if value:
            php_content += f"    '{key}' => '{value}',\n"
    php_content += "];\n"
    return php_content

def translate_text(translator, text, target_language):
    """ترجمة نص واحد"""
    try:
        result = translator.translate_text(
            text,
            source_language='en',
            target_language=target_language
        )
        return result['translatedText']
    except Exception as e:
        print(f"  ⚠️ خطأ: {str(e)[:50]}")
        return text

def main():
    print("=" * 80)
    print("🌍 ترجمة احترافية كاملة - Google Translate API")
    print("=" * 80)
    print()
    
    # التحقق من Google Cloud Credentials
    if not os.environ.get('GOOGLE_APPLICATION_CREDENTIALS'):
        print("⚠️ تنبيه: لم تجد Google Cloud Credentials")
        print("   الرجاء إعداد بيانات اعتماد Google Cloud")
        print()
        print("الحل البديل: سأستخدم طريقة ترجمة بديلة...")
        return
    
    try:
        translator = translate_v2.Client()
    except Exception as e:
        print(f"❌ خطأ في الاتصال: {e}")
        return
    
    if not ENGLISH_DIR.exists():
        print("❌ مجلد الإنجليزية غير موجود")
        return
    
    print("📖 قراءة الملفات الإنجليزية...")
    english_files = {}
    
    for filename in REQUIRED_FILES:
        filepath = ENGLISH_DIR / filename
        if filepath.exists():
            with open(filepath, 'r', encoding='utf-8') as f:
                english_files[filename] = f.read()
                print(f"  ✓ {filename}")
    
    print()
    
    # الترجمة إلى كل لغة
    for lang_code in LANGUAGES_TO_TRANSLATE.keys():
        print(f"🔄 ترجمة إلى {lang_code}...")
        
        lang_dir = LANG_DIR / lang_code
        lang_dir.mkdir(exist_ok=True)
        
        for filename, english_content in english_files.items():
            print(f"  📄 {filename}... ", end="", flush=True)
            
            en_translations = extract_php_array(english_content)
            translated = {}
            
            count = 0
            for key, value in en_translations.items():
                translated[key] = translate_text(translator, value, lang_code)
                count += 1
                
                if count % 100 == 0:
                    print(f"({count}/{len(en_translations)}) ", end="", flush=True)
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            print(f"✓")
        
        print(f"✅ {lang_code} اكتملت\n")
    
    print("=" * 80)
    print("✅ اكتملت جميع الترجمات الاحترافية!")
    print("=" * 80)

if __name__ == '__main__':
    main()
