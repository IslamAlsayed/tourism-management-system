<?php
$config = config('sidebar');
$en = app('translator')->getLoader()->load('en', 'sidebar', '*');
$ar = app('translator')->getLoader()->load('ar', 'sidebar', '*');

$missingEn = [];
$missingAr = [];

function checkMissing($array, &$missingEn, &$missingAr, $en, $ar) {
    if (!is_array($array)) return;
    foreach ($array as $item) {
        if (isset($item['title'])) {
            $t = $item['title'];
            if (!isset($en[$t])) $missingEn[] = $t;
            if (!isset($ar[$t])) $missingAr[] = $t;
        }
        if (isset($item['children'])) {
            checkMissing($item['children'], $missingEn, $missingAr, $en, $ar);
        }
    }
}

checkMissing($config, $missingEn, $missingAr, $en, $ar);

echo "==== Missing in EN (sidebar translation file) ====\n" . implode("\n", array_unique($missingEn)) . "\n\n";
echo "==== Missing in AR (sidebar translation file) ====\n" . implode("\n", array_unique($missingAr)) . "\n";
