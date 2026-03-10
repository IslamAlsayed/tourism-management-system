# -*- coding: utf-8 -*-
"""Test Arabic text in DOCX - diagnose encoding issues"""
from docx import Document
from docx.shared import Pt
import os

doc = Document()

# Test 1: Arabic via string literal
p1 = doc.add_paragraph()
run1 = p1.add_run('Test 1 - String literal: ')
run1.font.name = 'Arial'
run1.font.size = Pt(14)
run1a = p1.add_run('\u0645\u0631\u062d\u0628\u0627 \u0628\u0627\u0644\u0639\u0627\u0644\u0645')  # مرحبا بالعالم
run1a.font.name = 'Arial'
run1a.font.size = Pt(14)

# Test 2: Arabic via explicit Unicode escapes
p2 = doc.add_paragraph()
run2 = p2.add_run('Test 2 - Unicode escapes: ')
run2.font.name = 'Arial'
run2.font.size = Pt(14)
arabic_text = '\u062a\u0642\u0631\u064a\u0631 \u0627\u0644\u0641\u062d\u0635 \u0627\u0644\u0634\u0627\u0645\u0644'  # تقرير الفحص الشامل
run2a = p2.add_run(arabic_text)
run2a.font.name = 'Arial'
run2a.font.size = Pt(14)

# Test 3: Mixed English and Arabic
p3 = doc.add_paragraph()
run3 = p3.add_run('Test 3 - Mixed: Login / \u062a\u0633\u062c\u064a\u0644 \u0627\u0644\u062f\u062e\u0648\u0644')
run3.font.name = 'Arial'
run3.font.size = Pt(14)

# Test 4: Direct Arabic text (might fail if file encoding is wrong)
p4 = doc.add_paragraph()
run4 = p4.add_run('Test 4 - Direct: مرحبا بالعالم - تقرير الفحص')
run4.font.name = 'Arial'
run4.font.size = Pt(14)

# Test 5: Table with Arabic
table = doc.add_table(rows=2, cols=2)
table.style = 'Table Grid'
table.rows[0].cells[0].text = 'English Header'
table.rows[0].cells[1].text = '\u0627\u0644\u0639\u0646\u0648\u0627\u0646 \u0628\u0627\u0644\u0639\u0631\u0628\u064a\u0629'
table.rows[1].cells[0].text = 'OK'
table.rows[1].cells[1].text = '\u064a\u0639\u0645\u0644 \u0628\u0634\u0643\u0644 \u0635\u062d\u064a\u062d'

output = r"G:\Report Mixjo Top\test_arabic.docx"
os.makedirs(os.path.dirname(output), exist_ok=True)
doc.save(output)
print(f"Test file saved to: {output}")
print(f"Please open this file in Word and tell me which tests show Arabic correctly")
