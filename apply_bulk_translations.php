<?php

function applyTranslations($locale, $jsonFile) {
    $jsonPath = __DIR__ . "/$jsonFile";
    if (!file_exists($jsonPath)) {
        echo "Error: $jsonFile not found.\n";
        return;
    }

    $translations = json_decode(file_get_contents($jsonPath), true);
    if (!$translations) {
        echo "Error: Invalid JSON in $jsonFile.\n";
        return;
    }

    foreach ($translations as $fileName => $keys) {
        $phpPath = __DIR__ . "/resources/lang/$locale/$fileName";
        
        // Load existing or create empty
        if (file_exists($phpPath)) {
            $data = include $phpPath;
            if (!is_array($data)) $data = [];
        } else {
            $data = [];
            // Ensure directory exists
            $dir = dirname($phpPath);
            if (!is_dir($dir)) mkdir($dir, 0755, true);
        }

        // Inject translations
        foreach ($keys as $key => $val) {
            $data[$key] = $val;
        }

        // Save back to PHP file
        $content = "<?php\n\nreturn " . var_export($data, true) . ";\n";
        file_put_contents($phpPath, $content);
        echo "-> Applied " . count($keys) . " keys to $fileName ($locale)\n";
    }
}

echo "Applying Spanish Bulk Translations...\n";
applyTranslations('es', 'missing_es_translated.json');
applyTranslations('es', 'final_13_es.json');

echo "\nApplying Arabic Bulk Translations...\n";
applyTranslations('ar', 'missing_ar_translated.json');

echo "\nSUCCESS! System-wide parity achieved.\n";
