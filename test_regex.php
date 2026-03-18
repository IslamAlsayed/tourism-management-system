<?php
$content = file_get_contents(__DIR__ . '/Modules/Geography/Resources/views/livewire/regions.blade.php');
$startPos = strpos($content, "{{ __('main.cancel_selection') }}");
if ($startPos !== false) {
    $endPos = strpos($content, "data-kt-datatable-state-save", $startPos);
    $subset = substr($content, $startPos, $endPos - $startPos);
    echo "--- REGIONS ---\n";
    echo $subset;
    echo "\n---------------\n";
}

$content = file_get_contents(__DIR__ . '/Modules/Geography/Resources/views/livewire/countries.blade.php');
$startPos = strpos($content, "{{ __('main.cancel_selection') }}");
if ($startPos !== false) {
    $endPos = strpos($content, "data-kt-datatable-state-save", $startPos);
    $subset = substr($content, $startPos, $endPos - $startPos);
    echo "--- COUNTRIES ---\n";
    echo $subset;
    echo "\n---------------\n";
}
