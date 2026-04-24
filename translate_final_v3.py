#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 النظام الثالث: استخراج وترجمة مصطلحات main.php الفريدة
Third Iteration: Extract and Translate Unique Terms from main.php
"""

import re
from pathlib import Path
from collections import Counter

PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"
OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

# قاموس محسّن مع 200+ مصطلح سياحي
EXTENDED_DICT = {
    # Booking & Reservation (Extended)
    'booking': {'fr': 'Réservation', 'de': 'Buchung', 'it': 'Prenotazione', 'ja': '予約', 'ru': 'Бронирование', 'tr': 'Rezervasyon', 'he': 'הזמנה', 'es': 'Reserva'},
    'reserve': {'fr': 'Réserver', 'de': 'Buchen', 'it': 'Prenotare', 'ja': '予約する', 'ru': 'Забронировать', 'tr': 'Rezerv Et', 'he': 'הזמן', 'es': 'Reservar'},
    'confirm': {'fr': 'Confirmer', 'de': 'Bestätigen', 'it': 'Confermare', 'ja': '確認', 'ru': 'Подтвердить', 'tr': 'Onayla', 'he': 'אישור', 'es': 'Confirmar'},
    'confirmed': {'fr': 'Confirmée', 'de': 'Bestätigt', 'it': 'Confermato', 'ja': '確認済み', 'ru': 'Подтверждено', 'tr': 'Onaylandı', 'he': 'אושר', 'es': 'Confirmado'},
    'cancel': {'fr': 'Annuler', 'de': 'Stornieren', 'it': 'Annullare', 'ja': 'キャンセル', 'ru': 'Отменить', 'tr': 'İptal Et', 'he': 'בטל', 'es': 'Cancelar'},
    'cancelled': {'fr': 'Annulée', 'de': 'Storniert', 'it': 'Annullato', 'ja': 'キャンセル済み', 'ru': 'Отменено', 'tr': 'İptal Edildi', 'he': 'בוטל', 'es': 'Cancelado'},
    'refund': {'fr': 'Remboursement', 'de': 'Rückerstattung', 'it': 'Rimborso', 'ja': '払い戻し', 'ru': 'Возврат', 'tr': 'İade', 'he': 'החזר', 'es': 'Reembolso'},
    'pending': {'fr': 'En attente', 'de': 'Ausstehend', 'it': 'In Sospeso', 'ja': '保留中', 'ru': 'Ожидание', 'tr': 'Beklemede', 'he': 'בהמתנה', 'es': 'Pendiente'},
    'approved': {'fr': 'Approuvé', 'de': 'Genehmigt', 'it': 'Approvato', 'ja': '承認済み', 'ru': 'Одобрено', 'tr': 'Onaylandı', 'he': 'אושר', 'es': 'Aprobado'},
    'completed': {'fr': 'Terminée', 'de': 'Abgeschlossen', 'it': 'Completato', 'ja': '完了', 'ru': 'Завершено', 'tr': 'Tamamlandı', 'he': 'הסתיים', 'es': 'Completado'},
    'processing': {'fr': 'Traitement', 'de': 'Verarbeitung', 'it': 'Elaborazione', 'ja': '処理中', 'ru': 'Обработка', 'tr': 'İşleniyor', 'he': 'בתהליך', 'es': 'Procesando'},
    
    # Accommodation (Extended)
    'accommodation': {'fr': 'Hébergement', 'de': 'Unterkunft', 'it': 'Alloggio', 'ja': '宿泊', 'ru': 'Жилье', 'tr': 'Konaklama', 'he': 'אירוח', 'es': 'Alojamiento'},
    'accommodations': {'fr': 'Hébergements', 'de': 'Unterkünfte', 'it': 'Alloggi', 'ja': '宿泊施設', 'ru': 'Жилья', 'tr': 'Konaklama', 'he': 'אירוח', 'es': 'Alojamientos'},
    'hotel': {'fr': 'Hôtel', 'de': 'Hotel', 'it': 'Hotel', 'ja': 'ホテル', 'ru': 'Отель', 'tr': 'Otel', 'he': 'מלון', 'es': 'Hotel'},
    'hotels': {'fr': 'Hôtels', 'de': 'Hotels', 'it': 'Hotel', 'ja': 'ホテル', 'ru': 'Отели', 'tr': 'Oteller', 'he': 'מלונות', 'es': 'Hoteles'},
    'resort': {'fr': 'Complèxe Touristique', 'de': 'Resort', 'it': 'Resort', 'ja': 'リゾート', 'ru': 'Курорт', 'tr': 'Resort', 'he': 'אתר נופש', 'es': 'Centro Turístico'},
    'villa': {'fr': 'Villa', 'de': 'Villa', 'it': 'Villa', 'ja': 'ヴィラ', 'ru': 'Вилла', 'tr': 'Villa', 'he': 'וילה', 'es': 'Villa'},
    'apartment': {'fr': 'Appartement', 'de': 'Wohnung', 'it': 'Appartamento', 'ja': 'アパート', 'ru': 'Квартира', 'tr': 'Daire', 'he': 'דירה', 'es': 'Apartamento'},
    'hostel': {'fr': 'Auberge', 'de': 'Herberge', 'it': 'Ostello', 'ja': 'ホステル', 'ru': 'Хостел', 'tr': 'Otel', 'he': 'אכסניה', 'es': 'Albergue'},
    'camp': {'fr': 'Camping', 'de': 'Lager', 'it': 'Campeggio', 'ja': 'キャンプ', 'ru': 'Кемпинг', 'tr': 'Kamp', 'he': 'מחנה', 'es': 'Campamento'},
    'lodge': {'fr': 'Pavillon', 'de': 'Herberge', 'it': 'Rifugio', 'ja': 'ロッジ', 'ru': 'Домик', 'tr': 'Konak', 'he': 'בקתה', 'es': 'Cabaña'},
    'room': {'fr': 'Chambre', 'de': 'Zimmer', 'it': 'Stanza', 'ja': '部屋', 'ru': 'Номер', 'tr': 'Oda', 'he': 'חדר', 'es': 'Habitación'},
    'rooms': {'fr': 'Chambres', 'de': 'Zimmer', 'it': 'Stanze', 'ja': '部屋', 'ru': 'Номера', 'tr': 'Odalar', 'he': 'חדרים', 'es': 'Habitaciones'},
    'bed': {'fr': 'Lit', 'de': 'Bett', 'it': 'Letto', 'ja': 'ベッド', 'ru': 'Кровать', 'tr': 'Yatak', 'he': 'מיטה', 'es': 'Cama'},
    'bathroom': {'fr': 'Salle de Bain', 'de': 'Badezimmer', 'it': 'Bagno', 'ja': 'バスルーム', 'ru': 'Ванная', 'tr': 'Banyo', 'he': 'חדר אמבטיה', 'es': 'Baño'},
    'shower': {'fr': 'Douche', 'de': 'Dusche', 'it': 'Doccia', 'ja': 'シャワー', 'ru': 'Душ', 'tr': 'Duş', 'he': 'מקלחת', 'es': 'Ducha'},
    'kitchen': {'fr': 'Cuisine', 'de': 'Küche', 'it': 'Cucina', 'ja': 'キッチン', 'ru': 'Кухня', 'tr': 'Mutfak', 'he': 'מטבח', 'es': 'Cocina'},
    'balcony': {'fr': 'Balcon', 'de': 'Balkon', 'it': 'Balcone', 'ja': 'バルコニー', 'ru': 'Балкон', 'tr': 'Balkon', 'he': 'מרפסת', 'es': 'Balcón'},
    'terrace': {'fr': 'Terrasse', 'de': 'Terrasse', 'it': 'Terrazza', 'ja': 'テラス', 'ru': 'Терраса', 'tr': 'Teras', 'he': 'פטיו', 'es': 'Terraza'},
    'double': {'fr': 'Double', 'de': 'Doppel', 'it': 'Doppio', 'ja': 'ダブル', 'ru': 'Двойной', 'tr': 'Çift', 'he': 'כפול', 'es': 'Doble'},
    'single': {'fr': 'Simple', 'de': 'Einzeln', 'it': 'Singolo', 'ja': 'シングル', 'ru': 'Одиночный', 'tr': 'Tek', 'he': 'יחיד', 'es': 'Individual'},
    'twin': {'fr': 'Twin', 'de': 'Twin', 'it': 'Twin', 'ja': 'ツイン', 'ru': 'Двухместный', 'tr': 'İkiz', 'he': 'טווין', 'es': 'Twin'},
    'suite': {'fr': 'Suite', 'de': 'Suite', 'it': 'Suite', 'ja': 'スイート', 'ru': 'Люкс', 'tr': 'Suit', 'he': 'סוויט', 'es': 'Suite'},
    'family': {'fr': 'Familial', 'de': 'Familie', 'it': 'Familiare', 'ja': 'ファミリー', 'ru': 'Семейный', 'tr': 'Aile', 'he': 'משפחתי', 'es': 'Familiar'},
    
    # Payment & Pricing (Extended)
    'price': {'fr': 'Prix', 'de': 'Preis', 'it': 'Prezzo', 'ja': '価格', 'ru': 'Цена', 'tr': 'Fiyat', 'he': 'מחיר', 'es': 'Precio'},
    'prices': {'fr': 'Prix', 'de': 'Preise', 'it': 'Prezzi', 'ja': '価格', 'ru': 'Цены', 'tr': 'Fiyatlar', 'he': 'מחירים', 'es': 'Precios'},
    'cost': {'fr': 'Coût', 'de': 'Kosten', 'it': 'Costo', 'ja': 'コスト', 'ru': 'Стоимость', 'tr': 'Maliyet', 'he': 'עלות', 'es': 'Costo'},
    'payment': {'fr': 'Paiement', 'de': 'Zahlung', 'it': 'Pagamento', 'ja': '支払い', 'ru': 'Оплата', 'tr': 'Ödeme', 'he': 'תשלום', 'es': 'Pago'},
    'paid': {'fr': 'Payé', 'de': 'Bezahlt', 'it': 'Pagato', 'ja': '支払い済み', 'ru': 'Оплачено', 'tr': 'Ödendi', 'he': 'שולם', 'es': 'Pagado'},
    'discount': {'fr': 'Remise', 'de': 'Rabatt', 'it': 'Sconto', 'ja': '割引', 'ru': 'Скидка', 'tr': 'İndirim', 'he': 'הנחה', 'es': 'Descuento'},
    'tax': {'fr': 'Taxe', 'de': 'Steuern', 'it': 'Imposta', 'ja': '税金', 'ru': 'Налог', 'tr': 'Vergi', 'he': 'מיסים', 'es': 'Impuesto'},
    'total': {'fr': 'Total', 'de': 'Gesamt', 'it': 'Totale', 'ja': '合計', 'ru': 'Итого', 'tr': 'Toplam', 'he': 'סה"כ', 'es': 'Total'},
    'invoice': {'fr': 'Facture', 'de': 'Rechnung', 'it': 'Fattura', 'ja': '請求書', 'ru': 'Счет', 'tr': 'Fatura', 'he': 'חשבונית', 'es': 'Factura'},
    'receipt': {'fr': 'Reçu', 'de': 'Quittung', 'it': 'Ricevuta', 'ja': 'レシート', 'ru': 'Чек', 'tr': 'Makbuz', 'he': 'קבלה', 'es': 'Recibo'},
    'credit': {'fr': 'Crédit', 'de': 'Gutschrift', 'it': 'Credito', 'ja': 'クレジット', 'ru': 'Кредит', 'tr': 'Kredi', 'he': 'קרדיט', 'es': 'Crédito'},
    'debit': {'fr': 'Débit', 'de': 'Belastung', 'it': 'Debito', 'ja': 'デビット', 'ru': 'Дебет', 'tr': 'Borç', 'he': 'חיוב', 'es': 'Débito'},
    
    # Location (Extended)
    'location': {'fr': 'Emplacement', 'de': 'Lage', 'it': 'Posizione', 'ja': 'ロケーション', 'ru': 'Местоположение', 'tr': 'Konum', 'he': 'מיקום', 'es': 'Ubicación'},
    'city': {'fr': 'Ville', 'de': 'Stadt', 'it': 'Città', 'ja': '都市', 'ru': 'Город', 'tr': 'Şehir', 'he': 'עיר', 'es': 'Ciudad'},
    'cities': {'fr': 'Villes', 'de': 'Städte', 'it': 'Città', 'ja': '都市', 'ru': 'Города', 'tr': 'Şehirler', 'he': 'ערים', 'es': 'Ciudades'},
    'country': {'fr': 'Pays', 'de': 'Land', 'it': 'Paese', 'ja': '国', 'ru': 'Страна', 'tr': 'Ülke', 'he': 'מדינה', 'es': 'País'},
    'countries': {'fr': 'Pays', 'de': 'Länder', 'it': 'Paesi', 'ja': '国', 'ru': 'Страны', 'tr': 'Ülkeler', 'he': 'מדינות', 'es': 'Países'},
    'region': {'fr': 'Région', 'de': 'Region', 'it': 'Regione', 'ja': 'リージョン', 'ru': 'Область', 'tr': 'Bölge', 'he': 'אזור', 'es': 'Región'},
    'regions': {'fr': 'Régions', 'de': 'Regionen', 'it': 'Regioni', 'ja': 'リージョン', 'ru': 'Области', 'tr': 'Bölgeler', 'he': 'אזורים', 'es': 'Regiones'},
    'beach': {'fr': 'Plage', 'de': 'Strand', 'it': 'Spiaggia', 'ja': 'ビーチ', 'ru': 'Пляж', 'tr': 'Plaj', 'he': 'חוף', 'es': 'Playa'},
    'beaches': {'fr': 'Plages', 'de': 'Strände', 'it': 'Spiagge', 'ja': 'ビーチ', 'ru': 'Пляжи', 'tr': 'Plajlar', 'he': 'חופים', 'es': 'Playas'},
    'mountain': {'fr': 'Montagne', 'de': 'Berg', 'it': 'Montagna', 'ja': '山', 'ru': 'Гора', 'tr': 'Dağ', 'he': 'הר', 'es': 'Montaña'},
    'airport': {'fr': 'Aéroport', 'de': 'Flughafen', 'it': 'Aeroporto', 'ja': '空港', 'ru': 'Аэропорт', 'tr': 'Havaalanı', 'he': 'נמל תעופה', 'es': 'Aeropuerto'},
    'distance': {'fr': 'Distance', 'de': 'Entfernung', 'it': 'Distanza', 'ja': '距離', 'ru': 'Расстояние', 'tr': 'Mesafe', 'he': 'מרחק', 'es': 'Distancia'},
    'map': {'fr': 'Carte', 'de': 'Karte', 'it': 'Mappa', 'ja': '地図', 'ru': 'Карта', 'tr': 'Harita', 'he': 'מפה', 'es': 'Mapa'},
    'address': {'fr': 'Adresse', 'de': 'Adresse', 'it': 'Indirizzo', 'ja': 'アドレス', 'ru': 'Адрес', 'tr': 'Adres', 'he': 'כתובת', 'es': 'Dirección'},
    
    # Dates & Time (Extended)
    'date': {'fr': 'Date', 'de': 'Datum', 'it': 'Data', 'ja': '日付', 'ru': 'Дата', 'tr': 'Tarih', 'he': 'תאריך', 'es': 'Fecha'},
    'dates': {'fr': 'Dates', 'de': 'Daten', 'it': 'Date', 'ja': '日付', 'ru': 'Даты', 'tr': 'Tarihler', 'he': 'תאריכים', 'es': 'Fechas'},
    'arrival': {'fr': 'Arrivée', 'de': 'Ankunft', 'it': 'Arrivo', 'ja': '到着', 'ru': 'Прибытие', 'tr': 'Varış', 'he': 'הגעה', 'es': 'Llegada'},
    'departure': {'fr': 'Départ', 'de': 'Abreise', 'it': 'Partenza', 'ja': '出発', 'ru': 'Отъезд', 'tr': 'Kalkış', 'he': 'יציאה', 'es': 'Salida'},
    'night': {'fr': 'Nuit', 'de': 'Nacht', 'it': 'Notte', 'ja': '夜', 'ru': 'Ночь', 'tr': 'Gece', 'he': 'לילה', 'es': 'Noche'},
    'nights': {'fr': 'Nuits', 'de': 'Nächte', 'it': 'Notti', 'ja': '夜', 'ru': 'Ночи', 'tr': 'Geceler', 'he': 'לילות', 'es': 'Noches'},
    'day': {'fr': 'Jour', 'de': 'Tag', 'it': 'Giorno', 'ja': '日', 'ru': 'День', 'tr': 'Gün', 'he': 'יום', 'es': 'Día'},
    'days': {'fr': 'Jours', 'de': 'Tage', 'it': 'Giorni', 'ja': '日', 'ru': 'Дни', 'tr': 'Günler', 'he': 'ימים', 'es': 'Días'},
    'today': {'fr': 'Aujourd\'hui', 'de': 'Heute', 'it': 'Oggi', 'ja': '今日', 'ru': 'Сегодня', 'tr': 'Bugün', 'he': 'היום', 'es': 'Hoy'},
    'tomorrow': {'fr': 'Demain', 'de': 'Morgen', 'it': 'Domani', 'ja': '明日', 'ru': 'Завтра', 'tr': 'Yarın', 'he': 'מחר', 'es': 'Mañana'},
    'week': {'fr': 'Semaine', 'de': 'Woche', 'it': 'Settimana', 'ja': '週', 'ru': 'Неделя', 'tr': 'Hafta', 'he': 'שבוע', 'es': 'Semana'},
    'month': {'fr': 'Mois', 'de': 'Monat', 'it': 'Mese', 'ja': '月', 'ru': 'Месяц', 'tr': 'Ay', 'he': 'חודש', 'es': 'Mes'},
    'year': {'fr': 'Année', 'de': 'Jahr', 'it': 'Anno', 'ja': '年', 'ru': 'Год', 'tr': 'Yıl', 'he': 'שנה', 'es': 'Año'},
    
    # Users & Auth (Extended)
    'user': {'fr': 'Utilisateur', 'de': 'Benutzer', 'it': 'Utente', 'ja': 'ユーザー', 'ru': 'Пользователь', 'tr': 'Kullanıcı', 'he': 'משתמש', 'es': 'Usuario'},
    'users': {'fr': 'Utilisateurs', 'de': 'Benutzer', 'it': 'Utenti', 'ja': 'ユーザー', 'ru': 'Пользователи', 'tr': 'Kullanıcılar', 'he': 'משתמשים', 'es': 'Usuarios'},
    'client': {'fr': 'Client', 'de': 'Kunde', 'it': 'Cliente', 'ja': '顧客', 'ru': 'Клиент', 'tr': 'Müşteri', 'he': 'לקוח', 'es': 'Cliente'},
    'clients': {'fr': 'Clients', 'de': 'Kunden', 'it': 'Clienti', 'ja': '顧客', 'ru': 'Клиенты', 'tr': 'Müşteriler', 'he': 'לקוחות', 'es': 'Clientes'},
    'guest': {'fr': 'Invité', 'de': 'Gast', 'it': 'Ospite', 'ja': 'ゲスト', 'ru': 'Гость', 'tr': 'Misafir', 'he': 'אורח', 'es': 'Huésped'},
    'guests': {'fr': 'Invités', 'de': 'Gäste', 'it': 'Ospiti', 'ja': 'ゲスト', 'ru': 'Гости', 'tr': 'Misafirler', 'he': 'אורחים', 'es': 'Huéspedes'},
    'admin': {'fr': 'Administrateur', 'de': 'Administrator', 'it': 'Amministratore', 'ja': '管理者', 'ru': 'Администратор', 'tr': 'Yönetici', 'he': 'מנהל', 'es': 'Administrador'},
    'guide': {'fr': 'Guide', 'de': 'Führer', 'it': 'Guida', 'ja': 'ガイド', 'ru': 'Гид', 'tr': 'Rehber', 'he': 'מדריך', 'es': 'Guía'},
    'guides': {'fr': 'Guides', 'de': 'Führer', 'it': 'Guide', 'ja': 'ガイド', 'ru': 'Гиды', 'tr': 'Rehberler', 'he': 'מדריכים', 'es': 'Guías'},
    'login': {'fr': 'Connexion', 'de': 'Anmelden', 'it': 'Accedi', 'ja': 'ログイン', 'ru': 'Вход', 'tr': 'Giriş', 'he': 'כניסה', 'es': 'Iniciar Sesión'},
    'logout': {'fr': 'Déconnexion', 'de': 'Abmelden', 'it': 'Esci', 'ja': 'ログアウト', 'ru': 'Выход', 'tr': 'Çıkış', 'he': 'יציאה', 'es': 'Cerrar Sesión'},
    'password': {'fr': 'Mot de passe', 'de': 'Passwort', 'it': 'Password', 'ja': 'パスワード', 'ru': 'Пароль', 'tr': 'Şifre', 'he': 'סיסמה', 'es': 'Contraseña'},
    'email': {'fr': 'E-mail', 'de': 'E-Mail', 'it': 'Email', 'ja': 'メール', 'ru': 'Email', 'tr': 'E-posta', 'he': 'דוא"ל', 'es': 'Correo Electrónico'},
    'phone': {'fr': 'Téléphone', 'de': 'Telefon', 'it': 'Telefono', 'ja': '電話', 'ru': 'Телефон', 'tr': 'Telefon', 'he': 'טלפון', 'es': 'Teléfono'},
    'name': {'fr': 'Nom', 'de': 'Name', 'it': 'Nome', 'ja': '名前', 'ru': 'Имя', 'tr': 'İsim', 'he': 'שם', 'es': 'Nombre'},
    'profile': {'fr': 'Profil', 'de': 'Profil', 'it': 'Profilo', 'ja': 'プロフィール', 'ru': 'Профиль', 'tr': 'Profil', 'he': 'פרופיל', 'es': 'Perfil'},
    
    # Actions (Extended)
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
    'clear': {'fr': 'Effacer', 'de': 'Löschen', 'it': 'Cancella', 'ja': 'クリア', 'ru': 'Очистить', 'tr': 'Temizle', 'he': 'נקה', 'es': 'Borrar'},
    'export': {'fr': 'Exporter', 'de': 'Exportieren', 'it': 'Esporta', 'ja': 'エクスポート', 'ru': 'Экспорт', 'tr': 'Dışa Aktar', 'he': 'ייצוא', 'es': 'Exportar'},
    'import': {'fr': 'Importer', 'de': 'Importieren', 'it': 'Importa', 'ja': 'インポート', 'ru': 'Импорт', 'tr': 'İçe Aktar', 'he': 'ייבוא', 'es': 'Importar'},
    'download': {'fr': 'Télécharger', 'de': 'Herunterladen', 'it': 'Scarica', 'ja': 'ダウンロード', 'ru': 'Скачать', 'tr': 'İndir', 'he': 'הוריד', 'es': 'Descargar'},
    'upload': {'fr': 'Télécharger', 'de': 'Hochladen', 'it': 'Carica', 'ja': 'アップロード', 'ru': 'Загрузить', 'tr': 'Yükle', 'he': 'העלה', 'es': 'Cargar'},
    
    # Status & Quality
    'active': {'fr': 'Actif', 'de': 'Aktiv', 'it': 'Attivo', 'ja': 'アクティブ', 'ru': 'Активный', 'tr': 'Aktif', 'he': 'פעיל', 'es': 'Activo'},
    'inactive': {'fr': 'Inactif', 'de': 'Inaktiv', 'it': 'Inattivo', 'ja': 'アクティブでない', 'ru': 'Неактивный', 'tr': 'Pasif', 'he': 'לא פעיל', 'es': 'Inactivo'},
    'available': {'fr': 'Disponible', 'de': 'Verfügbar', 'it': 'Disponibile', 'ja': '利用可能', 'ru': 'Доступный', 'tr': 'Uygun', 'he': 'זמין', 'es': 'Disponible'},
    'unavailable': {'fr': 'Indisponible', 'de': 'Nicht Verfügbar', 'it': 'Non Disponibile', 'ja': '利用不可', 'ru': 'Недоступный', 'tr': 'Uygun Değil', 'he': 'לא זמין', 'es': 'No Disponible'},
    'success': {'fr': 'Succès', 'de': 'Erfolg', 'it': 'Successo', 'ja': '成功', 'ru': 'Успех', 'tr': 'Başarı', 'he': 'הצלחה', 'es': 'Éxito'},
    'error': {'fr': 'Erreur', 'de': 'Fehler', 'it': 'Errore', 'ja': 'エラー', 'ru': 'Ошибка', 'tr': 'Hata', 'he': 'שגיאה', 'es': 'Error'},
    'warning': {'fr': 'Avertissement', 'de': 'Warnung', 'it': 'Avvertenza', 'ja': '警告', 'ru': 'Предупреждение', 'tr': 'Uyarı', 'he': 'אזהרה', 'es': 'Advertencia'},
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

def smart_translate_v3(key, value, language_code):
    """ترجمة ذكية محسّنة - الإصدار الثالث"""
    
    if not value or len(value.strip()) == 0:
        return value
    
    key_lower = key.lower().replace('_', ' ')
    value_lower = value.lower().replace('_', ' ')
    
    # المرحلة 1: البحث المباشر
    if key_lower in EXTENDED_DICT and language_code in EXTENDED_DICT[key_lower]:
        return EXTENDED_DICT[key_lower][language_code]
    
    # المرحلة 2: البحث عن أجزاء المفتاح (أطول جزء أولاً)
    key_parts = key_lower.split()
    for part in sorted(key_parts, key=len, reverse=True):
        if len(part) > 2 and part in EXTENDED_DICT and language_code in EXTENDED_DICT[part]:
            return EXTENDED_DICT[part][language_code]
    
    # المرحلة 3: البحث عن كلمات في القيمة
    value_words = value_lower.split()
    for word in sorted(value_words, key=len, reverse=True):
        if len(word) > 3 and word in EXTENDED_DICT and language_code in EXTENDED_DICT[word]:
            return EXTENDED_DICT[word][language_code]
    
    # المرحلة 4: البحث البجزئي
    for dict_key, translations in EXTENDED_DICT.items():
        if language_code in translations and len(dict_key) > 2:
            if dict_key in key_lower or dict_key in value_lower:
                return translations[language_code]
    
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

print("=" * 80)
print("🌍 النظام الثالث: استخراج وترجمة مصطلحات main.php الفريدة")
print("=" * 80)
print()

if not ENGLISH_DIR.exists():
    print(f"❌ مجلد English غير موجود")
    exit()

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
print(f"📚 قاموس محسّن: {len(EXTENDED_DICT)} مصطلح سياحي")
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
            translated_value = smart_translate_v3(key, value, lang_code)
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
print("✅✅✅ اكتملت الترجمات!")
print(f"📁 مسار الحفظ: {OUTPUT_DIR}")
print("=" * 80)
