<?php

$directories = [
    __DIR__ . '/resources/views',
    __DIR__ . '/Modules',
];

$enPath = __DIR__ . '/resources/lang/en/main.php';
$enData = include $enPath;

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

$enFlat = flattenArray($enData);
$enValues = array_map('strtolower', array_values($enFlat));
$enKeysByValue = [];
foreach ($enFlat as $k => $v) {
    $enKeysByValue[strtolower(trim($v))] = $k;
}

$hardcoded = [];
$missingKeysInEn = [];

function scanFile($filePath, &$hardcoded, &$missingKeysInEn, $enKeysByValue) {
    $content = file_get_contents($filePath);
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);

    if ($extension === 'blade.php') {
        // 1. Find text inside {{ "..." }} or {{ '...' }}
        preg_match_all('/{{\s*["\']([^"\']+)["\']\s*}}/', $content, $matches);
        foreach ($matches[1] as $match) {
            if (!empty(trim($match)) && !str_contains($match, '$')) {
                $val = trim($match);
                if (!isset($enKeysByValue[strtolower($val)])) {
                    $hardcoded[$filePath][] = [
                        'type' => 'interpolation',
                        'text' => $val,
                        'line' => substr_count(substr($content, 0, strpos($content, $match)), "\n") + 1
                    ];
                }
            }
        }

        // 2. Find text inside tags (simple check)
        // This is tricky because it might match HTML structure.
        // We look for patterns like >Some Text< but exclude script/style
        $cleanContent = preg_replace('/<(script|style|svg).*?>.*?<\/\1>/is', '', $content);
        preg_match_all('/>\s*([A-Z][^<>{}\n\r]+?)\s*</', $cleanContent, $matches);
        foreach ($matches[1] as $match) {
            $val = trim($match);
            if (strlen($val) > 2 && !isset($enKeysByValue[strtolower($val)])) {
                // Ignore strings that are likely PHP variables or pure numbers
                if (preg_match('/^[0-9\s.,\/]+$/', $val)) continue;
                if (str_contains($val, '{{')) continue;

                $hardcoded[$filePath][] = [
                    'type' => 'tag_content',
                    'text' => $val,
                    'line' => substr_count(substr($content, 0, strpos($content, $match)), "\n") + 1
                ];
            }
        }

        // 3. Find placeholders and titles
        preg_match_all('/(placeholder|title|value)=["\']([^"\']+)["\']/', $content, $matches);
        foreach ($matches[2] as $index => $match) {
            $attr = $matches[1][$index];
            $val = trim($match);
            if (strlen($val) > 2 && !isset($enKeysByValue[strtolower($val)]) && !str_contains($val, '{{') && !str_contains($val, '$')) {
                $hardcoded[$filePath][] = [
                    'type' => 'attribute_' . $attr,
                    'text' => $val,
                    'line' => substr_count(substr($content, 0, strpos($content, $match)), "\n") + 1
                ];
            }
        }

        // 4. Find keys that ARE wrapped in __() but missing from en/main.php
        preg_match_all('/__\([\'"]main\.([^\'"]+)[\'"]\)/', $content, $matches);
        global $enFlat;
        foreach ($matches[1] as $key) {
            if (!isset($enFlat[$key])) {
                $missingKeysInEn[$filePath][] = $key;
            }
        }
    }
}

foreach ($directories as $dir) {
    if (!is_dir($dir)) continue;
    $it = new RecursiveDirectoryIterator($dir);
    foreach (new RecursiveIteratorIterator($it) as $file) {
        if ($file->isDir()) continue;
        if (str_contains($file->getPathname(), 'node_modules')) continue;
        if (str_contains($file->getPathname(), 'vendor')) continue;
        
        scanFile($file->getPathname(), $hardcoded, $missingKeysInEn, $enKeysByValue);
    }
}

echo "SCAN REPORT\n";
echo "===========\n\n";

echo "1. MISSING KEYS IN en/main.php (Wrapped in __() but no entry in file)\n";
$totalMissing = 0;
foreach ($missingKeysInEn as $file => $keys) {
    $keys = array_unique($keys);
    echo "File: $file\n";
    foreach ($keys as $key) {
        echo "  - main.$key\n";
        $totalMissing++;
    }
}
echo "Total Missing Keys: $totalMissing\n\n";

echo "2. HARDCODED STRINGS (Not wrapped in __() and not found as values in en/main.php)\n";
$totalHardcoded = 0;
foreach ($hardcoded as $file => $items) {
    echo "File: $file\n";
    $seen = [];
    foreach ($items as $item) {
        $key = $item['text'];
        if (isset($seen[$key])) continue;
        echo "  - [{$item['type']}] \"{$item['text']}\" (approx line {$item['line']})\n";
        $seen[$key] = true;
        $totalHardcoded++;
    }
}
echo "Total Hardcoded Strings: $totalHardcoded\n";

file_put_contents('scan_results.json', json_encode([
    'missing_in_en' => $missingKeysInEn,
    'hardcoded' => $hardcoded
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
