<?php

namespace App\Http\Controllers\Dashboard;

use App\Jobs\ExportDataJob;
use App\Jobs\ImportDataJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\ImportExportCompleted;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    // public function import($model, $models, $view = null)
    public function import(Request $request)
    {
        $model = $request->input('model');
        $modelClass = "App\\Models\\" . str_replace('-', '', studlyCaseName($model));
        $models = $request->input('models');
        $view = $request->input('view');
        $title = __('main.import_types', ['types' => __('main.' . $models)]);
        $description = __('main.import_types_description', ['types' => __('main.' . $models)]);
        // Validate model existence
        if (!class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }
        return view("pages.dashboard.$view.import", compact('models', 'view', 'title', 'description'));
    }

    public function importData(Request $request, $models)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx']);
        // $models = Str::plural(strtolower($models));
        $modelClass = "App\\Models\\" . studlyCaseName($models);

        // Handle accommodations sub-models
        if ($models == 'accommodations-rates') {
            $models = $request->input('model');
            $modelClass = "App\\Models\\" . $request->input('model');
        }

        if (!class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = generateUniqueFilename($models) . '.' . $extension;
        $folder = "excels/imports/" . Str::plural(strtolower($models));
        $filePath = $file->storeAs($folder, $filename, 'public');
        $absolutePath = Storage::disk('public')->path($filePath);
        if (!file_exists($absolutePath)) {
            return back()->withError(__('messages.operation_failed'));
        }
        // attach the current user id to the job so broadcasts can target the correct private channel
        $userId = function_exists('getActiveUser') && getActiveUser() ? getActiveUser()->id : null;
        // dd($request->all(), get_defined_vars());
        ImportDataJob::dispatch($modelClass, $absolutePath, 1000, $userId);
        $modelNameAr = __('main.' . $models);
        // Broadcast immediate queued notification (so the user gets realtime feedback)
        try {
            event(new ImportExportCompleted(__('main.import_queued', ['model' => $modelNameAr]), $userId));
        } catch (\Throwable $e) {
            // swallowing broadcast errors so import still proceeds
            Log::warning('Failed to broadcast import queued: ' . $e->getMessage());
        }

        return back()->withSuccess(__('main.import_queued', ['model' => $modelNameAr]));
    }

    public function exportData($models, $type = null)
    {
        $modelName = studlySingular($models);
        $modelClass = "App\\Models\\$modelName";
        if (!class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }
        if ($type) {
            $models = $type;
        }
        // Recompute model/class in case $models was overridden by $type
        $modelName = studlySingular($models);
        $modelClass = "App\\Models\\{$modelName}";

        // Determine filename and run export synchronously so we can return file
        $extension = config('app.excel_export_format', 'xlsx');
        $filename = generateUniqueFilename($models) . '.' . $extension;

        try {
            // Run the export job synchronously (will write the file to storage/public)
            ExportDataJob::dispatchSync($modelClass, $filename);

            // Build expected storage path (matches ExportDataJob behavior)
            $folderName = Str::plural(strtolower(class_basename($modelClass)));
            $filePath = "excels/exports/{$folderName}/{$filename}";
            $absolutePath = Storage::disk('public')->path($filePath);

            if (file_exists($absolutePath)) {
                // Return download response
                return response()->download($absolutePath, $filename, [
                    'Content-Type' => $extension == 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ]);
            }

            return back()->with('error', __('messages.operation_failed'));
        } catch (\Exception $e) {
            // Log and return error message
            Log::error('Export failed: ' . $e->getMessage());
            return back()->with('error', __('messages.operation_failed'));
        }
    }
}