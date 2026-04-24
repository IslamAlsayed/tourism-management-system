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

$es_ultimate = [
    'activity.php' => [
        'event_error' => 'Error de evento'
    ],
    'languages.php' => [
        'hindi' => 'Hindi',
        'urdu' => 'Urdu',
        'swahili' => 'Suajili'
    ],
    'main.php' => [
        // Avatar Menu (User requested)
        'my_profile' => 'Mi Perfil',
        'my_Perfil' => 'Mi Perfil',
        'dark_mode' => 'Modo Oscuro',
        'log_out' => 'Cerrar sesión',
        'sign_out' => 'Cerrar sesión',
        'idioma' => 'Idioma',
        'pro' => 'Pro',
        
        // Top Menu & Structural
        'search' => 'Buscar',
        'notifications' => 'Notificaciones',
        'quick_tools' => 'Herramientas rápidas',
        'settings' => 'Ajustes',
        'dashboard' => 'Panel de control',
        
        // Final 29 keys from audit
        'error' => 'error',
        'general' => 'General',
        'avatar' => 'Avatar',
        'regional' => 'Regional',
        'star_alliance' => 'Star Alliance',
        'oneworld' => 'OneWorld',
        'skyteam' => 'SkyTeam',
        'cultural' => 'Cultural',
        'capital' => 'Capital',
        'sector' => 'Sector',
        'telegram' => 'Telegram',
        'snapchat' => 'Snapchat',
        'tiktok' => 'TikTok',
        'youtube' => 'YouTube',
        'marketing' => 'Marketing',
        'eur' => 'Euro',
        'roles' => 'Roles',
        'subd' => 'SubD',
        'lid' => 'LID',
        'camping' => 'Camping',
        'premium' => 'Premium',
        'maps.asia/kuwait' => 'asia/kuwait',
        'romance' => 'Romance'
    ],
    'sidebar.php' => [
        'roles' => 'Roles de usuario',
        'general' => 'Visión General'
    ]
];

// Apply Spanish
foreach ($es_ultimate as $file => $trans) {
    applyFix($file, $trans, 'es');
}

// Ensure Arabic parity for the new Avatar keys
$ar_ultimate = [
    'main.php' => [
        'my_profile' => 'ملفي الشخصي',
        'my_Perfil' => 'ملفي الشخصي',
        'dark_mode' => 'الوضع الليلي',
        'log_out' => 'تسجيل الخروج',
        'idioma' => 'اللغة',
        'pro' => 'برو'
    ]
];

foreach ($ar_ultimate as $file => $trans) {
    applyFix($file, $trans, 'ar');
}

echo "ULTIMATE FIX APPLIED!\n";
