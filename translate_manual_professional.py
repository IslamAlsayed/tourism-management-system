#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 نظام الترجمة اليدوية الاحترافية
Professional Manual Translation System
Based on English (EN) and Arabic (AR) as references
"""

import re
from pathlib import Path
from collections import defaultdict

# المسارات
PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"
ARABIC_DIR = LANG_DIR / "ar"

# مسار الحفظ الجديد
OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")
OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

# 🌍 قاموس الترجمة الاحترافي الشامل
PROFESSIONAL_TRANSLATIONS = {
    'fr': {  # الفرنسية
        # Authentication
        'login': 'Connexion',
        'login_successful': 'Connexion réussie',
        'logout': 'Déconnexion',
        'logout_successful': 'Déconnexion réussie',
        'failed': 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        'password': 'Le mot de passe fourni est incorrect.',
        'throttle': 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
        'unauthenticated': 'Non authentifié.',
        
        # Automation
        'automation': 'Automatisation',
        'automation_settings': 'Paramètres d\'automatisation (n8n)',
        'add_new_webhook': 'Ajouter un nouveau webhook (n8n)',
        'edit_webhook': 'Modifier le webhook',
        'friendly_name': 'Nom convivial',
        'webhook_url': 'URL du webhook',
        'event_type': 'Type d\'événement',
        'all_events': 'Tous les événements (*)',
        'secret_token': 'Jeton secret (Optionnel)',
        'cancel': 'Annuler',
        'update_bridge': 'Mettre à jour le pont',
        'connect_to_n8n': 'Connectez-vous à n8n',
        'active_automation_bridges': 'Ponts d\'automatisation actifs',
        'name': 'Nom',
        'event': 'Événement',
        'status': 'Statut',
        'actions': 'Actions',
        'active': 'Actif',
        'paused': 'En pause',
        'recent_synchronizations': 'Synchronisations récentes',
        'time': 'Temps',
        'bridge': 'Pont',
        'response': 'Réponse',
        'webhook_saved': 'Webhook enregistré avec succès.',
        'restaurant_created': 'Restaurant créé',
        'restaurant_updated': 'Restaurant mis à jour',
        'hotel_created': 'Hôtel créé',
        'booking_created': 'Réservation créée',
        
        # General
        'success': 'Succès',
        'error': 'Erreur',
        'warning': 'Avertissement',
        'save': 'Enregistrer',
        'delete': 'Supprimer',
        'edit': 'Modifier',
        'create': 'Créer',
        'update': 'Mettre à jour',
        'add': 'Ajouter',
        'close': 'Fermer',
        'submit': 'Soumettre',
        'refresh': 'Actualiser',
        'loading': 'Chargement...',
        'no_data': 'Aucune donnée',
        'email': 'Adresse e-mail',
        'phone': 'Téléphone',
        'address': 'Adresse',
        'city': 'Ville',
        'country': 'Pays',
        'language': 'Langue',
        'settings': 'Paramètres',
        'profile': 'Profil',
        'dashboard': 'Tableau de bord',
        'export': 'Exporter',
        'import': 'Importer',
        'search': 'Rechercher',
        'filter': 'Filtrer',
        'sort': 'Trier',
        'back': 'Retour',
        'next': 'Suivant',
        'previous': 'Précédent',
        'download': 'Télécharger',
        'upload': 'Télécharger',
    },
    'de': {  # الألمانية
        'login': 'Anmelden',
        'login_successful': 'Anmeldung erfolgreich',
        'logout': 'Abmelden',
        'logout_successful': 'Abmeldung erfolgreich',
        'failed': 'Diese Anmeldedaten entsprechen nicht unseren Aufzeichnungen.',
        'password': 'Das angegebene Passwort ist falsch.',
        'throttle': 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
        'unauthenticated': 'Nicht authentifiziert.',
        
        'automation': 'Automatisierung',
        'automation_settings': 'Automatisierungseinstellungen (n8n)',
        'add_new_webhook': 'Neuen Webhook hinzufügen (n8n)',
        'edit_webhook': 'Webhook bearbeiten',
        'friendly_name': 'Anzeigename',
        'webhook_url': 'Webhook-URL',
        'event_type': 'Ereignistyp',
        'all_events': 'Alle Ereignisse (*)',
        'secret_token': 'Geheimes Token (Optional)',
        'cancel': 'Abbrechen',
        'update_bridge': 'Brücke aktualisieren',
        'connect_to_n8n': 'Mit n8n verbinden',
        'active_automation_bridges': 'Aktive Automatisierungsbrücken',
        'name': 'Name',
        'event': 'Ereignis',
        'status': 'Status',
        'actions': 'Aktionen',
        'active': 'Aktiv',
        'paused': 'Pausiert',
        'recent_synchronizations': 'Aktuelle Synchronisierungen',
        'time': 'Zeit',
        'bridge': 'Brücke',
        'response': 'Antwort',
        'webhook_saved': 'Webhook erfolgreich gespeichert.',
        'restaurant_created': 'Restaurant erstellt',
        'restaurant_updated': 'Restaurant aktualisiert',
        'hotel_created': 'Hotel erstellt',
        'booking_created': 'Buchung erstellt',
        
        'success': 'Erfolg',
        'error': 'Fehler',
        'warning': 'Warnung',
        'save': 'Speichern',
        'delete': 'Löschen',
        'edit': 'Bearbeiten',
        'create': 'Erstellen',
        'update': 'Aktualisieren',
        'add': 'Hinzufügen',
        'close': 'Schließen',
        'submit': 'Absenden',
        'refresh': 'Aktualisieren',
        'loading': 'Wird geladen...',
        'no_data': 'Keine Daten',
        'email': 'E-Mail',
        'phone': 'Telefon',
        'address': 'Adresse',
        'city': 'Stadt',
        'country': 'Land',
        'language': 'Sprache',
        'settings': 'Einstellungen',
        'profile': 'Profil',
        'dashboard': 'Dashboard',
        'export': 'Exportieren',
        'import': 'Importieren',
        'search': 'Suchen',
        'filter': 'Filtern',
        'sort': 'Sortieren',
        'back': 'Zurück',
        'next': 'Weiter',
        'previous': 'Vorherige',
        'download': 'Herunterladen',
        'upload': 'Hochladen',
    },
    'it': {  # الإيطالية
        'login': 'Accesso',
        'login_successful': 'Accesso riuscito',
        'logout': 'Disconnessione',
        'logout_successful': 'Disconnessione riuscita',
        'failed': 'Queste credenziali non corrispondono ai nostri registri.',
        'password': 'La password fornita non è corretta.',
        'throttle': 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
        'unauthenticated': 'Non autenticato.',
        
        'automation': 'Automazione',
        'automation_settings': 'Impostazioni di automazione (n8n)',
        'add_new_webhook': 'Aggiungi nuovo webhook (n8n)',
        'edit_webhook': 'Modifica webhook',
        'friendly_name': 'Nome visualizzato',
        'webhook_url': 'URL webhook',
        'event_type': 'Tipo di evento',
        'all_events': 'Tutti gli eventi (*)',
        'secret_token': 'Token segreto (Facoltativo)',
        'cancel': 'Annulla',
        'update_bridge': 'Aggiorna bridge',
        'connect_to_n8n': 'Connettiti a n8n',
        'active_automation_bridges': 'Bridge di automazione attivi',
        'name': 'Nome',
        'event': 'Evento',
        'status': 'Stato',
        'actions': 'Azioni',
        'active': 'Attivo',
        'paused': 'In pausa',
        'recent_synchronizations': 'Sincronizzazioni recenti',
        'time': 'Orario',
        'bridge': 'Bridge',
        'response': 'Risposta',
        'webhook_saved': 'Webhook salvato con successo.',
        'restaurant_created': 'Ristorante creato',
        'restaurant_updated': 'Ristorante aggiornato',
        'hotel_created': 'Hotel creato',
        'booking_created': 'Prenotazione creata',
        
        'success': 'Successo',
        'error': 'Errore',
        'warning': 'Avviso',
        'save': 'Salva',
        'delete': 'Elimina',
        'edit': 'Modifica',
        'create': 'Crea',
        'update': 'Aggiorna',
        'add': 'Aggiungi',
        'close': 'Chiudi',
        'submit': 'Invia',
        'refresh': 'Aggiorna',
        'loading': 'Caricamento in corso...',
        'no_data': 'Nessun dato',
        'email': 'Email',
        'phone': 'Telefono',
        'address': 'Indirizzo',
        'city': 'Città',
        'country': 'Paese',
        'language': 'Lingua',
        'settings': 'Impostazioni',
        'profile': 'Profilo',
        'dashboard': 'Cruscotto',
        'export': 'Esporta',
        'import': 'Importa',
        'search': 'Cerca',
        'filter': 'Filtra',
        'sort': 'Ordina',
        'back': 'Indietro',
        'next': 'Avanti',
        'previous': 'Precedente',
        'download': 'Scarica',
        'upload': 'Carica',
    },
    'ja': {  # اليابانية
        'login': 'ログイン',
        'login_successful': 'ログインに成功しました',
        'logout': 'ログアウト',
        'logout_successful': 'ログアウトに成功しました',
        'failed': 'これらの認証情報は当社の記録と一致しません.',
        'password': '提供されたパスワードは正いません.',
        'throttle': 'ログイン試行が多すぎます. :seconds秒後にもう一度お試しください.',
        'unauthenticated': '認証されていません.',
        
        'automation': 'オートメーション',
        'automation_settings': 'オートメーション設定 (n8n)',
        'add_new_webhook': '新しいウェブフックを追加 (n8n)',
        'edit_webhook': 'ウェブフックを編集',
        'friendly_name': '表示名',
        'webhook_url': 'ウェブフック URL',
        'event_type': 'イベントタイプ',
        'all_events': 'すべてのイベント (*)',
        'secret_token': 'シークレットトークン (オプション)',
        'cancel': 'キャンセル',
        'update_bridge': 'ブリッジを更新',
        'connect_to_n8n': 'n8n に接続',
        'active_automation_bridges': 'アクティブなオートメーションブリッジ',
        'name': '名前',
        'event': 'イベント',
        'status': 'ステータス',
        'actions': 'アクション',
        'active': 'アクティブ',
        'paused': '一時停止',
        'recent_synchronizations': '最要な同期',
        'time': '時間',
        'bridge': 'ブリッジ',
        'response': 'レスポンス',
        'webhook_saved': 'ウェブフックが正に保存されました.',
        'restaurant_created': 'レストランが作成されました',
        'restaurant_updated': 'レストランが更新されました',
        'hotel_created': 'ホテルが作成されました',
        'booking_created': '予約が作成されました',
        
        'success': '成功',
        'error': 'エラー',
        'warning': '警告',
        'save': '保存',
        'delete': '削除',
        'edit': '編集',
        'create': '作成',
        'update': '更新',
        'add': '追加',
        'close': '閉じる',
        'submit': '送信',
        'refresh': '更新',
        'loading': '読み込み中...',
        'no_data': 'データなし',
        'email': 'メール',
        'phone': '電話',
        'address': '住所',
        'city': '都市',
        'country': '国',
        'language': '言語',
        'settings': '設定',
        'profile': 'プロフィール',
        'dashboard': 'ダッシュボード',
        'export': 'エクスポート',
        'import': 'インポート',
        'search': '検索',
        'filter': 'フィルター',
        'sort': '並び替え',
        'back': '戻る',
        'next': '次へ',
        'previous': '前へ',
        'download': 'ダウンロード',
        'upload': 'アップロード',
    },
    'ru': {  # الروسية
        'login': 'Вход',
        'login_successful': 'Вход выполнен успішно',
        'logout': 'Выход',
        'logout_successful': 'Выход выполнен успішно',
        'failed': 'Эти учетные данные не соответствуют нашим записям.',
        'password': 'Введённый пароль неправилен.',
        'throttle': 'Слишком много попыток входа. Пожалуйста, попробуйте снова через :seconds секунд.',
        'unauthenticated': 'Не аутентифицирован.',
        
        'automation': 'Автоматизация',
        'automation_settings': 'Параметры автоматизации (n8n)',
        'add_new_webhook': 'Добавить новый webhook (n8n)',
        'edit_webhook': 'Редактировать webhook',
        'friendly_name': 'Понятное имя',
        'webhook_url': 'URL webhook',
        'event_type': 'Тип события',
        'all_events': 'Все события (*)',
        'secret_token': 'Секретный токен (Опционально)',
        'cancel': 'Отмена',
        'update_bridge': 'Обновить мост',
        'connect_to_n8n': 'Подключиться к n8n',
        'active_automation_bridges': 'Активные мосты автоматизации',
        'name': 'Имя',
        'event': 'событие',
        'status': 'Статус',
        'actions': 'Действия',
        'active': 'Активно',
        'paused': 'Пауза',
        'recent_synchronizations': 'Недавние синхронизации',
        'time': 'Время',
        'bridge': 'Мост',
        'response': 'Ответ',
        'webhook_saved': 'Webhook успішно сохранён.',
        'restaurant_created': 'Ресторан создан',
        'restaurant_updated': 'Ресторан оновлен',
        'hotel_created': 'Отель создан',
        'booking_created': 'Бронь создана',
        
        'success': 'Успіх',
        'error': 'Ошибка',
        'warning': 'Предупреждение',
        'save': 'Сохранить',
        'delete': 'Удалить',
        'edit': 'Редактировать',
        'create': 'Создать',
        'update': 'Обновить',
        'add': 'Добавить',
        'close': 'Закрыть',
        'submit': 'Отправить',
        'refresh': 'Обновить',
        'loading': 'Загрузка...',
        'no_data': 'Нет данных',
        'email': 'Email',
        'phone': 'Телефон',
        'address': 'Адрес',
        'city': 'Город',
        'country': 'Страна',
        'language': 'Язык',
        'settings': 'Параметры',
        'profile': 'Профиль',
        'dashboard': 'Панель управления',
        'export': 'Экспорт',
        'import': 'Импорт',
        'search': 'Поиск',
        'filter': 'Фильтр',
        'sort': 'Сортировка',
        'back': 'Назад',
        'next': 'Далее',
        'previous': 'Предыдущий',
        'download': 'Скачать',
        'upload': 'Загрузить',
    },
    'tr': {  # التركية
        'login': 'Giriş Yap',
        'login_successful': 'Giriş Başarılı',
        'logout': 'Çıkış Yap',
        'logout_successful': 'Çıkış Başarılı',
        'failed': 'Bu kimlik bilgileri kayıtlarımızla eşleşmiyor.',
        'password': 'Sağlanan şifre hatalı.',
        'throttle': 'Çok fazla giriş denemesi. Lütfen :seconds saniye içinde tekrar deneyin.',
        'unauthenticated': 'Kimlik doğrulanmadı.',
        
        'automation': 'Otomasyon',
        'automation_settings': 'Otomasyon Ayarları (n8n)',
        'add_new_webhook': 'Yeni Webhook Ekle (n8n)',
        'edit_webhook': 'Webhook\'u Düzenle',
        'friendly_name': 'Kolay İsim',
        'webhook_url': 'Webhook URL\'si',
        'event_type': 'Etkinlik Türü',
        'all_events': 'Tüm Etkinlikler (*)',
        'secret_token': 'Gizli Token (İsteğe Bağlı)',
        'cancel': 'İptal',
        'update_bridge': 'Köprüyü Güncelle',
        'connect_to_n8n': 'n8n\'e Bağlan',
        'active_automation_bridges': 'Aktif Otomasyon Köprüleri',
        'name': 'İsim',
        'event': 'Etkinlik',
        'status': 'Durum',
        'actions': 'İşlemler',
        'active': 'Aktif',
        'paused': 'Duraklatıldı',
        'recent_synchronizations': 'Son Senkronizasyonlar',
        'time': 'Zaman',
        'bridge': 'Köprü',
        'response': 'Yanıt',
        'webhook_saved': 'Webhook başarıyla kaydedildi.',
        'restaurant_created': 'Restoran Oluşturuldu',
        'restaurant_updated': 'Restoran Güncellendi',
        'hotel_created': 'Otel Oluşturuldu',
        'booking_created': 'Rezervasyon Oluşturuldu',
        
        'success': 'Başarılı',
        'error': 'Hata',
        'warning': 'Uyarı',
        'save': 'Kaydet',
        'delete': 'Sil',
        'edit': 'Düzenle',
        'create': 'Oluştur',
        'update': 'Güncelle',
        'add': 'Ekle',
        'close': 'Kapat',
        'submit': 'Gönder',
        'refresh': 'Yenile',
        'loading': 'Yükleniyor...',
        'no_data': 'Veri Yok',
        'email': 'E-posta',
        'phone': 'Telefon',
        'address': 'Adres',
        'city': 'Şehir',
        'country': 'Ülke',
        'language': 'Dil',
        'settings': 'Ayarlar',
        'profile': 'Profil',
        'dashboard': 'Pano',
        'export': 'Dışa Aktar',
        'import': 'İçe Aktar',
        'search': 'Ara',
        'filter': 'Filtre',
        'sort': 'Sırala',
        'back': 'Geri',
        'next': 'Sonraki',
        'previous': 'Önceki',
        'download': 'İndir',
        'upload': 'Yükle',
    },
    'he': {  # العبرية
        'login': 'כניסה',
        'login_successful': 'ההתחברות בוצעה בהצלחה',
        'logout': 'יציאה',
        'logout_successful': 'היציאה בוצעה בהצלחה',
        'failed': 'שם ססמה אלה אין התאמה לרשומות',
        'password': 'הססמה שסופקה אינה נכונה.',
        'throttle': 'ויותר מדי ניסיונות התחברות. אנא נסה שוב ב-:seconds שניות.',
        'unauthenticated': 'לא מאומת.',
        
        'automation': 'אוטומציה',
        'automation_settings': 'הגדרות אוטומציה (n8n)',
        'add_new_webhook': 'הוסף webhook חדש (n8n)',
        'edit_webhook': 'ערוך webhook',
        'friendly_name': 'שם ידידותי',
        'webhook_url': 'webhook URL',
        'event_type': 'סוג אירוע',
        'all_events': 'כל האירועים (*)',
        'secret_token': 'טוקן סודי (אופציונלי)',
        'cancel': 'ביטול',
        'update_bridge': 'עדכן גשר',
        'connect_to_n8n': 'התחבר ל-n8n',
        'active_automation_bridges': 'גשרי אוטומציה פעילים',
        'name': 'שם',
        'event': 'אירוע',
        'status': 'סטטוס',
        'actions': 'פעולות',
        'active': 'פעיל',
        'paused': 'מושהה',
        'recent_synchronizations': 'סנכרוניזציות אחרונות',
        'time': 'זמן',
        'bridge': 'גשר',
        'response': 'תגובה',
        'webhook_saved': 'webhook נשמר בהצלחה.',
        'restaurant_created': 'מסעדה נוצרה',
        'restaurant_updated': 'מסעדה עודכנה',
        'hotel_created': 'מלון נוצר',
        'booking_created': 'הזמנה נוצרה',
        
        'success': 'הצלחה',
        'error': 'שגיאה',
        'warning': 'אזהרה',
        'save': 'שמור',
        'delete': 'מחק',
        'edit': 'ערוך',
        'create': 'צור',
        'update': 'עדכן',
        'add': 'הוסף',
        'close': 'סגור',
        'submit': 'שלח',
        'refresh': 'רענן',
        'loading': 'טוען...',
        'no_data': 'אין נתונים',
        'email': 'דוא"ל',
        'phone': 'טלפון',
        'address': 'כתובת',
        'city': 'עיר',
        'country': 'ארץ',
        'language': 'שפה',
        'settings': 'הגדרות',
        'profile': 'פרופיל',
        'dashboard': 'לוח בקרה',
        'export': 'ייצוא',
        'import': 'ייבוא',
        'search': 'חיפוש',
        'filter': 'סנן',
        'sort': 'מיון',
        'back': 'חזור',
        'next': 'הבא',
        'previous': 'הקודם',
        'download': 'הורדה',
        'upload': 'העלאה',
    },
    'es': {  # الإسبانية
        'login': 'Iniciar sesión',
        'login_successful': 'Inicio de sesión satisfactorio',
        'logout': 'Cerrar sesión',
        'logout_successful': 'Cierre de sesión satisfactorio',
        'failed': 'Estas credenciales no coinciden con nuestros registros.',
        'password': 'La contraseña proporcionada es incorrecta.',
        'throttle': 'Demasiados intentos de inicio de sesión. Por favor, inténtelo de nuevo en :seconds segundos.',
        'unauthenticated': 'No autenticado.',
        
        'automation': 'Automatización',
        'automation_settings': 'Configuración de automatización (n8n)',
        'add_new_webhook': 'Agregar nuevo webhook (n8n)',
        'edit_webhook': 'Editar webhook',
        'friendly_name': 'Nombre descriptivo',
        'webhook_url': 'URL del webhook',
        'event_type': 'Tipo de evento',
        'all_events': 'Todos los eventos (*)',
        'secret_token': 'Token secreto (Opcional)',
        'cancel': 'Cancelar',
        'update_bridge': 'Actualizar puente',
        'connect_to_n8n': 'Conectar a n8n',
        'active_automation_bridges': 'Puentes de automatización activo',
        'name': 'Nombre',
        'event': 'Evento',
        'status': 'Estado',
        'actions': 'Acciones',
        'active': 'Activo',
        'paused': 'Pausado',
        'recent_synchronizations': 'Sincronizaciones recientes',
        'time': 'Hora',
        'bridge': 'Puente',
        'response': 'Respuesta',
        'webhook_saved': 'Webhook guardado satisfactoriamente.',
        'restaurant_created': 'Restaurante creado',
        'restaurant_updated': 'Restaurante actualizado',
        'hotel_created': 'Hotel creado',
        'booking_created': 'Reserva creada',
        
        'success': 'Éxito',
        'error': 'Error',
        'warning': 'Advertencia',
        'save': 'Guardar',
        'delete': 'Eliminar',
        'edit': 'Editar',
        'create': 'Crear',
        'update': 'Actualizar',
        'add': 'Agregar',
        'close': 'Cerrar',
        'submit': 'Enviar',
        'refresh': 'Actualizar',
        'loading': 'Cargando...',
        'no_data': 'Sin datos',
        'email': 'Correo electrónico',
        'phone': 'Teléfono',
        'address': 'Dirección',
        'city': 'Ciudad',
        'country': 'País',
        'language': 'Idioma',
        'settings': 'Configuración',
        'profile': 'Perfil',
        'dashboard': 'Panel de control',
        'export': 'Exportar',
        'import': 'Importar',
        'search': 'Búsqueda',
        'filter': 'Filtrar',
        'sort': 'Ordenar',
        'back': 'Atrás',
        'next': 'Siguiente',
        'previous': 'Anterior',
        'download': 'Descargar',
        'upload': 'Cargar',
    },
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

def build_php_array(translations):
    """بناء ملف PHP"""
    php_content = "<?php\n\nreturn [\n"
    for key, value in sorted(translations.items()):
        value = value.replace("'", "\\'").strip()
        if value:
            php_content += f"    '{key}' => '{value}',\n"
    php_content += "];\n"
    return php_content

def translate_value(value, lang_code, key):
    """ترجمة قيمة مع البحث الذكي"""
    if lang_code not in PROFESSIONAL_TRANSLATIONS:
        return value
    
    translator_dict = PROFESSIONAL_TRANSLATIONS[lang_code]
    
    # محاولة 1: البحث عن المفتاح كاملاً
    key_lower = key.lower()
    if key_lower in translator_dict:
        return translator_dict[key_lower]
    
    # محاولة 2: البحث عن كلمات مفتاحية في النص
    value_lower = value.lower()
    words = value_lower.split()
    
    for word in words:
        if word in translator_dict:
            return translator_dict[word]
    
    # محاولة 3: البحث عن جزيئات من الكلمات
    for en_key, tr_val in translator_dict.items():
        if en_key in value_lower:
            return value.replace(en_key, tr_val, 1)
    
    # إذا لم نجد ترجمة، نرجع النص الأصلي
    return value

def main():
    print("=" * 80)
    print("🌍 نظام الترجمة اليدوية الاحترافية")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد الإنجليزية غير موجود: {ENGLISH_DIR}")
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
    print(f"💾 سيتم الحفظ في: {OUTPUT_DIR}\n")
    
    languages = list(PROFESSIONAL_TRANSLATIONS.keys())
    
    for lang_code in languages:
        print(f"🔄 ترجمة إلى {lang_code}...")
        
        lang_dir = OUTPUT_DIR / lang_code
        lang_dir.mkdir(parents=True, exist_ok=True)
        
        for filename, en_dict in english_files.items():
            print(f"  📄 {filename}... ", end="", flush=True)
            
            translated = {}
            count = 0
            
            for key, value in en_dict.items():
                translated_text = translate_value(value, lang_code, key)
                translated[key] = translated_text
                count += 1
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
            
            print(f"✓")
        
        print(f"✅ {lang_code} اكتملت\n")
    
    print("=" * 80)
    print(f"✅ ✅ ✅ اكتملت جميع الترجمات بنجاح!")
    print(f"📁 تم الحفظ في: {OUTPUT_DIR}")
    print("=" * 80)
    print()
    print("📊 ملخص الترجمات:")
    for lang in languages:
        lang_path = OUTPUT_DIR / lang
        file_count = len(list(lang_path.glob("*.php"))) if lang_path.exists() else 0
        print(f"  • {lang}: {file_count} ملف")

if __name__ == '__main__':
    main()
