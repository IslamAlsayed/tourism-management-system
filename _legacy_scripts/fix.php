<?php
$files = glob(__DIR__ . '/Modules/*/Resources/views/livewire/*.blade.php', GLOB_BRACE);
$files = array_merge($files, glob(__DIR__ . '/Modules/*/*/Resources/views/livewire/*.blade.php', GLOB_BRACE));
$count = 0;
foreach($files as $file) {
    if (!is_file($file)) continue;
    $content = file_get_contents($file);
    if(strpos($content, '<div x-cloak x-show="$wire.selectedIds') !== false && strpos($content, '<div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" <div ') !== false) {
        $replaced = str_replace('<div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" <div ', '<div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" ', $content);
        if($replaced !== $content) {
            file_put_contents($file, $replaced);
            echo "Fixed: " . $file . "\n";
            $count++;
        }
    }
}
echo "Total fixed: " . $count . "\n";
