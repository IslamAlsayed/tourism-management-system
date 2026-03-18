<?php
$dir = new RecursiveDirectoryIterator('Modules');
$iter = new RecursiveIteratorIterator($dir);
$count = 0;
foreach ($iter as $file) {
    if (strpos($file->getPathname(), 'livewire') !== false && strpos($file->getFilename(), '.blade.php') !== false) {
        $content = file_get_contents($file->getPathname());
        if (preg_match("/'columns'\s*=>\s*\\\$columns?,/", $content) && strpos($content, "'allColumns'") === false) {
            $content = preg_replace("/('columns'\s*=>\s*\\\$columns?,)/", "$1\n                    'allColumns' => \$allColumns ?? [],", $content);
            file_put_contents($file->getPathname(), $content);
            $count++;
        }
    }
}
echo "Updated $count files.";
