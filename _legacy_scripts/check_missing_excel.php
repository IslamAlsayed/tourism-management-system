<?php
$url = 'https://docs.google.com/spreadsheets/d/1ryRXjeZkXut64ePtnMkvJSVv_RP4HisY/export?format=csv&gid=1666253559';
$csv = file_get_contents($url);

if (!$csv) {
    die("Failed to download CSV\n");
}

$lines = explode("\n", $csv);
$header = str_getcsv(array_shift($lines));

$idIndex = array_search('id', $header);
$nameIndex = array_search('name', $header);
$nameArIndex = array_search('name_ar', $header);

$targetIds = [18, 65, 111, 251];
$found = [];

foreach ($lines as $lineIndex => $line) {
    if (trim($line) === '') continue;
    $row = str_getcsv($line);
    
    // Some lines might not have an ID properly
    $id = isset($row[$idIndex]) ? (int)$row[$idIndex] : null;
    $name = $row[$nameIndex] ?? 'UNKNOWN';
    $nameAr = $row[$nameArIndex] ?? 'UNKNOWN';
    
    if (in_array($id, $targetIds)) {
        $found[] = [
            'id' => $id,
            'name' => $name,
            'name_ar' => $nameAr,
            'row_index' => $lineIndex + 2 // +2 because 1 for header, 1 for 0-based array index
        ];
    }
}

echo "Found Target Missing Countries in Excel:\n\n";
foreach ($found as $f) {
    echo "ID: {$f['id']} | Row in Excel: {$f['row_index']}\n";
    echo "Name: {$f['name']}\n";
    echo "Name (AR): {$f['name_ar']}\n";
    echo "--------------------------\n";
}
