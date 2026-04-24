<?php
/**
 * Final Migration V4 - Catches ALL remaining Keenicon patterns
 */

$projectRoot = __DIR__;
$dirs = [$projectRoot . '/resources/views', $projectRoot . '/Modules'];

$iconMap = [
    // Missing from V3
    'ki-abstract-26' => 'fa-shapes',
    'ki-abstract-46' => 'fa-circle-nodes',
    'ki-abstract-14' => 'fa-grip',
    'ki-abstract-28' => 'fa-chart-pie',
    'ki-element-11' => 'fa-grid-2',
    'ki-element-4' => 'fa-table-cells',
    'ki-element-equal' => 'fa-equals',
    'ki-row-horizontal' => 'fa-bars',
    'ki-category' => 'fa-layer-group',
    'ki-search-list' => 'fa-magnifying-glass-chart',
    'ki-sun' => 'fa-sun',
    'ki-moon' => 'fa-moon',
    'ki-information-5' => 'fa-circle-info',
    'ki-information' => 'fa-circle-info',
    'ki-paper-clip' => 'fa-paperclip',
    'ki-black-left-line' => 'fa-angles-left',
    'ki-entrance-left' => 'fa-right-from-bracket',
    'ki-route' => 'fa-route',
    'ki-text-align-center' => 'fa-align-center',
    'ki-flag' => 'fa-flag',
    'ki-dollar' => 'fa-dollar-sign',
    'ki-time' => 'fa-clock',
    'ki-loading' => 'fa-spinner',
    'ki-cloud' => 'fa-cloud',
    'ki-data' => 'fa-database',
    'ki-bookmark' => 'fa-bookmark',
    'ki-screen' => 'fa-desktop',
    'ki-eraser' => 'fa-eraser',
    'ki-folder' => 'fa-folder',
    'ki-exit-down' => 'fa-arrow-down-from-line',
    
    // Auth pages
    'ki-eye-slash' => 'fa-eye-slash',
    'ki-cross' => 'fa-xmark',
    'ki-lock' => 'fa-lock',
    'ki-key' => 'fa-key',
    'ki-security-user' => 'fa-shield-halved',
    'ki-shield' => 'fa-shield',
    'ki-shield-tick' => 'fa-shield-check',
    
    // Profile pages
    'ki-notification' => 'fa-bell',
    'ki-notification-on' => 'fa-bell',
    'ki-notification-bing' => 'fa-bell',
    'ki-toggle-on' => 'fa-toggle-on',
    'ki-toggle-off' => 'fa-toggle-off',
    'ki-map' => 'fa-map',
    'ki-geolocation' => 'fa-location-dot',
    'ki-calendar' => 'fa-calendar',
    'ki-calendar-8' => 'fa-calendar-day',
    
    // Misc
    'ki-questionnaire-tablet' => 'fa-clipboard-list',
    'ki-chart-simple' => 'fa-chart-simple',
    'ki-chart-line' => 'fa-chart-line',
    'ki-graph-up' => 'fa-chart-line-up',
    'ki-document' => 'fa-file',
    'ki-file-added' => 'fa-file-circle-plus',
    'ki-file' => 'fa-file',
    'ki-note-2' => 'fa-note-sticky',
    'ki-electricity' => 'fa-bolt',
    'ki-archive' => 'fa-box-archive',
    'ki-delivery' => 'fa-truck',
    'ki-home' => 'fa-house',
    'ki-home-2' => 'fa-house',
    'ki-address-book' => 'fa-address-book',
    'ki-bank' => 'fa-building-columns',
    'ki-like' => 'fa-thumbs-up',
    'ki-dislike' => 'fa-thumbs-down',
    'ki-star' => 'fa-star',
    'ki-heart' => 'fa-heart',
    'ki-pin' => 'fa-thumbtack',
    'ki-attach' => 'fa-paperclip',
    'ki-send' => 'fa-paper-plane',
    'ki-wrench' => 'fa-wrench',
    'ki-code' => 'fa-code',
    'ki-burger-menu' => 'fa-bars',
    'ki-burger-menu-2' => 'fa-bars',
    'ki-dots-vertical' => 'fa-ellipsis-vertical',
    'ki-dots-horizontal' => 'fa-ellipsis',
    'ki-more-2' => 'fa-ellipsis',
    'ki-magnifier' => 'fa-magnifying-glass',
    'ki-search-normal' => 'fa-magnifying-glass',
    'ki-plus' => 'fa-plus',
    'ki-close' => 'fa-xmark',
    'ki-check' => 'fa-check',
    'ki-sort' => 'fa-sort',
    'ki-link' => 'fa-link',
    'ki-disconnect' => 'fa-link-slash',
    'ki-maximize' => 'fa-maximize',
    'ki-minimize' => 'fa-minimize',
    'ki-refresh' => 'fa-arrows-rotate',
    'ki-update-folder' => 'fa-folder-arrow-up',
    'ki-download' => 'fa-download',
    'ki-upload' => 'fa-upload',
    'ki-save' => 'fa-floppy-disk',
    'ki-save-2' => 'fa-floppy-disk',
    'ki-undo' => 'fa-rotate-left',
    'ki-redo' => 'fa-rotate-right',
    'ki-image' => 'fa-image',
    'ki-picture' => 'fa-image',
    'ki-gallery' => 'fa-images',
    'ki-video' => 'fa-video',
    'ki-music' => 'fa-music',
    'ki-headphone' => 'fa-headphones',
    'ki-wifi' => 'fa-wifi',
    'ki-bluetooth' => 'fa-bluetooth',
    'ki-battery' => 'fa-battery-full',
    'ki-signal' => 'fa-signal',
    'ki-location' => 'fa-location-dot',
    'ki-compass' => 'fa-compass',
    'ki-globe' => 'fa-globe',
    'ki-world' => 'fa-earth-americas',
    'ki-language' => 'fa-language',
    'ki-translate' => 'fa-language',
    'ki-theme' => 'fa-palette',
    'ki-dark-mode' => 'fa-circle-half-stroke',
    'ki-tag' => 'fa-tag',
    'ki-tags' => 'fa-tags',
    'ki-gift' => 'fa-gift',
    'ki-message' => 'fa-message',
    'ki-chat' => 'fa-comments',
    'ki-call' => 'fa-phone',
    'ki-email' => 'fa-envelope',
    'ki-inbox' => 'fa-inbox',
    'ki-bell' => 'fa-bell',
    'ki-alarm' => 'fa-alarm-clock',
    'ki-stopwatch' => 'fa-stopwatch',
    'ki-timer' => 'fa-hourglass-half',
    'ki-history' => 'fa-clock-rotate-left',
    'ki-danger' => 'fa-triangle-exclamation',
    'ki-warning' => 'fa-triangle-exclamation',
    'ki-error' => 'fa-circle-exclamation',
    'ki-info' => 'fa-circle-info',
    'ki-question' => 'fa-circle-question',
    'ki-help' => 'fa-circle-question',
    'ki-success' => 'fa-circle-check',
    'ki-done' => 'fa-circle-check',
    'ki-ban' => 'fa-ban',
    'ki-power' => 'fa-power-off',
    'ki-logout' => 'fa-right-from-bracket',
    'ki-login' => 'fa-right-to-bracket',
    'ki-basket' => 'fa-basket-shopping',
    'ki-cart' => 'fa-cart-shopping',
    'ki-wallet' => 'fa-wallet',
    'ki-credit-card' => 'fa-credit-card',
    'ki-medal' => 'fa-medal',
    'ki-trophy' => 'fa-trophy',
    'ki-crown' => 'fa-crown',
    'ki-diamond' => 'fa-gem',
    'ki-fire' => 'fa-fire',
    'ki-flash' => 'fa-bolt',
    'ki-target' => 'fa-bullseye',
    'ki-puzzle' => 'fa-puzzle-piece',
    'ki-layers' => 'fa-layer-group',
    'ki-stack' => 'fa-layer-group',
    'ki-clipboard' => 'fa-clipboard',
    'ki-notepad' => 'fa-note-sticky',
    'ki-book' => 'fa-book',
    'ki-education' => 'fa-graduation-cap',
    'ki-teacher' => 'fa-chalkboard-user',
    'ki-car' => 'fa-car',
    'ki-airplane' => 'fa-plane',
    'ki-bus' => 'fa-bus',
    'ki-train' => 'fa-train',
    'ki-ship' => 'fa-ship',
    'ki-bicycle' => 'fa-bicycle',
    'ki-hospital' => 'fa-hospital',
    'ki-thermometer' => 'fa-thermometer-half',
    'ki-pill' => 'fa-pills',
    'ki-stethoscope' => 'fa-stethoscope',
    'ki-paw' => 'fa-paw',
    'ki-tree' => 'fa-tree',
    'ki-flower' => 'fa-seedling',
    'ki-sun-fog' => 'fa-sun',
    'ki-cloud-sun' => 'fa-cloud-sun',
    'ki-rain' => 'fa-cloud-rain',
    'ki-snow' => 'fa-snowflake',
    'ki-wind' => 'fa-wind',
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
        
        foreach (['ki-filled', 'ki-duotone', 'ki-outline'] as $prefix) {
            foreach ($iconMap as $kiName => $faName) {
                $pattern = '/' . preg_quote($prefix, '/') . '\s+' . preg_quote($kiName, '/') . '/';
                $replacement = 'fa-duotone fa-solid ' . $faName;
                $count = 0;
                $content = preg_replace($pattern, $replacement, $content, -1, $count);
                $fileReplacements += $count;
            }
        }
        
        foreach ($iconMap as $kiName => $faName) {
            $pattern = '/ki-solid\s+' . preg_quote($kiName, '/') . '/';
            $replacement = 'fa-solid ' . $faName;
            $count = 0;
            $content = preg_replace($pattern, $replacement, $content, -1, $count);
            $fileReplacements += $count;
        }
        
        $content = preg_replace('/<span\s+class="path\d+"><\/span>/', '', $content, -1, $count);
        $fileReplacements += $count;
        
        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            $totalFiles++;
            $totalReplacements += $fileReplacements;
            $shortPath = str_replace([$projectRoot . '/', $projectRoot . '\\'], '', $file->getPathname());
            echo "✅ [{$fileReplacements}] {$shortPath}\n";
        }
    }
}

echo "\n🎉 Done! {$totalFiles} files, {$totalReplacements} replacements.\n";
