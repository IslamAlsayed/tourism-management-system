<?php
/**
 * Bulk migration: Keenicons → Font Awesome Pro 7 duotone
 * Run: php migrate_icons.php
 */

$basePath = __DIR__;

$replacements = [
    // Filled icons
    'ki-filled ki-pencil'          => 'fa-duotone fa-solid fa-pen',
    'ki-filled ki-map'             => 'fa-duotone fa-solid fa-map-location-dot',
    'ki-filled ki-geolocation'     => 'fa-duotone fa-solid fa-location-dot',
    'ki-filled ki-check'           => 'fa-duotone fa-solid fa-check',
    'ki-filled ki-plus'            => 'fa-duotone fa-solid fa-plus',
    'ki-filled ki-chart-pie-3'     => 'fa-duotone fa-solid fa-chart-pie',
    'ki-filled ki-information'     => 'fa-duotone fa-solid fa-circle-info',
    'ki-filled ki-search'          => 'fa-duotone fa-solid fa-magnifying-glass',
    'ki-filled ki-exit-right'      => 'fa-duotone fa-solid fa-right-from-bracket',
    'ki-filled ki-setting-2'       => 'fa-duotone fa-solid fa-gear',
    'ki-filled ki-profile-circle'  => 'fa-duotone fa-solid fa-user-circle',
    'ki-filled ki-notification'    => 'fa-duotone fa-solid fa-bell',
    'ki-filled ki-messages'        => 'fa-duotone fa-solid fa-comments',
    'ki-filled ki-home'            => 'fa-duotone fa-solid fa-house',
    'ki-filled ki-shield-tick'     => 'fa-duotone fa-solid fa-shield-check',
    'ki-filled ki-lock'            => 'fa-duotone fa-solid fa-lock',
    'ki-filled ki-key'             => 'fa-duotone fa-solid fa-key',
    'ki-filled ki-questionnaire-tablet' => 'fa-duotone fa-solid fa-clipboard-list',
    'ki-filled ki-security-user'   => 'fa-duotone fa-solid fa-user-shield',
    'ki-filled ki-moon'            => 'fa-duotone fa-solid fa-moon',
    'ki-filled ki-sun'             => 'fa-duotone fa-solid fa-sun',
    'ki-filled ki-cloud-download'  => 'fa-duotone fa-solid fa-cloud-arrow-down',
    'ki-filled ki-cloud-upload'    => 'fa-duotone fa-solid fa-cloud-arrow-up',
    'ki-filled ki-file-up'         => 'fa-duotone fa-solid fa-file-arrow-up',
    'ki-filled ki-file-down'       => 'fa-duotone fa-solid fa-file-arrow-down',
    'ki-filled ki-document'        => 'fa-duotone fa-solid fa-file',
    'ki-filled ki-star'            => 'fa-duotone fa-solid fa-star',
    'ki-filled ki-flag'            => 'fa-duotone fa-solid fa-flag',
    'ki-filled ki-abstract-26'     => 'fa-duotone fa-solid fa-shapes',
    'ki-filled ki-calendar'        => 'fa-duotone fa-solid fa-calendar',
    'ki-filled ki-save'            => 'fa-duotone fa-solid fa-floppy-disk',
    'ki-filled ki-magnifier'       => 'fa-duotone fa-solid fa-magnifying-glass',
    'ki-filled ki-category'        => 'fa-duotone fa-solid fa-grid-2',
    'ki-filled ki-dots-vertical'   => 'fa-duotone fa-solid fa-ellipsis-vertical',
    'ki-filled ki-dots-horizontal' => 'fa-duotone fa-solid fa-ellipsis',
    'ki-filled ki-arrow-up'        => 'fa-duotone fa-solid fa-arrow-up',
    'ki-filled ki-arrow-down'      => 'fa-duotone fa-solid fa-arrow-down',
    'ki-filled ki-arrow-left'      => 'fa-duotone fa-solid fa-arrow-left',
    'ki-filled ki-arrow-right'     => 'fa-duotone fa-solid fa-arrow-right',

    // Outline icons
    'ki-outline ki-pencil'         => 'fa-duotone fa-solid fa-pen',
    'ki-outline ki-trash'          => 'fa-duotone fa-solid fa-trash',
    'ki-outline ki-trash-square'   => 'fa-duotone fa-solid fa-trash-can',
    'ki-outline ki-eye'            => 'fa-duotone fa-solid fa-eye',
    'ki-outline ki-notepad-edit'   => 'fa-duotone fa-solid fa-pen-to-square',
    'ki-outline ki-map'            => 'fa-duotone fa-solid fa-map-location-dot',
    'ki-outline ki-geolocation'    => 'fa-duotone fa-solid fa-location-dot',
    'ki-outline ki-user'           => 'fa-duotone fa-solid fa-user',
    'ki-outline ki-arrow-left'     => 'fa-duotone fa-solid fa-arrow-left',
    'ki-outline ki-arrow-right'    => 'fa-duotone fa-solid fa-arrow-right',
    'ki-outline ki-text-align-left' => 'fa-duotone fa-solid fa-align-left',
    'ki-outline ki-note'           => 'fa-duotone fa-solid fa-note-sticky',
    'ki-outline ki-global'         => 'fa-duotone fa-solid fa-globe',
    'ki-outline ki-pointers'       => 'fa-duotone fa-solid fa-signs-post',
    'ki-outline ki-phone'          => 'fa-duotone fa-solid fa-phone',
    'ki-outline ki-sms'            => 'fa-duotone fa-solid fa-envelope',
    'ki-outline ki-whatsapp'       => 'fa-brands fa-whatsapp',
    'ki-outline ki-edit'           => 'fa-duotone fa-solid fa-pen-to-square',
    'ki-outline ki-search'         => 'fa-duotone fa-solid fa-magnifying-glass',
    'ki-outline ki-magnifier'      => 'fa-duotone fa-solid fa-magnifying-glass',
    'ki-outline ki-cross'          => 'fa-duotone fa-solid fa-xmark',
    'ki-outline ki-cross-circle'   => 'fa-duotone fa-solid fa-circle-xmark',
    'ki-outline ki-check'          => 'fa-duotone fa-solid fa-check',
    'ki-outline ki-plus'           => 'fa-duotone fa-solid fa-plus',
    'ki-outline ki-minus'          => 'fa-duotone fa-solid fa-minus',
    'ki-outline ki-information'    => 'fa-duotone fa-solid fa-circle-info',
    'ki-outline ki-information-2'  => 'fa-duotone fa-solid fa-circle-info',
    'ki-outline ki-notification'   => 'fa-duotone fa-solid fa-bell',
    'ki-outline ki-setting'        => 'fa-duotone fa-solid fa-gear',
    'ki-outline ki-setting-2'      => 'fa-duotone fa-solid fa-gear',
    'ki-outline ki-filter'         => 'fa-duotone fa-solid fa-filter',
    'ki-outline ki-filter-search'  => 'fa-duotone fa-solid fa-filter',
    'ki-outline ki-sort'           => 'fa-duotone fa-solid fa-sort',
    'ki-outline ki-calendar'       => 'fa-duotone fa-solid fa-calendar',
    'ki-outline ki-document'       => 'fa-duotone fa-solid fa-file',
    'ki-outline ki-folder'         => 'fa-duotone fa-solid fa-folder',
    'ki-outline ki-home'           => 'fa-duotone fa-solid fa-house',
    'ki-outline ki-security-user'  => 'fa-duotone fa-solid fa-user-shield',
    'ki-outline ki-shield-tick'    => 'fa-duotone fa-solid fa-shield-check',
    'ki-outline ki-key'            => 'fa-duotone fa-solid fa-key',
    'ki-outline ki-lock'           => 'fa-duotone fa-solid fa-lock',
    'ki-outline ki-message-text'   => 'fa-duotone fa-solid fa-message',
    'ki-outline ki-messages'       => 'fa-duotone fa-solid fa-comments',
    'ki-outline ki-exit-right'     => 'fa-duotone fa-solid fa-right-from-bracket',
    'ki-outline ki-element-7'      => 'fa-duotone fa-solid fa-grid-2',
    'ki-outline ki-moon'           => 'fa-duotone fa-solid fa-moon',
    'ki-outline ki-night-day'      => 'fa-duotone fa-solid fa-sun',
    'ki-outline ki-cloud-download' => 'fa-duotone fa-solid fa-cloud-arrow-down',
    'ki-outline ki-cloud-upload'   => 'fa-duotone fa-solid fa-cloud-arrow-up',
    'ki-outline ki-save'           => 'fa-duotone fa-solid fa-floppy-disk',
    'ki-outline ki-category'       => 'fa-duotone fa-solid fa-grid-2',
    'ki-outline ki-dots-vertical'  => 'fa-duotone fa-solid fa-ellipsis-vertical',
    'ki-outline ki-dots-horizontal' => 'fa-duotone fa-solid fa-ellipsis',
    'ki-outline ki-chart-pie-3'    => 'fa-duotone fa-solid fa-chart-pie',
    'ki-outline ki-arrow-up'       => 'fa-duotone fa-solid fa-arrow-up',
    'ki-outline ki-arrow-down'     => 'fa-duotone fa-solid fa-arrow-down',
    'ki-outline ki-refresh'        => 'fa-duotone fa-solid fa-arrows-rotate',
    'ki-outline ki-abstract-26'    => 'fa-duotone fa-solid fa-shapes',
    'ki-outline ki-loading'        => 'fa-duotone fa-solid fa-spinner',
    'ki-outline ki-shield-cross'   => 'fa-duotone fa-solid fa-shield-xmark',
    'ki-outline ki-copy'           => 'fa-duotone fa-solid fa-copy',
    'ki-outline ki-questionnaire-tablet' => 'fa-duotone fa-solid fa-clipboard-list',
    'ki-outline ki-flag'           => 'fa-duotone fa-solid fa-flag',
    'ki-outline ki-star'           => 'fa-duotone fa-solid fa-star',
    'ki-outline ki-data'           => 'fa-duotone fa-solid fa-database',
    'ki-outline ki-file-up'        => 'fa-duotone fa-solid fa-file-arrow-up',
    'ki-outline ki-file-down'      => 'fa-duotone fa-solid fa-file-arrow-down',
    'ki-outline ki-profile-circle' => 'fa-duotone fa-solid fa-user-circle',
    'ki-outline ki-profile-user'   => 'fa-duotone fa-solid fa-user',
    'ki-outline ki-dollar'         => 'fa-duotone fa-solid fa-dollar-sign',
    'ki-outline ki-crown'          => 'fa-duotone fa-solid fa-crown',
    'ki-outline ki-address-book'   => 'fa-duotone fa-solid fa-address-book',
    'ki-outline ki-chart'          => 'fa-duotone fa-solid fa-chart-simple',
    'ki-outline ki-chart-simple'   => 'fa-duotone fa-solid fa-chart-simple',
    'ki-outline ki-gift'           => 'fa-duotone fa-solid fa-gift',
    'ki-outline ki-link'           => 'fa-duotone fa-solid fa-link',
    'ki-outline ki-picture'        => 'fa-duotone fa-solid fa-image',
    'ki-outline ki-switch'         => 'fa-duotone fa-solid fa-toggle-on',
    'ki-outline ki-color-swatch'   => 'fa-duotone fa-solid fa-palette',
];

$dirs = [
    $basePath . '/resources/views',
    $basePath . '/Modules',
];

$totalFiles = 0;
$totalReplacements = 0;

foreach ($dirs as $dir) {
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
            echo "✅ " . str_replace($basePath . '\\', '', $file->getPathname()) . "\n";
        }
    }
}

echo "\n========================================\n";
echo "Migration complete!\n";
echo "Files updated: {$totalFiles}\n";
echo "========================================\n";
