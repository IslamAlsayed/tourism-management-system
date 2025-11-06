<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\ExportDataJob;
use App\Jobs\ImportDataJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    public function import($models)
    {
        $modelName = Str::studly(Str::singular($models));
        $models = Str::plural(strtolower($models));
        $modelClass = "App\\Models\\{$modelName}";
        if (!class_exists($modelClass)) {
            return back()->withError("Invalid model: {$models}");
        }
        $title = __('main.import_types', ['types' => __('main.' . $models)]);
        $description = __('main.import_types_description', ['types' => __('main.' . $models)]);
        return view("pages.dashboard.$models.import", get_defined_vars());
    }

    public function importData(Request $request, $models)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx,xls']);
        $modelName = Str::studly(Str::singular($models));
        $models = Str::plural(strtolower($models));
        $modelClass = "App\\Models\\{$modelName}";
        if (!class_exists($modelClass)) {
            return back()->with('error', "Invalid model: {$modelName}");
        }
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = generateUniqueFilename($models) . '.' . $extension;
        $folder = "excels/imports/" . Str::plural(strtolower($models));
        $filePath = $file->storeAs($folder, $filename, 'public');
        $absolutePath = Storage::disk('public')->path($filePath);
        ImportDataJob::dispatch($modelClass, $absolutePath);
        return back()->with('success', "Import job for {$models} has been queued successfully.");
    }

    public function exportData($models, $type = null)
    {
        if (!isset($this->supportedModels[$models])) {
            abort(404);
        }
        if ($type) {
            $models = $type;
        }
        $modelName = Str::studly(Str::singular($models));
        $modelClass = "App\\Models\\{$modelName}";
        $filename = generateUniqueFilename($models) . '.' . config('app.excel_export_format', 'xlsx');
        ExportDataJob::dispatchSync($modelClass, $filename);
        return back()->with('status', 'Export job has been queued successfully.');
    }
}