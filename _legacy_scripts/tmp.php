<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$files = glob(__DIR__ . '/Modules/Restaurants/Resources/views/seasons/*.blade.php');
if(!$files) die("No files found\n");
foreach($files as $f) {
    if(is_file($f)) {
        $c = file_get_contents($f);
        $c = str_replace(
            ['accommodations::', 'dashboard.accommodations', 'accommodations', 'Accommodation', 'accommodations'],
            ['restaurants::', 'dashboard.restaurants', 'restaurants', 'Restaurant', 'restaurants'],
            $c
        );
        file_put_contents($f, $c);
        echo "Updated: " . basename($f) . "\n";
    }
}
echo "Done.\n";
