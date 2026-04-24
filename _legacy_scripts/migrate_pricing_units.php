<?php

$keys = ["cultural","family","fixed","government","historical","landmark","museum","natural","park","per_child","per_child_per_day","per_child_per_night","per_day","per_extra_hour_per_child","per_extra_hour_per_group","per_extra_hour_per_person","per_extra_hour_per_vehicle","per_group","per_group_per_day","per_group_per_night","per_km","per_meal","per_night","per_person","per_person_per_day","per_person_per_night","per_trip","per_unit","per_vehicle","private","romance","per_pax","per_booking"];

$langs = ["ar","en","es","it","fr","ja","tr","de","ru","he"];

foreach ($langs as $lang) {
    $tourismPath = __DIR__ . "/resources/lang/{$lang}/tourism.php";
    $pricingPath = __DIR__ . "/resources/lang/{$lang}/pricing_units.php";
    
    $tourism = file_exists($tourismPath) ? include $tourismPath : [];
    if (!is_array($tourism)) $tourism = [];
    
    $pricing = file_exists($pricingPath) ? include $pricingPath : [];
    if (!is_array($pricing)) $pricing = [];

    foreach ($keys as $key) {
        // Move from tourism to pricing
        if (isset($tourism[$key])) {
            $pricing[$key] = $tourism[$key];
            unset($tourism[$key]); // Remove from tourism
        } else {
            // Ensure it exists in pricing
            if (!isset($pricing[$key])) {
                $pricing[$key] = ucwords(str_replace('_', ' ', $key));
            }
        }
    }
    
    // Save pricing_units.php
    $exportPricing = var_export($pricing, true);
    $exportPricing = str_replace(array('array (', ')'), array('[', ']'), $exportPricing);
    file_put_contents($pricingPath, "<?php\n\nreturn " . $exportPricing . ";\n");
    
    // Save tourism.php
    $exportTourism = var_export($tourism, true);
    $exportTourism = str_replace(array('array (', ')'), array('[', ']'), $exportTourism);
    file_put_contents($tourismPath, "<?php\n\nreturn " . $exportTourism . ";\n");

    echo "Processed $lang\n";
}
echo "Migration complete.\n";
