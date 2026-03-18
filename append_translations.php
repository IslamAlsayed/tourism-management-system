<?php

$columnsFile = 'storage/logs/all_columns.json';
if (!file_exists($columnsFile)) {
    die("Columns file not found.\n");
}

$columns = json_decode(file_get_contents($columnsFile), true);
$languages = ['en', 'ar', 'es', 'it', 'fr', 'ja', 'tr', 'de', 'ru', 'he'];

foreach ($languages as $lang) {
    echo "Processing language: $lang\n";
    
    $langDir = "resources/lang/$lang";
    $langFile = "$langDir/main.php";
    
    if (!is_dir($langDir)) {
        mkdir($langDir, 0777, true);
    }
    
    $existing = [];
    $isNewFile = false;
    
    if (file_exists($langFile)) {
        $existing = require $langFile;
    } else {
        $isNewFile = true;
    }
    
    $newKeys = [];
    foreach ($columns as $key => $englishText) {
        if (!isset($existing[$key])) {
            $newKeys[$key] = $englishText;
        }
    }
    
    if (count($newKeys) > 0) {
        if ($isNewFile) {
            $content = "<?php\n\nreturn [\n";
            foreach ($newKeys as $key => $value) {
                $valEscaped = str_replace("'", "\'", $value);
                $content .= "    '$key' => '$valEscaped',\n";
            }
            $content .= "];\n";
            file_put_contents($langFile, $content);
        } else {
            $content = file_get_contents($langFile);
            $content = preg_replace('/\];\s*$/', '', $content);
            $content .= "\n    // --- Auto-Generated Column Translations ---\n";
            foreach ($newKeys as $key => $value) {
                $valEscaped = str_replace("'", "\'", $value);
                $content .= "    '$key' => '$valEscaped',\n";
            }
            $content .= "];\n";
            file_put_contents($langFile, $content);
        }
        echo "Added " . count($newKeys) . " new keys to $langFile.\n";
    } else {
        echo "No new keys to add for $langFile.\n";
    }
}

echo "All translation files checked and updated.\n";
