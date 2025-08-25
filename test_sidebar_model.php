<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

try {
    $result = App\Models\SidebarMenuOrder::getOrderedMenu();
    echo "Success! Method works. Found " . $result->count() . " items\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
