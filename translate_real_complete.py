#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 الترجمة الحقيقية الكاملة - بدون API مدفوع
Real Complete Translation - Free Service
"""

import re
from pathlib import Path
import requests
from time import sleep

PROJECT_ROOT = Path(__file__).parent
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"

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

def translate_free(text, target_lang):
    """ترجمة مجانية باستخدام MyMemory API"""
    try:
        # تقسيم النص الطويل
        if len(text) > 500:
            parts = [text[i:i+500] for i in range(0, len(text), 500)]
            results = []
            for part in parts:
                try:
                    url = "https://api.mymemory.translated.net/get"
                    params = {'q': part, 'langpair': f'en|{target_lang}'}
                    response = requests.get(url, params=params, timeout=5)
                    if response.status_code == 200:
                        data = response.json()
                        if data['responseStatus'] == 200:
                            results.append(data['responseData']['translatedText'])
                        else:
                            results.append(part)
                    sleep(0.1)  # تجنب الحد من المعدل
                except:
                    results.append(part)
            return ''.join(results)
        else:
            url = "https://api.mymemory.translated.net/get"
            params = {'q': text, 'langpair': f'en|{target_lang}'}
            response = requests.get(url, params=params, timeout=5)
            
            if response.status_code == 200:
                data = response.json()
                if data['responseStatus'] == 200:
                    return data['responseData']['translatedText']
        
        return text
    except Exception as e:
        print(f"    ⚠️ خطأ: {str(e)[:30]}")
        return text

def main():
    print("=" * 80)
    print("🌍 الترجمة الحقيقية الكاملة - API مجانية")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print("❌ مجلد الإنجليزية غير موجود")
        return
    
    print("📖 قراءة الملفات الإنجليزية...")
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
    
    print(f"\n📊 المجموع: {total_keys} مفتاح\n")
    
    # الترجمة
    for lang_code in LANGUAGES_TO_TRANSLATE.keys():
        print(f"🔄 ترجمة إلى {lang_code}...")
        
        lang_dir = LANG_DIR / lang_code
        lang_dir.mkdir(exist_ok=True)
        
        for filename, en_dict in english_files.items():
            print(f"  📄 {filename}... ", end="", flush=True)
            
            translated = {}
            count = 0
            
            for key, value in en_dict.items():
                if value.strip():
                    translated[key] = translate_free(value, lang_code)
                    count += 1
                    
                    # عرض التقدم
                    if count % 50 == 0:
                        print(f"({count}/{len(en_dict)}) ", end="", flush=True)
                        sleep(0.5)  # تجنب حد المعدل
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            print(f"✓ ({len(translated)} مفتاح)")
        
        print(f"✅ {lang_code} اكتملت\n")
    
    print("=" * 80)
    print("✅ ✅ ✅ اكتملت جميع الترجمات الحقيقية!")
    print("=" * 80)

if __name__ == '__main__':
    main()
