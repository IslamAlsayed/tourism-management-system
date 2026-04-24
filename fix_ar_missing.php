<?php
$basePath = __DIR__ . '/resources/lang/ar';
$filePath = $basePath . '/main.php';
$data = include $filePath;

// All 150 missing nested Arabic keys
$nested = [
    'main' => [
        'internal_title' => 'العنوان الداخلي',
        'active_status' => 'حالة التفعيل',
        'save_changes' => 'حفظ التغييرات',
        'saving' => 'جاري الحفظ...',
        'manage_system_columns' => 'إدارة أعمدة النظام',
        'dashboard_subtitle' => 'لوحة التحكم الفرعية',
        'please_wait' => 'يرجى الانتظار...',
        'available_columns' => 'الأعمدة المتاحة',
        'selected' => 'المحدد',
        'no_columns_found_title' => 'لم يتم العثور على أعمدة',
        'no_columns_found_desc' => 'لا توجد أعمدة متاحة لهذا الوحدة.',
        'import_history' => 'سجل الاستيراد',
        'processing' => 'قيد المعالجة',
        'clear_history' => 'مسح السجل',
        'importing_data' => 'جاري استيراد البيانات',
        'ready_to_start_import' => 'جاهز لبدء الاستيراد',
        'please_wait_importing' => 'يرجى الانتظار، جاري الاستيراد...',
        'start' => 'ابدأ',
        'records_processed' => 'السجلات المعالجة',
        'estimated_time' => 'الوقت المقدر',
        'import_started' => 'بدأ الاستيراد',
        'found_records' => 'السجلات الموجودة',
        'fetching_operations' => 'جاري جلب العمليات',
        'processing_next_batch' => 'معالجة الدفعة التالية',
        'cancel_import' => 'إلغاء الاستيراد',
        'queued_waiting' => 'في قائمة الانتظار',
        'cancel_queued' => 'إلغاء من قائمة الانتظار',
        'do_not_refresh_warning' => 'لا تقم بتحديث الصفحة أثناء الاستيراد!',
        'date' => 'التاريخ',
        'user' => 'المستخدم',
        'source' => 'المصدر',
        'details' => 'التفاصيل',
        'file_upload' => 'رفع ملف',
        'completed' => 'مكتمل',
        'failed' => 'فشل',
        'queued' => 'في الانتظار',
        'no_history_records' => 'لا توجد سجلات سابقة.',
        'media-files' => 'ملفات الوسائط',
        'media-file' => 'ملف وسائط',
        'all_types' => 'جميع الأنواع',
        'images' => 'صور',
        'videos' => 'فيديوهات',
        'documents' => 'مستندات',
        'spreadsheets' => 'جداول بيانات',
        'other' => 'أخرى',
        'all_collections' => 'جميع المجموعات',
        'all_status' => 'جميع الحالات',
        'grid_length' => 'طول الشبكة',
        'no_files_found' => 'لم يتم العثور على ملفات.',
        'meals' => 'وجبات',
        'auto_refresh' => 'تحديث تلقائي',
        'manage_users' => 'إدارة المستخدمين',
        'upload_files' => 'رفع الملفات',
        'upload_multiple_files' => 'رفع ملفات متعددة',
        'files' => 'ملفات',
        'click_or_drag_images_here' => 'انقر أو اسحب الصور هنا',
        'alt_text' => 'النص البديل',
        'available_collections' => 'المجموعات المتاحة',
        'priority_of_appearance' => 'أولوية الظهور',
        'featured' => 'مميز',
        'edit_media_file' => 'تعديل ملف الوسائط',
        'file_type' => 'نوع الملف',
        'file_size' => 'حجم الملف',
        'dimensions' => 'الأبعاد',
        'file_name' => 'اسم الملف',
        'replace_file' => 'استبدال الملف',
        'optional' => 'اختياري',
        'click_to_upload_or_drag_and_drop' => 'انقر للرفع أو اسحب وأفلت',
        'leave_empty_to_keep_current_file' => 'اتركه فارغاً للاحتفاظ بالملف الحالي',
        'replaced_file' => 'ملف مستبدل',
        'file' => 'ملف',
        'media_file_details' => 'تفاصيل ملف الوسائط',
        'download' => 'تحميل',
        'file_information' => 'معلومات الملف',
        'mime_type' => 'نوع MIME',
        'collection_name' => 'اسم المجموعة',
        'is_featured' => 'مميز',
        'display_order' => 'ترتيب العرض',
        'uploaded_by' => 'رفع بواسطة',
        'uploaded_at' => 'تاريخ الرفع',
        'last_updated' => 'آخر تحديث',
        'view_original' => 'عرض الأصل',
        'copy_url' => 'نسخ الرابط',
        'url_copied_to_clipboard' => 'تم نسخ الرابط!',
        'failed_to_copy_url' => 'فشل نسخ الرابط',
        'copied' => 'تم النسخ',
        'pricing-definition' => 'تعريف التسعير',
        'pricing-definitions' => 'تعريفات التسعير',
        'transportations_companies' => 'شركات النقل',
        'key' => 'المفتاح',
        'category' => 'الفئة',
        'id' => 'المعرّف',
        'mandatory' => 'إلزامي',
        'applicable_date' => 'تاريخ السريان',
        'policy' => 'السياسة',
        'quotation' => 'عرض الأسعار',
        'classification' => 'التصنيف',
        'star_rating' => 'تصنيف النجوم',
        'general_mobile' => 'الهاتف المحمول العام',
        'general_email' => 'البريد الإلكتروني العام',
        'contact_person' => 'شخص الاتصال',
        'street' => 'الشارع',
        'included' => 'مشمول',
        'no_data_available' => 'لا توجد بيانات متاحة',
        'restaurant' => 'مطعم',
        'services' => 'خدمات',
        'service' => 'خدمة',
        'per_adult_foreigners' => 'لكل بالغ (أجانب)',
        'per_adult_local' => 'لكل بالغ (محلي)',
        'per_adult_arab' => 'لكل بالغ (عربي)',
        'total_day_visit' => 'إجمالي زيارة اليوم',
        'operating_hours' => 'ساعات العمل',
        'summer_opening_time' => 'وقت الافتتاح صيفاً',
        'summer_closing_time' => 'وقت الإغلاق صيفاً',
        'winter_opening_time' => 'وقت الافتتاح شتاءً',
        'winter_closing_time' => 'وقت الإغلاق شتاءً',
        'person_name_01' => 'اسم الشخص 01',
        'phone' => 'الهاتف',
        'mobile' => 'الجوال',
        'fax' => 'الفاكس',
        'include_unified_ticket' => 'يشمل تذكرة موحدة',
        'local_guide_available' => 'مرشد محلي متوفر',
        'credit_cards' => 'بطاقات ائتمان',
        'club_cars_available' => 'سيارات النادي متوفرة',
        'no_supplements_available' => 'لا توجد ملحقات متاحة',
        'transportations-company' => 'شركة نقل',
        'rating' => 'التقييم',
        'vehicle-type' => 'نوع المركبة',
        'vehicle-types' => 'أنواع المركبات',
        'transportations-bus_type' => 'نوع الحافلة',
        'transportations-bus_types' => 'أنواع الحافلات',
        'states_' => 'الولايات',
        'important_information' => 'معلومات مهمة',
        'ensure_data_accuracy' => 'تأكد من دقة البيانات',
        'geographic_coordinates' => 'الإحداثيات الجغرافية',
        'use_map_services' => 'استخدم خدمات الخرائط',
        'transportation-bus-types' => 'أنواع حافلات النقل',
        'transportation-bus-type' => 'نوع حافلة النقل',
        'transportations-company_bus_type' => 'نوع حافلة الشركة',
        'transportations-company_bus_types' => 'أنواع حافلات الشركة',
        'min_seats' => 'الحد الأدنى للمقاعد',
        'max_seats' => 'الحد الأقصى للمقاعد',
        'seats' => 'المقاعد',
        'transportations-company-bus-types' => 'أنواع حافلات الشركة',
        'transportations-company-bus-type' => 'نوع حافلة الشركة',
        'transportations-department' => 'قسم النقل',
        'transportations-departments' => 'أقسام النقل',
        'optional_fields' => 'حقول اختيارية',
        'transportation-departments' => 'أقسام النقل',
        'transportation-department' => 'قسم النقل',
    ]
];

function updateNestedArray(&$original, $newValues) {
    foreach ($newValues as $key => $value) {
        if (is_array($value) && isset($original[$key]) && is_array($original[$key])) {
            updateNestedArray($original[$key], $value);
        } else {
            $original[$key] = $value;
        }
    }
}

function exportArrayToPhpSafeHelper($array, $indent = 1) {
    $spaces = str_repeat("    ", $indent);
    $content = "[\n";
    foreach ($array as $key => $value) {
        $safeKey = addcslashes((string)$key, "'\\");
        if (is_array($value)) {
            $content .= $spaces . "'$safeKey' => " . exportArrayToPhpSafeHelper($value, $indent + 1) . ",\n";
        } else {
            $safeValue = addcslashes((string)$value, "'\\");
            $content .= $spaces . "'$safeKey' => '$safeValue',\n";
        }
    }
    $content .= str_repeat("    ", $indent - 1) . "]";
    return $content;
}

function exportArrayToPhpSafe($array) {
    return "<?php\n\nreturn " . exportArrayToPhpSafeHelper($array) . ";\n";
}

updateNestedArray($data, $nested);
file_put_contents($filePath, exportArrayToPhpSafe($data));

echo "-> main.php (AR): Updated with 150 missing nested keys.\n";
echo "=====================================\n";
echo "SUCCESS! Fixed all 150 missing Arabic keys.\n";
echo "=====================================\n";
