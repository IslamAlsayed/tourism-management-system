#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
✅ نظام التحقق من جودة الترجمات
Translation Quality Verification System
"""

import re
from pathlib import Path
from collections import defaultdict

PROJECT_ROOT = Path(__file__).parent
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"

class TranslationValidator:
    """نظام التحقق من جودة الترجمات"""
    
    @staticmethod
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
    
    @staticmethod
    def check_text_language(text):
        """كشف لغة النص"""
        # نطاقات Unicode
        arabic_range = re.compile(r'[\u0600-\u06FF]')
        chinese_range = re.compile(r'[\u4E00-\u9FFF]')
        cyrillic_range = re.compile(r'[\u0400-\u04FF]')
        hebrew_range = re.compile(r'[\u0590-\u05FF]')
        japanese_hiragana = re.compile(r'[\u3040-\u309F]')
        japanese_katakana = re.compile(r'[\u30A0-\u30FF]')
        
        arabic_count = len(arabic_range.findall(text))
        chinese_count = len(chinese_range.findall(text))
        cyrillic_count = len(cyrillic_range.findall(text))
        hebrew_count = len(hebrew_range.findall(text))
        japanese_count = len(japanese_hiragana.findall(text)) + len(japanese_katakana.findall(text))
        
        return {
            'arabic': arabic_count,
            'chinese': chinese_count,
            'cyrillic': cyrillic_count,
            'hebrew': hebrew_count,
            'japanese': japanese_count,
            'total_non_latin': arabic_count + chinese_count + cyrillic_count + hebrew_count + japanese_count
        }
    
    @staticmethod
    def analyze_translation_quality(en_text, tr_text, lang_code):
        """تحليل جودة الترجمة"""
        issues = []
        score = 100
        
        # 1. التحقق من أن الترجمة ليست نسخة من الإنجليزية
        if en_text.lower().strip() == tr_text.lower().strip():
            issues.append("❌ الترجمة متطابقة مع الإنجليزية!")
            score -= 50
        
        # 2. التحقق من تغيير معقول في الطول
        length_ratio = len(tr_text) / max(len(en_text), 1)
        if length_ratio < 0.5 or length_ratio > 3:
            issues.append(f"⚠️ الطول غير متناسب (النسبة: {length_ratio:.2f})")
            score -= 15
        
        # 3. كشف اللغة
        lang_detection = TranslationValidator.check_text_language(tr_text)
        
        lang_requirements = {
            'fr': {'lang': 'فرنسي', 'min_non_latin': 0},
            'de': {'lang': 'ألماني', 'min_non_latin': 0},
            'it': {'lang': 'إيطالي', 'min_non_latin': 0},
            'es': {'lang': 'إسباني', 'min_non_latin': 0},
            'ru': {'lang': 'روسي', 'min_non_latin': 10},
            'ja': {'lang': 'ياباني', 'min_non_latin': 50},
            'he': {'lang': 'عبري', 'min_non_latin': 20},
            'ar': {'lang': 'عربي', 'min_non_latin': 50},
        }
        
        if lang_code in lang_requirements:
            required_chars = lang_requirements[lang_code]
            if lang_detection['total_non_latin'] < required_chars['min_non_latin']:
                issues.append(f"⚠️ قد تحتوي على نصوص إنجليزية بدلاً من {required_chars['lang']}")
                score -= 30
        
        # 4. التحقق من المتغيرات (placeholders)
        en_vars = set(re.findall(r':[a-zA-Z_]+', en_text))
        tr_vars = set(re.findall(r':[a-zA-Z_]+', tr_text))
        
        if en_vars != tr_vars:
            issues.append(f"❌ عدم تطابق المتغيرات: EN={en_vars}, TR={tr_vars}")
            score -= 20
        
        # 5. التحقق من العلامات
        en_marks = {':', ';', '.', ',', '!', '?'}
        en_punct = sum(1 for c in en_text if c in en_marks)
        tr_punct = sum(1 for c in tr_text if c in en_marks)
        
        if abs(en_punct - tr_punct) > 3:
            issues.append(f"⚠️ اختلاف في علامات الترقيم (EN={en_punct}, TR={tr_punct})")
            score -= 10
        
        return {
            'score': max(0, score),
            'issues': issues,
            'lang_detection': lang_detection,
            'quality': 'ممتاز' if score >= 90 else 'جيد' if score >= 70 else 'مقبول' if score >= 50 else 'ضعيف'
        }
    
    def validate_all_files(self, lang_code):
        """التحقق من جميع ملفات اللغة"""
        print(f"\n📊 التحقق من جودة الترجمات ({lang_code}):")
        print("=" * 80)
        
        lang_dir = LANG_DIR / lang_code
        if not lang_dir.exists():
            print(f"❌ مجلد {lang_code} غير موجود")
            return
        
        total_score = 0
        total_items = 0
        issues_found = []
        
        files = list(ENGLISH_DIR.glob("*.php"))
        for en_file in files:
            tr_file = lang_dir / en_file.name
            
            if not tr_file.exists():
                print(f"⚠️ {en_file.name} - غير موجود في {lang_code}")
                continue
            
            with open(en_file, 'r', encoding='utf-8') as f:
                en_content = f.read()
            
            with open(tr_file, 'r', encoding='utf-8') as f:
                tr_content = f.read()
            
            en_dict = self.extract_php_array(en_content)
            tr_dict = self.extract_php_array(tr_content)
            
            if len(en_dict) != len(tr_dict):
                print(f"⚠️ {en_file.name} - عدم تطابق عدد المفاتيح (EN={len(en_dict)}, TR={len(tr_dict)})")
            
            file_score = 0
            file_items = 0
            
            for key, en_value in en_dict.items():
                tr_value = tr_dict.get(key, '')
                
                quality = self.analyze_translation_quality(en_value, tr_value, lang_code)
                file_score += quality['score']
                file_items += 1
                total_score += quality['score']
                total_items += 1
                
                if quality['issues']:
                    issues_found.append({
                        'file': en_file.name,
                        'key': key,
                        'en': en_value[:50],
                        'tr': tr_value[:50],
                        'issues': quality['issues'],
                        'score': quality['score']
                    })
            
            if file_items > 0:
                avg_file_score = file_score / file_items
                print(f"  ✓ {en_file.name}: {avg_file_score:.1f}/100")
        
        print("\n" + "=" * 80)
        if total_items > 0:
            avg_score = total_score / total_items
            print(f"📈 الدرجة الإجمالية: {avg_score:.1f}/100")
            
            if avg_score >= 80:
                print("✅ جودة ممتازة!")
            elif avg_score >= 60:
                print("⚠️ جودة مقبولة - ينصح بالمراجعة")
            else:
                print("❌ جودة منخفضة - تحتاج إلى إعادة ترجمة")
        
        if issues_found:
            print(f"\n⚠️ وجدت {len(issues_found)} مشكلة:")
            for issue in issues_found[:10]:  # عرض أول 10 مشاكل فقط
                print(f"  • {issue['file']} - {issue['key']}")
                for prob in issue['issues']:
                    print(f"    {prob}")

def main():
    print("=" * 80)
    print("✅ نظام التحقق من جودة الترجمات")
    print("=" * 80)
    
    validator = TranslationValidator()
    
    languages = ['fr', 'de', 'it', 'ja', 'ru', 'tr', 'he', 'es', 'ar', 'en']
    
    for lang in languages:
        validator.validate_all_files(lang)

if __name__ == '__main__':
    main()
