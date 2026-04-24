<?php
$files = glob(__DIR__ . '/Modules/*/Resources/views/livewire/*.blade.php', GLOB_BRACE);
$files = array_merge($files, glob(__DIR__ . '/Modules/*/*/Resources/views/livewire/*.blade.php', GLOB_BRACE));

$count = 0;
foreach($files as $file) {
    if (!is_file($file)) continue;
    $content = file_get_contents($file);
    if(strpos($content, 'Bulk Action Buttons') !== false && strpos($content, '@if (!empty($selectedIds)') !== false) {
        
        $replaced = $content;

        // 1. Replace @if open
        $replaced = preg_replace(
            '/@if\s*\(\!empty\(\$selectedIds\)\s*&&\s*count\(\$selectedIds\)\s*>\s*0\)\s*(<div[^>]*?>)/s',
            '<div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" $1',
            $replaced
        );

        // 2. Replace count display
        $replaced = preg_replace(
            '/(<span[^>]*?>)\s*\{\{\s*count\(\$selectedIds\)\s*\}\}\s*(<\/span>)/s',
            '<span class="badge badge-primary" x-text="$wire.selectedIds.length"></span>',
            $replaced
        );

        // 3. Replace clearSelected and @endif
        $replaced = preg_replace_callback(
            '/(<button[^>]*?wire:click(?:\.prevent)?="clearSelected"[^>]*?>.*?<\/button>.*?)\s*@endif/s',
            function($matches) {
                $button = str_replace(['wire:click="clearSelected"', 'wire:click.prevent="clearSelected"'], '@click.prevent="$wire.selectedIds = []"', $matches[1]);
                return $button . "\n        </div>\n"; // Replace @endif with closing div (matching the open div) Wait! If there are nested divs, replacing @endif with </div> isn't foolproof, but let's assume one extra wrapper. Actually, we replaced @if(...) <div... with <div... <div..., so we just need one extra </div>. Or wait... we replaced `@if` and the FIRST `<div...` with `<div x-show...> <div...`. So yes, we need one extra `</div>` at the end substituting `@endif`.
            },
            $replaced
        );

        if($replaced !== $content) {
            file_put_contents($file, $replaced);
            echo "Updated: " . $file . "\n";
            $count++;
        }
    }
}
echo "Total updated: " . $count . "\n";
