<?php
// Check the ACTUAL bytes of the Arabic file
$filePath = __DIR__ . '/resources/lang/ar/main.php';
$content = file_get_contents($filePath);

// Get the first "dashboard" value
preg_match("/'dashboard'\s*=>\s*'([^']+)'/", $content, $match);
$dashboardValue = $match[1] ?? 'NOT FOUND';

// Show the hex bytes of the value
echo "Dashboard value raw bytes:\n";
echo "String: " . $dashboardValue . "\n";
echo "Hex: ";
for ($i = 0; $i < min(strlen($dashboardValue), 50); $i++) {
    echo sprintf('%02X ', ord($dashboardValue[$i]));
}
echo "\n\n";

// Check: Is this proper UTF-8 Arabic?
// Arabic 'ل' in UTF-8 = D9 84
// If we see C3 99 C2 84 that means double-encoded
$hex = bin2hex(substr($dashboardValue, 0, 4));
echo "First 4 bytes hex: $hex\n";

if (substr($hex, 0, 2) === 'c3' || substr($hex, 0, 2) === 'c2') {
    echo "DIAGNOSIS: File is DOUBLE-ENCODED UTF-8!\n";
    echo "The Arabic UTF-8 bytes were treated as Latin-1 and re-encoded to UTF-8.\n";
    echo "Fix: Need to convert from UTF-8 to Latin-1 (which reverses the double encoding)\n";
} elseif (substr($hex, 0, 2) === 'd9' || substr($hex, 0, 2) === 'd8') {
    echo "DIAGNOSIS: File is PROPERLY encoded UTF-8 Arabic!\n";
    echo "The display issue is in the terminal/viewer, not in the file.\n";
} else {
    echo "DIAGNOSIS: Unknown encoding, first bytes: $hex\n";
}

// Also test if including the file works
$data = include($filePath);
$dashVal = $data['dashboard'] ?? 'NOT FOUND';
echo "\nIncluded value hex: ";
for ($i = 0; $i < min(strlen($dashVal), 20); $i++) {
    echo sprintf('%02X ', ord($dashVal[$i]));
}
echo "\n";

// Check: is it actual Arabic UTF-8?
if (preg_match('/[\xd8-\xdb][\x80-\xbf]/', $dashVal)) {
    echo "Result: Contains valid UTF-8 Arabic characters\n";
} else {
    echo "Result: Does NOT contain valid UTF-8 Arabic\n";
    echo "Likely double-encoded. Characters found: ";
    for ($i = 0; $i < min(strlen($dashVal), 10); $i++) {
        echo sprintf('\\x%02X', ord($dashVal[$i]));
    }
    echo "\n";
}
