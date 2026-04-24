#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 نظام الترجمة الاحترافي الشامل
Comprehensive Professional Translation System
Uses complete translation dictionary
"""

import re
import json
from pathlib import Path
from collections import defaultdict

# إعدادات المشروع
PROJECT_ROOT = Path(__file__).parent
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"

# قاموس ترجمة شامل احترافي
COMPREHENSIVE_DICT = {
    'fr': {  # الفرنسية
        'login_successful': 'Connexion réussie',
        'logout_successful': 'Déconnexion réussie',
        'failed': 'Les identifiants fournis sont incorrects.',
        'password': 'Mot de passe',
        'throttle': 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
        'unauthenticated': 'Non authentifié.',
        'login': 'Connexion',
        'logout': 'Déconnexion',
        'email': 'E-mail',
        'success': 'Succès',
        'error': 'Erreur',
        'warning': 'Avertissement',
        'save': 'Enregistrer',
        'cancel': 'Annuler',
        'delete': 'Supprimer',
        'edit': 'Modifier',
        'create': 'Créer',
        'update': 'Mettre à jour',
        'add': 'Ajouter',
        'dashboard': 'Tableau de bord',
        'automation': 'Automatisation',
        'webhook': 'Webhook',
        'trigger': 'Déclencheur',
        'action': 'Action',
        'users': 'Utilisateurs',
        'settings': 'Paramètres',
        'profile': 'Profil',
        'language': 'Langue',
        'theme': 'Thème',
        'export': 'Exporter',
        'import': 'Importer',
        'download': 'Télécharger',
        'upload': 'Télécharger',
        'activity': 'Activité',
        'messages': 'Messages',
        'notifications': 'Notifications',
        'settings': 'Paramètres',
    },
    'de': {  # الألمانية
        'login_successful': 'Anmeldung erfolgreich',
        'logout_successful': 'Abmeldung erfolgreich',
        'failed': 'Die angegebenen Anmeldedaten sind falsch.',
        'password': 'Passwort',
        'throttle': 'Zu viele Anmeldeversuche. Versuchen Sie es in :seconds Sekunden erneut.',
        'unauthenticated': 'Nicht authentifiziert.',
        'login': 'Anmelden',
        'logout': 'Abmelden',
        'email': 'E-Mail',
        'success': 'Erfolg',
        'error': 'Fehler',
        'warning': 'Warnung',
        'save': 'Speichern',
        'cancel': 'Abbrechen',
        'delete': 'Löschen',
        'edit': 'Bearbeiten',
        'create': 'Erstellen',
        'update': 'Aktualisieren',
        'add': 'Hinzufügen',
        'dashboard': 'Instrumententafel',
        'automation': 'Automatisierung',
        'webhook': 'Webhook',
        'trigger': 'Auslöser',
        'action': 'Aktion',
        'users': 'Benutzer',
        'settings': 'Einstellungen',
        'profile': 'Profil',
        'language': 'Sprache',
        'theme': 'Design',
        'export': 'Exportieren',
        'import': 'Importieren',
        'download': 'Herunterladen',
        'upload': 'Hochladen',
        'activity': 'Aktivität',
        'messages': 'Nachrichten',
        'notifications': 'Benachrichtigungen',
    },
    'it': {  # الإيطالية
        'login_successful': 'Accesso riuscito',
        'logout_successful': 'Disconnessione riuscita',
        'failed': 'Le credenziali fornite sono errate.',
        'password': 'Password',
        'throttle': 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
        'unauthenticated': 'Non autenticato.',
        'login': 'Accesso',
        'logout': 'Disconnessione',
        'email': 'Email',
        'success': 'Successo',
        'error': 'Errore',
        'warning': 'Avviso',
        'save': 'Salva',
        'cancel': 'Annulla',
        'delete': 'Elimina',
        'edit': 'Modifica',
        'create': 'Crea',
        'update': 'Aggiorna',
        'add': 'Aggiungi',
        'dashboard': 'Cruscotto',
        'automation': 'Automazione',
        'webhook': 'Webhook',
        'trigger': 'Attivatore',
        'action': 'Azione',
        'users': 'Utenti',
        'settings': 'Impostazioni',
        'profile': 'Profilo',
        'language': 'Lingua',
        'theme': 'Tema',
        'export': 'Esporta',
        'import': 'Importa',
        'download': 'Scarica',
        'upload': 'Carica',
        'activity': 'Attività',
        'messages': 'Messaggi',
        'notifications': 'Notifiche',
    },
    'ja': {  # اليابانية
        'login_successful': 'ログインに成功しました',
        'logout_successful': 'ログアウトました',
        'failed': '提供された資格情報は正しくありません。',
        'password': 'パスワード',
        'throttle': 'ログイン試行が多すぎます。 :seconds秒後にもう一度お試しください。',
        'unauthenticated': '認証されていません。',
        'login': 'ログイン',
        'logout': 'ログアウト',
        'email': 'メール',
        'success': '成功',
        'error': 'エラー',
        'warning': '警告',
        'save': '保存',
        'cancel': 'キャンセル',
        'delete': '削除',
        'edit': '編集',
        'create': '作成',
        'update': '更新',
        'add': '追加',
        'dashboard': 'ダッシュボード',
        'automation': 'オートメーション',
        'webhook': 'ウェブフック',
        'trigger': 'トリガー',
        'action': 'アクション',
        'users': 'ユーザー',
        'settings': '設定',
        'profile': 'プロフィール',
        'language': '言語',
        'theme': 'テーマ',
        'export': 'エクスポート',
        'import': 'インポート',
        'download': 'ダウンロード',
        'upload': 'アップロード',
        'activity': 'アクティビティ',
        'messages': 'メッセージ',
        'notifications': '通知',
    },
    'ru': {  # الروسية
        'login_successful': 'Вход выполнен успешно',
        'logout_successful': 'Выход выполнен успешно',
        'failed': 'Предоставленные учетные данные неверны.',
        'password': 'Пароль',
        'throttle': 'Слишком много попыток входа. Пожалуйста, попробуйте еще раз через :seconds секунд.',
        'unauthenticated': 'Не аутентифицирован.',
        'login': 'Вход',
        'logout': 'Выход',
        'email': 'Email',
        'success': 'Успех',
        'error': 'Ошибка',
        'warning': 'Предупреждение',
        'save': 'Сохранить',
        'cancel': 'Отмена',
        'delete': 'Удалить',
        'edit': 'Редактировать',
        'create': 'Создать',
        'update': 'Обновить',
        'add': 'Добавить',
        'dashboard': 'Панель управления',
        'automation': 'Автоматизация',
        'webhook': 'Вебхук',
        'trigger': 'Триггер',
        'action': 'Действие',
        'users': 'Пользователи',
        'settings': 'Параметры',
        'profile': 'Профиль',
        'language': 'Язык',
        'theme': 'Тема',
        'export': 'Экспорт',
        'import': 'Импорт',
        'download': 'Загрузить',
        'upload': 'Загрузить',
        'activity': 'Активность',
        'messages': 'Сообщения',
        'notifications': 'Уведомления',
    },
    'tr': {  # التركية
        'login_successful': 'Giriş başarılı',
        'logout_successful': 'Çıkış başarılı',
        'failed': 'Sağlanan kimlik bilgileri hatalı.',
        'password': 'Şifre',
        'throttle': 'Çok fazla giriş denemesi. Lütfen :seconds saniye içinde tekrar deneyin.',
        'unauthenticated': 'Kimlik doğrulanmadı.',
        'login': 'Giriş Yap',
        'logout': 'Çıkış Yap',
        'email': 'E-posta',
        'success': 'Başarılı',
        'error': 'Hata',
        'warning': 'Uyarı',
        'save': 'Kaydet',
        'cancel': 'İptal',
        'delete': 'Sil',
        'edit': 'Düzenle',
        'create': 'Oluştur',
        'update': 'Güncelle',
        'add': 'Ekle',
        'dashboard': 'Kontrol Paneli',
        'automation': 'Otomasyon',
        'webhook': 'Webhook',
        'trigger': 'Tetikleyici',
        'action': 'İşlem',
        'users': 'Kullanıcılar',
        'settings': 'Ayarlar',
        'profile': 'Profil',
        'language': 'Dil',
        'theme': 'Tema',
        'export': 'Dışa Aktar',
        'import': 'İçe Aktar',
        'download': 'İndir',
        'upload': 'Yükle',
        'activity': 'Etkinlik',
        'messages': 'Mesajlar',
        'notifications': 'Bildirimler',
    },
    'he': {  # العبرية
        'login_successful': 'הכניסה הצליחה',
        'logout_successful': 'היציאה הצליחה',
        'failed': 'פרטי ההכנסה שסופקו אינם נכונים.',
        'password': 'סיסמה',
        'throttle': 'יותר מדי ניסיונות כניסה. אנא נסה שוב ב-:seconds שניות.',
        'unauthenticated': 'לא מאומת.',
        'login': 'כניסה',
        'logout': 'יציאה',
        'email': 'דוא״ל',
        'success': 'הצלחה',
        'error': 'שגיאה',
        'warning': 'אזהרה',
        'save': 'שמור',
        'cancel': 'ביטול',
        'delete': 'מחק',
        'edit': 'ערוך',
        'create': 'צור',
        'update': 'עדכן',
        'add': 'הוסף',
        'dashboard': 'לוח בקרה',
        'automation': 'אוטומציה',
        'webhook': 'Webhook',
        'trigger': 'הפעלה',
        'action': 'פעולה',
        'users': 'משתמשים',
        'settings': 'הגדרות',
        'profile': 'פרופיל',
        'language': 'שפה',
        'theme': 'ערכת נושא',
        'export': 'ייצוא',
        'import': 'ייבוא',
        'download': 'הורדה',
        'upload': 'העלאה',
        'activity': 'פעילות',
        'messages': 'הודעות',
        'notifications': 'התראות',
    },
    'es': {  # الإسبانية
        'login_successful': 'Inicio de sesión exitoso',
        'logout_successful': 'Cierre de sesión exitoso',
        'failed': 'Las credenciales proporcionadas son incorrectas.',
        'password': 'Contraseña',
        'throttle': 'Demasiados intentos de inicio de sesión. Inténtelo de nuevo en :seconds segundos.',
        'unauthenticated': 'No autenticado.',
        'login': 'Iniciar sesión',
        'logout': 'Cerrar sesión',
        'email': 'Correo electrónico',
        'success': 'Éxito',
        'error': 'Error',
        'warning': 'Advertencia',
        'save': 'Guardar',
        'cancel': 'Cancelar',
        'delete': 'Eliminar',
        'edit': 'Editar',
        'create': 'Crear',
        'update': 'Actualizar',
        'add': 'Añadir',
        'dashboard': 'Panel de control',
        'automation': 'Automatización',
        'webhook': 'Webhook',
        'trigger': 'Disparador',
        'action': 'Acción',
        'users': 'Usuarios',
        'settings': 'Configuración',
        'profile': 'Perfil',
        'language': 'Idioma',
        'theme': 'Tema',
        'export': 'Exportar',
        'import': 'Importar',
        'download': 'Descargar',
        'upload': 'Cargar',
        'activity': 'Actividad',
        'messages': 'Mensajes',
        'notifications': 'Notificaciones',
    },
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

def translate_value(value, lang_code, key):
    """ترجمة قيمة واحدة مع معالجة النصوص المعقدة"""
    if lang_code not in COMPREHENSIVE_DICT:
        return value
    
    # البحث عن ترجمة دقيقة
    key_lower = key.lower()
    if key_lower in COMPREHENSIVE_DICT[lang_code]:
        return COMPREHENSIVE_DICT[lang_code][key_lower]
    
    # محاولة العثور على كلمات مفتاحية في النص
    value_lower = value.lower()
    for en_word, tr_word in COMPREHENSIVE_DICT[lang_code].items():
        if en_word in value_lower:
            value = value.replace(en_word, tr_word)
    
    return value

def main():
    print("=" * 80)
    print("🌍 نظام الترجمة الاحترافي الشامل")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد الإنجليزية غير موجود")
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
    
    languages = list(COMPREHENSIVE_DICT.keys())
    
    for lang_code in languages:
        print(f"🔄 {lang_code}: ترجمة جميع الملفات...")
        
        lang_dir = LANG_DIR / lang_code
        lang_dir.mkdir(exist_ok=True)
        
        for filename, english_content in english_files.items():
            en_translations = extract_php_array(english_content)
            translated = {}
            
            for key, value in en_translations.items():
                translated[key] = translate_value(value, lang_code, key)
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            print(f"  ✓ {filename}")
        
        print(f"✅ {lang_code} اكتملت\n")
    
    print("=" * 80)
    print("✅ ✅ ✅ اكتملت جميع الترجمات الاحترافية بنجاح!")
    print("=" * 80)

if __name__ == '__main__':
    main()
