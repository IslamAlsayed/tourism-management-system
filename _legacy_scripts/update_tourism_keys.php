<?php
$keys = ["cultural","family","fixed","government","historical","landmark","museum","natural","park","per_child","per_child_per_day","per_child_per_night","per_day","per_extra_hour_per_child","per_extra_hour_per_group","per_extra_hour_per_person","per_extra_hour_per_vehicle","per_group","per_group_per_day","per_group_per_night","per_km","per_meal","per_night","per_person","per_person_per_day","per_person_per_night","per_trip","per_unit","per_vehicle","private","romance"];

$langs = ["ar","en","es","it","fr","ja","tr","de","ru","he"];

foreach ($langs as $lang) {
    $path = __DIR__ . "/resources/lang/{$lang}/tourism.php";
    $mainPath = __DIR__ . "/resources/lang/{$lang}/main.php";
    
    $tourism = file_exists($path) ? include $path : [];
    $main = file_exists($mainPath) ? include $mainPath : [];
    
    foreach ($keys as $key) {
        if (!isset($tourism[$key])) {
            if (isset($main[$key])) {
                $tourism[$key] = $main[$key];
            } else {
                $tourism[$key] = ucwords(str_replace('_', ' ', $key));
            }
        }
    }
    
    $export = var_export($tourism, true);
    $export = str_replace(array('array (', ')'), array('[', ']'), $export);
    file_put_contents($path, "<?php\n\nreturn " . $export . ";\n");
    echo "Updated $lang\n";
}
echo "Done.";
