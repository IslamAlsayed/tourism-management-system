<?php

function updateNestedArray(&$target, $keys, $value) {
    $key = array_shift($keys);
    if (empty($keys)) {
        $target[$key] = $value;
    } else {
        if (!isset($target[$key]) || !is_array($target[$key])) {
            $target[$key] = [];
        }
        updateNestedArray($target[$key], $keys, $value);
    }
}

function applyFix($file, $translations, $locale = 'es') {
    $path = __DIR__ . "/resources/lang/$locale/$file";
    if (!file_exists($path)) {
        echo "File not found: $path\n";
        return;
    }
    
    $data = include $path;
    foreach ($translations as $key => $val) {
        $keys = explode('.', $key);
        updateNestedArray($data, $keys, $val);
    }
    
    $content = "<?php\n\nreturn " . var_export($data, true) . ";\n";
    file_put_contents($path, $content);
    echo "-> Applied fix to $file ($locale)\n";
}

$es_manager_fixes = [
    'main.php' => [
        // Translation Manager UI
        'translation_manager' => 'Gestor de Traducciones',
        'translations' => 'Traducciones',
        'import_csv' => 'Importar CSV',
        'export' => 'Exportar',
        'auto_scan_files' => 'Escaneo automático',
        'add_new_text' => 'Añadir nuevo texto',
        'review_suggestions' => 'Revisar sugerencias',
        'all' => 'Todo',
        'missing' => 'Faltante',
        'done' => 'Hecho',
        'key' => 'Clave',
        'english_reference' => 'Referencia en Inglés',
        'status' => 'Estado',
        'suggest' => 'Sugerir',
        'home' => 'Inicio',
        'shortcuts' => 'Atajos',
        'settings' => 'Ajustes',
        'please_wait_downloading' => 'Por favor, espere mientras se descarga...',
        'download_failed' => 'Descarga fallida',
        'file_not_found' => 'Archivo no encontrado',
        'scan_complete' => 'Escaneo completado',
        'found_new_keys' => 'Nuevas claves encontradas',
        
        // Pagination & Labels
        'results_per_page' => 'Resultados por página',
        'total_records' => 'Total de registros',
        'no_suggestions' => 'No hay sugerencias'
    ],
    'sidebar.php' => [
        'translation_manager' => 'Gestor de Traducciones',
        'cruises' => 'Cruceros'
    ]
];

// Apply Spanish
foreach ($es_manager_fixes as $file => $trans) {
    applyFix($file, $trans, 'es');
}

// Arabic Parity for Manager UI
$ar_manager_fixes = [
    'main.php' => [
        'translation_manager' => 'مدير الترجمة',
        'translations' => 'الترجمات',
        'import_csv' => 'استيراد CSV',
        'export' => 'تصدير',
        'auto_scan_files' => 'مسح تلقائي للملفات',
        'add_new_text' => 'إضافة نص جديد',
        'review_suggestions' => 'مراجعة الاقتراحات',
        'all' => 'الكل',
        'missing' => 'مفقود',
        'done' => 'مكتمل',
        'key' => 'المفتاح',
        'english_reference' => 'المرجع الإنجليزي',
        'status' => 'الحالة',
        'suggest' => 'اقتراح',
        'home' => 'الرئيسية',
        'shortcuts' => 'الاختصارات',
        'settings' => 'الإعدادات',
        'please_wait_downloading' => 'يرجى الانتظار أثناء التحميل...',
        'download_failed' => 'فشل التحميل',
        'file_not_found' => 'الملف غير موجود'
    ],
    'sidebar.php' => [
        'translation_manager' => 'مدير الترجمة',
        'cruises' => 'الرحلات البحرية'
    ]
];

foreach ($ar_manager_fixes as $file => $trans) {
    applyFix($file, $trans, 'ar');
}

echo "TRANSLATION MANAGER UI FIX APPLIED!\n";
