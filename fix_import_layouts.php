<?php

$dir = 'resources/views/pages/dashboard';

function replaceInDir($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            replaceInDir($path);
        } else {
            if (strpos($file, 'import.blade.php') !== false) {
                $content = file_get_contents($path);
                
                // Only modify if it doesn't already contain kt-container-fixed
                if (strpos($content, 'kt-container-fixed') === false) {
                    // Replace @section('content') with container opening
                    $content = str_replace("@section('content')", "@section('content')\n    <div class=\"kt-container-fixed pt-4 pb-8\">", $content);
                    
                    // Replace @endsection with container closing
                    // To be safe, we'll replace the last occurrence of @endsection
                    $pos = strrpos($content, "@endsection");
                    if ($pos !== false) {
                        $content = substr_replace($content, "    </div>\n@endsection", $pos, strlen("@endsection"));
                        file_put_contents($path, $content);
                        echo "Fixed: $path\n";
                    }
                }
            }
        }
    }
}

replaceInDir($dir);
echo "Replacement complete.\n";
