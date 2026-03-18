<?php
$lineAr = "    'column_filters' => 'الفلاتر',\n";
$lineEn = "    'column_filters' => 'Column Search',\n";

function insertLine($file, $line) {
    if (!file_exists($file)) return "Error: $file not found";
    $contents = file_get_contents($file);
    if (strpos($contents, "'column_filters'") !== false) return "Already exists in $file";
    
    // Insert before the last closing bracket that usually marks the end of the array
    $pos = strrpos($contents, '];');
    if ($pos !== false) {
        $contents = substr_replace($contents, $line, $pos, 0);
        file_put_contents($file, $contents);
        return "Added to $file";
    }
    return "Failed to find closing tag in $file";
}

echo insertLine(__DIR__ . '/resources/lang/ar/main.php', $lineAr) . "\n";
echo insertLine(__DIR__ . '/resources/lang/en/main.php', $lineEn) . "\n";
