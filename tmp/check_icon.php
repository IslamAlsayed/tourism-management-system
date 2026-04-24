<?php
$json = file_get_contents('public/assets/plugins/fontawesome-icons/metadata/icons.json');
$data = json_decode($json, true);
$hotel = $data['hotel'] ?? null;
if ($hotel) {
    unset($hotel['svg']); // Too large
    echo json_encode($hotel, JSON_PRETTY_PRINT);
} else {
    echo "Icon 'hotel' not found.";
}
