<?php

$dirs = ['Modules', 'resources/views/components'];

function replaceInDir($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            replaceInDir($path);
        } else {
            if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $content = file_get_contents($path);
                
                // Replace for confirm_bulk_delete
                // From: text: '{{ __('messages.confirm_bulk_delete') }}',
                // To: text: `{{ __('messages.confirm_bulk_delete') }}`,
                $content = preg_replace('/text:\s*\'\{\{\s*__\(\'messages\.confirm_bulk_delete\'\)\s*\}\}\'/', 'text: `{{ __(\'messages.confirm_bulk_delete\') }}`', $content);
                
                // Replace for confirm_bulk_force_delete
                $content = preg_replace('/text:\s*\'\{\{\s*__\(\'messages\.confirm_bulk_force_delete\'\)\s*\}\}\'/', 'text: `{{ __(\'messages.confirm_bulk_force_delete\') }}`', $content);
                
                file_put_contents($path, $content);
            }
        }
    }
}

foreach ($dirs as $dir) {
    replaceInDir($dir);
}
echo "Replacement complete.\n";
