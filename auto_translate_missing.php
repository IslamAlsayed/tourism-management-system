<?php

$sourceLang = 'en';
$targetLangs = ['ar', 'de', 'es', 'fr', 'he', 'it', 'ja', 'ru', 'tr'];
$files = ['main.php', 'messages.php', 'sidebar.php', 'auth.php', 'automation.php', 'activity.php', 'languages.php'];

$basePath = __DIR__ . '/resources/lang';

function translateText($text, $targetLang) {
    // Basic Google Translate free endpoint (gtx)
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=" . urlencode($targetLang) . "&dt=t&q=" . urlencode($text);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $result = json_decode($response, true);
        if (isset($result[0][0][0])) {
            $translated = "";
            foreach ($result[0] as $sentence) {
                $translated .= $sentence[0];
            }
            return $translated;
        }
    }
    return $text; // Fallback to English if translation fails
}

function exportArrayToPhp($array) {
    $content = "<?php\n\nreturn [\n";
    foreach ($array as $key => $value) {
        // Safe escaping for PHP
        $safeKey = addcslashes($key, "'\\");
        $safeValue = addcslashes($value, "'\\");
        $content .= "    '$safeKey' => '$safeValue',\n";
    }
    $content .= "];\n";
    return $content;
}

$totalTranslated = 0;

foreach ($targetLangs as $lang) {
    echo "=====================================\n";
    echo "Processing Language: " . strtoupper($lang) . "\n";
    echo "=====================================\n";
    
    foreach ($files as $file) {
        $sourceFile = $basePath . '/' . $sourceLang . '/' . $file;
        $targetFile = $basePath . '/' . $lang . '/' . $file;
        
        if (!file_exists($sourceFile)) continue;
        
        $sourceArray = include $sourceFile;
        $targetArray = file_exists($targetFile) ? include $targetFile : [];
        
        $missingKeys = array_diff_key($sourceArray, $targetArray);
        $count = count($missingKeys);
        
        if ($count > 0) {
            echo "-> $file: Found $count missing keys. Translating...\n";
            $added = 0;
            
            foreach ($missingKeys as $key => $enValue) {
                // If the English value contains HTML or variables like :count, it might be tricky, 
                // but Google handles it somewhat okay.
                if (trim($enValue) === '') {
                    $targetArray[$key] = '';
                } else {
                    $translated = translateText($enValue, $lang);
                    $targetArray[$key] = $translated;
                    $added++;
                    $totalTranslated++;
                    echo "   [$key] translated.\n";
                }
                
                // Add a small delay to avoid Google blocking our IP
                usleep(100000); // 0.1 seconds
            }
            
            // Sort array alphabetically by key
            ksort($targetArray);
            
            // Save back to file
            file_put_contents($targetFile, exportArrayToPhp($targetArray));
            echo "-> $file: Saved $added new translations.\n";
        } else {
            echo "-> $file: Perfect. No missing keys.\n";
        }
    }
}

echo "\n=====================================\n";
echo "DONE! Total missing keys translated and added: $totalTranslated\n";
echo "=====================================\n";

?>
