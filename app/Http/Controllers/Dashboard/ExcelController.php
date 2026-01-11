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
        return view("pages.dashboard.$view.import", compact('models', 'model', 'view', 'title', 'description'));
    }

    public function importData(Request $request, $models)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx']);

        $model = $request->input('model');
        $modelClass = "App\\Models\\" . str_replace('-', '', studlyCaseName($model));

        // Validate model existence
        if (!class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }

        // Get fillable columns to inform user what columns are expected
        try {
            $modelInstance = new $modelClass;
            $fillableColumns = $modelInstance->getFillable();

            // Log expected columns for debugging
            Log::info("Import initiated for model: {$modelClass}");
            Log::info("Expected fillable columns: " . implode(', ', $fillableColumns));
        } catch (\Throwable $e) {
            Log::warning("Failed to get fillable columns for {$modelClass}: " . $e->getMessage());
        }

        // Store uploaded file
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = generateUniqueFilename($models) . '.' . $extension;
        $folder = "excels/imports/" . Str::plural(strtolower($models));
        $filePath = $file->storeAs($folder, $filename, 'public');
        $absolutePath = Storage::disk('public')->path($filePath);

        if (!file_exists($absolutePath)) {
            return back()->withError(__('messages.operation_failed'));
        }

        // Dispatch import job with user ID for real-time notifications
        $userId = function_exists('getActiveUser') && getActiveUser() ? getActiveUser()->id : null;

        // The ImportDataJob will:
        // 1. Automatically ignore extra columns from Excel (not in fillable)
        // 2. Set NULL for missing columns (not in Excel but in fillable)
        // 3. Protect against primary key insertion
        // 4. Handle data type conversions (dates, booleans, etc.)
        // 5. Log ignored and missing columns for transparency
        ImportDataJob::dispatch($modelClass, $absolutePath, 1000, $userId);

        $modelName = __('main.' . $models);

        // Broadcast immediate queued notification
        try {
            event(new ImportExportCompleted(
                __('main.import_queued', ['model' => $modelName]),
                $userId
            ));
        } catch (\Throwable $e) {
            Log::warning('Failed to broadcast import queued: ' . $e->getMessage());
        }

        return back()->withSuccess(__('main.import_queued', ['model' => $modelName]));
    }

    public function exportData(Request $request, $models)
    {
        $modelClass = "App\\Models\\" . str_replace('-', '', studlyCaseName($models));
        if (!class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }

        // Determine filename and run export synchronously so we can return file
        $extension = config('app.excel_export_format', 'xlsx');
        $filename = generateUniqueFilename($models) . '.' . $extension;

        // Get export options from request or use defaults
        // Only use default hidden columns (id, uuid) - don't add model's excluded columns
        // The model's excluded columns are meant for table views, not exports
        $hiddenColumns = $request->input('hidden_columns', ['id', 'uuid']);

        $includeRelations = $request->input('include_relations', true);

        try {
            // Run the export job synchronously with smart options
            ExportDataJob::dispatchSync(
                $modelClass,
                $filename,
                5000, // chunk size
                $hiddenColumns,
                $includeRelations
            );

            // Build expected storage path (matches ExportDataJob behavior)
            $folderName = Str::plural(strtolower(class_basename($modelClass)));
            $filePath = "excels/exports/{$folderName}/{$filename}";
            $absolutePath = Storage::disk('public')->path($filePath);

            if (file_exists($absolutePath)) {
                // Return download response
                return response()->download($absolutePath, $filename, [
                    'Content-Type' => $extension == 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ])->deleteFileAfterSend(false); // Keep file for potential re-download
            }

            return back()->with('error', __('messages.operation_failed'));
        } catch (\Exception $e) {
            // Log and return error message
            Log::error('Export failed: ' . $e->getMessage());
            return back()->with('error', __('messages.operation_failed') . ': ' . $e->getMessage());
        }
    }
}