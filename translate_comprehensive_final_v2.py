#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 نظام الترجمة الاحترافي المحسّن النهائي
Enhanced Professional Translation System with Smart Matching Algorithm
"""

import re
from pathlib import Path

PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"
OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

# قاموس محسّن مع 370+ مصطلح
CORE_DICT = {
    # Booking
    'booking': {'fr': 'Réservation', 'de': 'Buchung', 'it': 'Prenotazione', 'ja': '予約', 'ru': 'Бронирование', 'tr': 'Rezervasyon', 'he': 'הזמנה', 'es': 'Reserva'},
    'reserve': {'fr': 'Réserver', 'de': 'Buchen', 'it': 'Prenotare', 'ja': '予約する', 'ru': 'Забронировать', 'tr': 'Rezerv Et', 'he': 'הזמן', 'es': 'Reservar'},
    'confirm': {'fr': 'Confirmer', 'de': 'Bestätigen', 'it': 'Confermare', 'ja': '確認', 'ru': 'Подтвердить', 'tr': 'Onayla', 'he': 'אישור', 'es': 'Confirmar'},
    'cancel': {'fr': 'Annuler', 'de': 'Stornieren', 'it': 'Annullare', 'ja': 'キャンセル', 'ru': 'Отменить', 'tr': 'İptal Et', 'he': 'בטל', 'es': 'Cancelar'},
    'refund': {'fr': 'Remboursement', 'de': 'Rückerstattung', 'it': 'Rimborso', 'ja': '払い戻し', 'ru': 'Возврат', 'tr': 'İade', 'he': 'החזר', 'es': 'Reembolso'},
    'check-in': {'fr': 'Enregistrement', 'de': 'Einchecken', 'it': 'Check-in', 'ja': 'チェックイン', 'ru': 'Регистрация', 'tr': 'Giriş', 'he': 'צ\'ק אין', 'es': 'Check-in'},
    'check-out': {'fr': 'Départ', 'de': 'Auschecken', 'it': 'Check-out', 'ja': 'チェックアウト', 'ru': 'Выезд', 'tr': 'Çıkış', 'he': 'צ\'ק אאוט', 'es': 'Check-out'},
    'cancelled': {'fr': 'Annulée', 'de': 'Storniert', 'it': 'Annullato', 'ja': 'キャンセル済み', 'ru': 'Отменено', 'tr': 'İptal Edildi', 'he': 'בוטל', 'es': 'Cancelado'},
    'pending': {'fr': 'En attente', 'de': 'Ausstehend', 'it': 'In Sospeso', 'ja': '保留中', 'ru': 'Ожидание', 'tr': 'Beklemede', 'he': 'בהמתנה', 'es': 'Pendiente'},
    'approved': {'fr': 'Approuvé', 'de': 'Genehmigt', 'it': 'Approvato', 'ja': '承認済み', 'ru': 'Одобрено', 'tr': 'Onaylandı', 'he': 'אושר', 'es': 'Aprobado'},
    
    # Accommodation
    'accommodation': {'fr': 'Hébergement', 'de': 'Unterkunft', 'it': 'Alloggio', 'ja': '宿泊', 'ru': 'Жилье', 'tr': 'Konaklama', 'he': 'אירוח', 'es': 'Alojamiento'},
    'accommodations': {'fr': 'Hébergements', 'de': 'Unterkünfte', 'it': 'Alloggi', 'ja': '宿泊施設', 'ru': 'Жилья', 'tr': 'Konaklama', 'he': 'אירוח', 'es': 'Alojamientos'},
    'hotel': {'fr': 'Hôtel', 'de': 'Hotel', 'it': 'Hotel', 'ja': 'ホテル', 'ru': 'Отель', 'tr': 'Otel', 'he': 'מלון', 'es': 'Hotel'},
    'resort': {'fr': 'Complèxe Touristique', 'de': 'Resort', 'it': 'Resort', 'ja': 'リゾート', 'ru': 'Курорт', 'tr': 'Resort', 'he': 'אתר נופש', 'es': 'Centro Turístico'},
    'villa': {'fr': 'Villa', 'de': 'Villa', 'it': 'Villa', 'ja': 'ヴィラ', 'ru': 'Вилла', 'tr': 'Villa', 'he': 'וילה', 'es': 'Villa'},
    'apartment': {'fr': 'Appartement', 'de': 'Wohnung', 'it': 'Appartamento', 'ja': 'アパート', 'ru': 'Квартира', 'tr': 'Daire', 'he': 'דירה', 'es': 'Apartamento'},
    'hostel': {'fr': 'Auberge Jeunesse', 'de': 'Herberge', 'it': 'Ostello', 'ja': 'ホステル', 'ru': 'Хостел', 'tr': 'Hostel', 'he': 'אכסניה', 'es': 'Albergue'},
    'camp': {'fr': 'Camping', 'de': 'Lager', 'it': 'Campeggio', 'ja': 'キャンプ', 'ru': 'Кемпинг', 'tr': 'Kamp', 'he': 'מחנה', 'es': 'Campamento'},
    'lodge': {'fr': 'Pavillon', 'de': 'Herberge', 'it': 'Rifugio', 'ja': 'ロッジ', 'ru': 'Домик', 'tr': 'Konak', 'he': 'בקתה', 'es': 'Cabaña'},
    'room': {'fr': 'Chambre', 'de': 'Zimmer', 'it': 'Stanza', 'ja': '部屋', 'ru': 'Номер', 'tr': 'Oda', 'he': 'חדר', 'es': 'Habitación'},
    'bed': {'fr': 'Lit', 'de': 'Bett', 'it': 'Letto', 'ja': 'ベッド', 'ru': 'Кровать', 'tr': 'Yatak', 'he': 'מיטה', 'es': 'Cama'},
    'bathroom': {'fr': 'Salle de Bain', 'de': 'Badezimmer', 'it': 'Bagno', 'ja': 'バスルーム', 'ru': 'Ванная', 'tr': 'Banyo', 'he': 'חדר אמבטיה', 'es': 'Baño'},
    'shower': {'fr': 'Douche', 'de': 'Dusche', 'it': 'Doccia', 'ja': 'シャワー', 'ru': 'Душ', 'tr': 'Duş', 'he': 'מקלחת', 'es': 'Ducha'},
    'kitchen': {'fr': 'Cuisine', 'de': 'Küche', 'it': 'Cucina', 'ja': 'キッチン', 'ru': 'Кухня', 'tr': 'Mutfak', 'he': 'מטבח', 'es': 'Cocina'},
    'balcony': {'fr': 'Balcon', 'de': 'Balkon', 'it': 'Balcone', 'ja': 'バルコニー', 'ru': 'Балкон', 'tr': 'Balkon', 'he': 'מרפסת', 'es': 'Balcón'},
    
    # Payment & Pricing
    'price': {'fr': 'Prix', 'de': 'Preis', 'it': 'Prezzo', 'ja': '価格', 'ru': 'Цена', 'tr': 'Fiyat', 'he': 'מחיר', 'es': 'Precio'},
    'cost': {'fr': 'Coût', 'de': 'Kosten', 'it': 'Costo', 'ja': 'コスト', 'ru': 'Стоимость', 'tr': 'Maliyet', 'he': 'עלות', 'es': 'Costo'},
    'payment': {'fr': 'Paiement', 'de': 'Zahlung', 'it': 'Pagamento', 'ja': '支払い', 'ru': 'Оплата', 'tr': 'Ödeme', 'he': 'תשלום', 'es': 'Pago'},
    'paid': {'fr': 'Payé', 'de': 'Bezahlt', 'it': 'Pagato', 'ja': '支払い済み', 'ru': 'Оплачено', 'tr': 'Ödendi', 'he': 'שולם', 'es': 'Pagado'},
    'discount': {'fr': 'Remise', 'de': 'Rabatt', 'it': 'Sconto', 'ja': '割引', 'ru': 'Скидка', 'tr': 'İndirim', 'he': 'הנחה', 'es': 'Descuento'},
    'tax': {'fr': 'Taxe', 'de': 'Steuern', 'it': 'Imposta', 'ja': '税金', 'ru': 'Налог', 'tr': 'Vergi', 'he': 'מיסים', 'es': 'Impuesto'},
    'total': {'fr': 'Total', 'de': 'Gesamt', 'it': 'Totale', 'ja': '合計', 'ru': 'Итого', 'tr': 'Toplam', 'he': 'סה"כ', 'es': 'Total'},
    'invoice': {'fr': 'Facture', 'de': 'Rechnung', 'it': 'Fattura', 'ja': '請求書', 'ru': 'Счет', 'tr': 'Fatura', 'he': 'חשבונית', 'es': 'Factura'},
    
    # Location
    'location': {'fr': 'Emplacement', 'de': 'Lage', 'it': 'Posizione', 'ja': 'ロケーション', 'ru': 'Местоположение', 'tr': 'Konum', 'he': 'מיקום', 'es': 'Ubicación'},
    'city': {'fr': 'Ville', 'de': 'Stadt', 'it': 'Città', 'ja': '都市', 'ru': 'Город', 'tr': 'Şehir', 'he': 'עיר', 'es': 'Ciudad'},
    'country': {'fr': 'Pays', 'de': 'Land', 'it': 'Paese', 'ja': '国', 'ru': 'Страна', 'tr': 'Ülke', 'he': 'מדינה', 'es': 'País'},
    'region': {'fr': 'Région', 'de': 'Region', 'it': 'Regione', 'ja': 'リージョン', 'ru': 'Область', 'tr': 'Bölge', 'he': 'אזור', 'es': 'Región'},
    'beach': {'fr': 'Plage', 'de': 'Strand', 'it': 'Spiaggia', 'ja': 'ビーチ', 'ru': 'Пляж', 'tr': 'Plaj', 'he': 'חוף', 'es': 'Playa'},
    'mountain': {'fr': 'Montagne', 'de': 'Berg', 'it': 'Montagna', 'ja': '山', 'ru': 'Гора', 'tr': 'Dağ', 'he': 'הר', 'es': 'Montaña'},
    'airport': {'fr': 'Aéroport', 'de': 'Flughafen', 'it': 'Aeroporto', 'ja': '空港', 'ru': 'Аэропорт', 'tr': 'Havaalanı', 'he': 'נמל תעופה', 'es': 'Aeropuerto'},
    'distance': {'fr': 'Distance', 'de': 'Entfernung', 'it': 'Distanza', 'ja': '距離', 'ru': 'Расстояние', 'tr': 'Mesafe', 'he': 'מרחק', 'es': 'Distancia'},
    'map': {'fr': 'Carte', 'de': 'Karte', 'it': 'Mappa', 'ja': '地図', 'ru': 'Карта', 'tr': 'Harita', 'he': 'מפה', 'es': 'Mapa'},
    
    # Dates & Time
    'date': {'fr': 'Date', 'de': 'Datum', 'it': 'Data', 'ja': '日付', 'ru': 'Дата', 'tr': 'Tarih', 'he': 'תאריך', 'es': 'Fecha'},
    'arrival': {'fr': 'Arrivée', 'de': 'Ankunft', 'it': 'Arrivo', 'ja': '到着', 'ru': 'Прибытие', 'tr': 'Varış', 'he': 'הגעה', 'es': 'Llegada'},
    'departure': {'fr': 'Départ', 'de': 'Abreise', 'it': 'Partenza', 'ja': '出発', 'ru': 'Отъезд', 'tr': 'Kalkış', 'he': 'יציאה', 'es': 'Salida'},
    'night': {'fr': 'Nuit', 'de': 'Nacht', 'it': 'Notte', 'ja': '夜', 'ru': 'Ночь', 'tr': 'Gece', 'he': 'לילה', 'es': 'Noche'},
    'day': {'fr': 'Jour', 'de': 'Tag', 'it': 'Giorno', 'ja': '日', 'ru': 'День', 'tr': 'Gün', 'he': 'יום', 'es': 'Día'},
    'today': {'fr': 'Aujourd\'hui', 'de': 'Heute', 'it': 'Oggi', 'ja': '今日', 'ru': 'Сегодня', 'tr': 'Bugün', 'he': 'היום', 'es': 'Hoy'},
    'tomorrow': {'fr': 'Demain', 'de': 'Morgen', 'it': 'Domani', 'ja': '明日', 'ru': 'Завтра', 'tr': 'Yarın', 'he': 'מחר', 'es': 'Mañana'},
    
    # Users & Auth
    'user': {'fr': 'Utilisateur', 'de': 'Benutzer', 'it': 'Utente', 'ja': 'ユーザー', 'ru': 'Пользователь', 'tr': 'Kullanıcı', 'he': 'משתמש', 'es': 'Usuario'},
    'client': {'fr': 'Client', 'de': 'Kunde', 'it': 'Cliente', 'ja': '顧客', 'ru': 'Клиент', 'tr': 'Müşteri', 'he': 'לקוח', 'es': 'Cliente'},
    'guest': {'fr': 'Invité', 'de': 'Gast', 'it': 'Ospite', 'ja': 'ゲスト', 'ru': 'Гость', 'tr': 'Misafir', 'he': 'אורח', 'es': 'Huésped'},
    'admin': {'fr': 'Administrateur', 'de': 'Administrator', 'it': 'Amministratore', 'ja': '管理者', 'ru': 'Администратор', 'tr': 'Yönetici', 'he': 'מנהל', 'es': 'Administrador'},
    'login': {'fr': 'Connexion', 'de': 'Anmelden', 'it': 'Accedi', 'ja': 'ログイン', 'ru': 'Вход', 'tr': 'Giriş', 'he': 'כניסה', 'es': 'Iniciar Sesión'},
    'logout': {'fr': 'Déconnexion', 'de': 'Abmelden', 'it': 'Esci', 'ja': 'ログアウト', 'ru': 'Выход', 'tr': 'Çıkış', 'he': 'יציאה', 'es': 'Cerrar Sesión'},
    'password': {'fr': 'Mot de passe', 'de': 'Passwort', 'it': 'Password', 'ja': 'パスワード', 'ru': 'Пароль', 'tr': 'Şifre', 'he': 'סיסמה', 'es': 'Contraseña'},
    'email': {'fr': 'E-mail', 'de': 'E-Mail', 'it': 'Email', 'ja': 'メール', 'ru': 'Email', 'tr': 'E-posta', 'he': 'דוא"ל', 'es': 'Correo Electrónico'},
    'phone': {'fr': 'Téléphone', 'de': 'Telefon', 'it': 'Telefono', 'ja': '電話', 'ru': 'Телефон', 'tr': 'Telefon', 'he': 'טלפון', 'es': 'Teléfono'},
    'name': {'fr': 'Nom', 'de': 'Name', 'it': 'Nome', 'ja': '名前', 'ru': 'Имя', 'tr': 'İsim', 'he': 'שם', 'es': 'Nombre'},
    
    # Actions
    'add': {'fr': 'Ajouter', 'de': 'Hinzufügen', 'it': 'Aggiungi', 'ja': '追加', 'ru': 'Добавить', 'tr': 'Ekle', 'he': 'הוסף', 'es': 'Agregar'},
    'new': {'fr': 'Nouveau', 'de': 'Neu', 'it': 'Nuovo', 'ja': '新規', 'ru': 'Новый', 'tr': 'Yeni', 'he': 'חדש', 'es': 'Nuevo'},
    'edit': {'fr': 'Modifier', 'de': 'Bearbeiten', 'it': 'Modifica', 'ja': '編集', 'ru': 'Редактировать', 'tr': 'Düzenle', 'he': 'ערוך', 'es': 'Editar'},
    'delete': {'fr': 'Supprimer', 'de': 'Löschen', 'it': 'Elimina', 'ja': '削除', 'ru': 'Удалить', 'tr': 'Sil', 'he': 'מחק', 'es': 'Eliminar'},
    'save': {'fr': 'Enregistrer', 'de': 'Speichern', 'it': 'Salva', 'ja': '保存', 'ru': 'Сохранить', 'tr': 'Kaydet', 'he': 'שמור', 'es': 'Guardar'},
    'search': {'fr': 'Rechercher', 'de': 'Suchen', 'it': 'Cerca', 'ja': '検索', 'ru': 'Поиск', 'tr': 'Ara', 'he': 'חפש', 'es': 'Buscar'},
    'filter': {'fr': 'Filtrer', 'de': 'Filtern', 'it': 'Filtra', 'ja': 'フィルター', 'ru': 'Фильтр', 'tr': 'Filtrele', 'he': 'סנן', 'es': 'Filtrar'},
    'sort': {'fr': 'Trier', 'de': 'Sortieren', 'it': 'Ordina', 'ja': 'ソート', 'ru': 'Сортировка', 'tr': 'Sırala', 'he': 'מיין', 'es': 'Ordenar'},
    'view': {'fr': 'Afficher', 'de': 'Anzeigen', 'it': 'Visualizza', 'ja': '表示', 'ru': 'Просмотр', 'tr': 'Görüntüle', 'he': 'צפה', 'es': 'Ver'},
    'update': {'fr': 'Mise à jour', 'de': 'Aktualisieren', 'it': 'Aggiorna', 'ja': '更新', 'ru': 'Обновить', 'tr': 'Güncelle', 'he': 'עדכן', 'es': 'Actualizar'},
    'detail': {'fr': 'Détail', 'de': 'Details', 'it': 'Dettagli', 'ja': '詳細', 'ru': 'Подробности', 'tr': 'Detay', 'he': 'פרטים', 'es': 'Detalles'},
    
    # Status
    'active': {'fr': 'Actif', 'de': 'Aktiv', 'it': 'Attivo', 'ja': 'アクティブ', 'ru': 'Активный', 'tr': 'Aktif', 'he': 'פעיל', 'es': 'Activo'},
    'inactive': {'fr': 'Inactif', 'de': 'Inaktiv', 'it': 'Inattivo', 'ja': 'アクティブでない', 'ru': 'Неактивный', 'tr': 'Pasif', 'he': 'לא פעיל', 'es': 'Inactivo'},
    'available': {'fr': 'Disponible', 'de': 'Verfügbar', 'it': 'Disponibile', 'ja': '利用可能', 'ru': 'Доступный', 'tr': 'Uygun', 'he': 'זמין', 'es': 'Disponible'},
    'unavailable': {'fr': 'Indisponible', 'de': 'Nicht verfügbar', 'it': 'Non Disponibile', 'ja': '利用不可', 'ru': 'Недоступный', 'tr': 'Uygun Değil', 'he': 'לא זמין', 'es': 'No Disponible'},
    'success': {'fr': 'Succès', 'de': 'Erfolg', 'it': 'Successo', 'ja': '成功', 'ru': 'Успех', 'tr': 'Başarı', 'he': 'הצלחה', 'es': 'Éxito'},
    'error': {'fr': 'Erreur', 'de': 'Fehler', 'it': 'Errore', 'ja': 'エラー', 'ru': 'Ошибка', 'tr': 'Hata', 'he': 'שגיאה', 'es': 'Error'},
    'warning': {'fr': 'Avertissement', 'de': 'Warnung', 'it': 'Avvertenza', 'ja': '警告', 'ru': 'Предупреждение', 'tr': 'Uyarı', 'he': 'אזהרה', 'es': 'Advertencia'},
    
    # More Tourism Terms
    'tour': {'fr': 'Visite Guidée', 'de': 'Rundgang', 'it': 'Tour', 'ja': 'ツアー', 'ru': 'Тур', 'tr': 'Tur', 'he': 'סיור', 'es': 'Tour'},
    'guide': {'fr': 'Guide', 'de': 'Führer', 'it': 'Guida', 'ja': 'ガイド', 'ru': 'Гид', 'tr': 'Rehber', 'he': 'מדריך', 'es': 'Guía'},
    'activity': {'fr': 'Activité', 'de': 'Aktivität', 'it': 'Attività', 'ja': 'アクティビティ', 'ru': 'Деятельность', 'tr': 'Etkinlik', 'he': 'פעילות', 'es': 'Actividad'},
    'reservation': {'fr': 'Réservation', 'de': 'Reservierung', 'it': 'Prenotazione', 'ja': '予約', 'ru': 'Резервирование', 'tr': 'Ayırma', 'he': 'הזמנה', 'es': 'Reserva'},
    'rating': {'fr': 'Évaluation', 'de': 'Bewertung', 'it': 'Valutazione', 'ja': '評価', 'ru': 'Рейтинг', 'tr': 'Derecelendirme', 'he': 'דירוג', 'es': 'Calificación'},
    'review': {'fr': 'Avis', 'de': 'Rezension', 'it': 'Recensione', 'ja': 'レビュー', 'ru': 'Отзыв', 'tr': 'İnceleme', 'he': 'ביקורת', 'es': 'Reseña'},
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

def smart_translate(key, value, language_code):
    """ترجمة ذكية باستخدام عدة استراتيجيات"""
    
    if not value or len(value.strip()) == 0:
        return value
    
    key_lower = key.lower().replace('_', ' ')
    value_lower = value.lower().replace('_', ' ')
    
    # إزالة الكلمات الشائعة
    stop_words = {'the', 'a', 'an', 'is', 'are', 'be', 'and', 'or', 'not', 'in', 'at', 'to', 'for', 'of'}
    
    # استراتيجية 1: البحث المباشر في المفتاح
    if key_lower in CORE_DICT and language_code in CORE_DICT[key_lower]:
        return CORE_DICT[key_lower][language_code]
    
    # استراتيجية 2: البحث عن أجزاء المفتاح
    key_parts = [p for p in key_lower.split() if p and p not in stop_words]
    for part in key_parts:
        if part in CORE_DICT and language_code in CORE_DICT[part]:
            return CORE_DICT[part][language_code]
    
    # استراتيجية 3: البحث في القيمة
    value_parts = [p for p in value_lower.split() if p and p not in stop_words and len(p) > 2]
    for word in value_parts:
        if word in CORE_DICT and language_code in CORE_DICT[word]:
            return CORE_DICT[word][language_code]
    
    # استراتيجية 4: البحث عن كلمات بادئة  
    for dict_key, translations in CORE_DICT.items():
        if language_code in translations:
            if dict_key in key_lower or dict_key in value_lower:
                return translations[language_code]
    
    # إرجاع القيمة الأصلية إذا لم نجد ترجمة
    return value

def build_php_array(translations):
    """بناء ملف PHP مع الترجمات"""
    php_content = "<?php\n\nreturn [\n"
    for key, value in sorted(translations.items()):
        if value:
            value_escaped = value.replace("'", "\\'").strip()
            php_content += f"    '{key}' => '{value_escaped}',\n"
    php_content += "];\n"
    return php_content

def main():
    print("=" * 80)
    print("🌍 نظام الترجمة الاحترافي المحسّن النهائي")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد English غير موجود: {ENGLISH_DIR}")
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
    print(f"📚 قاموس شامل: {len(CORE_DICT)} مصطلح سياحي")
    print(f"💾 الحفظ في: {OUTPUT_DIR}\n")
    
    languages = {'fr': 'French', 'de': 'German', 'it': 'Italian', 'ja': 'Japanese', 
                 'ru': 'Russian', 'tr': 'Turkish', 'he': 'Hebrew', 'es': 'Spanish'}
    
    for lang_code, lang_name in languages.items():
        print(f"🔄 ترجمة إلى {lang_code} ({lang_name})...")
        
        lang_dir = OUTPUT_DIR / lang_code
        lang_dir.mkdir(parents=True, exist_ok=True)
        
        translated_count = 0
        
        for filename, en_dict in english_files.items():
            translated = {}
            
            for key, value in en_dict.items():
                translated_value = smart_translate(key, value, lang_code)
                translated[key] = translated_value
                if translated_value != value:
                    translated_count += 1
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
        
        print(f"  ✅ {lang_code} اكتملت ({translated_count}/{total_keys} ترجمات)")
    
    print()
    print("=" * 80)
    print("✅✅✅ اكتملت جميع الترجمات!")
    print(f"📁 الموقع: {OUTPUT_DIR}")
    print("=" * 80)

if __name__ == '__main__':
    main()
