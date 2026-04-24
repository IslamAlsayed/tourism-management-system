<?php
$source = 'public/assets/plugins/fontawesome-icons/metadata/icons.json';
if (!file_exists($source)) {
    echo "Source not found.";
    exit;
}

$json = file_get_contents($source);
$icons = json_decode($json, true);
$compact = [];

foreach ($icons as $name => $data) {
    $compact[] = [
        'id' => $name,
        'label' => $data['label'] ?? $name,
        'search' => array_merge([$name], $data['search']['terms'] ?? []),
        'styles' => $data['styles'] ?? []
    ];
}

file_put_contents('storage/app/fa_metadata_compact.json', json_encode($compact));
echo "Compact metadata generated at storage/app/fa_metadata_compact.json (" . count($compact) . " icons)";
