<?php
$url = 'https://docs.google.com/spreadsheets/d/1ryRXjeZkXut64ePtnMkvJSVv_RP4HisY/export?format=csv&gid=1666253559';
$csv = file_get_contents($url);

$lines = explode("\n", $csv);
$header = str_getcsv(array_shift($lines));

$targetIds = [18, 65, 111];

echo "Total rows in CSV: " . count($lines) . "\n\n";

foreach ($lines as $lineIndex => $line) {
    if (trim($line) === '') continue;
    $row = str_getcsv($line);
    
    $id = isset($row[0]) ? (int)$row[0] : null;
    
    if (in_array($id, $targetIds)) {
        echo "=== DATA FOR ID $id ===\n";
        foreach ($header as $i => $colName) {
            $val = $row[$i] ?? 'NULL';
            echo "$colName: '$val'\n";
        }
        echo "\n";
    }
}
