<?php

namespace App\Http\Controllers\Dashboard;

use App\Jobs\ExportDataJob;
use App\Jobs\ImportDataJob;
use App\Models\ImportHistory;
use App\Models\ImportSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\ImportExportCompleted;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ExcelController extends Controller
{
    // public function import($model, $models, $view = null)
    public function import(Request $request)
    {
        $model = $request->input('model');
        $models = $request->input('models');
        $view = $request->input('view');

        // If model is not provided, derive it from models parameter
        if (empty($model) && !empty($models)) {
            $model = $models;
        }

        // If view is not provided, derive it from models parameter
        if (empty($view) && !empty($models)) {
            // Map models to their view paths (including module namespaces)
            $viewMap = [
                'users' => 'core::users',
                'roles' => 'core::roles',
                'permissions' => 'core::permissions',
                'currencies' => 'localization::currencies',
                'languages' => 'localization::languages',
                'timezones' => 'localization::timezones',
                'system-languages' => 'localization::system-languages',
                'countries' => 'geography::countries',
                'cities' => 'geography::cities',
                'regions' => 'geography::regions',
                'subregions' => 'geography::subregions',
                'states' => 'geography::states',
                'nationalities' => 'geography::nationalities',
                'restaurants' => 'restaurants::restaurants',
                'restauranttypes' => 'restaurants::types',
                'restaurantmeals' => 'restaurants::meals',
                'accommodations' => 'accommodations::accommodations',
                'accommodationtypes' => 'accommodations::types',
                'rooms' => 'accommodations::rooms',
                'seasons' => 'accommodations::seasons',
                'meals' => 'accommodations::meals',
                'supplements' => 'accommodations::supplements',
                'airlines' => 'airlines',
                'pricing-definitions' => 'pricing-definitions',
                'transportation-bus-types' => 'transportation-bus-types',
                'transportation-company-bus-types' => 'transportation-company-bus-types',
                'transportation-departments' => 'transportation-departments',
                'transportation-vehicles' => 'transportation-vehicles',
                'tours-guides' => 'tourguides::guides',
                'tours.guides' => 'tourguides::guides',
                'guide-types' => 'tourguides::types',
                'guide-reviews' => 'tourguides::reviews',
            ];
            $view = $viewMap[$models] ?? $models;
        }

        // Resolve model class dynamically to support Modules
        $modelClass = $this->resolveModelClass($model);

        // Validate model existence
        if (!$modelClass || !class_exists($modelClass)) {
            Log::warning("Import: Could not resolve model class for: {$model}");
            return back()->withError(__('messages.invalid_model_specified'));
        }

        $title = __('main.import_types', ['types' => __('main.' . preg_replace('/-/', '.', $models, 1))]);
        $description = __('main.import_types_description', ['types' => __('main.' . preg_replace('/-/', '.', $models, 1))]);
        
        $importSetting = ImportSetting::where('model_type', $modelClass)->first();
        $googleDriveUrl = $importSetting ? $importSetting->google_drive_url : null;
        $lastImport = $importSetting ? [
            'count' => $importSetting->last_import_count,
            'date' => $importSetting->last_imported_at ? $importSetting->last_imported_at->diffForHumans() : null,
        ] : null;

        $history = ImportHistory::where('model_type', $modelClass)
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Check if specific import view exists, otherwise use generic
        $specificView = str_contains($view, '::') ? "$view.import" : "pages.dashboard.$view.import";
        $genericView = 'pages.dashboard.generic-import';
        
        $viewToUse = view()->exists($specificView) ? $specificView : $genericView;
        
        return view($viewToUse, compact('title', 'description', 'models', 'model', 'view', 'googleDriveUrl', 'lastImport', 'history', 'modelClass'));
    }

    public function importData(Request $request, $models)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx']);

        $model = $request->input('model');
        
        // Resolve model class dynamically
        $modelClass = $this->resolveModelClass($model);

        // Validate model existence
        if (!$modelClass || !class_exists($modelClass)) {
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

        $userId = function_exists('getActiveUserId') && getActiveUserId() ? getActiveUserId() : null;

        // Create history record immediately
        $history = ImportHistory::create([
            'model_type' => $modelClass,
            'user_id' => $userId,
            'source' => 'file',
            'status' => 'queued',
            'file_path' => $filePath,
        ]);

        // The ImportDataJob will:
        // 1. Automatically ignore extra columns from Excel (not in fillable)
        // 2. Set NULL for missing columns (not in Excel but in fillable)
        // 3. Protect against primary key insertion
        // 4. Handle data type conversions (dates, booleans, etc.)
        // 5. Log ignored and missing columns for transparency
        ImportDataJob::dispatch($modelClass, $absolutePath, 1000, $userId, 'file', $history->uuid);

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

    public function importFromGoogleDrive(Request $request, $models)
    {
        $request->validate([
            'google_drive_url' => 'required|string'
        ]);

        $model = $request->input('model');
        $modelClass = $this->resolveModelClass($model);

        if (!$modelClass || !class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified'));
        }

        $url = $request->input('google_drive_url');
        $action = $request->input('action');
        
        $userId = function_exists('getActiveUserId') && getActiveUserId() ? getActiveUserId() : null;

        // Save or update the URL
        ImportSetting::updateOrCreate(
            ['model_type' => $modelClass],
            ['google_drive_url' => $url]
        );

        if ($action === 'save_only') {
            return back()->withSuccess(__('main.google_drive_link_saved_successfully') ?? 'Google Drive link saved successfully.');
        }

        // Create ONE history record
        $history = ImportHistory::create([
            'model_type' => $modelClass,
            'user_id' => $userId,
            'source' => 'google_drive',
            'status' => 'processing',
        ]);

        // Convert Google Drive view URL to export URL
        $fileId = $this->extractGoogleDriveFileId($url);
        
        if ($fileId) {
            // Try CSV export first (for native Google Sheets)
            $csvExportUrl = "https://docs.google.com/spreadsheets/d/{$fileId}/export?format=csv";
            // Fallback: Direct download link (for uploaded XLSX/CSV files)
            $directDownloadUrl = "https://docs.google.com/uc?export=download&id={$fileId}";
        } else {
            // Treat as generic public URL
            $csvExportUrl = $url;
            $directDownloadUrl = $url;
        }
        
        $downloadResult = null;
        $contentType = null;

        try {
            Log::info("Attempting to download Google Drive file ID/URL: {$url}");
            
            try {
                $response = Http::withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        CURLOPT_DNS_CACHE_TIMEOUT => 0,
                    ]
                ])->retry(3, 200)->timeout(120)->connectTimeout(30)->get($csvExportUrl);
            } catch (\Exception $e) {
                Log::warning("Http::get failed entirely (timeout?): " . $e->getMessage());
            }
            
            if (!isset($response) || !$response->successful() || str_contains($response->header('Content-Type'), 'text/html')) {
                Log::info("standard cURL failed or returned HTML for: {$url}. Trying direct download...");
                
                try {
                    $response = Http::withOptions([
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        ]
                    ])->retry(3, 200)->timeout(120)->connectTimeout(30)->get($directDownloadUrl);
                } catch (\Exception $e) {
                    Log::warning("Http::get (direct format) failed entirely: " . $e->getMessage());
                }
            }

            if (isset($response) && $response->successful() && !str_contains($response->header('Content-Type'), 'text/html')) {
                $downloadResult = $response->body();
                $contentType = $response->header('Content-Type');
            } else {
                // LAST RESORT: Try shell_exec curl.exe if available (very robust on Windows)
                Log::info("PHP Http failed. Attempting system curl.exe fallback for URL: {$url}");
                $downloadResult = $this->downloadUsingCurlExe($csvExportUrl);
                if (!$downloadResult) {
                    $downloadResult = $this->downloadUsingCurlExe($directDownloadUrl);
                }
                
                if ($downloadResult) {
                    $contentType = 'text/csv';
                }
            }

            if (!$downloadResult) {
                $status = isset($response) ? $response->status() : 0;
                Log::error("Failed to download from Google Drive. Status: {$status}");
                
                $errorMessage = __('main.failed_to_download_from_drive');
                if ($status === 403 || $status === 401) {
                    $errorMessage .= " - " . (__('main.ensure_file_is_public') ?? 'Ensure the file is shared as "Anyone with the link can view".');
                } elseif ($status === 404) {
                    $errorMessage .= " - " . (__('main.file_not_found') ?? 'File not found. Verify the ID.');
                }
                
                $history->update([
                    'status' => 'failed',
                    'error_message' => $errorMessage
                ]);
                return back()->withError($errorMessage);
            }

            // Detect extension from Content-Type
            $extension = 'xlsx';
            
            if (str_contains($contentType ?? '', 'csv')) {
                $extension = 'csv';
            } elseif (str_contains($contentType ?? '', 'openxmlformats') || str_contains($contentType ?? '', 'spreadsheetml')) {
                $extension = 'xlsx';
            }

            $filename = generateUniqueFilename($models) . "_drive." . $extension;
            $folder = "excels/imports/" . Str::plural(strtolower($models));
            $filePath = "{$folder}/{$filename}";
            
            // Use $downloadResult instead of $response->body()
            Storage::disk('public')->put($filePath, $downloadResult);
            $absolutePath = Storage::disk('public')->path($filePath);

            Log::info("Downloaded Google Drive file to: {$absolutePath} (Size: " . strlen($downloadResult) . " bytes)");

            // Update history with file path and status
            $history->update([
                'status' => 'queued',
                'file_path' => $filePath,
            ]);

            ImportDataJob::dispatch($modelClass, $absolutePath, 1000, $userId, 'google_drive', $history->uuid);

            $modelName = __('main.' . $models);

            try {
                event(new ImportExportCompleted(
                    __('main.import_queued', ['model' => $modelName]),
                    $userId
                ));
            } catch (\Throwable $e) {
                Log::warning('Failed to broadcast import queued: ' . $e->getMessage());
            }

            return back()->withSuccess(__('main.import_queued', ['model' => $modelName]));

        } catch (\Exception $e) {
            Log::error("Exception downloading from Google Drive: " . $e->getMessage());
            $history->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            return back()->withError(__('main.operation_failed'));
        }
    }

    private function extractGoogleDriveFileId($url)
    {
        $pattern = '/(?<=\/d\/)([a-zA-Z0-9-_]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        
        // Handle id= format
        parse_str(parse_url($url, PHP_URL_QUERY), $queries);
        if (isset($queries['id'])) {
            return $queries['id'];
        }

        return null;
    }

    public function clearImportHistory(Request $request)
    {
        $modelType = $request->input('model_type');
        
        if (!$modelType) {
            return back()->withError(__('messages.invalid_model_specified'));
        }

        $deleted = ImportHistory::where('model_type', $modelType)->delete();
        
        Log::info("Import history cleared for {$modelType}: {$deleted} records deleted by user " . (getActiveUserId() ?? 'unknown'));
        
        return back()->withSuccess(__('main.import_history_cleared') ?? "Import history cleared ({$deleted} records)");
    }

    public function exportData(Request $request, $models)
    {
        $modelClass = $this->resolveModelClass($models);
        
        if (!$modelClass || !class_exists($modelClass)) {
            return back()->withError(__('messages.invalid_model_specified') ?? 'Invalid model specified for export.');
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

    /**
     * Resolve model class name from short name, supporting Modules.
     */
    private function resolveModelClass($modelName)
    {
        if (empty($modelName)) return null;

        // If it's a dotted string (e.g., dashboard.localization.currencies), take last segment
        if (str_contains($modelName, '.')) {
            $segments = explode('.', $modelName);
            $modelName = end($segments);
        }

        // Normalize model name
        $normalized = trim(str_replace(['-', '_', ' '], '', strtolower($modelName)));
        
        // Map common entities to their Modular paths
        $map = [
            'users' => \Modules\Core\Entities\User::class,
            'user' => \Modules\Core\Entities\User::class,
            'roles' => \Spatie\Permission\Models\Role::class,
            'role' => \Spatie\Permission\Models\Role::class,
            'permissions' => \Spatie\Permission\Models\Permission::class,
            'permission' => \Spatie\Permission\Models\Permission::class,
            'countries' => \Modules\Geography\Entities\Country::class,
            'country' => \Modules\Geography\Entities\Country::class,
            'cities' => \Modules\Geography\Entities\City::class,
            'city' => \Modules\Geography\Entities\City::class,
            'regions' => \Modules\Geography\Entities\Region::class,
            'region' => \Modules\Geography\Entities\Region::class,
            'subregions' => \Modules\Geography\Entities\Subregion::class,
            'subregion' => \Modules\Geography\Entities\Subregion::class,
            'accommodations' => \Modules\Accommodations\Entities\Accommodation::class,
            'accommodation' => \Modules\Accommodations\Entities\Accommodation::class,
            'accommodationtypes' => \Modules\Accommodations\Entities\Type::class,
            'accommodationtype' => \Modules\Accommodations\Entities\Type::class,
            'companies' => \Modules\Transportation\Entities\Company::class,
            'company' => \Modules\Transportation\Entities\Company::class,
            'transportationcompany' => \Modules\Transportation\Entities\Company::class,
            'transportationcompanies' => \Modules\Transportation\Entities\Company::class,
            'transportationscompanies' => \Modules\Transportation\Entities\Company::class,
            'airlines' => \App\Models\Airline::class,
            'airline' => \App\Models\Airline::class,
            'tours' => \Modules\Tours\Entities\Tour::class,
            'tour' => \Modules\Tours\Entities\Tour::class,
            'bookings' => \Modules\Bookings\Entities\Booking::class,
            'booking' => \Modules\Bookings\Entities\Booking::class,
            'clients' => \Modules\CRM\Entities\Client::class,
            'client' => \Modules\CRM\Entities\Client::class,
            // Tourists
            'sites' => \Modules\TouristSites\Entities\TouristSite::class,
            'site' => \Modules\TouristSites\Entities\TouristSite::class,
            'touristsites' => \Modules\TouristSites\Entities\TouristSite::class,
            'touristsite' => \Modules\TouristSites\Entities\TouristSite::class,
            'services' => \Modules\TouristServices\Entities\TouristService::class,
            'service' => \Modules\TouristServices\Entities\TouristService::class,
            'touristservices' => \Modules\TouristServices\Entities\TouristService::class,
            'touristservice' => \Modules\TouristServices\Entities\TouristService::class,
            // Geography
            'states' => \Modules\Geography\Entities\State::class,
            'state' => \Modules\Geography\Entities\State::class,
            'nationalities' => \Modules\Geography\Entities\Nationality::class,
            'nationality' => \Modules\Geography\Entities\Nationality::class,
            // EntryPoints
            'landcrossings' => \Modules\EntryPoints\Entities\Landcrossing::class,
            'landcrossing' => \Modules\EntryPoints\Entities\Landcrossing::class,
            'seaports' => \Modules\EntryPoints\Entities\Seaport::class,
            'seaport' => \Modules\EntryPoints\Entities\Seaport::class,
            'airports' => \Modules\EntryPoints\Entities\Airport::class,
            'airport' => \Modules\EntryPoints\Entities\Airport::class,
            // Localization
            'systemlanguages' => \Modules\Localization\Entities\SystemLanguage::class,
            'systemlanguage' => \Modules\Localization\Entities\SystemLanguage::class,
            'currencies' => \Modules\Localization\Entities\Currency::class,
            'currency' => \Modules\Localization\Entities\Currency::class,
            'languages' => \Modules\Localization\Entities\Language::class,
            'language' => \Modules\Localization\Entities\Language::class,
            'timezones' => \Modules\Localization\Entities\Timezone::class,
            'timezone' => \Modules\Localization\Entities\Timezone::class,
            // Tour Guides
            'guides' => \Modules\TourGuides\Entities\TourGuide::class,
            'guide' => \Modules\TourGuides\Entities\TourGuide::class,
            'guidetypes' => \Modules\TourGuides\Entities\TourGuideType::class,
            'guidetype' => \Modules\TourGuides\Entities\TourGuideType::class,
            'guidereviews' => \Modules\TourGuides\Entities\TourGuideReview::class,
            'guidereview' => \Modules\TourGuides\Entities\TourGuideReview::class,
            'tourguides' => \Modules\TourGuides\Entities\TourGuide::class,
            'tourguide' => \Modules\TourGuides\Entities\TourGuide::class,
            'tourguidetypes' => \Modules\TourGuides\Entities\TourGuideType::class,
            'tourguidetype' => \Modules\TourGuides\Entities\TourGuideType::class,
            'tourguidereviews' => \Modules\TourGuides\Entities\TourGuideReview::class,
            'tourguidereview' => \Modules\TourGuides\Entities\TourGuideReview::class,
            // Accommodations
            'seasons' => \Modules\Accommodations\Entities\Season::class,
            'season' => \Modules\Accommodations\Entities\Season::class,
            'rooms' => \Modules\Accommodations\Entities\Room::class,
            'room' => \Modules\Accommodations\Entities\Room::class,
            'meals' => \Modules\Accommodations\Entities\Meal::class,
            'meal' => \Modules\Accommodations\Entities\Meal::class,
            'supplements' => \Modules\Accommodations\Entities\Supplement::class,
            'supplement' => \Modules\Accommodations\Entities\Supplement::class,
            
            // Restaurant, Supplements, Seasons, Meals, and Types
            'restaurant' => \Modules\Restaurants\Entities\Restaurant::class,
            'restaurants' => \Modules\Restaurants\Entities\Restaurant::class,
            'restaurantsupplement' => \Modules\Restaurants\Entities\RestaurantSupplement::class,
            'restaurantsupplements' => \Modules\Restaurants\Entities\RestaurantSupplement::class,
            'restauranttype' => \Modules\Restaurants\Entities\RestaurantType::class,
            'restauranttypes' => \Modules\Restaurants\Entities\RestaurantType::class,
            'restaurantmeal' => \Modules\Restaurants\Entities\RestaurantMeal::class,
            'restaurantmeals' => \Modules\Restaurants\Entities\RestaurantMeal::class,
            'restaurantseason' => \Modules\Accommodations\Entities\Season::class,
            'restaurantseasons' => \Modules\Accommodations\Entities\Season::class,

            // Transportation Supplements and Seasons
            'transportationsupplement' => \Modules\Accommodations\Entities\Supplement::class,
            'transportationsupplements' => \Modules\Accommodations\Entities\Supplement::class,
            'transportationseason' => \Modules\Accommodations\Entities\Season::class,
            'transportationseasons' => \Modules\Accommodations\Entities\Season::class,
        ];
        if (str_contains($modelName, 'transportation') && str_contains($modelName, 'companies')) {
             return \Modules\Transportation\Entities\Company::class;
        }
        if (str_contains($modelName, 'core') && str_contains($modelName, 'users')) {
             return \Modules\Core\Entities\User::class;
        }

        if (isset($map[$normalized])) {
            return $map[$normalized];
        }

        // Fallback: Check standard App\Models
        $appModel = "App\\Models\\" . Str::studly($modelName);
        if (class_exists($appModel)) {
            return $appModel;
        }

        return null;
    }

    private function downloadUsingCurlExe($url)
    {
        try {
            Log::info("Attempting system curl.exe for URL: " . substr($url, 0, 100));
            // Use -L for redirects, -k for insecure, -s for silent
            // On Windows, curl.exe is usually in system32
            $tempFile = tempnam(sys_get_temp_dir(), 'curl_');
            $command = "curl.exe -L -s -o " . escapeshellarg($tempFile) . " " . escapeshellarg($url);
            
            exec($command, $output, $returnVar);
            
            if ($returnVar === 0 && file_exists($tempFile) && filesize($tempFile) > 0) {
                $content = file_get_contents($tempFile);
                unlink($tempFile);
                Log::info("system curl.exe success. Downloaded " . strlen($content) . " bytes.");
                
                // If the content is small and contains 'HTML', it might be a login page
                if (strlen($content) < 2000 && stripos($content, '<html') !== false) {
                    Log::warning("system curl.exe returned HTML, likely a login page or error.");
                    return null;
                }
                
                return $content;
            }
            
            if (file_exists($tempFile)) unlink($tempFile);
            Log::warning("system curl.exe failed with return code: " . $returnVar);
        } catch (\Throwable $e) {
            Log::error("Exception in downloadUsingCurlExe: " . $e->getMessage());
        }
        return null;
    }
}
