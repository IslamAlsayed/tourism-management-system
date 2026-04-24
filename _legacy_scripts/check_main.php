<?php
$en = require('resources/lang/en/main.php');
$ar = require('resources/lang/ar/main.php');
$missingInAr = array_diff_key($en, $ar);
$missingInEn = array_diff_key($ar, $en);
$engInAr = [];
foreach($ar as $k => $v) {
    if(is_string($v) && preg_match('/^[a-zA-Z\s\-_0-9()\[\]]+$/', $v)) {
        if (!preg_match('/(?:[A-Za-z]+_[A-Za-z]+)+/', $k)) { // exclude machine names
            $engInAr[$k] = $v;
        }
    }
}
echo "Number of missing keys in AR: " . count($missingInAr) . "\n";
echo "Number of missing keys in EN: " . count($missingInEn) . "\n";
echo "Number of English values in AR: " . count($engInAr) . "\n";
echo "\n--- Some English values inside AR ---\n";
print_r(array_slice($engInAr, 0, 15));
