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

$es_ui_fixes = [
    'main.php' => [
        // Column Names found by browser
        'accommodations' => 'Alojamientos',
        'currency' => 'Moneda',
        'is_active' => 'Está activo',
        'cities' => 'Ciudades',
        'city' => 'Ciudad',
        'country' => 'País',
        'category' => 'Categoría',
        'iso2' => 'ISO2',
        'iso3' => 'ISO3',
        'emoji' => 'Emoji',
        'capital' => 'Capital',
        'tld' => 'TLD',
        'native' => 'Nativo',
        'region_id' => 'ID de Región',
        'subregion_id' => 'ID de Subregión',
        'timezone_id' => 'ID de Zona Horaria',
        'translation_id' => 'ID de Traducción',
        'pricing_unit' => 'Unidad de Precio',
        'pricing-definitions' => 'Definiciones de Precios',
        
        // UI & Structure
        'showing' => 'Mostrando',
        'of' => 'de',
        'page' => 'página',
        'progress' => 'Progreso',
        'columns' => 'Columnas',
        'reset_filters' => 'Restablecer filtros',
        'filter_by' => 'Filtrar por',
        'search_in' => 'Buscar en',
        'type_to_search' => 'Escribe para buscar',
        'quick_actions' => 'Acciones rápidas',
        'quick_' => 'Rápido ',
        'force_' => 'Forzar ',
        
        // Common missing tech terms
        'uuid' => 'UUID',
        'id' => 'ID'
    ]
];

// Apply Fixes
foreach ($es_ui_fixes as $file => $trans) {
    applyFix($file, $trans, 'es');
}

// Mirror structural UI fixes to Arabic for 100% parity
$ar_ui_fixes = [
    'main.php' => [
        'showing' => 'عرض',
        'of' => 'من',
        'page' => 'صفحة',
        'progress' => 'التقدم',
        'columns' => 'الأعمدة',
        'reset_filters' => 'إعادة تعيين الفلاتر',
        'filter_by' => 'تصفية حسب',
        'search_in' => 'البحث في',
        'quick_actions' => 'إجراءات سريعة',
        'accommodations' => 'أماكن الإقامة',
        'currency' => 'العملة',
        'is_active' => 'نشط',
        'cities' => 'المدن',
        'city' => 'المدينة',
        'country' => 'الدولة',
        'category' => 'الفئة'
    ]
];

foreach ($ar_ui_fixes as $file => $trans) {
    applyFix($file, $trans, 'ar');
}

echo "DONE!\n";
