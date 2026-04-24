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
$finalExport = [];

foreach ($langs as $lang) {
    $langKeys = get_lang_keys("$baseDir/$lang/main.php");
    $toTranslate = [];
    
    foreach ($enKeys as $key => $enValue) {
        if (!isset($langKeys[$key])) {
            $toTranslate[$key] = $enValue;
        } else {
            $value = $langKeys[$key];
            // Identify untranslated placeholder values (e.g. 'main.save') or empty strings
            if ($value === "" || $value === $key || $value === $enValue && strpos($value, '.') !== false) {
                 $toTranslate[$key] = $enValue;
            }
        }
    }
    if (!empty($toTranslate)) {
        $finalExport[$lang] = $toTranslate;
    }
}

file_put_contents('translation_export_raw.json', json_encode($finalExport, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Exported " . count($finalExport) . " languages to translation_export_raw.json\n";
foreach ($finalExport as $lang => $keys) {
    echo "$lang: " . count($keys) . " keys\n";
}
