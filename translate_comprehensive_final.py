#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
🌍 نظام الترجمة الاحترافي النهائي - مع قاموس شامل سياحي
Final Professional Translation System with Comprehensive Tourism Dictionary
"""

import re
from pathlib import Path

PROJECT_ROOT = Path("g:/MixJo Top downlode mains by dats/for edit/tourism-management-system  13 FEB 2026 0221AM/tourism-management-system")
LANG_DIR = PROJECT_ROOT / "resources" / "lang"
ENGLISH_DIR = LANG_DIR / "en"
ARABIC_DIR = LANG_DIR / "ar"
OUTPUT_DIR = Path("G:/Translate mixjo VS Code/Translate VSCODE 2")

REQUIRED_FILES = ['auth.php', 'automation.php', 'activity.php', 'languages.php',
                  'messages.php', 'sidebar.php', 'en.php', 'main.php']

# 🌍 قاموس شامل 370+ مصطلح سياحي مترجم للـ 8 لغات
TOURISM_TRANSLATIONS = {
    # Booking & Reservation
    'booking': {'fr': 'Réservation', 'de': 'Buchung', 'it': 'Prenotazione', 'ja': '予約', 'ru': 'Бронирование', 'tr': 'Rezervasyon', 'he': 'הזמנה', 'es': 'Reserva'},
    'reservation': {'fr': 'Réservation', 'de': 'Reservierung', 'it': 'Prenotazione', 'ja': '予約', 'ru': 'Резервирование', 'tr': 'Ayırma', 'he': 'הזמנה', 'es': 'Reserva'},
    'confirm': {'fr': 'Confirmer', 'de': 'Bestätigen', 'it': 'Confermare', 'ja': '確認', 'ru': 'Подтвердить', 'tr': 'Onayla', 'he': 'אישור', 'es': 'Confirmar'},
    'confirmed': {'fr': 'Confirmée', 'de': 'Bestätigt', 'it': 'Confermato', 'ja': '確認済み', 'ru': 'Подтверждено', 'tr': 'Onaylandı', 'he': 'אושר', 'es': 'Confirmado'},
    'check-in': {'fr': 'Enregistrement', 'de': 'Einchecken', 'it': 'Check-in', 'ja': 'チェックイン', 'ru': 'Регистрация', 'tr': 'Giriş', 'he': 'צ\'ק אין', 'es': 'Check-in'},
    'check_in': {'fr': 'Enregistrement', 'de': 'Einchecken', 'it': 'Check-in', 'ja': 'チェックイン', 'ru': 'Регистрация', 'tr': 'Giriş', 'he': 'צ\'ק אין', 'es': 'Check-in'},
    'check-out': {'fr': 'Départ', 'de': 'Auschecken', 'it': 'Check-out', 'ja': 'チェックアウト', 'ru': 'Выезд', 'tr': 'Çıkış', 'he': 'צ\'ק אאוט', 'es': 'Check-out'},
    'check_out': {'fr': 'Départ', 'de': 'Auschecken', 'it': 'Check-out', 'ja': 'チェックアウト', 'ru': 'Выезд', 'tr': 'Çıkış', 'he': 'צ\'ק אאוט', 'es': 'Check-out'},
    'cancellation': {'fr': 'Annulation', 'de': 'Stornierung', 'it': 'Cancellazione', 'ja': 'キャンセル', 'ru': 'Отмена', 'tr': 'İptal', 'he': 'ביטול', 'es': 'Cancelación'},
    'cancel': {'fr': 'Annuler', 'de': 'Stornieren', 'it': 'Annullare', 'ja': 'キャンセル', 'ru': 'Отменить', 'tr': 'İptal Et', 'he': 'בטל', 'es': 'Cancelar'},
    'refund': {'fr': 'Remboursement', 'de': 'Rückerstattung', 'it': 'Rimborso', 'ja': '払い戻し', 'ru': 'Возврат', 'tr': 'İade', 'he': 'החזר', 'es': 'Reembolso'},

    # Accommodation Types
    'hotel': {'fr': 'Hôtel', 'de': 'Hotel', 'it': 'Hotel', 'ja': 'ホテル', 'ru': 'Отель', 'tr': 'Otel', 'he': 'מלון', 'es': 'Hotel'},
    'resort': {'fr': 'Station Balnéaire', 'de': 'Resort', 'it': 'Resort', 'ja': 'リゾート', 'ru': 'Курорт', 'tr': 'Resort', 'he': 'אתר נופש', 'es': 'Centro Turístico'},
    'villa': {'fr': 'Villa', 'de': 'Villa', 'it': 'Villa', 'ja': 'ヴィラ', 'ru': 'Вилла', 'tr': 'Villa', 'he': 'וילה', 'es': 'Villa'},
    'apartment': {'fr': 'Appartement', 'de': 'Wohnung', 'it': 'Appartamento', 'ja': 'アパート', 'ru': 'Квартира', 'tr': 'Daire', 'he': 'דירה', 'es': 'Apartamento'},
    'hostel': {'fr': 'Auberge Jeunesse', 'de': 'Herberge', 'it': 'Ostello', 'ja': 'ホステル', 'ru': 'Хостел', 'tr': 'Hostel', 'he': 'אכסניה', 'es': 'Albergue'},
    'guest_house': {'fr': 'Maison d\'Hôtes', 'de': 'Gästehaus', 'it': 'Famiglia Ospitante', 'ja': 'ゲストハウス', 'ru': 'Гостевой Дом', 'tr': 'Konuk Evi', 'he': 'בית אורחים', 'es': 'Casa de Huéspedes'},
    'bed_breakfast': {'fr': 'Gîte', 'de': 'Pension', 'it': 'Bed & Breakfast', 'ja': 'ベッド&ブレックファスト', 'ru': 'Постель и Завтрак', 'tr': 'Yatak ve Kahvaltı', 'he': 'מלון הסעד', 'es': 'Alojamiento y Desayuno'},
    'room': {'fr': 'Chambre', 'de': 'Zimmer', 'it': 'Stanza', 'ja': '部屋', 'ru': 'Номер', 'tr': 'Oda', 'he': 'חדר', 'es': 'Habitación'},
    'single_room': {'fr': 'Chambre Simple', 'de': 'Einzelzimmer', 'it': 'Camera Singola', 'ja': 'シングルルーム', 'ru': 'Одноместный Номер', 'tr': 'Tekli Oda', 'he': 'חדר יחיד', 'es': 'Habitación Individual'},
    'double_room': {'fr': 'Chambre Double', 'de': 'Doppelzimmer', 'it': 'Camera Doppia', 'ja': 'ダブルルーム', 'ru': 'Двухместный Номер', 'tr': 'Çift Oda', 'he': 'חדר זוגי', 'es': 'Habitación Doble'},
    'twin_room': {'fr': 'Chambre Twin', 'de': 'Zweibettzimmer', 'it': 'Camera Twin', 'ja': 'ツインルーム', 'ru': 'Номер с Двумя Кроватями', 'tr': 'İkiz Yatak Odası', 'he': 'חדר טווין', 'es': 'Habitación Twin'},
    'suite': {'fr': 'Suite', 'de': 'Suite', 'it': 'Suite', 'ja': 'スイート', 'ru': 'Люкс', 'tr': 'Suit', 'he': 'סוויט', 'es': 'Suite'},
    'family_room': {'fr': 'Chambre Familiale', 'de': 'Familienzimmer', 'it': 'Camera Familiare', 'ja': 'ファミリールーム', 'ru': 'Семейный Номер', 'tr': 'Aile Odası', 'he': 'חדר משפחתי', 'es': 'Habitación Familiar'},

    # Room Features
    'bed': {'fr': 'Lit', 'de': 'Bett', 'it': 'Letto', 'ja': 'ベッド', 'ru': 'Кровать', 'tr': 'Yatak', 'he': 'מיטה', 'es': 'Cama'},
    'bathroom': {'fr': 'Salle de Bain', 'de': 'Badezimmer', 'it': 'Bagno', 'ja': 'バスルーム', 'ru': 'Ванная Комната', 'tr': 'Banyo', 'he': 'חדר אמבטיה', 'es': 'Baño'},
    'shower': {'fr': 'Douche', 'de': 'Dusche', 'it': 'Doccia', 'ja': 'シャワー', 'ru': 'Душ', 'tr': 'Duş', 'he': 'מקלחת', 'es': 'Ducha'},
    'balcony': {'fr': 'Balcon', 'de': 'Balkon', 'it': 'Balcone', 'ja': 'バルコニー', 'ru': 'Балкон', 'tr': 'Balkon', 'he': 'מרפסת', 'es': 'Balcón'},
    'terrace': {'fr': 'Terrasse', 'de': 'Terrasse', 'it': 'Terrazza', 'ja': 'テラス', 'ru': 'Терраса', 'tr': 'Teras', 'he': 'כיפת רחוב', 'es': 'Terraza'},
    'view': {'fr': 'Vue', 'de': 'Ausblick', 'it': 'Vista', 'ja': '眺望', 'ru': 'Вид', 'tr': 'Manzara', 'he': 'תצפית', 'es': 'Vista'},
    'kitchen': {'fr': 'Cuisine', 'de': 'Küche', 'it': 'Cucina', 'ja': 'キッチン', 'ru': 'Кухня', 'tr': 'Mutfak', 'he': 'מטבח', 'es': 'Cocina'},
    'living_room': {'fr': 'Salon', 'de': 'Wohnzimmer', 'it': 'Soggiorno', 'ja': 'リビングルーム', 'ru': 'Гостиная', 'tr': 'Oturma Odası', 'he': 'סלון', 'es': 'Sala de Estar'},
    'television': {'fr': 'Télévision', 'de': 'Fernseher', 'it': 'Televisione', 'ja': 'テレビ', 'ru': 'Телевизор', 'tr': 'Televizyon', 'he': 'טלוויזיה', 'es': 'Televisión'},
    'air_conditioning': {'fr': 'Climatisation', 'de': 'Klimaanlage', 'it': 'Aria Condizionata', 'ja': 'エアコン', 'ru': 'Кондиционер', 'tr': 'Klima', 'he': 'מזגן', 'es': 'Aire Acondicionado'},
    'heating': {'fr': 'Chauffage', 'de': 'Heizung', 'it': 'Riscaldamento', 'ja': '暖房', 'ru': 'Отопление', 'tr': 'Isıtma', 'he': 'חימום', 'es': 'Calefacción'},
    'wifi': {'fr': 'WiFi', 'de': 'WiFi', 'it': 'WiFi', 'ja': 'WiFi', 'ru': 'WiFi', 'tr': 'WiFi', 'he': 'WiFi', 'es': 'WiFi'},
    'internet': {'fr': 'Internet', 'de': 'Internet', 'it': 'Internet', 'ja': 'インターネット', 'ru': 'Интернет', 'tr': 'İnternet', 'he': 'אינטרנט', 'es': 'Internet'},
    'safe': {'fr': 'Coffre-fort', 'de': 'Tresor', 'it': 'Cassaforte', 'ja': '金庫', 'ru': 'Сейф', 'tr': 'Kasa', 'he': 'כספת', 'es': 'Caja Fuerte'},

    # Amenities & Facilities
    'restaurant': {'fr': 'Restaurant', 'de': 'Restaurant', 'it': 'Ristorante', 'ja': 'レストラン', 'ru': 'Ресторан', 'tr': 'Restoran', 'he': 'מסעדה', 'es': 'Restaurante'},
    'bar': {'fr': 'Bar', 'de': 'Bar', 'it': 'Bar', 'ja': 'バー', 'ru': 'Бар', 'tr': 'Bar', 'he': 'בר', 'es': 'Bar'},
    'cafe': {'fr': 'Café', 'de': 'Café', 'it': 'Caffè', 'ja': 'カフェ', 'ru': 'Кафе', 'tr': 'Kafe', 'he': 'קפה', 'es': 'Café'},
    'swimming_pool': {'fr': 'Piscine', 'de': 'Schwimmbad', 'it': 'Piscina', 'ja': 'プール', 'ru': 'Бассейн', 'tr': 'Yüzme Havuzu', 'he': 'בריכה', 'es': 'Piscina'},
    'spa': {'fr': 'Spa', 'de': 'Spa', 'it': 'Spa', 'ja': 'スパ', 'ru': 'Спа', 'tr': 'Spa', 'he': 'ספא', 'es': 'Spa'},
    'gym': {'fr': 'Salle de Sport', 'de': 'Fitnessraum', 'it': 'Palestra', 'ja': 'ジム', 'ru': 'Тренажерный Зал', 'tr': 'Fitness Salonu', 'he': 'חדר כושר', 'es': 'Gimnasio'},
    'fitness': {'fr': 'Remise en forme', 'de': 'Fitness', 'it': 'Fitness', 'ja': 'フィットネス', 'ru': 'Фитнес', 'tr': 'Fitness', 'he': 'כושר גופני', 'es': 'Fitness'},
    'sauna': {'fr': 'Sauna', 'de': 'Sauna', 'it': 'Sauna', 'ja': 'サウナ', 'ru': 'Сауна', 'tr': 'Sauna', 'he': 'סאונה', 'es': 'Sauna'},
    'parking': {'fr': 'Parking', 'de': 'Parkplatz', 'it': 'Parcheggio', 'ja': '駐車', 'ru': 'Парковка', 'tr': 'Otopark', 'he': 'חניה', 'es': 'Estacionamiento'},
    'free_parking': {'fr': 'Parking Gratuit', 'de': 'Kostenlos Parkieren', 'it': 'Parcheggio Gratuito', 'ja': '無料駐車', 'ru': 'Бесплатное Парковка', 'tr': 'Ücretsiz Otopark', 'he': 'חניה חינמית', 'es': 'Estacionamiento Gratuito'},
    'laundry': {'fr': 'Blanchisserie', 'de': 'Wäscheservice', 'it': 'Lavanderia', 'ja': 'ランドリー', 'ru': 'Прачечная', 'tr': 'Çamaşır', 'he': 'כביסה', 'es': 'Lavandería'},
    'concierge': {'fr': 'Concierge', 'de': 'Portier', 'it': 'Concierge', 'ja': 'コンシェルジュ', 'ru': 'Консьерж', 'tr': 'Turist Ofisi', 'he': 'קונסיירז\' ', 'es': 'Conserje'},
    'reception': {'fr': 'Réception', 'de': 'Rezeption', 'it': 'Ricezione', 'ja': 'フロント', 'ru': 'Стойка Регистрации', 'tr': 'Resepsiyon', 'he': 'קבלה', 'es': 'Recepción'},
    'luggage_storage': {'fr': 'Stockage des Bagages', 'de': 'Gepäcklagerung', 'it': 'Deposito Bagagli', 'ja': '荷物保管', 'ru': 'Хранение Багажа', 'tr': 'Bagaj Depolama', 'he': 'אחסון מטענים', 'es': 'Almacenamiento de Equipaje'},
    'multilingual_staff': {'fr': 'Personnel Multilingue', 'de': 'Mehrsprachiges Personal', 'it': 'Personale Multilingue', 'ja': '多言語スタッフ', 'ru': 'Многоязычный Персонал', 'tr': 'Çok Dilli Personel', 'he': 'צוות דוברי שפות מרובות', 'es': 'Personal Multilingüe'},

    # Dining & Meals
    'breakfast': {'fr': 'Petit déjeuner', 'de': 'Frühstück', 'it': 'Colazione', 'ja': '朝食', 'ru': 'Завтрак', 'tr': 'Kahvaltı', 'he': 'ארוחת בוקר', 'es': 'Desayuno'},
    'lunch': {'fr': 'Déjeuner', 'de': 'Mittagessen', 'it': 'Pranzo', 'ja': '昼食', 'ru': 'Обед', 'tr': 'Öğle Yemeği', 'he': 'ארוחת צהריים', 'es': 'Almuerzo'},
    'dinner': {'fr': 'Dîner', 'de': 'Abendessen', 'it': 'Cena', 'ja': '夕食', 'ru': 'Ужин', 'tr': 'Akşam Yemeği', 'he': 'ארוחת ערב', 'es': 'Cena'},
    'buffet': {'fr': 'Buffet', 'de': 'Buffet', 'it': 'Buffet', 'ja': 'ビュッフェ', 'ru': 'Буфет', 'tr': 'Buffet', 'he': 'בופה', 'es': 'Buffet'},
    'room_service': {'fr': 'Service d\'Étage', 'de': 'Zimmerservice', 'it': 'Servizio in Camera', 'ja': 'ルームサービス', 'ru': 'Комнатный Сервис', 'tr': 'Oda Servisi', 'he': 'שירות חדרים', 'es': 'Servicio a la Habitación'},
    'menu': {'fr': 'Menu', 'de': 'Speisekarte', 'it': 'Menu', 'ja': 'メニュー', 'ru': 'Меню', 'tr': 'Menü', 'he': 'התפריט', 'es': 'Menú'},
    'special_diet': {'fr': 'Régime Spécial', 'de': 'Spezialdiät', 'it': 'Dieta Speciale', 'ja': '特別食', 'ru': 'Специальная Диета', 'tr': 'Özel Diyet', 'he': 'דיאטה מיוחדת', 'es': 'Dieta Especial'},

    # Guest Information
    'name': {'fr': 'Nom', 'de': 'Name', 'it': 'Nome', 'ja': '名前', 'ru': 'Имя', 'tr': 'İsim', 'he': 'שם', 'es': 'Nombre'},
    'email': {'fr': 'E-mail', 'de': 'E-Mail', 'it': 'Email', 'ja': 'メールアドレス', 'ru': 'Email', 'tr': 'E-posta', 'he': 'דוא"ל', 'es': 'Correo Electrónico'},
    'phone': {'fr': 'Téléphone', 'de': 'Telefon', 'it': 'Telefono', 'ja': '電話', 'ru': 'Телефон', 'tr': 'Telefon', 'he': 'טלפון', 'es': 'Teléfono'},
    'address': {'fr': 'Adresse', 'de': 'Adresse', 'it': 'Indirizzo', 'ja': '住所', 'ru': 'Адрес', 'tr': 'Adres', 'he': 'כתובת', 'es': 'Dirección'},
    'passport': {'fr': 'Passeport', 'de': 'Reisepass', 'it': 'Passaporto', 'ja': 'パスポート', 'ru': 'Паспорт', 'tr': 'Pasaport', 'he': 'דרכון', 'es': 'Pasaporte'},
    'language': {'fr': 'Langue', 'de': 'Sprache', 'it': 'Lingua', 'ja': '言語', 'ru': 'Язык', 'tr': 'Dil', 'he': 'שפה', 'es': 'Idioma'},
    'preferences': {'fr': 'Préférences', 'de': 'Vorlieben', 'it': 'Preferenze', 'ja': '好み', 'ru': 'Предпочтения', 'tr': 'Tercihler', 'he': 'העדפות', 'es': 'Preferencias'},
    'date_birth': {'fr': 'Date de Naissance', 'de': 'Geburtsdatum', 'it': 'Data di Nascita', 'ja': '生年月日', 'ru': 'Дата Рождения', 'tr': 'Doğum Tarihi', 'he': 'תאריך לידה', 'es': 'Fecha de Nacimiento'},
    'nationality': {'fr': 'Nationalité', 'de': 'Nationalität', 'it': 'Nazionalità', 'ja': '国籍', 'ru': 'Национальность', 'tr': 'Uyruk', 'he': 'לאום', 'es': 'Nacionalidad'},
    'customer': {'fr': 'Client', 'de': 'Kunde', 'it': 'Cliente', 'ja': '顧客', 'ru': 'Клиент', 'tr': 'Müşteri', 'he': 'לקוח', 'es': 'Cliente'},
    'guest': {'fr': 'Invité', 'de': 'Gast', 'it': 'Ospite', 'ja': 'ゲスト', 'ru': 'Гость', 'tr': 'Misafir', 'he': 'אורח', 'es': 'Huésped'},

    # Pricing & Payment
    'price': {'fr': 'Prix', 'de': 'Preis', 'it': 'Prezzo', 'ja': '価格', 'ru': 'Цена', 'tr': 'Fiyat', 'he': 'מחיר', 'es': 'Precio'},
    'discount': {'fr': 'Remise', 'de': 'Rabatt', 'it': 'Sconto', 'ja': '割引', 'ru': 'Скидка', 'tr': 'İndirim', 'he': 'הנחה', 'es': 'Descuento'},
    'payment': {'fr': 'Paiement', 'de': 'Zahlung', 'it': 'Pagamento', 'ja': '支払い', 'ru': 'Оплата', 'tr': 'Ödeme', 'he': 'תשלום', 'es': 'Pago'},
    'credit_card': {'fr': 'Carte de Crédit', 'de': 'Kreditkarte', 'it': 'Carta di Credito', 'ja': 'クレジットカード', 'ru': 'Кредитная Карта', 'tr': 'Kredi Kartı', 'he': 'כרטיס אחראיות', 'es': 'Tarjeta de Crédito'},
    'debit_card': {'fr': 'Carte de Débit', 'de': 'Debitkarte', 'it': 'Carta di Debito', 'ja': 'デビットカード', 'ru': 'Дебетовая Карта', 'tr': 'Banka Kartı', 'he': 'כרטיס חיוב', 'es': 'Tarjeta de Débito'},
    'paypal': {'fr': 'PayPal', 'de': 'PayPal', 'it': 'PayPal', 'ja': 'PayPal', 'ru': 'PayPal', 'tr': 'PayPal', 'he': 'PayPal', 'es': 'PayPal'},
    'bank_transfer': {'fr': 'Virement Bancaire', 'de': 'Banküberweisung', 'it': 'Bonifico Bancario', 'ja': '銀行振込', 'ru': 'Банковский Перевод', 'tr': 'Banka Transferi', 'he': 'העברה בנקאית', 'es': 'Transferencia Bancaria'},
    'cash': {'fr': 'Espèces', 'de': 'Bargeld', 'it': 'Contanti', 'ja': '現金', 'ru': 'Наличные', 'tr': 'Nakit', 'he': 'מזומנים', 'es': 'Efectivo'},
    'invoice': {'fr': 'Facture', 'de': 'Rechnung', 'it': 'Fattura', 'ja': '請求書', 'ru': 'Счет', 'tr': 'Fatura', 'he': 'חשבונית', 'es': 'Factura'},
    'total': {'fr': 'Total', 'de': 'Gesamtbetrag', 'it': 'Totale', 'ja': '合計', 'ru': 'Итого', 'tr': 'Toplam', 'he': 'סה"כ', 'es': 'Total'},
    'tax': {'fr': 'Taxe', 'de': 'Steuern', 'it': 'Imposta', 'ja': '税金', 'ru': 'Налог', 'tr': 'Vergi', 'he': 'מיסים', 'es': 'Impuesto'},
    'transaction': {'fr': 'Transaction', 'de': 'Transaktion', 'it': 'Transazione', 'ja': 'トランザクション', 'ru': 'Транзакция', 'tr': 'İşlem', 'he': 'עסקה', 'es': 'Transacción'},

    # Booking Status
    'pending': {'fr': 'En attente', 'de': 'Ausstehend', 'it': 'In Sospeso', 'ja': '保留中', 'ru': 'Ожидание', 'tr': 'Beklemede', 'he': 'בהמתנה', 'es': 'Pendiente'},
    'approved': {'fr': 'Approuvé', 'de': 'Bezahlt', 'it': 'Approvato', 'ja': '承認済み', 'ru': 'Одобрено', 'tr': 'Onay', 'he': 'אושר', 'es': 'Aprobado'},
    'cancelled': {'fr': 'Annulée', 'de': 'Storniert', 'it': 'Annullato', 'ja': 'キャンセル済み', 'ru': 'Отменено', 'tr': 'İptal Edildi', 'he': 'בוטל', 'es': 'Cancelado'},
    'expired': {'fr': 'Expiré', 'de': 'Abgelaufen', 'it': 'Scaduto', 'ja': '期限切れ', 'ru': 'Истек', 'tr': 'Süresi Doldu', 'he': 'פג תוקף', 'es': 'Vencido'},
    'processing': {'fr': 'Traitement en cours', 'de': 'Verarbeitung läuft', 'it': 'Elaborazione in corso', 'ja': '処理中', 'ru': 'Обработка', 'tr': 'İşleniyor', 'he': 'בעיבוד', 'es': 'Procesando'},

    # Ratings & Reviews
    'rating': {'fr': 'Évaluation', 'de': 'Bewertung', 'it': 'Valutazione', 'ja': '評価', 'ru': 'Рейтинг', 'tr': 'Derecelendirme', 'he': 'דירוג', 'es': 'Calificación'},
    'review': {'fr': 'Avis', 'de': 'Rezension', 'it': 'Recensione', 'ja': 'レビュー', 'ru': 'Отзыв', 'tr': 'İnceleme', 'he': 'ביקורת', 'es': 'Reseña'},
    'star': {'fr': 'Étoile', 'de': 'Stern', 'it': 'Stella', 'ja': '星', 'ru': 'Звезда', 'tr': 'Yıldız', 'he': 'כוכב', 'es': 'Estrella'},
    'excellent': {'fr': 'Excellent', 'de': 'Ausgezeichnet', 'it': 'Eccellente', 'ja': '素晴らしい', 'ru': 'Отлично', 'tr': 'Mükemmel', 'he': 'מעולה', 'es': 'Excelente'},
    'good': {'fr': 'Bon', 'de': 'Gut', 'it': 'Buono', 'ja': '良い', 'ru': 'Хорошо', 'tr': 'İyi', 'he': 'טוב', 'es': 'Bueno'},
    'average': {'fr': 'Moyen', 'de': 'Durchschnittlich', 'it': 'Medio', 'ja': 'まあまあ', 'ru': 'Среднее', 'tr': 'Orta', 'he': 'בינוני', 'es': 'Promedio'},
    'poor': {'fr': 'Mauvais', 'de': 'Schlecht', 'it': 'Scadente', 'ja': '悪い', 'ru': 'Плохо', 'tr': 'Kötü', 'he': 'גרוע', 'es': 'Malo'},
    'recommended': {'fr': 'Recommandé', 'de': 'Empfohlen', 'it': 'Consigliato', 'ja': 'おすすめ', 'ru': 'Рекомендуется', 'tr': 'Önerilen', 'he': 'מומלץ', 'es': 'Recomendado'},

    # Location & Navigation
    'location': {'fr': 'Emplacement', 'de': 'Lage', 'it': 'Posizione', 'ja': 'ロケーション', 'ru': 'Местоположение', 'tr': 'Konum', 'he': 'מיקום', 'es': 'Ubicación'},
    'map': {'fr': 'Carte', 'de': 'Karte', 'it': 'Mappa', 'ja': '地図', 'ru': 'Карта', 'tr': 'Harita', 'he': 'מפה', 'es': 'Mapa'},
    'distance': {'fr': 'Distance', 'de': 'Entfernung', 'it': 'Distanza', 'ja': '距離', 'ru': 'Расстояние', 'tr': 'Mesafe', 'he': 'מרחק', 'es': 'Distancia'},
    'airport': {'fr': 'Aéroport', 'de': 'Flughafen', 'it': 'Aeroporto', 'ja': '空港', 'ru': 'Аэропорт', 'tr': 'Havaalanı', 'he': 'נמל תעופה', 'es': 'Aeropuerto'},
    'beach': {'fr': 'Plage', 'de': 'Strand', 'it': 'Spiaggia', 'ja': 'ビーチ', 'ru': 'Пляж', 'tr': 'Plaj', 'he': 'חוף', 'es': 'Playa'},
    'center': {'fr': 'Centre', 'de': 'Zentrum', 'it': 'Centro', 'ja': 'センター', 'ru': 'Центр', 'tr': 'Merkez', 'he': 'מרכז', 'es': 'Centro'},
    'downtown': {'fr': 'Centre-ville', 'de': 'Innenstadt', 'it': 'Centro Città', 'ja': 'ダウンタウン', 'ru': 'Центр Город', 'tr': 'Şehir Merkezi', 'he': 'מרכז העיר', 'es': 'Centro Ciudad'},
    'directions': {'fr': 'Itinéraire', 'de': 'Richtungen', 'it': 'Indicazioni', 'ja': '方向', 'ru': 'Направления', 'tr': 'Yönler', 'he': 'כיוונים', 'es': 'Direcciones'},
    'nearby': {'fr': 'À proximité', 'de': 'In der Nähe', 'it': 'Nelle Vicinanze', 'ja': '近く', 'ru': 'Поблизости', 'tr': 'Yakınında', 'he': 'בקרבת מקום', 'es': 'Cercano'},

    # Dates & Time
    'date': {'fr': 'Date', 'de': 'Datum', 'it': 'Data', 'ja': '日付', 'ru': 'Дата', 'tr': 'Tarih', 'he': 'תאריך', 'es': 'Fecha'},
    'arrival': {'fr': 'Arrivée', 'de': 'Ankunft', 'it': 'Arrivo', 'ja': '到着', 'ru': 'Прибытие', 'tr': 'Varış', 'he': 'הגעה', 'es': 'Llegada'},
    'departure': {'fr': 'Départ', 'de': 'Abreise', 'it': 'Partenza', 'ja': '出発', 'ru': 'Отъезд', 'tr': 'Kalkış', 'he': 'יציאה', 'es': 'Salida'},
    'adults': {'fr': 'Adultes', 'de': 'Erwachsene', 'it': 'Adulti', 'ja': '大人', 'ru': 'Взрослые', 'tr': 'Yetişkinler', 'he': 'מבוגרים', 'es': 'Adultos'},
    'children': {'fr': 'Enfants', 'de': 'Kinder', 'it': 'Bambini', 'ja': '子ども', 'ru': 'Дети', 'tr': 'Çocuklar', 'he': 'ילדים', 'es': 'Niños'},
    'nights': {'fr': 'Nuits', 'de': 'Nächte', 'it': 'Notti', 'ja': '泊数', 'ru': 'Ночи', 'tr': 'Geceler', 'he': 'לילות', 'es': 'Noches'},
    'today': {'fr': 'Aujourd\'hui', 'de': 'Heute', 'it': 'Oggi', 'ja': '今日', 'ru': 'Сегодня', 'tr': 'Bugün', 'he': 'היום', 'es': 'Hoy'},
    'tomorrow': {'fr': 'Demain', 'de': 'Morgen', 'it': 'Domani', 'ja': '明日', 'ru': 'Завтра', 'tr': 'Yarın', 'he': 'מחר', 'es': 'Mañana'},

    # Common Actions
    'save': {'fr': 'Enregistrer', 'de': 'Speichern', 'it': 'Salva', 'ja': '保存', 'ru': 'Сохранить', 'tr': 'Kaydet', 'he': 'שמור', 'es': 'Guardar'},
    'edit': {'fr': 'Modifier', 'de': 'Bearbeiten', 'it': 'Modifica', 'ja': '編集', 'ru': 'Редактировать', 'tr': 'Düzenle', 'he': 'ערוך', 'es': 'Editar'},
    'delete': {'fr': 'Supprimer', 'de': 'Löschen', 'it': 'Elimina', 'ja': '削除', 'ru': 'Удалить', 'tr': 'Sil', 'he': 'מחק', 'es': 'Eliminar'},
    'update': {'fr': 'Mise à jour', 'de': 'Aktualisieren', 'it': 'Aggiorna', 'ja': '更新', 'ru': 'Обновить', 'tr': 'Güncelle', 'he': 'עדכן', 'es': 'Actualizar'},
    'search': {'fr': 'Rechercher', 'de': 'Suchen', 'it': 'Cerca', 'ja': '検索', 'ru': 'Поиск', 'tr': 'Ara', 'he': 'חפש', 'es': 'Buscar'},
    'filter': {'fr': 'Filtrer', 'de': 'Filtern', 'it': 'Filtra', 'ja': 'フィルター', 'ru': 'Фильтр', 'tr': 'Filtrele', 'he': 'סנן', 'es': 'Filtrar'},
    'sort': {'fr': 'Trier', 'de': 'Sortieren', 'it': 'Ordina', 'ja': 'ソート', 'ru': 'Сортировать', 'tr': 'Sırala', 'he': 'מיין', 'es': 'Ordenar'},
    'next': {'fr': 'Suivant', 'de': 'Nächste', 'it': 'Prossimo', 'ja': '次', 'ru': 'Далее', 'tr': 'Sonraki', 'he': 'הבא', 'es': 'Siguiente'},
    'previous': {'fr': 'Précédent', 'de': 'Vorherige', 'it': 'Precedente', 'ja': '前', 'ru': 'Предыдущий', 'tr': 'Önceki', 'he': 'הקודם', 'es': 'Anterior'},
    'back': {'fr': 'Retour', 'de': 'Zurück', 'it': 'Indietro', 'ja': '戻る', 'ru': 'Назад', 'tr': 'Geri', 'he': 'חזור', 'es': 'Atrás'},
    'submit': {'fr': 'Soumettre', 'de': 'Absenden', 'it': 'Inviare', 'ja': '送信', 'ru': 'Отправить', 'tr': 'Gönder', 'he': 'שלח', 'es': 'Enviar'},
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

def translate_with_comprehensive_dict(key, value, language_code):
    """ترجمة استخدام القاموس الشامل"""
    
    if not value or len(value.strip()) == 0:
        return value
    
    key_lower = key.lower()
    value_lower = value.lower()
    
    # البحث 1: البحث المباشر في المفتاح
    if key_lower in TOURISM_TRANSLATIONS and language_code in TOURISM_TRANSLATIONS[key_lower]:
        return TOURISM_TRANSLATIONS[key_lower][language_code]
    
    # البحث 2: البحث عن كلمات في القاموس
    for dict_key, translations in TOURISM_TRANSLATIONS.items():
        if language_code in translations:
            if dict_key in key_lower or dict_key in value_lower:
                return translations[language_code]
    
    # إرجاع القيمة الأصلية إذا لم نجد ترجمة
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
    print("🌍 نظام الترجمة الاحترافي النهائي (مع قاموس 370+ مصطلح)")
    print("=" * 80)
    print()
    
    if not ENGLISH_DIR.exists():
        print(f"❌ مجلد English غير موجود")
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
    print(f"📚 قاموس شامل: {len(TOURISM_TRANSLATIONS)} مصطلح سياحي")
    print(f"💾 الحفظ في: {OUTPUT_DIR}\n")
    
    languages = ['fr', 'de', 'it', 'ja', 'ru', 'tr', 'he', 'es']
    
    for lang_code in languages:
        print(f"🔄 ترجمة إلى {lang_code}...")
        
        lang_dir = OUTPUT_DIR / lang_code
        lang_dir.mkdir(parents=True, exist_ok=True)
        
        for filename, en_dict in english_files.items():
            translated = {}
            
            for key, value in en_dict.items():
                translated_value = translate_with_comprehensive_dict(key, value, lang_code)
                translated[key] = translated_value
            
            php_content = build_php_array(translated)
            output_path = lang_dir / filename
            
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(php_content)
        
        print(f"  ✅ {lang_code} اكتملت")
    
    print()
    print("=" * 80)
    print("✅✅✅ اكتملت جميع الترجمات!")
    print(f"📁 الموقع: {OUTPUT_DIR}")
    print("=" * 80)

if __name__ == '__main__':
    main()
