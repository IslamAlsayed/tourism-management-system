<?php

$sourceFile = 'G:\MixJo Top downlode mains by dats\FontAwesome 7.2 Pro\fontawesome-pro-7.2.0-web\metadata\icons.json';
$outputFile = __DIR__ . '/fa-icons-7.2.json';

if (!file_exists($sourceFile)) {
    die("Source file not found: $sourceFile\n");
}

echo "Reading source JSON (34MB+)... This might take a few seconds.\n";
$data = json_decode(file_get_contents($sourceFile), true);

if (!$data) {
    die("Failed to decode JSON. Memory limit might be too low.\n");
}

$compact = [];

foreach ($data as $name => $icon) {
    // We only need the name, search terms, and available styles
    $compact[] = [
        'name'   => $name,
        'label'  => $icon['label'] ?? $name,
        'search' => $icon['search']['terms'] ?? [],
        'styles' => $icon['styles'] ?? [],
        // Unicode for potential CSS/font usage
        'unicode' => $icon['unicode'] ?? '',
    ];
}

echo "Writing compact JSON (" . count($compact) . " icons)...\n";
file_put_contents($outputFile, json_encode($compact));

echo "Done! Output saved to: $outputFile\n";
