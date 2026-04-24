<?php
$files = glob(__DIR__ . '/Modules/*/Resources/views/livewire/*.blade.php', GLOB_BRACE);
$files = array_merge($files, glob(__DIR__ . '/Modules/*/*/Resources/views/livewire/*.blade.php', GLOB_BRACE));
$count = 0;
foreach($files as $file) {
    if (!is_file($file)) continue;
    $content = file_get_contents($file);
    
    // Look for the specific malformed string
    $search = '<div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" <div';
    $replace = '<div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0"';
    
    if(strpos($content, $search) !== false) {
        $replaced = str_replace($search, $replace, $content);
        if($replaced !== $content) {
            file_put_contents($file, $replaced);
            echo "Fixed: " . basename($file) . "\n";
            $count++;
        }
    }
}
echo "Total fixed: " . $count . "\n";
