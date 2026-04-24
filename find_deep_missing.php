<?php

function flattenArray($array, $prefix = '') {
    $result = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, flattenArray($value, $prefix . $key . '.'));
        } else {
            $result[$prefix . $key] = $value;
        }
    }
    return $result;
}

$basePath = __DIR__ . '/resources/lang';
$enPath = $basePath . '/en';
$locales = ['ar', 'es'];

// List all files in EN directory
$files = array_diff(scandir($enPath), array('.', '..'));

$all_missing = [];

foreach ($locales as $locale) {
    $targetPath = $basePath . "/$locale";
    $missing_for_locale = [];
    
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;
        
        $enData = include "$enPath/$file";
        $enFlat = flattenArray($enData);
        
        $targetFile = "$targetPath/$file";
        // Also check if en.php exists in target even if it was en.php in source
        $targetData = file_exists($targetFile) ? include $targetFile : [];
        $targetFlat = flattenArray($targetData);
        
        $missing = [];
        foreach ($enFlat as $key => $enVal) {
            $targetVal = isset($targetFlat[$key]) ? $targetFlat[$key] : null;
            
            $isMissing = false;
            if ($targetVal === null || $targetVal === '') {
                $isMissing = true;
            } else {
                // Suspicious check: if target value is exactly the same as English value
                // and it's not a placeholder (starts with :) and is longer than 2 chars
                if (trim(strtolower($targetVal)) === trim(strtolower($enVal))) {
                    if (strpos($enVal, ':') !== 0 && strlen($enVal) > 2) {
                        // Exception list for common brand names or technical terms
                        $exceptions = ['mixjo', 'php', 'url', 'id', 'pdf', 'csv', 'xlsx', 'iata', 'dst', 'iso', 'ably', 'gps', 'wifi', 'usb', 'uuid', 'drive'];
                        $isException = false;
                        foreach($exceptions as $exc) {
                            if (trim(strtolower($enVal)) === $exc) {
                                $isException = true;
                                break;
                            }
                        }
                        
                        $parityExceptions = [
                            'Hotel', 'Hotel ', 'Admin', 'CRM', 'WhatsApp', 'Google Maps', 'Google Drive', 
                            'ISO2', 'ISO3', 'TLD', 'Emoji', 'EmojiU', 'SMS', 'MCP', 'APIs', 'Video', 
                            'Tours', 'Natural', 'Natural ', 'Local', 'Local ', 'Slug', 'Token', 'Logo', 'Logos',
                            'Banners', 'Spa', 'Jeep', '4x4', 'asia', 'australia', 'kuwait', 'Mini', 'total',
                            'General', 'Regional', 'Star Alliance', 'OneWorld', 'SkyTeam', 'Cultural', 'Capital',
                            'Sector', 'Telegram', 'Snapchat', 'TikTok', 'YouTube', 'Marketing', 'Roles', 'SubD',
                            'LID', 'Camping', 'Premium', 'Romance', 'Avatar', 'Pro',
                            'Hindi', 'Urdu', 'Euro', 'error', 'Individual', 'Push', 'Kuwait', 'asia/kuwait'
                        ];

                        if (!$isException && !in_array($enVal, $parityExceptions)) {
                            $isMissing = true;
                        }
                    }
                }
            }

            if ($isMissing) {
                $missing[$key] = $enVal;
            }
        }
        
        if (!empty($missing)) {
            $missing_for_locale[$file] = $missing;
        }
    }
    $all_missing[$locale] = $missing_for_locale;
}

file_put_contents('missing_ar.json', json_encode($all_missing['ar'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents('missing_es.json', json_encode($all_missing['es'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "=====================================\n";
foreach ($locales as $locale) {
    $count = 0;
    foreach ($all_missing[$locale] as $fileKeys) {
        $count += count($fileKeys);
    }
    echo "Found $count missing/English-value keys in " . strtoupper($locale) . ".\n";
}
echo "Saved to missing_ar.json and missing_es.json\n";
echo "=====================================\n";
