<?php

namespace App\Http\Controllers\Dashboard\Transportation;

use App\Jobs\ImportDataJob;
use App\Jobs\ExportDataJob;
use App\Events\ImportExportCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TransportationImportExportController extends Controller
{
    /**
     * Show import form for transportation companies
     */
    public function showImportForm()
    {
        $title = __('main.import_types', ['types' => __('main.transportations_companies')]);
        $description = __('main.import_types_description', ['types' => __('main.transportations_companies')]);

        return view('pages.dashboard.transportation.import-companies', compact('title', 'description'));
    }

    /**
     * Handle import of transportation companies
     */
    public function importCompanies(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = generateUniqueFilename('transportations-companies') . '.' . $extension;
            $folder = "excels/imports/transportations-companies";
            $filePath = $file->storeAs($folder, $filename, 'public');
            $absolutePath = Storage::disk('public')->path($filePath);

            if (!file_exists($absolutePath)) {
                return back()->withError(__('messages.operation_failed'));
            }

            // Get user for notifications
            $userId = getActiveUser()->id ?? null;

            // Dispatch import job
            ImportDataJob::dispatch(\App\Models\TransportationCompany::class, $absolutePath, 1000, $userId);

            $modelName = __('main.transportations_companies');

            // Broadcast notification
            try {
                event(new ImportExportCompleted(
                    __('main.import_queued', ['model' => $modelName]),
                    $userId
                ));
            } catch (\Throwable $e) {
                Log::warning('Failed to broadcast import queued: ' . $e->getMessage());
            }

            return back()->withSuccess(__('main.import_queued', ['model' => $modelName]));
        } catch (\Throwable $e) {
            Log::error('Transportation company import failed: ' . $e->getMessage());
            return back()->withError(__('messages.operation_failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Export transportation companies with optional relations
     */
    public function exportCompanies(Request $request)
    {
        try {
            $modelClass = \App\Models\TransportationCompany::class;
            $extension = config('app.excel_export_format', 'xlsx');
            $filename = generateUniqueFilename('transportations-companies') . '.' . $extension;

            // Default hidden columns only (id and uuid)
            // Do not add model's excluded columns as they are meant for table display, not exports
            $hiddenColumns = $request->input('hidden_columns', ['id', 'uuid']);

            $includeRelations = $request->input('include_relations', true);

            // Run export job synchronously
            ExportDataJob::dispatchSync(
                $modelClass,
                $filename,
                5000,
                $hiddenColumns,
                $includeRelations
            );

            // Build expected storage path
            $folderName = 'transportations_companies';
            $filePath = "excels/exports/{$folderName}/{$filename}";
            $absolutePath = Storage::disk('public')->path($filePath);

            if (file_exists($absolutePath)) {
                return response()->download($absolutePath, $filename, [
                    'Content-Type' => $extension == 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ])->deleteFileAfterSend(false);
            }

            return back()->with('error', __('messages.operation_failed'));
        } catch (\Exception $e) {
            Log::error('Transportation company export failed: ' . $e->getMessage());
            return back()->with('error', __('messages.operation_failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Show import form for transportation company contacts
     */
    public function showContactsImportForm()
    {
        $title = __('main.import_types', ['types' => __('main.transportations_company_contacts')]);
        $description = __('main.import_types_description', ['types' => __('main.transportations_company_contacts')]);

        return view('pages.dashboard.transportation.import-contacts', compact('title', 'description'));
    }

    /**
     * Handle import of transportation company contacts
     */
    public function importContacts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = generateUniqueFilename('transportations-company-contacts') . '.' . $extension;
            $folder = "excels/imports/transportations-company-contacts";
            $filePath = $file->storeAs($folder, $filename, 'public');
            $absolutePath = Storage::disk('public')->path($filePath);

            if (!file_exists($absolutePath)) {
                return back()->withError(__('messages.operation_failed'));
            }

            // Get user for notifications
            $userId = getActiveUser()->id ?? null;

            // Dispatch import job
            ImportDataJob::dispatch(\App\Models\TransportationCompanyContact::class, $absolutePath, 1000, $userId);

            $modelName = __('main.transportations_company_contacts');

            // Broadcast notification
            try {
                event(new ImportExportCompleted(
                    __('main.import_queued', ['model' => $modelName]),
                    $userId
                ));
            } catch (\Throwable $e) {
                Log::warning('Failed to broadcast import queued: ' . $e->getMessage());
            }

            return back()->withSuccess(__('main.import_queued', ['model' => $modelName]));
        } catch (\Throwable $e) {
            Log::error('Transportation company contacts import failed: ' . $e->getMessage());
            return back()->withError(__('messages.operation_failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Export transportation company contacts
     */
    public function exportContacts(Request $request)
    {
        try {
            $modelClass = \App\Models\TransportationCompanyContact::class;
            $extension = config('app.excel_export_format', 'xlsx');
            $filename = generateUniqueFilename('transportations-company-contacts') . '.' . $extension;

            // Default hidden columns only (id and uuid)
            // Do not add model's excluded columns as they are meant for table display, not exports
            $hiddenColumns = $request->input('hidden_columns', ['id', 'uuid']);

            $includeRelations = $request->input('include_relations', true);

            // Run export job synchronously
            ExportDataJob::dispatchSync(
                $modelClass,
                $filename,
                5000,
                $hiddenColumns,
                $includeRelations
            );

            // Build expected storage path
            $folderName = 'transportations_company_contacts';
            $filePath = "excels/exports/{$folderName}/{$filename}";
            $absolutePath = Storage::disk('public')->path($filePath);

            if (file_exists($absolutePath)) {
                return response()->download($absolutePath, $filename, [
                    'Content-Type' => $extension == 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ])->deleteFileAfterSend(false);
            }

            return back()->with('error', __('messages.operation_failed'));
        } catch (\Exception $e) {
            Log::error('Transportation company contacts export failed: ' . $e->getMessage());
            return back()->with('error', __('messages.operation_failed') . ': ' . $e->getMessage());
        }
    }
}