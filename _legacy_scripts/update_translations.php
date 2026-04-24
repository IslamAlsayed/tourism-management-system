<?php
$bladePath = __DIR__ . '/resources/views/livewire/ui-icons-manager.blade.php';
$content = file_get_contents($bladePath);

preg_match_all("/__\('main\.([^']+)'\)\s*\?\?\s*'([^']+)'/", $content, $matches);

$newKeys = [];
for ($i = 0; $i < count($matches[0]); $i++) {
    $newKeys[$matches[1][$i]] = $matches[2][$i];
}

$updateLang = function($langPath, $sourceKeys) {
    if (!file_exists($langPath)) return;
    $existing = require $langPath;
    $added = 0;
    foreach ($sourceKeys as $k => $v) {
        if (!isset($existing[$k])) {
            // Very simple english to arabic translation mapping for a few common words
            // Since we don't have a real translation engine here, we'll try to put Arabic if it's the ar file
            if (strpos($langPath, '/ar/') !== false) {
                // Some basic fallbacks for AR just so it doesn't show exactly English if possible
                $v = str_replace('UI Icons Manager', 'مدير أيقونات واجهة المستخدم', $v);
                $v = str_replace('Manage & customize system icon appearances across themes', 'إدارة وتخصيص مظهر أيقونات النظام في جميع السمات', $v);
                $v = str_replace('Add Icon', 'إضافة أيقونة', $v);
                $v = str_replace('Search by key or class...', 'ابحث بواسطة المفتاح أو الفئة...', $v);
                $v = str_replace('Select All', 'تحديد الكل', $v);
                $v = str_replace('Bulk Edit', 'تعديل جماعي', $v);
                $v = str_replace('Clear Selection', 'مسح التحديد', $v);
                $v = str_replace('Icons', 'أيقونات', $v);
                $v = str_replace('Inactive', 'غير نشط', $v);
                $v = str_replace('Active', 'نشط', $v);
                $v = str_replace('Edit', 'تعديل', $v);
                $v = str_replace('Deactivate', 'إلغاء التنشيط', $v);
                $v = str_replace('Activate', 'تنشيط', $v);
                $v = str_replace('No Icons Found', 'لم يتم العثور على أيقونات', $v);
                $v = str_replace('Action', 'إجراء', $v);
                $v = str_replace('Preview & Details', 'معاينة وتفاصيل', $v);
                $v = str_replace('Styling', 'الأنماط', $v);
                $v = str_replace('Status', 'الحالة', $v);
                $v = str_replace('Actions', 'إجراءات', $v);
                $v = str_replace('Shape', 'الشكل', $v);
                $v = str_replace('Weight', 'الوزن', $v);
                $v = str_replace('Size', 'الحجم', $v);
                $v = str_replace('Add New Icon', 'إضافة أيقونة جديدة', $v);
                $v = str_replace('Edit Icon Details', 'تعديل تفاصيل الأيقونة', $v);
                $v = str_replace('Live Preview', 'معاينة مباشرة', $v);
                $v = str_replace('Icon Target (Key)', 'مفتاح الأيقونة', $v);
                $v = str_replace('Icon CSS Class', 'فئة CSS', $v);
                $v = str_replace('Light Theme Configuration', 'إعدادات السمة الفاتحة', $v);
                $v = str_replace('Dark Theme Configuration', 'إعدادات السمة الداكنة', $v);
                $v = str_replace('Background', 'الخلفية', $v);
                $v = str_replace('Border', 'الحدود', $v);
                $v = str_replace('Square', 'مربع', $v);
                $v = str_replace('Slightly Rounded', 'دائري قليلاً', $v);
                $v = str_replace('Rounded', 'دائري', $v);
                $v = str_replace('Circle', 'دائرة', $v);
                $v = str_replace('Discard', 'إلغاء', $v);
                $v = str_replace('Update Configuration', 'تحديث الإعدادات', $v);
                $v = str_replace('Bulk Configuration', 'إعدادات جماعية', $v);
                $v = str_replace('Cancel', 'إلغاء', $v);
                $v = str_replace('Apply Bulk Configuration', 'تطبيق الإعدادات', $v);
                $v = str_replace('Apply', 'تطبيق', $v);
                $v = str_replace('Light Background', 'خلفية فاتحة', $v);
                $v = str_replace('Dark Background', 'خلفية داكنة', $v);
                $v = str_replace('No Change', 'بدون تغيير', $v);
            }
            $existing[$k] = $v;
            $added++;
        }
    }
    if ($added > 0) {
        $export = var_export($existing, true);
        $export = preg_replace('/^array \(/', '[', $export);
        $export = preg_replace('/^\)$/m', ']', $export);
        $export = str_replace('array (', '[', $export);
        $export = str_replace(')', ']', $export);
        
        $output = "<?php\n\nreturn " . $export . ";\n";
        file_put_contents($langPath, $output);
        echo "Added $added keys to $langPath\n";
    } else {
        echo "No new keys for $langPath\n";
    }
};

$updateLang(__DIR__ . '/resources/lang/en/main.php', $newKeys);
$updateLang(__DIR__ . '/resources/lang/ar/main.php', $newKeys);
