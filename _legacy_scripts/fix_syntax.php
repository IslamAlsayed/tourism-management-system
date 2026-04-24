<?php
$file = 'resources/lang/ru/main.php';
$content = file_get_contents($file);
$content = preg_replace("/=> \[\s*\[/", "=> [", $content);
file_put_contents($file, $content);
echo "Cleaned syntax!\n";
