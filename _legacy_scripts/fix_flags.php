<?php
$file = 'resources/views/components/static-columns.blade.php';
if (!file_exists($file)) die("File not found");

$content = file_get_contents($file);

// 1. Fix broken "style" attributes that absorbed class names
// e.g. class="rounded-full w-6 h-6" style="width: 24px; height: 24px; min-width: 24px; shrink-0"
$patterns = [
    // This removes the broken style entirely so we can re-add it cleanly
    '/w-6 h-6" style="width: 24px; height: 24px; min-width: 24px; (shrink-0)"/',
    '/w-6 h-6" style="width: 24px; height: 24px; min-width: 24px; (shrink-0.+?)"/',
    '/w-7 h-7" style="width: 28px; height: 28px; min-width: 28px; (shrink-0.+?)"/'
];
$replacements = [
    'w-6 h-6 $1"',
    'w-6 h-6 $1"',
    'w-7 h-7 $1"'
];
$content = preg_replace($patterns, $replacements, $content);

// 2. Add clean styles after any class that contains w-6/h-6 or w-7/h-7
// We match class="..." and append style="..."
$content = preg_replace('/class="([^"]*?w-6 h-6[^"]*?)"/', 'class="$1" style="width: 24px; height: 24px; min-width: 24px;"', $content);
$content = preg_replace('/class="([^"]*?w-7 h-7[^"]*?)"/', 'class="$1" style="width: 28px; height: 28px; min-width: 28px;"', $content);

// 3. Fix the standalone h-[16px] emoji SVG
// Replace style="height: 16px; width: auto;" with proper dimensions
$content = str_replace('style="height: 16px; width: auto;"', 'style="height: 16px; width: 24px; object-fit: contain;"', $content);

file_put_contents($file, $content);
echo "Cleaned up HTML attributes across static-columns.blade.php";
