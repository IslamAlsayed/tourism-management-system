<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$ts = new Modules\TranslationManager\Services\TranslationService();
$enFlat = $ts->getFlattenedTranslations('en', 'main');
$ruFlat = $ts->getFlattenedTranslations('ru', 'main');

function translateText($text, $source = 'en', $target = 'ru') {
    if (empty(trim($text))) return $text;
    
    // Check if there are laravel variables like :attribute
    $variables = [];
    preg_match_all('/:([a-zA-Z0-9_]+)/', $text, $matches);
    foreach ($matches[0] as $i => $match) {
        $placeholder = "___VAR{$i}___";
        $variables[$placeholder] = $match;
        $text = str_replace($match, $placeholder, $text);
    }

    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=" . $source . "&tl=" . $target . "&dt=t&q=" . urlencode($text);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Be polite
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36");
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    if (!isset($result[0]) || empty($result[0])) {
        return $text; // fallback
    }
    
    $translatedText = '';
    foreach ($result[0] as $part) {
        $translatedText .= $part[0];
    }

    // Restore laravel variables
    foreach ($variables as $placeholder => $originalVar) {
        $translatedText = str_replace($placeholder, $originalVar, $translatedText);
    }
    
    return $translatedText;
}

$missingKeys = [];
foreach ($enFlat as $k => $v) {
    $r = $ruFlat[$k] ?? '';
    // Let's translate anything that is exactly the same as English, empty, or null
    if ($r === '' || $r === null || trim($r) === trim($v)) {
        if (!empty(trim($v)) && !is_numeric($v)) {
            $missingKeys[$k] = $v;
        }
    }
}

echo "Found " . count($missingKeys) . " keys to translate.\n";

$count = 0;
foreach ($missingKeys as $k => $v) {
    if ($count > 300) {
        break; // Process in batches to avoid API block
    }
    
    $ru = translateText($v, 'en', 'ru');
    if ($ru && $ru !== $v) {
        try {
            $ts->saveTranslation('ru', 'main', $k, $ru);
            echo "Translated: {$k} => {$ru}\n";
        } catch (\Exception $e) {
            echo "Error saving {$k}: " . $e->getMessage() . "\n";
        }
    }
    $count++;
    // Sleep gently
    usleep(300000); // 300ms
}

echo "Saved $count translations.\n";
