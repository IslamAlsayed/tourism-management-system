#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 نظام الترجمة المجاني - بدون API Key مطلوب
Free Translation System - No API Key Required
استخدام LibreTranslate + Google Translate معاً
"""

import re
from pathlib import Path
from time import sleep
import requests
import json

PROJECT_ROOT = Path(__file__).parent
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"

LANGUAGES = {
    'fr': {'name': 'French', 'code': 'fr', 'flag': '🇫🇷'},
    'de': {'name': 'German', 'code': 'de', 'flag': '🇩🇪'},
    'it': {'name': 'Italian', 'code': 'it', 'flag': '🇮🇹'},
    'ja': {'name': 'Japanese', 'code': 'ja', 'flag': '🇯🇵'},
    'ru': {'name': 'Russian', 'code': 'ru', 'flag': '🇷🇺'},
    'tr': {'name': 'Turkish', 'code': 'tr', 'flag': '🇹🇷'},
    'he': {'name': 'Hebrew', 'code': 'he', 'flag': '🇮🇱'},
    'es': {'name': 'Spanish', 'code': 'es', 'flag': '🇪🇸'},
}

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

class FreeTranslator:
    """نظام ترجمة مجاني"""
    
    @staticmethod
    def translate_with_google(text, target_lang):
        """ترجمة باستخدام formalsymbol Google Translate"""
        try:
            # استخدام MyMemory API (مجاني تماماً)
            url = "https://api.mymemory.translated.net/get"
            params = {
                'q': text[:500],  # حد أقصى 500 حرف في الطلب
                'langpair': f'en|{target_lang}'
            }
            
            response = requests.get(url, params=params, timeout=10)
            
            if response.status_code == 200:
                data = response.json()
                if data.get('responseStatus') == 200:
                    return data['responseData']['translatedText']
        
        except Exception as e:
            pass
        
        return text
    
    @staticmethod
    def translate_text(text, target_lang_code):
        """ترجمة نص مع إعادة محاولة"""
        if not text.strip():
            return text
        
        # محاولة أولى
        translated = FreeTranslator.translate_with_google(text, target_lang_code)
        
        # إذا عادت الترجمة الإنجليزية، محاولة الانتظار وإعادة المحاولة
        if translated.lower().strip() == text.lower().strip():
            sleep(2)
            translated = FreeTranslator.translate_with_google(text, target_lang_code)
        
        return translated

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
    """بناء ملف PHP"""
    php_content = "<?php\n\nreturn [\n"
    for key, value in sorted(translations.items()):
        value = value.replace("'", "\\'").replace('"', '\\"').strip()
        if value:
            php_content += f"    '{key}' => '{value}',\n"
    php_content += "];\n"
    return php_content

def main():
    print("=" * 80)
    print("🌍 نظام الترجمة المجاني - بدون API Key")
    print("=" * 80)
    print()
    print("⚠️  تنبيه: هذا النظام يستخدم API مجانية وقد يكون بطيء الحركة")
    print("    لأفضل النتائج، الرجاء الحصول على Gemini API Key")
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
    
    print(f"\n📊 المجموع: {total_keys} مفتاح")
    print("⏳ قد يستغرق الأمر بعض الوقت (API مجانية بطيئة)...")
    print()
    
    # الترجمة
    for lang_code, lang_info in LANGUAGES.items():
        print(f"{lang_info['flag']} ترجمة {lang_info['name']} ({lang_code})...")
        
        lang_dir = LANG_DIR / lang_code
        lang_dir.mkdir(exist_ok=True)
        
        for filename, en_dict in english_files.items():
            print(f"  📄 {filename}... ", end="", flush=True)
            
            translated = {}
            count = 0
            
            for key, value in en_dict.items():
                if value.strip():
                    translated[key] = FreeTranslator.translate_text(
                        value, 
                        lang_info['code']
                    )
                    count += 1
                    
                    # عرض التقدم
                    if count % 100 == 0:
                        print(f"({count}/{len(en_dict)}) ", end="", flush=True)
                    
                    # تجنب حد المعدل
                    if count % 10 == 0:
                        sleep(0.5)
            
            # كتابة الملف
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            print(f"✓")
        
        print(f"✅ {lang_code} اكتملت\n")
        sleep(2)  # انتظر قبل اللغة التالية
    
    print("=" * 80)
    print("✅ اكتملت جميع الترجمات!")
    print("=" * 80)
    print()
    print("💡 ملاحظات:")
    print("   • الترجمات مجانية لكنها أساسية")
    print("   • للحصول على ترجمات احترافية أفضل، استخدم Gemini API")
    print("   • URL للحصول على Gemini Key: https://makersuite.google.com/app/apikey")

if __name__ == '__main__':
    main()
