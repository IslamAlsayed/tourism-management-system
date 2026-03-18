<?php

function checkDivs($filePath) {
    $content = file_get_contents($filePath);
    $cardContentPos = strpos($content, 'class="kt-card-content px-2"');
    if ($cardContentPos === false) return;
    
    // get string from there to the table
    $tablePos = strpos($content, 'data-kt-datatable-state-save', $cardContentPos);
    if ($tablePos === false) return;
    
    $block = substr($content, $cardContentPos, $tablePos - $cardContentPos);
    $opened = substr_count($block, '<div') - substr_count($block, '</div>');
    echo basename($filePath) . " -> Unclosed divs before table: " . $opened . "\n";
}

$modulesDir = __DIR__ . '/Modules';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($modulesDir));
$regex = new RegexIterator($iterator, '/^.+\/Resources\/views\/livewire\/.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $file) {
    checkDivs($file[0]);
}

