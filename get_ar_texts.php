<?php
$sourceLang = 'en';
$targetLang = 'es';
$files = ['main.php', 'messages.php', 'sidebar.php', 'auth.php', 'automation.php', 'activity.php', 'languages.php'];
$basePath = __DIR__ . '/resources/lang';
$untranslated = [];
$count = 0;

foreach ($files as $file) {
    $sourcePath = "$basePath/$sourceLang/$file";
    $targetPath = "$basePath/$targetLang/$file";
    
    if (!file_exists($sourcePath)) continue;
    
    $sourceArray = include $sourcePath;
    $targetArray = file_exists($targetPath) ? include $targetPath : [];
    
    foreach ($sourceArray as $key => $enValue) {
        // If the Arabic value is exactly the same as the English value (and it's not empty)
        // This means it hasn't been translated yet.
        if (isset($targetArray[$key]) && $targetArray[$key] === $enValue && trim($enValue) !== '') {
            $untranslated[$file][$key] = $enValue;
            $count++;
        }
    }
}

file_put_contents('untranslated_es.json', json_encode($untranslated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "=====================================\n";
echo "SUCCESS: Found $count untranslated keys in Spanish.\n";
echo "Saved to untranslated_es.json\n";
echo "=====================================\n";
?>
