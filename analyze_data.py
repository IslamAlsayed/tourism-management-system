#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
📚 استخراج وتحليل جميع البيانات الإنجليزية
Extract and Analyze Complete English Database
للتحقق من المفاتيح الفعلية التي تحتاج إلى ترجمة
"""

import re
from pathlib import Path
from collections import defaultdict

PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
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

print("=" * 80)
print("📚 استخراج وتحليل جميع البيانات الإنجليزية")
print("=" * 80)
print()

all_data = {}
total_keys = 0

for filename in REQUIRED_FILES:
    filepath = ENGLISH_DIR / filename
    if filepath.exists():
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            translations = extract_php_array(content)
            all_data[filename] = translations
            total_keys += len(translations)
            print(f"✓ {filename}: {len(translations)} مفتاح")

print(f"\n📊 المجموع: {total_keys} مفتاح")
print()

# تحليل الكلمات الشائعة
print("🔍 تحليل الكلمات الشائعة في القيم:")
print("-" * 80)

word_freq = defaultdict(int)
for filename, data in all_data.items():
    for key, value in data.items():
        if value:
            words = value.lower().split()
            for word in words:
                word_clean = re.sub(r'[^a-z_0-9]', '', word)
                if len(word_clean) > 2:
                    word_freq[word_clean] += 1

# أكثر 50 كلمة شيوعاً
sorted_words = sorted(word_freq.items(), key=lambda x: x[1], reverse=True)[:50]

for word, count in sorted_words[:30]:
    print(f"  • {word:<20} ({count} مرات)")

print()
print("=" * 80)
print("💡 الآن سأقوم بإنشاء قاموس شامل بناءً على هذه الكلمات...")
print("=" * 80)
