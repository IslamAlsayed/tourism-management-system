#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌐 نظام الترجمة عبر Google Translate (بدون API Key)
Translation System using Google Translate
"""

import re
from pathlib import Path
import urllib.request
import urllib.parse
import json
import time

PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"
OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

# قائمة اللغات المستهدفة وأكوادها
LANGUAGE_CODES = {
    'fr': 'fr',  # الفرنسية
    'de': 'de',  # الألمانية
    'it': 'it',  # الإيطالية
    'ja': 'ja',  # اليابانية
    'ru': 'ru',  # الروسية
    'tr': 'tr',  # التركية
    'he': 'he',  # العبرية
    'es': 'es',  # الإسبانية
}

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

def translate_text_mymemory(text, from_lang, to_lang):
    """ترجمة نصية باستخدام MyMemory API (مجاني)"""
    try:
        if not text or len(text.strip()) == 0:
            return text
        
        # تجنب الترجمة المتكررة للنص نفسه
        if from_lang == to_lang:
            return text
        
        url = f"https://api.mymemory.translated.net/get?q={urllib.parse.quote(text)}&langpair={from_lang}|{to_lang}"
        
        headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        }
        
        request = urllib.request.Request(url, headers=headers)
        
        with urllib.request.urlopen(request, timeout=5) as response:
            data = json.loads(response.read().decode('utf-8'))
            
            if data.get('responseStatus') == 200:
                translated = data['responseData']['translatedText']
                if translated and translated != text:
                    return translated
            
            return text
    except Exception as e:
        print(f"    ⚠️  خطأ الترجمة: {str(e)[:50]}... استخدام النص الأصلي")
        return text

def build_php_array(translations):
    """بناء ملف PHP"""
    php_content = "<?php\n\nreturn [\n"
    for key, value in sorted(translations.items()):
        if value:
            value_escaped = value.replace("'", "\\'").strip()
            php_content += f"    '{key}' => '{value_escaped}',\n"
    php_content += "];\n"
    return php_content

def main():
    print("=" * 80)
    print("🌐 نظام الترجمة عبر MyMemory (مجاني وسريع)")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد الإنجليزية غير موجود: {ENGLISH_DIR}")
        return
    
    print("📖 قراءة جميع الملفات الإنجليزية...")
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
                print(f"  ✓ {filename} ({len(translations)} مفتاح)")
    
    print(f"\n📊 المجموع: {total_keys} مفتاح")
    print(f"💾 سيتم الحفظ في: {OUTPUT_DIR}\n")
    
    lang_names = {
        'fr': '🇫🇷 الفرنسية',
        'de': '🇩🇪 الألمانية',
        'it': '🇮🇹 الإيطالية',
        'ja': '🇯🇵 اليابانية',
        'ru': '🇷🇺 الروسية',
        'tr': '🇹🇷 التركية',
        'he': '🇮🇱 العبرية',
        'es': '🇪🇸 الإسبانية',
    }
    
    for lang_code in LANGUAGE_CODES.keys():
        print(f"🔄 ترجمة إلى {lang_names[lang_code]}...")
        
        lang_dir = OUTPUT_DIR / lang_code
        lang_dir.mkdir(parents=True, exist_ok=True)
        
        for filename, en_dict in english_files.items():
            print(f"  📄 {filename}... ", end="", flush=True)
            
            translated = {}
            count = 0
            
            for key, value in en_dict.items():
                # ترجمة القيمة
                if value and len(value.strip()) > 0:
                    translated_text = translate_text_mymemory(value, 'en', LANGUAGE_CODES[lang_code])
                    translated[key] = translated_text
                    count += 1
                else:
                    translated[key] = value
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            print(f"✓ ({count} مفتاح)")
            time.sleep(1)  # تجنب الإفراط في الطلبات
        
        print(f"✅ {lang_names[lang_code]} اكتملت\n")
    
    print("=" * 80)
    print(f"✅ ✅ ✅ اكتملت جميع الترجمات بنجاح!")
    print(f"📁 تم الحفظ في: {OUTPUT_DIR}")
    print("=" * 80)

if __name__ == '__main__':
    main()
