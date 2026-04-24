<?php

$dir = new RecursiveDirectoryIterator("g:\\MixJo Top downlode mains by dats\\for edit\\tourism-management-system  13 FEB 2026 0221AM\\tourism-management-system\\Modules");
foreach (new RecursiveIteratorIterator($dir) as $file) {
    if ($file->getExtension() === 'php' && strpos($file->getPathname(), 'Livewire') !== false) {
        $content = file_get_contents($file->getPathname());
        
        $pattern = '/public\s+function\s+updatingFilter([a-zA-Z0-9_]+)\s*\(\$value\)\s*\{\s*if\s*\([\s\S]+?\$this->resetPage\(\);\s*\}/';
        
        $newContent = preg_replace_callback($pattern, function($matches) {
            $propName = 'filter' . $matches[1];
            return "public function updatingFilter{$matches[1]}(\$value)\n    {\n        \$this->{$propName} = is_array(\$value) && isset(\$value['payload']['value']) ? \$value['payload']['value'] : \$value;\n        \$this->resetPage();\n    }";
        }, $content);

        // Also fix the simpler variant
        $pattern2 = '/public\s+function\s+updatingFilter([a-zA-Z0-9_]+)\s*\(\$value\)\s*\{\s*\$this->(filter[a-zA-Z0-9_]+)\s*=\s*\$value;\s*\$this->resetPage\(\);\s*\}/';
        
        $newContent2 = preg_replace_callback($pattern2, function($matches) {
            return "public function updatingFilter{$matches[1]}(\$value)\n    {\n        \$this->{$matches[2]} = is_array(\$value) && isset(\$value['payload']['value']) ? \$value['payload']['value'] : \$value;\n        \$this->resetPage();\n    }";
        }, $newContent);

        if ($content !== $newContent2) {
            file_put_contents($file->getPathname(), $newContent2);
            echo "Fixed: " . basename($file->getPathname()) . "\n";
        }
    }
}
