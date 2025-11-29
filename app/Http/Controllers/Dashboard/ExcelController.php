<?php

namespace App\Http\Controllers\Dashboard;

use App\Jobs\ExportDataJob;
use App\Jobs\ImportDataJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\ImportExportCompleted;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    public function import($models)
    {
        $modelName = studlySingular($models);
        if ($models == 'media-files') {
            $modelName = 'MediaFile';
        }
        $modelClass = "App\\Models\\$modelName";
        if (!class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }
        $title = __('main.import_types', ['types' => __('main.' . $models)]);
        $description = __('main.import_types_description', ['types' => __('main.' . $models)]);
        return view("pages.dashboard.$models.import", compact('title', 'description'));
    }

    public function importData(Request $request, $models)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx']);
        $modelName = studlySingular($models);
        $models = Str::plural(strtolower($models));
        $modelClass = "App\\Models\\{$modelName}";
        if (!class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = generateUniqueFilename($models) . '.' . $extension;
        $folder = "excels/imports/" . Str::plural(strtolower($models));
        $filePath = $file->storeAs($folder, $filename, 'public');
        $absolutePath = Storage::disk('public')->path($filePath);
        ImportDataJob::dispatch($modelClass, $absolutePath);

        $modelNameAr = __('main.' . $models);
        event(new ImportExportCompleted(__('main.import_queued', ['model' => $modelNameAr])));
        return back()->withSuccess(__('main.import_queued', ['model' => $modelNameAr]));
    }

    public function exportData($models, $type = null)
    {
        if (!isset($this->supportedModels[$models])) {
            abort(404);
        }
        if ($type) {
            $models = $type;
        }
        $modelName = studlySingular($models);
        $modelClass = "App\\Models\\{$modelName}";
        $filename = generateUniqueFilename($models) . '.' . config('app.excel_export_format', 'xlsx');
        ExportDataJob::dispatchSync($modelClass, $filename);
        return back()->with('status', __('messages.operation_successful'));
    }
}