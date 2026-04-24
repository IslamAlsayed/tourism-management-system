<?php
/**
 * Bulk migration v2: ALL remaining Keenicons → Font Awesome Pro 7
 */

$basePath = __DIR__;

$replacements = [
    // Arrows & navigation
    'ki-filled ki-down'            => 'fa-solid fa-chevron-down',
    'ki-filled ki-up'              => 'fa-solid fa-chevron-up',
    'ki-filled ki-left'            => 'fa-solid fa-chevron-left',
    'ki-filled ki-right'           => 'fa-solid fa-chevron-right',
    'ki-outline ki-down'           => 'fa-solid fa-chevron-down',
    'ki-outline ki-up'             => 'fa-solid fa-chevron-up',

    // Users & people
    'ki-filled ki-users'           => 'fa-duotone fa-solid fa-users',
    'ki-outline ki-users'          => 'fa-duotone fa-solid fa-users',
    'ki-outline ki-profile-2user'  => 'fa-duotone fa-solid fa-user-group',

    // UI elements
    'ki-filled ki-element-11'      => 'fa-duotone fa-solid fa-grid-2',
    'ki-filled ki-element-4'       => 'fa-duotone fa-solid fa-table-cells',
    'ki-outline ki-element-3'      => 'fa-duotone fa-solid fa-table-cells-large',
    'ki-filled ki-burger-menu'     => 'fa-duotone fa-solid fa-grip-lines',
    'ki-outline ki-burger-menu'    => 'fa-duotone fa-solid fa-grip-lines',

    // Finance & currency
    'ki-filled ki-dollar'          => 'fa-duotone fa-solid fa-dollar-sign',
    'ki-outline ki-dollar'         => 'fa-duotone fa-solid fa-dollar-sign',
    'ki-filled ki-bill'            => 'fa-duotone fa-solid fa-receipt',
    'ki-outline ki-bill'           => 'fa-duotone fa-solid fa-receipt',
    'ki-filled ki-chart-line'      => 'fa-duotone fa-solid fa-chart-line',
    'ki-outline ki-chart-line'     => 'fa-duotone fa-solid fa-chart-line',
    'ki-filled ki-arrows-circle'   => 'fa-duotone fa-solid fa-arrows-rotate',
    'ki-outline ki-arrows-circle'  => 'fa-duotone fa-solid fa-arrows-rotate',
    'ki-outline ki-bank'           => 'fa-duotone fa-solid fa-building-columns',
    'ki-outline ki-calculator'     => 'fa-duotone fa-solid fa-calculator',

    // Media & files
    'ki-filled ki-picture'         => 'fa-duotone fa-solid fa-image',
    'ki-filled ki-cross'           => 'fa-duotone fa-solid fa-xmark',
    'ki-filled ki-file'            => 'fa-duotone fa-solid fa-file',
    'ki-filled ki-folder-add'      => 'fa-duotone fa-solid fa-folder-plus',
    'ki-filled ki-cloud-add'       => 'fa-duotone fa-solid fa-cloud-arrow-up',
    'ki-filled ki-send'            => 'fa-duotone fa-solid fa-paper-plane',
    'ki-filled ki-brifecase-timer' => 'fa-duotone fa-solid fa-briefcase-clock',

    // Cruises & transport
    'ki-outline ki-ship'           => 'fa-duotone fa-solid fa-ship',
    'ki-outline ki-water'          => 'fa-duotone fa-solid fa-water',
    'ki-outline ki-shop'           => 'fa-duotone fa-solid fa-store',
    'ki-outline ki-design'         => 'fa-duotone fa-solid fa-drafting-compass',

    // Communication
    'ki-outline ki-message-notify' => 'fa-duotone fa-solid fa-comment-dots',
    'ki-outline ki-lightbulb'      => 'fa-duotone fa-solid fa-lightbulb',

    // Abstract icons → closest FA equivalents
    'ki-filled ki-abstract-41'     => 'fa-duotone fa-solid fa-diagram-project',
    'ki-filled ki-abstract-39'     => 'fa-duotone fa-solid fa-cube',
    'ki-outline ki-abstract-28'    => 'fa-duotone fa-solid fa-cubes',
    'ki-filled ki-abstract-26'     => 'fa-duotone fa-solid fa-shapes',
    'ki-filled ki-global'          => 'fa-duotone fa-solid fa-globe',

    // Sidebar menu icons (common patterns)
    'ki-filled ki-menu'            => 'fa-duotone fa-solid fa-bars',
    'ki-outline ki-menu'           => 'fa-duotone fa-solid fa-bars',
];

$dirs = [
    $basePath . '/resources/views',
    $basePath . '/Modules',
];

$totalFiles = 0;

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'php') continue;
        if (strpos($file->getFilename(), '.blade.php') === false) continue;

        $content = file_get_contents($file->getPathname());
        $original = $content;

        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            $totalFiles++;
            $short = str_replace($basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
            echo "✅ $short\n";
        }
    }
}

echo "\n========================================\n";
echo "V2 Migration complete! Files: $totalFiles\n";
echo "========================================\n";
