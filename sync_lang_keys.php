<?php

$sourceLang = 'en';
$targetLangs = ['ar', 'de', 'es', 'fr', 'he', 'it', 'ja', 'ru', 'tr'];
$files = ['main.php', 'messages.php', 'sidebar.php', 'auth.php', 'automation.php', 'activity.php', 'languages.php'];

$basePath = __DIR__ . '/resources/lang';

function exportArrayToPhpSafeHelper($array, $indent = 1) {
    $spaces = str_repeat("    ", $indent);
    $content = "[\n";
    foreach ($array as $key => $value) {
        $safeKey = addcslashes((string)$key, "'\\");
        if (is_array($value)) {
            $content .= $spaces . "'$safeKey' => " . exportArrayToPhpSafeHelper($value, $indent + 1) . ",\n";
        } else {
            $safeValue = addcslashes((string)$value, "'\\");
            $content .= $spaces . "'$safeKey' => '$safeValue',\n";
        }
    }
    $content .= str_repeat("    ", $indent - 1) . "]";
    return $content;
}

function exportArrayToPhpSafe($array) {
    return "<?php\n\nreturn " . exportArrayToPhpSafeHelper($array) . ";\n";
}

$totalSynced = 0;

foreach ($targetLangs as $lang) {
    echo str_repeat('-', 50) . "\n";
    echo "Syncing Language: [" . strtoupper($lang) . "]\n";
    echo str_repeat('-', 50) . "\n";
    
    foreach ($files as $file) {
        $sourceFile = $basePath . '/' . $sourceLang . '/' . $file;
        $targetFile = $basePath . '/' . $lang . '/' . $file;
        
        if (!file_exists($sourceFile)) continue;
        
        $sourceArray = include $sourceFile;
        $targetArray = file_exists($targetFile) ? include $targetFile : [];
        
        $missingKeys = array_diff_key($sourceArray, $targetArray);
        $count = count($missingKeys);
        
        if ($count > 0) {
            echo "-> $file: Found $count missing keys. Syncing...\n";
            $added = 0;
            
            foreach ($missingKeys as $key => $enValue) {
                // دمج المفاتيح الناقصة مع وضع القيمة الإنجليزية كقيمة افتراضية (Fallback)
                $targetArray[$key] = $enValue;
                $added++;
                $totalSynced++;
            }
            
            // ترتيب المصفوفة أبجدياً للحفاظ على نظافة الكود
            ksort($targetArray);
            
            // الحفظ الآمن للملف
            file_put_contents($targetFile, exportArrayToPhpSafe($targetArray));
            echo "   [✓] Saved $added synchronized keys to $file.\n";
        } else {
            echo "-> $file: Up to date.\n";
        }
    }
}

echo "\n" . str_repeat('=', 50) . "\n";
echo "SUCCESS! Total missing keys synchronized: $totalSynced\n";
echo str_repeat('=', 50) . "\n";

?>
