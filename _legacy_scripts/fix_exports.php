<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/Modules');
$iterator = new RecursiveIteratorIterator($dir);
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach ($regex as $file) {
    if (strpos($file[0], 'Livewire') !== false) {
        $content = file_get_contents($file[0]);
        $original = $content;

        // Pattern for PDF
        $patternPdf = '/\$result\s*=\s*\$this->exportSelectedPdfForModel\((.*?)\);\s*\$this->selectedIds\s*=\s*\[\];\s*\$this->selectPage\s*=\s*false;\s*\$this->dispatch\(\'reset-checkout-boxes\'\);\s*return\s*\$result;/s';
        $replacementPdf = 'return $this->exportSelectedPdfForModel($1);';
        
        // Pattern for Excel
        $patternExcel = '/\$result\s*=\s*\$this->exportSelectedExcelForModel\((.*?)\);\s*\$this->selectedIds\s*=\s*\[\];\s*\$this->selectPage\s*=\s*false;\s*\$this->dispatch\(\'reset-checkout-boxes\'\);\s*return\s*\$result;/s';
        $replacementExcel = 'return $this->exportSelectedExcelForModel($1);';

        $content = preg_replace($patternPdf, $replacementPdf, $content);
        $content = preg_replace($patternExcel, $replacementExcel, $content);

        if ($content !== $original) {
            file_put_contents($file[0], $content);
            $count++;
            echo "Fixed: " . $file[0] . "\n";
        }
    }
}

echo "Total files fixed: $count\n";
