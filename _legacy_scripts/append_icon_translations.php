<?php

$paths = glob('resources/lang/*/main.php');

$newKeys = [
    'en' => [
        'sync_discover' => 'Sync & Discover',
        'sync_success' => 'Icons synced successfully',
        'icon_type' => 'Icon Type',
        'icon_class' => 'Icon Class',
        'icon_weight' => 'Icon Weight',
        'primary_color_light' => 'Primary Color (Light)',
        'secondary_color_light' => 'Secondary Color (Light)',
        'primary_color_dark' => 'Primary Color (Dark)',
        'secondary_color_dark' => 'Secondary Color (Dark)',
        'custom_css_classes' => 'Custom CSS Classes',
        'custom_inline_styles' => 'Custom Inline Styles',
        'preview_dark' => 'Preview (Dark)',
        'preview_light' => 'Preview (Light)',
        'duotone' => 'Duotone',
        'solid' => 'Solid',
        'regular' => 'Regular',
        'light' => 'Light',
        'thin' => 'Thin',
        'scan_files' => 'Scan Files for New Icons',
        'start_sync' => 'Start Synchronization',
        'syncing' => 'Syncing...',
        'icon_size' => 'Icon Size',
    ],
    'ar' => [
        'sync_discover' => 'مزامنة واكتشاف',
        'sync_success' => 'تمت مزامنة الأيقونات بنجاح',
        'icon_type' => 'نوع الأيقونة',
        'icon_class' => 'فئة الأيقونة',
        'icon_weight' => 'وزن الأيقونة',
        'primary_color_light' => 'اللون الأساسي (النهاري)',
        'secondary_color_light' => 'اللون الثانوي (النهاري)',
        'primary_color_dark' => 'اللون الأساسي (الليلي)',
        'secondary_color_dark' => 'اللون الثانوي (الليلي)',
        'custom_css_classes' => 'فئات CSS المخصصة',
        'custom_inline_styles' => 'أنماط مضمنة مخصصة',
        'preview_dark' => 'معاينة (ليلي)',
        'preview_light' => 'معاينة (نهاري)',
        'duotone' => 'مزدوج (Duotone)',
        'solid' => 'صلب (Solid)',
        'regular' => 'عادي (Regular)',
        'light' => 'خفيف (Light)',
        'thin' => 'نحيف (Thin)',
        'scan_files' => 'فحص الملفات لاكتشاف أيقونات جديدة',
        'start_sync' => 'بدء المزامنة',
        'syncing' => 'جاري المزامنة...',
        'icon_size' => 'حجم الأيقونة',
    ]
];

foreach ($paths as $path) {
    preg_match('/lang\/(.*?)\/main\.php/', $path, $matches);
    $lang = $matches[1] ?? 'en';
    
    $content = file_get_contents($path);
    
    // Choose translation source (use Arabic for ar, English for rest as fallback)
    $sourceKeys = $lang === 'ar' ? $newKeys['ar'] : $newKeys['en'];
    
    $appended = false;
    foreach ($sourceKeys as $key => $value) {
        // If key doesn\'t exist, append it before the last ];
        if (strpos($content, "'$key'") === false && strpos($content, "\"$key\"") === false) {
            $value = str_replace("'", "\'", $value);
            $lineToInsert = "    '$key' => '$value',\n";
            $content = preg_replace('/];(?!.*];)/s', $lineToInsert . "];", $content);
            $appended = true;
        }
    }
    
    if ($appended) {
        file_put_contents($path, $content);
        echo "Updated $lang\n";
    } else {
        echo "No new keys needed for $lang\n";
    }
}
echo "Done!\n";
