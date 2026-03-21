<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Str;

class AuditViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:views {module?} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit database columns against show/edit blade views for missing fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=================================================");
        $this->info("   Turism CMS - View Columns Audit Script        ");
        $this->info("=================================================");

        $moduleName = $this->argument('module');
        $modelNameFilter = $this->option('model');
        
        $modules = $moduleName ? [Module::find($moduleName)] : Module::allEnabled();
        
        if (empty($modules) || (count($modules) === 1 && $modules[0] === null)) {
            $this->error("No modules found.");
            return;
        }

        $totalMissing = 0;

        foreach ($modules as $module) {
            $this->warn("\n[Module: " . $module->getName() . "]");
            $modelsPath = $module->getPath() . '/Entities';
            if (!File::exists($modelsPath)) {
                $this->line("No Entities found.");
                continue;
            }

            $models = File::files($modelsPath);
            foreach ($models as $modelFile) {
                $modelName = $modelFile->getFilenameWithoutExtension();
                $class = "Modules\\" . $module->getName() . "\\Entities\\" . $modelName;
                
                if (!class_exists($class)) continue;
                if ($modelNameFilter && strtolower($modelName) !== strtolower($modelNameFilter)) continue;

                try {
                    $model = new $class;
                    if (!method_exists($model, 'getTable')) continue;

                    $table = $model->getTable();
                    if (!Schema::hasTable($table)) {
                        $this->line("  - Skipping $modelName (Table '$table' does not exist)");
                        continue;
                    }

                    $columns = Schema::getColumnListing($table);
                    // Exclude standard/metadata columns that users usually don't view/edit directly
                    $excluded = [
                        'id', 'created_at', 'updated_at', 'deleted_at', 
                        'created_by', 'updated_by', 'is_active', 'password', 'remember_token'
                    ];
                    $columns = array_diff($columns, $excluded);

                    $viewsPath = $module->getPath() . '/Resources/views';
                    
                    // Folder name is usually the kebab plural of the model name, e.g., RestaurantType => restaurant-types
                    $folderNameOptions = [
                        Str::plural(Str::kebab($modelName)),
                        Str::kebab($modelName),
                        strtolower($modelName),
                        Str::plural(strtolower($modelName))
                    ];

                    $showView = null;
                    $editView = null;
                    $createView = null;

                    foreach ($folderNameOptions as $folder) {
                        $s = $viewsPath . '/' . $folder . '/show.blade.php';
                        $e = $viewsPath . '/' . $folder . '/edit.blade.php';
                        $c = $viewsPath . '/' . $folder . '/create.blade.php';
                        if (File::exists($s)) $showView = $s;
                        if (File::exists($e)) $editView = $e;
                        if (File::exists($c)) $createView = $c;
                    }

                    if (!$showView && !$editView && !$createView) {
                        $this->line("  - Skipping $modelName (No show/edit views found)");
                        continue;
                    }

                    $this->info("\n  Analyzing Model: $modelName (Table: $table)");

                    if ($showView) $totalMissing += $this->checkView($showView, 'Show', $columns);
                    if ($editView) $totalMissing += $this->checkView($editView, 'Edit', $columns);
                    if ($createView) $totalMissing += $this->checkView($createView, 'Create', $columns);

                } catch (\Exception $e) {
                    $this->error("  - Error processing $modelName: " . $e->getMessage());
                }
            }
        }

        $this->info("\n=================================================");
        if ($totalMissing > 0) {
            $this->error("Audit Complete: Found $totalMissing potentially missing columns in views.");
        } else {
            $this->info("Audit Complete: All DB columns seem to be present in views!");
        }
    }

    protected function checkView($path, $type, $columns)
    {
        $content = File::get($path);
        $missing = [];

        foreach ($columns as $column) {
            // Check if column name exists anywhere in the blade template
            // It could be in $model->column_name, name="column_name", wire:model="column_name", etc.
            if (!Str::contains($content, $column)) {
                $missing[] = $column;
            }
        }

        if (count($missing) > 0) {
            $this->error("    [❌] $type View is missing: " . implode(', ', $missing));
            return count($missing);
        } else {
            $this->line("    [✅] $type View has all columns.");
            return 0;
        }
    }
}
