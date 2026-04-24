<?php
$json = file_get_contents('public/assets/plugins/fontawesome-icons/metadata/icon-families.json');
$data = json_decode($json, true);
if ($data && isset($data['hotel'])) {
    echo json_encode($data['hotel'], JSON_PRETTY_PRINT);
} else {
    echo "Icon 'hotel' not found or JSON error.";
}
