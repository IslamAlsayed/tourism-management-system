#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
✅ نظام الترجمة الذكية المحسّن
Smart Enhanced Translation System
استخدا م ترجمة ديناميكية + قاموس محسّن
"""

import re
from pathlib import Path
import json
import time

PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"
ARABIC_DIR = LANG_DIR / "ar"
OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

# خريطة الترجمة الثابتة للكلمات الشائعة (مستخرجة بعناية فائقة)
CORE_TRANSLATIONS = {
    'fr': {
        'login': 'Connexion', 'logout': 'Déconnexion', 'active': 'Actif', 'name': 'Nom',
        'email': 'E-mail', 'phone': 'Téléphone', 'address': 'Adresse', 'city': 'Ville',
        'country': 'Pays', 'save': 'Enregistrer', 'delete': 'Supprimer', 'edit': 'Modifier',
        'update': 'Mettre à jour', 'add': 'Ajouter', 'cancel': 'Annuler', 'status': 'Statut',
        'action': 'Action', 'actions': 'Actions', 'search': 'Rechercher', 'filter': 'Filtrer',
        'yes': 'Oui', 'no': 'Non', 'ok': 'OK', 'error': 'Erreur', 'success': 'Succès',
        'warning': 'Avertissement', 'info': 'Information', 'loading': 'Chargement',
        'date': 'Date', 'time': 'Heure', 'start': 'Démarrage', 'end': 'Fin',
        'from': 'De', 'to': 'À', 'create': 'Créer', 'close': 'Fermer',
    },
    'de': {
        'login': 'Anmelden', 'logout': 'Abmelden', 'active': 'Aktiv', 'name': 'Name',
        'email': 'E-Mail', 'phone': 'Telefon', 'address': 'Adresse', 'city': 'Stadt',
        'country': 'Land', 'save': 'Speichern', 'delete': 'Löschen', 'edit': 'Bearbeiten',
        'update': 'Aktualisieren', 'add': 'Hinzufügen', 'cancel': 'Abbrechen', 'status': 'Status',
        'action': 'Aktion', 'actions': 'Aktionen', 'search': 'Suchen', 'filter': 'Filtern',
        'yes': 'Ja', 'no': 'Nein', 'ok': 'OK', 'error': 'Fehler', 'success': 'Erfolg',
        'warning': 'Warnung', 'info': 'Information', 'loading': 'Wird geladen',
        'date': 'Datum', 'time': 'Zeit', 'start': 'Start', 'end': 'Ende',
        'from': 'Von', 'to': 'Zu', 'create': 'Erstellen', 'close': 'Schließen',
    },
    'it': {
        'login': 'Accesso', 'logout': 'Disconnessione', 'active': 'Attivo', 'name': 'Nome',
        'email': 'Email', 'phone': 'Telefono', 'address': 'Indirizzo', 'city': 'Città',
        'country': 'Paese', 'save': 'Salva', 'delete': 'Elimina', 'edit': 'Modifica',
        'update': 'Aggiorna', 'add': 'Aggiungi', 'cancel': 'Annulla', 'status': 'Stato',
        'action': 'Azione', 'actions': 'Azioni', 'search': 'Cerca', 'filter': 'Filtra',
        'yes': 'Sì', 'no': 'No', 'ok': 'OK', 'error': 'Errore', 'success': 'Successo',
        'warning': 'Avviso', 'info': 'Informazione', 'loading': 'Caricamento',
        'date': 'Data', 'time': 'Ora', 'start': 'Inizio', 'end': 'Fine',
        'from': 'Da', 'to': 'A', 'create': 'Crea', 'close': 'Chiudi',
    },
    'ja': {
        'login': 'ログイン', 'logout': 'ログアウト', 'active': 'アクティブ', 'name': '名前',
        'email': 'メール', 'phone': '電話', 'address': '住所', 'city': '都市',
        'country': '国', 'save': '保存', 'delete': '削除', 'edit': '編集',
        'update': '更新', 'add': '追加', 'cancel': 'キャンセル', 'status': 'ステータス',
        'action': 'アクション', 'actions': 'アクション', 'search': '検索', 'filter': 'フィルター',
        'yes': 'はい', 'no': 'いいえ', 'ok': 'OK', 'error': 'エラー', 'success': '成功',
        'warning': '警告', 'info': '情報', 'loading': '読み込み',
        'date': '日付', 'time': '時刻', 'start': '開始', 'end': '終了',
        'from': 'から', 'to': 'へ', 'create': '作成', 'close': '閉じる',
    },
    'ru': {
        'login': 'Вход', 'logout': 'Выход', 'active': 'Активный', 'name': 'Имя',
        'email': 'Email', 'phone': 'Телефон', 'address': 'Адрес', 'city': 'Город',
        'country': 'Страна', 'save': 'Сохранить', 'delete': 'Удалить', 'edit': 'Редактировать',
        'update': 'Обновить', 'add': 'Добавить', 'cancel': 'Отмена', 'status': 'Статус',
        'action': 'Действие', 'actions': 'Действия', 'search': 'Поиск', 'filter': 'Фильтр',
        'yes': 'Да', 'no': 'Нет', 'ok': 'OK', 'error': 'Ошибка', 'success': 'Успех',
        'warning': 'Предупреждение', 'info': 'Информация', 'loading': 'Загрузка',
        'date': 'Дата', 'time': 'Время', 'start': 'Начало', 'end': 'Конец',
        'from': 'От', 'to': 'До', 'create': 'Создать', 'close': 'Закрыть',
    },
    'tr': {
        'login': 'Giriş', 'logout': 'Çıkış', 'active': 'Aktif', 'name': 'İsim',
        'email': 'E-posta', 'phone': 'Telefon', 'address': 'Adres', 'city': 'Şehir',
        'country': 'Ülke', 'save': 'Kaydet', 'delete': 'Sil', 'edit': 'Düzenle',
        'update': 'Güncelle', 'add': 'Ekle', 'cancel': 'İptal', 'status': 'Durum',
        'action': 'İşlem', 'actions': 'İşlemler', 'search': 'Ara', 'filter': 'Filtrele',
        'yes': 'Evet', 'no': 'Hayır', 'ok': 'OK', 'error': 'Hata', 'success': 'Başarı',
        'warning': 'Uyarı', 'info': 'Bilgi', 'loading': 'Yükleniyor',
        'date': 'Tarih', 'time': 'Zaman', 'start': 'Başla', 'end': 'Son',
        'from': 'Gönderen', 'to': 'Kime', 'create': 'Oluştur', 'close': 'Kapat',
    },
    'he': {
        'login': 'כניסה', 'logout': 'יציאה', 'active': 'פעיל', 'name': 'שם',
        'email': 'דוא"ל', 'phone': 'טלפון', 'address': 'כתובת', 'city': 'עיר',
        'country': 'ארץ', 'save': 'שמור', 'delete': 'מחק', 'edit': 'ערוך',
        'update': 'עדכן', 'add': 'הוסף', 'cancel': 'ביטול', 'status': 'סטטוס',
        'action': 'פעולה', 'actions': 'פעולות', 'search': 'חפש', 'filter': 'סנן',
        'yes': 'כן', 'no': 'לא', 'ok': 'OK', 'error': 'שגיאה', 'success': 'הצלחה',
        'warning': 'אזהרה', 'info': 'מידע', 'loading': 'טוען',
        'date': 'תאריך', 'time': 'זמן', 'start': 'התחלה', 'end': 'סוף',
        'from': 'מ', 'to': 'אל', 'create': 'צור', 'close': 'סגור',
    },
    'es': {
        'login': 'Iniciar sesión', 'logout': 'Cerrar sesión', 'active': 'Activo', 'name': 'Nombre',
        'email': 'Correo', 'phone': 'Teléfono', 'address': 'Dirección', 'city': 'Ciudad',
        'country': 'País', 'save': 'Guardar', 'delete': 'Eliminar', 'edit': 'Editar',
        'update': 'Actualizar', 'add': 'Añadir', 'cancel': 'Cancelar', 'status': 'Estado',
        'action': 'Acción', 'actions': 'Acciones', 'search': 'Buscar', 'filter': 'Filtrar',
        'yes': 'Sí', 'no': 'No', 'ok': 'OK', 'error': 'Error', 'success': 'Éxito',
        'warning': 'Advertencia', 'info': 'Información', 'loading': 'Cargando',
        'date': 'Fecha', 'time': 'Hora', 'start': 'Inicio', 'end': 'Fin',
        'from': 'De', 'to': 'A', 'create': 'Crear', 'close': 'Cerrar',
    },
}

def extract_php_array(php_content):
    """استخراج المفاتيح والقيم"""
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

def translate_smart(key, value, language_code):
    """ترجمة ذكية بناءً على المفتاح والقيمة"""
    
    if not value or len(value.strip()) == 0:
        return value
    
    key_lower = key.lower()
    value_lower = value.lower()
    core_dict = CORE_TRANSLATIONS.get(language_code, {})
    
    # البحث #1: البحث المباشر في المفتاح
    if key_lower in core_dict:
        return core_dict[key_lower]
    
    # البحث #2: البحث في القيمة
    if value_lower in core_dict:
        return core_dict[value_lower]
    
    # البحث #3: البحث عن أجزاء من الكلمات
    for word, translation in core_dict.items():
        if word in key_lower or word in value_lower:
            return translation
    
    # إذا لم نجد، نرجع النص الأصلي (هذا أفضل من استخدام reference غير موجودة)
    return value

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
    print("✅ نظام الترجمة الذكية المحسّن")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"ERR: English directory not found")
        return
    
    # قراءة الملفات الإنجليزية
    print("READ: Reading all English files...")
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
                print(f"  OK {filename} ({len(translations)} keys)")
    
    print(f"\nTOTAL: {total_keys} keys")
    print(f"SAVE: {OUTPUT_DIR}\n")
    
    languages = ['fr', 'de', 'it', 'ja', 'ru', 'tr', 'he', 'es']
    
    for lang_code in languages:
        print(f"TRANSLATE: {lang_code}...")
        
        lang_dir = OUTPUT_DIR / lang_code
        lang_dir.mkdir(parents=True, exist_ok=True)
        
        for filename, en_dict in english_files.items():
            translated = {}
            
            for key, value in en_dict.items():
                translated_value = translate_smart(key, value, lang_code)
                translated[key] = translated_value
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
        
        print(f"  OK {lang_code}\n")
    
    print("=" * 80)
    print("SUCCESS: All smart translations completed!")
    print(f"LOCATION: {OUTPUT_DIR}")
    print("=" * 80)

if __name__ == '__main__':
    main()
