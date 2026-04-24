<?php

$modulesDir = __DIR__ . '/Modules';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($modulesDir));

$count = 0;
foreach ($iterator as $file) {
    if ($file->isDir()) continue;
    $filePath = $file->getPathname();
    
    // Check if it's a blade file inside Resources/views/livewire
    if (strpos($filePath, 'Resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'livewire') !== false && strpos($filePath, '.blade.php') !== false) {
        
        $content = file_get_contents($filePath);
        
        // Find the cancel_selection text
        $btnPos = strpos($content, "{{ __('main.cancel_selection') }}");
        if ($btnPos === false) {
            $btnPos = strpos($content, "cancel_selection");
        }
        
        if ($btnPos !== false) {
            $tablePos = strpos($content, "data-kt-datatable-state-save", $btnPos);
            if ($tablePos !== false) {
                // we have the block!
                $beforeBtn = substr($content, 0, $btnPos);
                // find the end of the button
                $btnEnd = strpos($content, "</button>", $btnPos) + 9;
                $beforeBlock = substr($content, 0, $btnEnd);
                
                // find the start of the table div
                $tableStart = strrpos(substr($content, 0, $tablePos), "<div");
                
                $middlePart = substr($content, $btnEnd, $tableStart - $btnEnd);
                $afterBlock = substr($content, $tableStart);
                
                // In the middle part, we count how many </div> we have.
                // We just want to remove the LAST </div> in the middle part.
                
                $lastDivPos = strrpos($middlePart, "</div>");
                if ($lastDivPos !== false) {
                    // Determine if there are at least TWO </div>s in this middle part
                    $divCount = substr_count($middlePart, "</div>");
                    
                    // If there's 2 or more, then one of them is the injected extra one.
                    // Actually, if we're sure it's the extra one, we conditionally remove it only if the divCount is 2 or 3.
                    // Wait, if it's the injected one, the previous refactor definitely added it.
                    // Let's verify by checking how many "opened" divs there are in the whole hierarchy.
                    
                    $cardContentPos = strpos($content, 'class="kt-card-content');
                    if ($cardContentPos !== false) {
                        $blockToTable = substr($content, $cardContentPos, $tablePos - $cardContentPos);
                        $opened = substr_count($blockToTable, '<div') - substr_count($blockToTable, '</div>');
                        
                        // Because <div class="kt-card-content..."> is OPEN, the number of unclosed divs right before the table SHOULD be 1.
                        // If it's 0, it means it was prematurely closed!
                        if ($opened === 0) {
                            $newMiddlePart = substr_replace($middlePart, "", $lastDivPos, 6);
                            $replaced = $beforeBlock . $newMiddlePart . $afterBlock;
                            
                            if ($replaced !== $content) {
                                file_put_contents($filePath, $replaced);
                                echo "Fixed double div in: " . $filePath . " (Opened was {$opened})\n";
                                $count++;
                            }
                        } else {
                            // echo "Skipped (Opened = {$opened}): " . $filePath . "\n";
                        }
                    }
                }
            }
        }
    }
}
echo "Total files fixed: " . $count . "\n";
