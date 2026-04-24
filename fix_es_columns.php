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

// Translations for Columns and missing keys (Spanish)
$es_fixes = [
    'activity.php' => [
        'event_error' => 'Error'
    ],
    'languages.php' => [
        'hindi' => 'Hindi',
        'urdu' => 'Urdu',
        'swahili' => 'Swahili'
    ],
    'main.php' => [
        // Column Names (Strictly for the data-table headers)
        'id' => 'ID',
        'uuid' => 'UUID',
        'name' => 'Nombre',
        'name_ar' => 'Nombre (Árabe)',
        'name_en' => 'Nombre (Inglés)',
        'status' => 'Estado',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
        'deleted_at' => 'Eliminado el',
        'email' => 'Correo electrónico',
        'phone' => 'Teléfono',
        'role' => 'Rol',
        'roles' => 'Roles',
        'code' => 'Código',
        'symbol' => 'Símbolo',
        'iso2' => 'ISO2',
        'iso3' => 'ISO3',
        'capital' => 'Capital',
        'region' => 'Región',
        'subregion' => 'Subregión',
        'timezone' => 'Zona horaria',
        'active' => 'Activo',
        'actions' => 'Acciones',
        'type' => 'Tipo',
        'price' => 'Precio',
        'location' => 'Ubicación',
        'continent' => 'Continente',
        'address' => 'Dirección',
        'description' => 'Descripción',
        'notes' => 'Notas',
        'user_id' => 'ID de usuario',
        'image' => 'Imagen',
        'avatar' => 'Avatar',
        
        // Missing Keys
        'error' => 'error',
        'general' => 'General',
        'regional' => 'Regional',
        'star_alliance' => 'Star Alliance',
        'oneworld' => 'OneWorld',
        'skyteam' => 'SkyTeam',
        'cultural' => 'Cultural',
        'sector' => 'Sector',
        'telegram' => 'Telegram',
        'snapchat' => 'Snapchat',
        'tiktok' => 'TikTok',
        'youtube' => 'YouTube',
        'marketing' => 'Marketing',
        'eur' => 'Euro',
        'subd' => 'SubD',
        'lid' => 'LID',
        'camping' => 'Camping',
        'visas' => 'Visados',
        'visa' => 'Visado',
        'premium' => 'Premium',
        'resort' => 'Complejo turístico',
        'romance' => 'Romance'
    ],
    'sidebar.php' => [
        'roles' => 'Roles',
        'resorts' => 'Complejos',
        'lodges' => 'Cabañas',
        'general' => 'General'
    ]
];

// Apply Spanish Fixes
foreach ($es_fixes as $file => $trans) {
    applyFix($file, $trans, 'es');
}

// Ensure Arabic also has these core columns for consistency
$ar_fixes = [
    'main.php' => [
        'id' => 'المعرف',
        'uuid' => 'المعرف الفريد',
        'name' => 'الاسم',
        'status' => 'الحالة',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
        'actions' => 'العمليات',
        'email' => 'البريد الإلكتروني',
        'phone' => 'الهاتف'
    ]
];

foreach ($ar_fixes as $file => $trans) {
    applyFix($file, $trans, 'ar');
}

echo "DONE!\n";
