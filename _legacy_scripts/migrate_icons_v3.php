<?php
/**
 * Final Keenicon→FA Pro 7 migration (V3)
 * Targets ALL remaining ki-filled, ki-duotone, ki-outline, ki-solid patterns
 */

$projectRoot = __DIR__;
$dirs = [
    $projectRoot . '/resources/views',
    $projectRoot . '/Modules',
];

// Comprehensive mapping: keenicon-name => fa-icon-name
$iconMap = [
    // Communication
    'ki-sms' => 'fa-envelope',
    'ki-message-notify' => 'fa-bell',
    'ki-message-programming' => 'fa-terminal',
    'ki-phone' => 'fa-phone',
    'ki-whatsapp' => 'fa-comment-dots',
    
    // Users & People
    'ki-people' => 'fa-users',
    'ki-user' => 'fa-user',
    'ki-user-edit' => 'fa-user-pen',
    'ki-user-tick' => 'fa-user-check',
    'ki-profile-user' => 'fa-id-card',
    
    // Actions & UI
    'ki-eye' => 'fa-eye',
    'ki-pencil' => 'fa-pen',
    'ki-trash' => 'fa-trash',
    'ki-camera' => 'fa-camera',
    'ki-copy' => 'fa-copy',
    'ki-copied' => 'fa-clipboard-check',
    'ki-printer' => 'fa-print',
    'ki-check-circle' => 'fa-circle-check',
    'ki-double-check' => 'fa-check-double',
    'ki-verify' => 'fa-badge-check',
    'ki-exit-up' => 'fa-arrow-up-from-bracket',
    'ki-handcart' => 'fa-cart-shopping',
    'ki-minus' => 'fa-minus',
    'ki-setting' => 'fa-gear',
    'ki-setting-3' => 'fa-sliders',
    'ki-gear' => 'fa-gear',
    'ki-share' => 'fa-share-nodes',
    'ki-size' => 'fa-expand',
    'ki-subtitle' => 'fa-closed-captioning',
    'ki-badge' => 'fa-id-badge',
    'ki-cheque' => 'fa-money-check',
    'ki-briefcase' => 'fa-briefcase',
    'ki-rocket' => 'fa-rocket',
    'ki-design' => 'fa-palette',
    'ki-design-1' => 'fa-swatchbook',
    
    // Security
    'ki-shield-search' => 'fa-shield-halved',
    'ki-shield-cross' => 'fa-shield-xmark',
    'ki-filter-edit' => 'fa-filter',
    
    // Arrows
    'ki-arrow-left' => 'fa-arrow-left',
    'ki-arrow-right' => 'fa-arrow-right',
    'ki-down' => 'fa-chevron-down',
    'ki-up' => 'fa-chevron-up',
    
    // Abstract/Layout
    'ki-abstract-35' => 'fa-shapes',
    'ki-abstract-13' => 'fa-cube',
    'ki-abstract-11' => 'fa-cubes',
    'ki-layout' => 'fa-table-columns',
    'ki-cloud-change' => 'fa-cloud-arrow-up',
    
    // Navigation
    'ki-arrow-up' => 'fa-arrow-up',
    'ki-arrow-down' => 'fa-arrow-down',
];

$totalFiles = 0;
$totalReplacements = 0;

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'php') continue;
        
        $content = file_get_contents($file->getPathname());
        $original = $content;
        $fileReplacements = 0;
        
        // Replace ki-filled ki-{name} → fa-duotone fa-solid fa-{name}
        foreach ($iconMap as $kiName => $faName) {
            $pattern = '/ki-filled\s+' . preg_quote($kiName, '/') . '/';
            $replacement = 'fa-duotone fa-solid ' . $faName;
            $count = 0;
            $content = preg_replace($pattern, $replacement, $content, -1, $count);
            $fileReplacements += $count;
        }
        
        // Replace ki-duotone ki-{name} → fa-duotone fa-solid fa-{name}
        foreach ($iconMap as $kiName => $faName) {
            $pattern = '/ki-duotone\s+' . preg_quote($kiName, '/') . '/';
            $replacement = 'fa-duotone fa-solid ' . $faName;
            $count = 0;
            $content = preg_replace($pattern, $replacement, $content, -1, $count);
            $fileReplacements += $count;
        }
        
        // Replace ki-outline ki-{name} → fa-duotone fa-solid fa-{name}
        foreach ($iconMap as $kiName => $faName) {
            $pattern = '/ki-outline\s+' . preg_quote($kiName, '/') . '/';
            $replacement = 'fa-duotone fa-solid ' . $faName;
            $count = 0;
            $content = preg_replace($pattern, $replacement, $content, -1, $count);
            $fileReplacements += $count;
        }
        
        // Replace ki-solid ki-{name} → fa-solid fa-{name}
        foreach ($iconMap as $kiName => $faName) {
            $pattern = '/ki-solid\s+' . preg_quote($kiName, '/') . '/';
            $replacement = 'fa-solid ' . $faName;
            $count = 0;
            $content = preg_replace($pattern, $replacement, $content, -1, $count);
            $fileReplacements += $count;
        }
        
        // Remove <span class="path1"></span><span class="path2"></span> etc.
        $content = preg_replace('/<span\s+class="path\d+"><\/span>/', '', $content, -1, $count);
        $fileReplacements += $count;
        
        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            $totalFiles++;
            $totalReplacements += $fileReplacements;
            $shortPath = str_replace($projectRoot . '/', '', $file->getPathname());
            $shortPath = str_replace($projectRoot . '\\', '', $shortPath);
            echo "✅ [{$fileReplacements}] {$shortPath}\n";
        }
    }
}

echo "\n🎉 Done! {$totalFiles} files updated, {$totalReplacements} replacements.\n";
