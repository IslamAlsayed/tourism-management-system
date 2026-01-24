<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use App\Events\ImportExportCompleted;
use App\Events\DataStorageMessage;
use App\Services\TransportationDataImporter;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $modelClass;
    protected string $filePath;
    protected ?int $userId;
    protected int $chunkSize;
    protected array $pendingTransportationContacts = [];
    protected array $transportationCompanyUuidMap = [];
    protected array $tourGuideTypePivotData = []; // Store pivot data for TourGuideType

    public function __construct(string $modelClass, string $filePath, int $chunkSize = 1000, ?int $userId = null)
    {
        $this->modelClass = $modelClass;
        $this->filePath = $filePath;
        $this->chunkSize = $chunkSize;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $model = new $this->modelClass;

        if (!method_exists($model, 'getFillable')) {
            Log::error("Model {$this->modelClass} must have fillable attributes.");
            return;
        }

        $fillable = $model->getFillable();

        // Ensure we only attempt to insert columns that actually exist in the DB table
        $dbColumns = [];
        $dateLikeColumns = [];
        try {
            $dbColumns = Schema::getColumnListing($model->getTable());
            $fillable = array_values(array_intersect($fillable, $dbColumns));

            // ensure primary key is not part of fillable to avoid attempting to insert it
            try {
                $pkName = $model->getKeyName();
                if (!empty($pkName)) {
                    $pkLower = strtolower($pkName);
                    $fillable = array_values(array_filter($fillable, function ($c) use ($pkLower) {
                        return strtolower($c) !== $pkLower;
                    }));
                }
            } catch (\Throwable $_) {
                // ignore
            }

            // fetch column types so we can coerce dates
            $cols = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM `" . $model->getTable() . "`");
            foreach ($cols as $c) {
                $field = $c->Field ?? $c['Field'] ?? null;
                $type = $c->Type ?? $c['Type'] ?? '';
                if ($field) {
                    $lower = strtolower($type);
                    if (str_contains($lower, 'date') || str_contains($lower, 'timestamp') || str_contains($lower, 'time')) {
                        $dateLikeColumns[$field] = true;
                    }
                }
            }
        } catch (\Throwable $e) {
            // if schema inspection fails, log and continue with original fillable
            Log::warning('Failed to inspect DB columns for ' . $this->modelClass . ': ' . $e->getMessage());
        }

        // اقرأ الملف كـ stream (بدون تحميل كل البيانات مرة واحدة)
        // notify start of storage
        try {
            Event::dispatch(new DataStorageMessage('سيتم تخزين البيانات'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage start message: ' . $e->getMessage());
        }

        $rows = SimpleExcelReader::create($this->filePath)
            ->getRows();

        $buffer = [];
        $counter = 0;
        $headerMap = null; // map normalized header -> actual header key
        $totalRows = 0; // track total rows read

        foreach ($rows as $rowIndex => $row) {
            $totalRows++;

            // Row keys may be the header names (associative). Normalize on first row.
            if ($headerMap === null) {
                $headerMap = [];
                foreach (array_keys((array) $row) as $originalKey) {
                    $norm = Str::of($originalKey)->trim()->lower();
                    // convert spaces and dots to underscores
                    $norm = preg_replace('/[\s\.]+/', '_', (string) $norm);
                    $headerMap[$norm] = $originalKey;
                }

                // Log detected headers
                Log::debug('ImportDataJob detected headers: ' . json_encode($headerMap));

                // create reverse lookup from fillable -> header key if possible
                $fillableLookup = [];
                foreach ($fillable as $col) {
                    $colNorm = strtolower($col);
                    // try exact match
                    if (isset($headerMap[$colNorm])) {
                        $fillableLookup[$col] = $headerMap[$colNorm];
                        continue;
                    }
                    // try snake_case of header names
                    foreach ($headerMap as $hNorm => $orig) {
                        if ($hNorm === $colNorm || $hNorm === Str::snake($col)) {
                            $fillableLookup[$col] = $orig;
                            break;
                        }
                    }
                    // fallback: leave unmapped for now
                }

                // Log the fillable lookup mapping
                Log::debug('ImportDataJob fillable lookup: ' . json_encode($fillableLookup));
            }

            // تنظيف القيم: trim/null
            $cleaned = [];
            foreach ((array) $row as $k => $v) {
                if (is_string($v)) {
                    $v = trim($v);
                    if ($v === '' || strtolower($v) === 'null')
                        $v = null;
                }
                $cleaned[$k] = $v;
            }

            // Capture TourGuideType pivot data BEFORE filtering by fillable
            // This is necessary because state_id and city_id are NOT columns in tour_guide_types table
            if ($this->modelClass === \App\Models\TourGuideType::class) {
                $pivotData = [];

                // Extract state_id from cleaned data
                foreach ($headerMap as $normKey => $origKey) {
                    if ($normKey === 'state_id' && isset($cleaned[$origKey])) {
                        // Clean the value - remove brackets and whitespace
                        $value = $cleaned[$origKey];
                        if (is_string($value)) {
                            $value = str_replace(['[', ']', ' '], '', $value);
                        }
                        $pivotData['state_id'] = $value;
                    }
                    if ($normKey === 'city_id' && isset($cleaned[$origKey])) {
                        // Clean the value - remove brackets and whitespace
                        $value = $cleaned[$origKey];
                        if (is_string($value)) {
                            $value = str_replace(['[', ']', ' '], '', $value);
                        }
                        $pivotData['city_id'] = $value;
                    }
                }

                // We'll store this and match it later using type or uuid
                if (!empty($pivotData)) {
                    // Try to get identifying info (including row index as fallback)
                    foreach ($headerMap as $normKey => $origKey) {
                        if ($normKey === 'uuid' && isset($cleaned[$origKey])) {
                            $pivotData['uuid'] = $cleaned[$origKey];
                        }
                        if ($normKey === 'type' && isset($cleaned[$origKey])) {
                            $pivotData['type'] = $cleaned[$origKey];
                        }
                    }
                    // Add row index to ensure we can match even if UUID is missing
                    $pivotData['row_index'] = $totalRows;
                    $this->tourGuideTypePivotData[] = $pivotData;
                    Log::debug('Captured TourGuideType pivot data: ' . json_encode($pivotData));
                }
            }

            // Build a row aligned with $fillable using lookup when possible
            $prepared = [];
            foreach ($fillable as $col) {
                if (!empty($fillableLookup[$col])) {
                    $headerKey = $fillableLookup[$col];
                    $prepared[$col] = $cleaned[$headerKey] ?? null;
                } else {
                    // attempt to find header by normalized name
                    $found = null;
                    $colNorm = strtolower($col);
                    foreach ($headerMap as $hNorm => $origKey) {
                        if ($hNorm === $colNorm || $hNorm === Str::snake($col)) {
                            $found = $origKey;
                            break;
                        }
                    }
                    $prepared[$col] = $found ? ($cleaned[$found] ?? null) : null;
                }
            }

            // Set default values for common boolean columns if they are null
            if (isset($prepared['is_active']) && $prepared['is_active'] === null) {
                $prepared['is_active'] = true;
            }
            if (isset($prepared['is_included']) && $prepared['is_included'] === null) {
                $prepared['is_included'] = false;
            }

            // Generate UUID if column exists in fillable and value is empty/null
            if (in_array('uuid', $fillable) && empty($prepared['uuid'])) {
                $prepared['uuid'] = (string) Str::uuid();
            }

            // Generate code for Client model if column exists and value is empty
            if ($this->modelClass === \App\Models\Client::class && in_array('code', $fillable) && empty($prepared['code'])) {
                $prepared['code'] = generateCode('CLT-', 5);
                Log::debug("Auto-generated Client code: {$prepared['code']}");
            }

            // Convert model_type from simple name to full namespace
            // e.g., "accommodation" -> "App\Models\Accommodation"
            // e.g., "transportation-company" -> "App\Models\TransportationCompany"
            if (in_array('model_type', $fillable) && !empty($prepared['model_type'])) {
                $modelType = trim((string) $prepared['model_type']);

                // If it doesn't contain backslash, assume it's a simple name
                if (!str_contains($modelType, '\\')) {
                    // Convert kebab-case, snake_case, or lowercase to StudlyCase
                    $className = Str::studly(str_replace(['-', '_'], ' ', $modelType));
                    $prepared['model_type'] = "App\\Models\\{$className}";
                    Log::debug("Converted model_type '{$modelType}' to '{$prepared['model_type']}'");
                }
            }

            // Handle max_occupancy conversion for Room model (e.g., "2A+1C" -> occupancy_details + numeric max_occupancy)
            if (isset($prepared['max_occupancy']) && is_string($prepared['max_occupancy'])) {
                $occupancyStr = trim($prepared['max_occupancy']);

                // Check if it contains letters (A for Adults, C for Children)
                if (preg_match('/[A-Za-z]/', $occupancyStr)) {
                    // Save original string to occupancy_details if that column exists in fillable
                    if (in_array('occupancy_details', $fillable)) {
                        $prepared['occupancy_details'] = $occupancyStr;
                    }

                    // Calculate total numeric value
                    $total = 0;
                    if (preg_match_all('/(\d+)[ACac]/', $occupancyStr, $matches)) {
                        $total = array_sum(array_map('intval', $matches[1]));
                    }

                    // Replace max_occupancy with numeric total
                    $prepared['max_occupancy'] = $total > 0 ? $total : 1;
                }
            }

            // Normalize price_type to snake_case if exists
            if (isset($prepared['price_type'])) {
                $priceTypeStr = trim((string) $prepared['price_type']);
                $prepared['price_type'] = Str::snake($priceTypeStr);
                Log::debug("Normalized price_type to '{$prepared['price_type']}'");
            }

            // Smart timezone_id lookup: if value is text, search by name/abbreviation
            if (
                in_array('timezone_id', $fillable) && !empty($prepared['timezone_id']) ||
                in_array('timezone', $fillable) && !empty($prepared['timezone'])
            ) {
                $timezoneValue = $prepared['timezone_id'] ?? $prepared['timezone'];

                // If not numeric, try to find timezone by name intelligently
                if (!is_numeric($timezoneValue)) {
                    try {
                        $searchTerm = trim((string) $timezoneValue);

                        // Try exact match first (name, name_ar, or abbreviation)
                        $timezone = \App\Models\Timezone::where('name', $searchTerm)
                            ->orWhere('name_ar', $searchTerm)
                            ->orWhere('abbreviation', $searchTerm)
                            ->first();

                        // If not found, try case-insensitive partial match
                        if (!$timezone) {
                            try {
                                $timezone = \App\Models\Timezone::where('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('abbreviation', 'LIKE', "%{$searchTerm}%")
                                    ->first();
                                Log::info("Created new timezone: '{$searchTerm}' with ID: {$timezone->id}");
                            } catch (\Throwable $createError) {
                                Log::warning("Failed to create new timezone '{$searchTerm}': " . $createError->getMessage());
                                $prepared['timezone_id'] = null;
                            }
                        }

                        if ($timezone) {
                            $prepared['timezone_id'] = $timezone->id;
                            Log::debug("Resolved timezone '{$searchTerm}' to ID: {$timezone->id} ({$timezone->name})");
                        } else {
                            Log::warning("Could not resolve timezone: '{$searchTerm}' - setting to null");
                            $prepared['timezone_id'] = null;
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve timezone: ' . $e->getMessage());
                        $prepared['timezone_id'] = null;
                    }
                }
            } else {
                $prepared['timezone_id'] = 1;
            }

            // Smart language_id lookup: if value is text, search by name/code
            if (in_array('language_id', $fillable) && !empty($prepared['language_id'])) {
                $languageValue = $prepared['language_id'];

                if (!is_numeric($languageValue)) {
                    try {
                        $searchTerm = trim((string) $languageValue);

                        // Try exact match first (name, name_ar, code, or iso_code)
                        $language = \App\Models\Language::where('name', $searchTerm)
                            ->orWhere('name_ar', $searchTerm)
                            ->orWhere('code', $searchTerm)
                            ->orWhere('iso_code', $searchTerm)
                            ->first();

                        // If not found, try partial match
                        if (!$language) {
                            $language = \App\Models\Language::where('name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                ->first();
                        }

                        if ($language) {
                            $prepared['language_id'] = $language->id;
                            Log::debug("Resolved language '{$searchTerm}' to ID: {$language->id} ({$language->name})");
                        } else {
                            Log::warning("Could not resolve language: '{$searchTerm}' - setting to null");
                            $prepared['language_id'] = null;
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve language: ' . $e->getMessage());
                        $prepared['language_id'] = null;
                    }
                }
            }

            // Smart currency_id lookup: if value is text, search by name/code
            if (in_array('currency_id', $fillable) && !empty($prepared['currency_id'])) {
                $currencyValue = $prepared['currency_id'];

                if (!is_numeric($currencyValue)) {
                    try {
                        $searchTerm = trim((string) $currencyValue);

                        // Try exact match first (name, name_ar, code, or symbol)
                        $currency = \App\Models\Currency::where('name', $searchTerm)
                            ->orWhere('name_ar', $searchTerm)
                            ->orWhere('code', $searchTerm)
                            ->orWhere('symbol', $searchTerm)
                            ->first();

                        // If not found, try partial match
                        if (!$currency) {
                            $currency = \App\Models\Currency::where('name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('code', 'LIKE', "%{$searchTerm}%")
                                ->first();
                        }

                        if ($currency) {
                            $prepared['currency_id'] = $currency->id ?? 138;
                            Log::debug("Resolved currency '{$searchTerm}' to ID: {$currency->id} ({$currency->name})");
                        } else {
                            Log::warning("Could not resolve currency: '{$searchTerm}' - setting to null");
                            $prepared['currency_id'] = 138;
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve currency: ' . $e->getMessage());
                        $prepared['currency_id'] = 138;
                    }
                }
            } else {
                $prepared['currency_id'] = 138;
            }

            // Smart type_id lookup: if value is text, search by name/code, or create if not found
            // Also supports 'type' column as alias for 'type_id'
            // Handles both numeric IDs and text names
            if (in_array('type_id', $fillable)) {
                // Check if type_id exists in prepared data, otherwise try 'type' column from Excel
                $typeValue = null;

                if (!empty($prepared['type_id'])) {
                    $typeValue = $prepared['type_id'];
                } else {
                    // Try to find 'type' column in cleaned data (Excel might have 'type' instead of 'type_id')
                    foreach ($headerMap as $normKey => $origKey) {
                        if ($normKey === 'type' && isset($cleaned[$origKey])) {
                            $typeValue = $cleaned[$origKey];
                            Log::debug("Using 'type' column value for type_id: {$typeValue}");
                            break;
                        }
                    }
                }

                // Process the type value if it exists
                if (!empty($typeValue)) {
                    // If it's numeric, use it as ID directly
                    if (is_numeric($typeValue)) {
                        $prepared['type_id'] = (int) $typeValue;
                        Log::debug("Using numeric type_id: {$typeValue}");
                    } else {
                        // If it's text, search for it in the database
                        try {
                            $searchTerm = trim((string) $typeValue);

                            // Try exact match first (name, name_ar)
                            $type = \App\Models\Type::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->first();

                            // If not found, try partial match
                            if (!$type) {
                                $type = \App\Models\Type::where('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                    ->first();
                            }

                            // If still not found, create new type
                            if (!$type) {
                                try {
                                    $type = \App\Models\Type::create(['name' => $searchTerm, 'name_ar' => $searchTerm]);
                                    Log::info("Created new type: '{$searchTerm}' with ID: {$type->id}");
                                } catch (\Throwable $createError) {
                                    Log::warning("Failed to create new type '{$searchTerm}': " . $createError->getMessage());
                                    $prepared['type_id'] = null;
                                }
                            }

                            if ($type) {
                                $prepared['type_id'] = $type->id;
                                Log::debug("Resolved type '{$searchTerm}' to ID: {$type->id} ({$type->name})");
                            } else {
                                Log::warning("Could not resolve or create type: '{$searchTerm}' - setting to null");
                                $prepared['type_id'] = null;
                            }
                        } catch (\Throwable $e) {
                            Log::warning('Failed to resolve type: ' . $e->getMessage());
                            $prepared['type_id'] = null;
                        }
                    }
                }
            }

            // Smart region_id lookup: if value is text, search by name
            if (in_array('region_id', $fillable) && !empty($prepared['region_id'])) {
                $regionValue = $prepared['region_id'];

                if (!is_numeric($regionValue)) {
                    try {
                        $searchTerm = trim((string) $regionValue);

                        $region = \App\Models\Region::where('name', $searchTerm)
                            ->orWhere('name_ar', $searchTerm)
                            ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                            ->first();

                        if ($region) {
                            $prepared['region_id'] = $region->id;
                            Log::debug("Resolved region '{$searchTerm}' to ID: {$region->id} ({$region->name})");
                        } else {
                            Log::warning("Could not resolve region: '{$searchTerm}' - setting to null");
                            $prepared['region_id'] = null;
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve region: ' . $e->getMessage());
                        $prepared['region_id'] = null;
                    }
                }
            }

            // Smart subregion_id lookup: if value is text, search by name
            if (in_array('subregion_id', $fillable) && !empty($prepared['subregion_id'])) {
                $subregionValue = $prepared['subregion_id'];

                if (!is_numeric($subregionValue)) {
                    try {
                        $searchTerm = trim((string) $subregionValue);

                        $subregion = \App\Models\Subregion::where('name', $searchTerm)
                            ->orWhere('name_ar', $searchTerm)
                            ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                            ->first();

                        if ($subregion) {
                            $prepared['subregion_id'] = $subregion->id;
                            Log::debug("Resolved subregion '{$searchTerm}' to ID: {$subregion->id} ({$subregion->name})");
                        } else {
                            Log::warning("Could not resolve subregion: '{$searchTerm}' - setting to null");
                            $prepared['subregion_id'] = null;
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve subregion: ' . $e->getMessage());
                        $prepared['subregion_id'] = null;
                    }
                }
            }

            $country = null;
            // Resolve country_id (text → id)
            if (in_array('country_id', $fillable) && !empty($prepared['country_id'])) {
                try {
                    $countryValue = $prepared['country_id'];

                    if (is_numeric($countryValue)) {
                        $country = \App\Models\Country::find($countryValue);
                    } else {
                        $searchTerm = trim((string) $countryValue);

                        $country = \App\Models\Country::query()
                            ->where('name', $searchTerm)
                            ->orWhere('name_ar', $searchTerm)
                            ->orWhere('iso2', $searchTerm)
                            ->orWhere('iso3', $searchTerm)
                            ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                            ->first();

                        if ($country) {
                            $prepared['country_id'] = $country->id;
                            Log::debug("Resolved country '{$searchTerm}' to ID {$country->id} ({$country->name})");
                        } else {
                            Log::warning("Could not resolve country '{$searchTerm}', setting country_id to null");
                            $prepared['country_id'] = null;
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('Country resolution failed: ' . $e->getMessage());
                    $prepared['country_id'] = null;
                }
            }

            // Auto-fill region & subregion from resolved country
            if ($country) {
                if (in_array('region_id', $fillable) && empty($prepared['region_id']) && $country->region_id) {
                    $prepared['region_id'] = $country->region_id;
                    Log::debug("Auto-filled region_id from country: {$country->region_id}");
                }

                if (in_array('subregion_id', $fillable) && empty($prepared['subregion_id']) && $country->subregion_id) {
                    $prepared['subregion_id'] = $country->subregion_id;
                    Log::debug("Auto-filled subregion_id from country: {$country->subregion_id}");
                }
            }

            // Auto-fill country_id and state_id from city if not provided
            if (!empty($prepared['city_id']) && is_numeric($prepared['city_id'])) {
                try {
                    $city = \App\Models\City::find($prepared['city_id']);

                    // If country_id is missing, get it from city
                    if (in_array('country_id', $fillable) && empty($prepared['country_id'])) {
                        if ($city && $city->country_id) {
                            $prepared['country_id'] = $city->country_id;
                            Log::debug("Auto-filled country_id from city: {$city->country_id}");
                        }
                    }

                    // If state_id is missing, get it from city
                    if (in_array('state_id', $fillable) && empty($prepared['state_id'])) {
                        if ($city && $city->state_id) {
                            $prepared['state_id'] = $city->state_id;
                            Log::debug("Auto-filled state_id from city: {$city->state_id}");
                        }
                    }
                } catch (\Throwable $e) {
                    Log::debug('Failed to auto-fill country/state from city: ' . $e->getMessage());
                }
            }

            // Auto-fill country_id from state if not provided (fallback)
            if (!empty($prepared['state_id']) && is_numeric($prepared['state_id']) && empty($prepared['country_id'])) {
                try {
                    if (in_array('country_id', $fillable)) {
                        $state = \App\Models\State::find($prepared['state_id']);
                        if ($state && $state->country_id) {
                            $prepared['country_id'] = $state->country_id;
                            Log::debug("Auto-filled country_id from state: {$state->country_id}");
                        }
                    }
                } catch (\Throwable $e) {
                    Log::debug('Failed to auto-fill country from state: ' . $e->getMessage());
                }
            }

            // Log first prepared row as sample
            if ($rowIndex === 0 || $totalRows === 1) {
                Log::debug('ImportDataJob sample prepared row: ' . json_encode($prepared));
            }

            // Coerce date-like columns (excel serial numbers or unparsable strings)
            foreach ($prepared as $kcol => $val) {
                if ($val === null)
                    continue;

                // Skip non-date columns that might be mistakenly identified as dates
                $skipColumns = ['price_type', 'contact_person', 'type', 'status', 'category'];
                if (in_array($kcol, $skipColumns)) {
                    continue;
                }

                if (isset($dateLikeColumns[$kcol])) {
                    // Excel serial numbers are integers (e.g. 44561)
                    if (is_numeric($val) && intval($val) == $val) {
                        try {
                            $serial = intval($val);
                            // Excel to Unix timestamp: ($serial - 25569) * 86400
                            $timestamp = ($serial - 25569) * 86400;
                            // guard against negative timestamps
                            if ($timestamp > 0) {
                                $prepared[$kcol] = \Carbon\Carbon::createFromTimestampUTC($timestamp)
                                    ->toDateTimeString();
                            } else {
                                $prepared[$kcol] = null;
                            }
                        } catch (\Throwable $e) {
                            $prepared[$kcol] = null;
                        }
                    } else {
                        // try parsing string dates robustly
                        try {
                            $prepared[$kcol] = \Carbon\Carbon::parse($val)
                                ->toDateTimeString();
                        } catch (\Throwable $e) {
                            // if parse fails, set null and log a debug entry
                            Log::debug("Failed to parse date for column {$kcol}: " . var_export($val, true));
                            $prepared[$kcol] = null;
                        }
                    }
                }
            }

            // Capture transportation company contact details for separate table
            if ($this->modelClass === \App\Models\TransportationCompany::class) {
                $contactRow = TransportationDataImporter::extractContactData($prepared, $cleaned);
                if (!empty($contactRow)) {
                    $this->pendingTransportationContacts[] = $contactRow;
                }
            }

            // prevent duplicate primary-key insertion (CSV might contain `id` column)
            try {
                $pk = $model->getKeyName();
                if (!empty($pk) && isset($prepared[$pk])) {
                    unset($prepared[$pk]);
                }
            } catch (\Throwable $_) {
                // ignore if model doesn't provide key name
            }


            // debug: log the resolved fillable columns and primary key
            try {
                $resolvedPk = null;
                try {
                    $resolvedPk = $model->getKeyName();
                } catch (\Throwable $_) {
                    $resolvedPk = null;
                }
                Log::debug('ImportDataJob resolved fillable: ' . implode(',', $fillable) . ' pk: ' . ($resolvedPk ?? 'NULL'));
            } catch (\Throwable $_) {
                // ignore logging failures
            }
            $buffer[] = $prepared;

            if (count($buffer) >= $this->chunkSize) {
                // defensive: remove any primary-key-like keys from buffer rows before insert
                $pk = null;
                try {
                    $pk = $model->getKeyName();
                } catch (\Throwable $_) {
                    $pk = null;
                }

                // Strong sanitization: only allow columns that are in $fillable
                // and always strip primary-key-like keys (id and model PK),
                // handling BOM/encoding/whitespace variants via normalization.
                $sanitized = [];
                // Ensure 'id' and model primary key are removed from allowed columns
                $normPkTmp = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
                $allowed = array_values(array_filter($fillable, function ($c) use ($normPkTmp) {
                    $norm = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $c)));
                    if ($norm === 'id')
                        return false;
                    if ($normPkTmp && $norm === $normPkTmp)
                        return false;
                    return true;
                }));
                $normPk = $normPkTmp;
                $normAllowed = [];
                foreach ($allowed as $a) {
                    $normAllowed[$a] = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $a)));
                }

                foreach ($buffer as $row) {
                    $filtered = [];
                    foreach ($row as $origKey => $value) {
                        $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));

                        // drop any primary key-like column (explicit id or model pk)
                        if ($normKey === 'id' || ($normPk && $normKey === $normPk)) {
                            continue;
                        }

                        // if the original key exactly matches an allowed column, keep it
                        if (in_array($origKey, $allowed, true)) {
                            $filtered[$origKey] = $value;
                            continue;
                        }

                        // otherwise try to match by normalized names to an allowed column
                        foreach ($normAllowed as $allowedOrig => $allowedNorm) {
                            if ($normKey === $allowedNorm) {
                                $filtered[$allowedOrig] = $value;
                                break;
                            }
                        }
                    }
                    $sanitized[] = $filtered;
                }

                try {
                    // debug: log the columns we will insert for verification
                    if (!empty($sanitized)) {
                        Log::debug('Inserting chunk columns: ' . implode(',', array_keys((array) $sanitized[0])));
                        Log::debug('Allowed columns for insert: ' . implode(',', $allowed));
                        // Build final rows using only allowed columns (prevent any unexpected keys)
                        $finalRows = [];
                        foreach ($sanitized as $sr) {
                            $rowBuilt = [];
                            foreach ($allowed as $col) {
                                if (array_key_exists($col, $sr)) {
                                    $rowBuilt[$col] = $sr[$col];
                                    continue;
                                }
                                // case-insensitive fallback
                                foreach ($sr as $k => $v) {
                                    if (mb_strtolower(trim((string) $k)) === mb_strtolower(trim((string) $col))) {
                                        $rowBuilt[$col] = $v;
                                        break;
                                    }
                                }
                            }
                            $finalRows[] = $rowBuilt;
                        }
                        Log::debug('Final rows count before insert: ' . count($finalRows));
                        if (!empty($finalRows)) {
                            Log::debug('Sample final row: ' . json_encode($finalRows[0]));
                        }
                    } else {
                        $finalRows = [];
                    }

                    // Use service for transportation companies to handle duplicates
                    if ($this->modelClass === \App\Models\TransportationCompany::class) {
                        $chunkUuidMap = null;
                        TransportationDataImporter::upsertCompanies($finalRows, $chunkUuidMap);
                        $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $chunkUuidMap ?? []);
                        $counter += count($finalRows);
                    } else {
                        $this->modelClass::insert($finalRows);
                        $counter += count($finalRows);
                    }
                } catch (\Throwable $e) {
                    Log::warning('Bulk insert failed, falling back to per-row inserts: ' . $e->getMessage());
                    // notify error
                    try {
                        Event::dispatch(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
                    } catch (\Throwable $_) {
                        Log::debug('Failed to dispatch data-storage error message: ' . $_->getMessage());
                    }
                    foreach ($sanitized as $r) {
                        try {
                            // Ensure single-row is filtered the same way as chunks
                            $filtered = [];
                            $normPkSingle = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
                            foreach ($r as $origKey => $value) {
                                $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));
                                if ($normKey === 'id' || ($normPkSingle && $normKey === $normPkSingle)) {
                                    continue;
                                }
                                if (in_array($origKey, $allowed ?? [], true)) {
                                    $filtered[$origKey] = $value;
                                    continue;
                                }
                                foreach ($normAllowed ?? [] as $allowedOrig => $allowedNorm) {
                                    if ($normKey === $allowedNorm) {
                                        $filtered[$allowedOrig] = $value;
                                        break;
                                    }
                                }
                            }
                            Log::debug('Inserting single row columns: ' . implode(',', array_keys((array) $filtered)));
                            if (!empty($filtered)) {
                                if ($this->modelClass === \App\Models\TransportationCompany::class) {
                                    $rowUuidMap = null;
                                    TransportationDataImporter::upsertCompanies([$filtered], $rowUuidMap);
                                    $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $rowUuidMap ?? []);
                                } else {
                                    $this->modelClass::insert([$filtered]);
                                }
                                $counter++;
                            }
                        } catch (\Throwable $er) {
                            Log::warning('Skipping failing row during import: ' . json_encode($r) . ' Error: ' . $er->getMessage());
                        }
                    }
                }

                // broadcast progress update (non-blocking)
                try {
                    Event::dispatch(new ImportExportCompleted(__('main.import_progress', ['count' => number_format($counter)]), $this->userId));
                } catch (\Throwable $e) {
                    Log::warning('Failed to broadcast progress: ' . $e->getMessage());
                }

                $buffer = [];
            }
        }

        // Final buffer handling for remaining rows
        // remaining
        if (!empty($buffer)) {
            // sanitize final buffer similar to chunk handling
            $pk = null;
            try {
                $pk = $model->getKeyName();
            } catch (\Throwable $_) {
                $pk = null;
            }

            // Strong sanitization for final buffer: same behavior as chunk handling
            $sanitized = [];
            // Ensure 'id' and model primary key are removed from allowed columns
            $normPkTmp = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
            $allowed = array_values(array_filter($fillable, function ($c) use ($normPkTmp) {
                $norm = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $c)));
                if ($norm === 'id')
                    return false;
                if ($normPkTmp && $norm === $normPkTmp)
                    return false;
                return true;
            }));
            $normPk = $normPkTmp;
            $normAllowed = [];
            foreach ($allowed as $a) {
                $normAllowed[$a] = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $a)));
            }

            foreach ($buffer as $row) {
                $filtered = [];
                foreach ($row as $origKey => $value) {
                    $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));
                    if ($normKey === 'id' || ($normPk && $normKey === $normPk)) {
                        continue;
                    }
                    if (in_array($origKey, $allowed, true)) {
                        $filtered[$origKey] = $value;
                        continue;
                    }
                    foreach ($normAllowed as $allowedOrig => $allowedNorm) {
                        if ($normKey === $allowedNorm) {
                            $filtered[$allowedOrig] = $value;
                            break;
                        }
                    }
                }
                $sanitized[] = $filtered;
            }

            try {
                // Build final rows using only allowed columns for the final chunk
                $finalRows = [];
                foreach ($sanitized as $sr) {
                    $rowBuilt = [];
                    foreach ($allowed as $col) {
                        if (array_key_exists($col, $sr)) {
                            $rowBuilt[$col] = $sr[$col];
                            continue;
                        }
                        foreach ($sr as $k => $v) {
                            if (mb_strtolower(trim((string) $k)) === mb_strtolower(trim((string) $col))) {
                                $rowBuilt[$col] = $v;
                                break;
                            }
                        }
                    }
                    $finalRows[] = $rowBuilt;
                }
                // if ($this->modelClass === \App\Models\TransportationCompany::class) {
                //     // $this->modelClass::updateOrCreate($finalRows);
                //     $this->modelClass::updateOrCreate(['name' => $type['name']], $finalRows);
                // } else {

                // Use service for transportation companies to handle duplicates
                if ($this->modelClass === \App\Models\TransportationCompany::class) {
                    $chunkUuidMap = null;
                    TransportationDataImporter::upsertCompanies($finalRows, $chunkUuidMap);
                    $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $chunkUuidMap ?? []);
                    $counter += count($finalRows);
                } else {
                    $this->modelClass::insert($finalRows);
                    $counter += count($finalRows);
                }
                // }
            } catch (\Throwable $e) {
                Log::warning('Bulk insert failed on final chunk, falling back to per-row inserts: ' . $e->getMessage());
                try {
                    Event::dispatch(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
                } catch (\Throwable $_) {
                    Log::debug('Failed to dispatch data-storage error message: ' . $_->getMessage());
                }
                foreach ($sanitized as $r) {
                    try {
                        // ensure no PK present (normalized check)
                        foreach (array_keys($r) as $k) {
                            $normKey = preg_replace('/[^a-z0-9_]/', '', strtolower(trim((string) $k)));
                            $normPk = $pk ? preg_replace('/[^a-z0-9_]/', '', strtolower(trim((string) $pk))) : null;
                            if ($normPk && $normKey === $normPk) {
                                unset($r[$k]);
                                continue;
                            }
                            if ($normKey === 'id') {
                                unset($r[$k]);
                                continue;
                            }
                        }
                        if ($this->modelClass === \App\Models\TransportationCompany::class) {
                            $rowUuidMap = null;
                            TransportationDataImporter::upsertCompanies([$r], $rowUuidMap);
                            $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $rowUuidMap ?? []);
                        } else {
                            $this->modelClass::insert([$r]);
                        }
                        $counter++;
                    } catch (\Throwable $er) {
                        Log::warning('Skipping failing row during import (final chunk): ' . json_encode($r) . ' Error: ' . $er->getMessage());
                    }
                }
            }
        }

        if ($this->modelClass === \App\Models\TransportationCompany::class) {
            TransportationDataImporter::processPendingContacts($this->pendingTransportationContacts, $this->transportationCompanyUuidMap);
            Log::debug('Transportation import completed: ' . count($this->transportationCompanyUuidMap) . ' UUID mappings, ' . count($this->pendingTransportationContacts) . ' contacts processed');
        }

        // Sync TourGuideType relationships (states and cities)
        if ($this->modelClass === \App\Models\TourGuideType::class) {
            $this->syncTourGuideTypeRelationships();
        }

        // Log summary
        Log::debug("ImportDataJob completed: Total rows read: {$totalRows}, Records inserted: {$counter}");

        // Auto-sync relationships after importing specific models
        // $this->syncRelationshipsAfterImport($model);

        // استخراج اسم الموديل بشكل أنظف
        $modelName = class_basename($this->modelClass);
        $modelNamePlural = \Illuminate\Support\Str::plural(strtolower($modelName));
        $modelNameAr = __('main.' . $modelNamePlural);

        // إرسال رسالة نجاح مفصلة
        $message = __('main.import_completed_successfully', [
            'model' => $modelNameAr,
            'count' => number_format($counter),
        ]);

        // في حالة عدم وجود ترجمة، استخدم رسالة افتراضية
        if (str_contains($message, 'main.import_completed_successfully')) {
            $message = "تم استيراد " . number_format($counter) . " سجل من {$modelNameAr} بنجاح!";
        }

        try {
            Event::dispatch(new ImportExportCompleted($message, $this->userId));
        } catch (\Throwable $e) {
            Log::warning('Failed to broadcast completion: ' . $e->getMessage());
        }
        // notify successful storage
        try {
            Event::dispatch(new DataStorageMessage('تم التخزين'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage success message: ' . $e->getMessage());
        }
    }

    protected function upsertTransportationCompanies(array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        try {
            // For transportation companies, use upsert based on name + country_id
            // This prevents duplicates with same name in same country
            foreach ($rows as $row) {
                // Build match criteria: name + country_id if country_id exists
                $matchCriteria = ['name' => $row['name'] ?? null];
                if (!empty($row['country_id'])) {
                    $matchCriteria['country_id'] = $row['country_id'];
                }

                // Filter out empty match criteria
                $matchCriteria = array_filter($matchCriteria, function ($v) {
                    return $v !== null && $v !== '';
                });

                if (empty($matchCriteria)) {
                    // If no match criteria, just insert
                    \App\Models\TransportationCompany::create($row);
                    continue;
                }

                // Prepare update data (exclude match criteria)
                $updateData = array_diff_key($row, $matchCriteria);

                // Use updateOrCreate to handle duplicates
                \App\Models\TransportationCompany::updateOrCreate(
                    $matchCriteria,
                    $updateData
                );

                Log::debug("Upserted transportation company with criteria: " . json_encode($matchCriteria));
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to upsert transportation companies: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Auto-sync many-to-many relationships after importing specific models
     */
    protected function syncRelationshipsAfterImport($model): void
    {
        try {
            $modelClass = get_class($model);
            $tableName = $model->getTable();

            // Handle Country model: sync states and cities based on country_id
            if ($modelClass === 'App\\Models\\Country' || $tableName === 'countries') {
                Log::info('Auto-syncing states and cities for imported countries...');

                $countries = \App\Models\Country::all();
                $syncedStates = 0;
                $syncedCities = 0;

                foreach ($countries as $country) {
                    // Sync states that belong to this country
                    $stateIds = \App\Models\State::where('country_id', $country->id)
                        ->pluck('id')
                        ->toArray();
                    if (!empty($stateIds)) {
                        $country->states()
                            ->sync($stateIds);
                        $syncedStates += count($stateIds);
                    }

                    // Sync cities that belong to states of this country
                    $cityIds = \App\Models\City::whereIn('state_id', $stateIds)
                        ->pluck('id')
                        ->toArray();
                    if (!empty($cityIds)) {
                        $country->cities()
                            ->sync($cityIds);
                        $syncedCities += count($cityIds);
                    }
                }

                Log::info("Auto-sync completed: {$syncedStates} states and {$syncedCities} cities synced to countries.");
            }

            // Add more model-specific sync logic here as needed
            // Example: if ($modelClass === 'App\\Models\\State') { ... }

        } catch (\Throwable $e) {
            Log::warning('Failed to auto-sync relationships: ' . $e->getMessage());
        }
    }

    /**
     * Sync TourGuideType states and cities from imported data
     */
    protected function syncTourGuideTypeRelationships(): void
    {
        try {
            if (empty($this->tourGuideTypePivotData)) {
                Log::info('No TourGuideType pivot data to sync.');
                return;
            }

            Log::info('Syncing TourGuideType states and cities from import...');

            $syncedStates = 0;
            $syncedCities = 0;

            // Get all tour guide types ordered by ID (should match import order)
            $allTypes = \App\Models\TourGuideType::orderBy('id')->get();

            foreach ($this->tourGuideTypePivotData as $pivotData) {
                // Find the TourGuideType by UUID, type name, or row index
                $type = null;

                if (!empty($pivotData['uuid'])) {
                    $type = \App\Models\TourGuideType::where('uuid', $pivotData['uuid'])->first();
                }

                if (!$type && !empty($pivotData['type'])) {
                    $type = \App\Models\TourGuideType::where('type', $pivotData['type'])->first();
                }

                // Fallback: use row index to match (since records are inserted in order)
                if (!$type && isset($pivotData['row_index'])) {
                    $index = $pivotData['row_index'] - 1; // Convert to 0-based index
                    if (isset($allTypes[$index])) {
                        $type = $allTypes[$index];
                        Log::debug("Matched TourGuideType by row index: {$index}");
                    }
                }

                if (!$type) {
                    Log::warning('Could not find TourGuideType for pivot sync: ' . json_encode($pivotData));
                    continue;
                }

                // Handle state_id
                if (!empty($pivotData['state_id'])) {
                    // Handle comma-separated IDs or single ID
                    $stateIds = is_string($pivotData['state_id'])
                        ? array_filter(array_map('trim', explode(',', $pivotData['state_id'])))
                        : [$pivotData['state_id']];
                    $stateIds = array_filter($stateIds, 'is_numeric');

                    if (!empty($stateIds)) {
                        $type->states()->sync($stateIds);
                        $syncedStates += count($stateIds);
                        Log::debug("Synced " . count($stateIds) . " states (" . implode(',', $stateIds) . ") for TourGuideType ID: {$type->id}, Type: {$type->type}");
                    }
                }

                // Handle city_id
                if (!empty($pivotData['city_id'])) {
                    // Handle comma-separated IDs or single ID
                    $cityIds = is_string($pivotData['city_id'])
                        ? array_filter(array_map('trim', explode(',', $pivotData['city_id'])))
                        : [$pivotData['city_id']];
                    $cityIds = array_filter($cityIds, 'is_numeric');

                    if (!empty($cityIds)) {
                        $type->cities()->sync($cityIds);
                        $syncedCities += count($cityIds);
                        Log::debug("Synced " . count($cityIds) . " cities (" . implode(',', $cityIds) . ") for TourGuideType ID: {$type->id}, Type: {$type->type}");
                    }
                }
            }

            Log::info("TourGuideType sync completed: {$syncedStates} state relationships and {$syncedCities} city relationships synced.");
        } catch (\Throwable $e) {
            Log::warning('Failed to sync TourGuideType relationships: ' . $e->getMessage());
            Log::warning('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
