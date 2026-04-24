<?php
$files = glob('Modules/*/Resources/views/livewire/*.blade.php');
$count = 0;
foreach($files as $file) {
    if (!is_file($file)) continue;
    $content = file_get_contents($file);
    $new = preg_replace('/<div class="kt-scrollable-x-auto">\s*(@component\(\'components\.data-table\'.*?@endcomponent)\s*<\/div>/s', '$1', $content);
    if ($new !== $content) {
        file_put_contents($file, $new);
        echo "Fixed: $file\n";
        $count++;
    }
}
echo "Total fixed: $count\n";
