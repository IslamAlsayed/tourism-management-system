<?php

function get_lang_keys($filePath) {
    if (!file_exists($filePath)) return [];
    try {
        $content = include $filePath;
        if (!is_array($content)) return [];
        return flatten_array($content);
    } catch (Exception $e) {
        return [];
    }
}

function flatten_array($array, $prefix = '') {
    $result = [];
    foreach ($array as $key => $value) {
        $fullKey = $prefix ? $prefix . '.' . $key : $key;
        if (is_array($value)) {
            $result = array_merge($result, flatten_array($value, $fullKey));
        } else {
            $result[$fullKey] = $value;
        }
    }
    return $result;
}

$baseDir = "resources/lang";
$enKeys = get_lang_keys("$baseDir/en/main.php");

$langs = ['ar', 'es', 'it', 'fr', 'de', 'he', 'ru', 'tr', 'ja'];
$stats = [];

foreach ($langs as $lang) {
    $langKeys = get_lang_keys("$baseDir/$lang/main.php");
    $untranslated = [];
    
    foreach ($enKeys as $key => $enValue) {
        if (!isset($langKeys[$key])) {
            $untranslated[$key] = $enValue;
        } else {
            $value = $langKeys[$key];
            
            // Check if value is a placeholder based on its structure
            // Example: 'main.save' is a typical placeholder in this project
            if ($value === $enValue && strpos($value, '.') !== false) {
                 $untranslated[$key] = $enValue;
            }
            
            // Also check for 'main.' prefix specifically
            if (strpos($value, 'main.') === 0 && strpos($value, ' ') === false) {
                 // But wait, some keys ARE 'main.something'. 
                 // However, if the value is EQUAL to the key, then it's untranslated.
                 // In this project, if 'main.save' => 'main.save', it's definitely untranslated.
                 if ($value === $key) {
                      $untranslated[$key] = $enValue;
                 }
            }
        }
    }
    $stats[$lang] = [
        'count' => count($untranslated),
        'keys' => array_keys($untranslated)
    ];
}

// Just output counts for now to see if they match user's numbers
foreach ($stats as $lang => $data) {
    echo "$lang: " . $data['count'] . "\n";
}
