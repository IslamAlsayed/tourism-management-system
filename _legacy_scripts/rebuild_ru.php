<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$ts = new Modules\TranslationManager\Services\TranslationService();
$enFlat = $ts->getFlattenedTranslations('en', 'main');

// We will read the RU file as text because loading it might have multidimensional array issues.
// But wait, if we read it as text it's hard. Let's just use Google Translate for what's actually missing,
// and for what's already translated, we just extract it from the actual ru/main.php flattened manually?
// No, the flattened array from ru also has '0' keys if it was parsed wrong.
$ruOldFlat = $ts->getFlattenedTranslations('ru', 'main');

$newRuFlat = [];
foreach ($enFlat as $k => $v) {
    // If ruOldFlat has the key exactly, use it.
    if (isset($ruOldFlat[$k]) && $ruOldFlat[$k] !== '' && $ruOldFlat[$k] !== null) {
        $newRuFlat[$k] = $ruOldFlat[$k];
    } else {
        // Look for the broken zero-indexed key caused by the bug, e.g., 'sidebar.0.Ai-Agent'
        $parts = explode('.', $k);
        if (count($parts) > 1) {
            $brokenKey = $parts[0] . '.0.' . implode('.', array_slice($parts, 1));
            if (isset($ruOldFlat[$brokenKey]) && $ruOldFlat[$brokenKey] !== '' && $ruOldFlat[$brokenKey] !== null) {
                $newRuFlat[$k] = $ruOldFlat[$brokenKey];
            } else {
                $newRuFlat[$k] = $v; // Keep English as fallback
            }
        } else {
            $newRuFlat[$k] = $v;
        }
    }
}

// Rebuild the multidimensional array safely
$rebuiltArray = [];
foreach ($newRuFlat as $k => $v) {
    \Illuminate\Support\Arr::set($rebuiltArray, $k, $v);
}

$ts->writeTranslationFile(resource_path("lang/ru/main.php"), $rebuiltArray);
echo "Rebuilt ru/main.php correctly!\n";
