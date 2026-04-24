<?php

namespace Modules\TranslationManager\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Modules\Core\Entities\User;
use Modules\Localization\Entities\SystemLanguage;
use Modules\TranslationManager\Entities\TranslationSuggestion;
use Modules\TranslationManager\Mail\TranslationSuggestionMail;
use Modules\TranslationManager\Services\TranslationService;

class TranslationManager extends Component
{
    use WithPagination, WithFileUploads;

    protected function ts(): TranslationService
    {
        return app(TranslationService::class);
    }

    public $perPage = 15;
    
    public $importFile;

    public $selectedFile = 'global::main';

    public $selectedLocale = 'ar';

    public $search = '';

    public $filterMode = 'all'; // all, missing, translated

    public $translations = [];

    public $referenceTranslations = [];

    public $editingKey = null;

    public $editingValue = '';

    public $availableFiles = [];

    public $availableLocales = [];
    
    public $localePhotos = [];

    public $stats = [];

    // Suggestion properties
    public $showSuggestionModal = false;

    public $suggestionKey = '';

    public $suggestionValue = '';

    public $suggestionReason = '';

    public $suggestionCurrentValue = '';

    // Advanced Super Admin Controls
    public $newKeyName = '';
    public $newKeyValue = '';

    // Review properties (super admin)
    public $showReviewPanel = false;

    public $pendingSuggestions = [];
    public $historySuggestions = [];

    public $reviewNote = '';
    
    public $showKeyColumn = false;

    // Standard components.columns properties (must match CustomColumnsLivewireLegacy interface)
    public string $modelClass = '';
    public $selectedIds = [];
    public $selectAll = false;
    public array $allColumns = ['key', 'english', 'translation', 'status', 'suggest'];
    public array $columns = ['key', 'english', 'translation', 'status', 'suggest'];
    public array $pendingColumns = ['key', 'english', 'translation', 'status', 'suggest'];
    public bool $hasCustomColumns = false;
    
    public $editingSuggestedValues = [];

    protected $listeners = ['refreshTranslations' => 'loadTranslations'];

    public function mount()
    {
        $this->discoverFiles();
        $this->discoverLocales();
        $this->loadTranslations();
    }

    // ═══════════ Column Management Methods (required by components.columns) ═══════════

    public function applyColumns()
    {
        $this->columns = array_values(array_intersect($this->pendingColumns, $this->allColumns));
        $this->dispatch('close-modal');
    }

    public function resetColumns(): void
    {
        $this->columns = $this->allColumns;
        $this->pendingColumns = $this->allColumns;
    }

    public function toggleAll(): void
    {
        if (count($this->pendingColumns) === count($this->allColumns)) {
            $this->pendingColumns = array_slice($this->allColumns, 0, 3);
        } else {
            $this->pendingColumns = $this->allColumns;
        }
        $this->applyColumns();
    }

    public function clearAllColumns(): void
    {
        $this->pendingColumns = ['key', 'translation'];
        $this->applyColumns();
    }

    public function updatedPendingColumns(): void
    {
        $this->pendingColumns = array_values(array_intersect($this->pendingColumns, $this->allColumns));
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $items = $this->translations;
            // Apply current filters to select only visible items
            if ($this->filterMode === 'missing') {
                $items = array_filter($items, fn ($v) => $v === '' || $v === null);
            } elseif ($this->filterMode === 'translated') {
                $items = array_filter($items, fn ($v) => $v !== '' && $v !== null);
            }
            $this->selectedIds = array_keys($items);
        } else {
            $this->selectedIds = [];
        }
    }

    public function discoverFiles()
    {
        $files = [];

        // Global files
        $enPath = resource_path('lang/en');
        if (File::isDirectory($enPath)) {
            foreach (File::files($enPath) as $file) {
                if ($file->getExtension() === 'php') {
                    $files[] = 'global::' . $file->getFilenameWithoutExtension();
                }
            }
        }

        // Module files
        $modulesPath = base_path('Modules');
        if (File::isDirectory($modulesPath)) {
            foreach (File::directories($modulesPath) as $moduleDir) {
                $moduleName = basename($moduleDir);
                $moduleLangPath = $moduleDir . '/Resources/lang/en';
                
                if (File::isDirectory($moduleLangPath)) {
                    foreach (File::files($moduleLangPath) as $file) {
                        if ($file->getExtension() === 'php') {
                            $files[] = $moduleName . '::' . $file->getFilenameWithoutExtension();
                        }
                    }
                }
            }
        }

        $this->availableFiles = collect($files)->sort()->values()->toArray();

        // Ensure a valid selection
        if (!in_array($this->selectedFile, $this->availableFiles) && count($this->availableFiles) > 0) {
            $this->selectedFile = $this->availableFiles[0];
        }
    }

    private function resolveFilePath($locale, $fileString)
    {
        return $this->ts()->resolveFilePath($locale, $fileString);
    }

    public function discoverLocales()
    {
        $langPath = resource_path('lang');
        $dirs = File::directories($langPath);
        
        $orderedLocales = [];
        foreach ($dirs as $dir) {
            $code = basename($dir);
            $lang = SystemLanguage::where('code', $code)->first();
            
            $orderedLocales[] = [
                'code' => $code,
                'native' => $lang ? ($lang->native ?? $lang->name) : strtoupper($code),
                'photo' => $lang ? $lang->photo : null,
                'sort_order' => $lang ? $lang->sort_order : 999
            ];
        }
        
        usort($orderedLocales, fn($a, $b) => $a['sort_order'] <=> $b['sort_order']);
        
        $this->availableLocales = [];
        $this->localePhotos = [];
        foreach ($orderedLocales as $loc) {
            $this->availableLocales[$loc['code']] = $loc['native'];
            $this->localePhotos[$loc['code']] = $loc['photo'];
        }
        
        // Ensure current locale is valid fallback
        if (!isset($this->availableLocales[$this->selectedLocale])) {
            $this->selectedLocale = array_key_first($this->availableLocales) ?: 'en';
        }
    }

    public function updatedSelectedFile()
    {
        $this->resetPage();
        $this->loadTranslations();
    }

    public function updatedSelectedLocale()
    {
        $this->resetPage();
        $this->loadTranslations();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterMode()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function loadTranslations()
    {
        $this->referenceTranslations = $this->ts()->getFlattenedTranslations('en', $this->selectedFile);
        $targetTranslations = $this->ts()->getFlattenedTranslations($this->selectedLocale, $this->selectedFile);

        // Merge: all English keys with their target values
        $this->translations = [];
        foreach ($this->referenceTranslations as $key => $enValue) {
            $this->translations[$key] = $targetTranslations[$key] ?? '';
        }

        // Calculate stats
        $total = count($this->referenceTranslations);
        $translated = count(array_filter($this->translations, fn ($v) => $v !== '' && $v !== null));
        $missing = $total - $translated;
        $hasSuggestions = \Modules\TranslationManager\Entities\TranslationSuggestion::where('status', 'pending')
                    ->where('file', $this->selectedFile)
                    ->where('locale', $this->selectedLocale)
                    ->count();

        $this->stats = [
            'total' => $total,
            'translated' => $translated,
            'missing' => $missing,
            'has_suggestions' => $hasSuggestions,
            'percentage' => $total > 0 ? round(($translated / $total) * 100, 1) : 0,
        ];
    }

    // Removed getFilteredTranslationsProperty for manual pagination inside render

    public function startEditing($key)
    {
        $this->editingKey = $key;
        if (str_contains($key, '|||')) {
            $parts = explode('|||', $key, 2);
            $file = $parts[0];
            $actualKey = $parts[1];
            
            $existing = $this->ts()->getFlattenedTranslations($this->selectedLocale, $file);
            $this->editingValue = $existing[$actualKey] ?? '';
        } else {
            $this->editingValue = $this->translations[$key] ?? '';
        }
    }

    public function saveTranslation()
    {
        if (! $this->editingKey) {
            return;
        }

        $file = $this->selectedFile;
        $actualKey = $this->editingKey;

        if (str_contains($this->editingKey, '|||')) {
            $parts = explode('|||', $this->editingKey, 2);
            $file = $parts[0];
            $actualKey = $parts[1];
        }

        try {
            $this->ts()->saveTranslation($this->selectedLocale, $file, $actualKey, $this->editingValue);

            // Update local state if the file is the currently selected file
            if ($file === $this->selectedFile) {
                $this->translations[$actualKey] = $this->editingValue;
                
                // Recalculate stats
                $total = count($this->referenceTranslations);
                $translated = count(array_filter($this->translations, fn ($v) => $v !== '' && $v !== null));
                $this->stats['translated'] = $translated;
                $this->stats['missing'] = $total - $translated;
                $this->stats['percentage'] = $total > 0 ? round(($translated / $total) * 100, 1) : 0;
            }

            $this->editingKey = null;
            $this->editingValue = '';

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('Saved successfully'),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("TranslationManager: Failed to save translation.", ['error' => $e->getMessage()]);
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('Failed to save translation.'),
            ]);
        }
    }

    public function cancelEditing()
    {
        $this->editingKey = null;
        $this->editingValue = '';
    }

    // =============== SUPER ADMIN / MANUAL ADDITIONS ===============

    public function saveNewKey()
    {
        $this->validate([
            'newKeyName' => 'required|string|regex:/^[a-zA-Z0-9_\-\.]+$/',
            'newKeyValue' => 'required|string',
        ]);

        try {
            $this->ts()->saveTranslation('en', $this->selectedFile, $this->newKeyName, $this->newKeyValue);

            $this->newKeyName = '';
            $this->newKeyValue = '';
            
            $this->loadTranslations();
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('New translation text added successfully!'),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("TranslationManager: Failed to save new key.", ['error' => $e->getMessage()]);
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('Failed to add new text.'),
            ]);
        }
    }

    public function scanProjectMissingKeys()
    {
        $paths = [resource_path('views'), app_path(), base_path('routes')];
        $allKeys = [];

        foreach ($paths as $path) {
            if (!File::isDirectory($path)) continue;
            
            $files = File::allFiles($path);
            foreach ($files as $file) {
                if ($file->getExtension() !== 'php') continue;
                $content = file_get_contents($file->getPathname());
                // Match __('string') or trans('string')
                preg_match_all("/(?:__|trans)\(['\"]([^'\"]+)['\"]\)/", $content, $matches);
                if (!empty($matches[1])) {
                    $allKeys = array_merge($allKeys, $matches[1]);
                }
                // Match @lang('string')
                preg_match_all("/@lang\(['\"]([^'\"]+)['\"]\)/", $content, $matches);
                if (!empty($matches[1])) {
                    $allKeys = array_merge($allKeys, $matches[1]);
                }
            }
        }

        $allKeys = array_unique($allKeys);

        // Append missing ones to 'messages' as default fallback fallback if not existing in the current loaded file
        $enFile = $this->resolveFilePath('en', $this->selectedFile);
        $existing = File::exists($enFile) ? (include $enFile) : [];
        
        // We need a completely flat list of absolutely everything we have in en/ to avoid duplicating keys the dev put elsewhere
        $globalExisting = [];
        foreach ($this->availableFiles as $f) {
            $fPath = $this->resolveFilePath('en', $f);
            if (File::exists($fPath)) {
                $globalExisting = array_merge($globalExisting, $this->flattenArray(include $fPath));
            }
        }

        $addedCounter = 0;
        foreach ($allKeys as $key) {
            if (!isset($globalExisting[$key])) {
                // Not found anywhere! Add to currently selected file
                $this->setNestedValue($existing, $key, $key); // English text defaults to exactly the key name
                $addedCounter++;
            }
        }

        if ($addedCounter > 0) {
            $this->writeTranslationFile($enFile, $existing);
            $this->loadTranslations();
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __("Auto-Scan Complete! Found and instantly added {$addedCounter} new missing core texts."),
            ]);
        } else {
            $this->dispatch('show-toast', [
                'type' => 'info',
                'message' => __('Scan complete. No missing codes found!'),
            ]);
        }
    }

    // =============== SUGGESTION METHODS ===============

    public function openSuggestionModal($key)
    {
        $this->suggestionKey = $key;
        $this->suggestionCurrentValue = $this->translations[$key] ?? '';
        $this->suggestionValue = '';
        $this->suggestionReason = '';
        $this->showSuggestionModal = true;
    }

    public function closeSuggestionModal()
    {
        $this->showSuggestionModal = false;
        $this->suggestionKey = '';
        $this->suggestionValue = '';
        $this->suggestionReason = '';
    }

    public function submitSuggestion()
    {
        $this->validate([
            'suggestionValue' => 'required|string|min:1',
        ]);

        try {
            $suggestion = TranslationSuggestion::create([
                'user_id' => Auth::id(),
                'locale' => $this->selectedLocale,
                'file' => $this->selectedFile,
                'key' => $this->suggestionKey,
                'current_value' => $this->suggestionCurrentValue,
                'suggested_value' => $this->suggestionValue,
                'reason' => $this->suggestionReason,
                'status' => 'pending',
            ]);

            // Send internal notification to all superadmins
            $superAdmins = User::where('role', 'superadmin')->get();
            foreach ($superAdmins as $admin) {
                Notification::createForUser(
                    'system',
                    "Translation suggestion for [{$this->selectedFile}.{$this->suggestionKey}] in ".strtoupper($this->selectedLocale).' by '.Auth::user()->name,
                    'Translation Suggestion',
                    [
                        'type' => 'translation_suggestion',
                        'suggestion_id' => $suggestion->id,
                        'file' => $this->selectedFile,
                        'key' => $this->suggestionKey,
                        'locale' => $this->selectedLocale,
                    ],
                    $admin->id
                );

                // Send email notification
                try {
                    if ($admin->email) {
                        Mail::to($admin->email)->queue(new TranslationSuggestionMail($suggestion));
                    }
                } catch (\Exception $e) {
                    // Silently fail email - notification is still created
                }
            }

            $this->closeSuggestionModal();
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('Suggestion submitted successfully! The admin will review it.'),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("TranslationManager: Failed to submit suggestion.", ['error' => $e->getMessage()]);
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('Failed to submit suggestion.'),
            ]);
        }
    }

    // =============== ADMIN REVIEW METHODS ===============

    public function toggleReviewPanel()
    {
        $this->showReviewPanel = ! $this->showReviewPanel;
        if ($this->showReviewPanel) {
            $this->loadPendingSuggestions();
            $this->loadHistorySuggestions();
        }
    }

    public function loadPendingSuggestions()
    {
        $this->pendingSuggestions = TranslationSuggestion::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->toArray();

        foreach ($this->pendingSuggestions as $s) {
            $this->editingSuggestedValues[$s['id']] = $this->editingSuggestedValues[$s['id']] ?? $s['suggested_value'];
        }
    }

    public function loadHistorySuggestions()
    {
        $this->historySuggestions = TranslationSuggestion::with('user')
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get()
            ->toArray();
    }

    public function clearSuggestionHistory()
    {
        TranslationSuggestion::whereIn('status', ['approved', 'rejected'])->delete();
        $this->loadHistorySuggestions();
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('Suggestion history cleared!'),
        ]);
    }

    public function approveSuggestion($id)
    {
        try {
            $suggestion = TranslationSuggestion::findOrFail($id);

            $finalValue = $this->editingSuggestedValues[$id] ?? $suggestion->suggested_value;

            // Apply the translation directly via TS
            $this->ts()->saveTranslation($suggestion->locale, $suggestion->file, $suggestion->key, $finalValue);

            // Update suggestion status
            $suggestion->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'review_note' => $this->reviewNote,
            ]);

            // Notify the user who submitted
            Notification::createForUser(
                'success',
                "Your translation suggestion for [{$suggestion->file}.{$suggestion->key}] has been approved!",
                'Translation Approved',
                ['suggestion_id' => $suggestion->id],
                $suggestion->user_id
            );

            $this->reviewNote = '';
            $this->loadPendingSuggestions();
            $this->loadHistorySuggestions();
            $this->loadTranslations();

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('Suggestion approved and translation updated!'),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("TranslationManager: Failed to approve suggestion.", ['error' => $e->getMessage()]);
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('Failed to approve suggestion and save file.'),
            ]);
        }
    }

    public function rejectSuggestion($id)
    {
        $suggestion = TranslationSuggestion::findOrFail($id);

        $suggestion->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_note' => $this->reviewNote,
        ]);

        // Notify the user who submitted
        Notification::createForUser(
            'warning',
            "Your translation suggestion for [{$suggestion->file}.{$suggestion->key}] was not accepted.".($this->reviewNote ? " Reason: {$this->reviewNote}" : ''),
            'Translation Rejected',
            ['suggestion_id' => $suggestion->id],
            $suggestion->user_id
        );

        $this->reviewNote = '';
        $this->loadPendingSuggestions();
        $this->loadHistorySuggestions();

        $this->dispatch('show-toast', [
            'type' => 'info',
            'message' => __('Suggestion rejected.'),
        ]);
    }

    public function getAllLocaleStats()
    {
        return \Illuminate\Support\Facades\Cache::remember('translation_manager_locale_stats', 60 * 60 * 24, function () {
            $stats = [];
            
            foreach ($this->availableLocales as $code => $name) {
                $stats[$code] = [
                    'name' => $name,
                    'photo' => $this->localePhotos[$code] ?? null,
                    'total' => 0,
                    'translated' => 0,
                    'missing' => 0,
                    'percentage' => 0,
                    'files' => []
                ];
            }

            foreach ($this->availableFiles as $file) {
                $enFile = $this->resolveFilePath('en', $file);
                $enTranslations = \Illuminate\Support\Facades\File::exists($enFile) ? $this->flattenArray(include $enFile) : [];
                $fileTotal = count($enTranslations);
                
                foreach ($this->availableLocales as $code => $name) {
                    $targetFile = $this->resolveFilePath($code, $file);
                    $targetTranslations = \Illuminate\Support\Facades\File::exists($targetFile) ? $this->flattenArray(include $targetFile) : [];
                    
                    $fileTranslated = 0;
                    foreach ($enTranslations as $key => $val) {
                        if (isset($targetTranslations[$key]) && $targetTranslations[$key] !== '' && $targetTranslations[$key] !== null) {
                            $fileTranslated++;
                        }
                    }
                    
                    $stats[$code]['total'] += $fileTotal;
                    $stats[$code]['translated'] += $fileTranslated;
                    $stats[$code]['missing'] += ($fileTotal - $fileTranslated);
                    
                    $filePercentage = $fileTotal > 0 ? round(($fileTranslated / $fileTotal) * 100, 1) : 0;
                    
                    $displayLabel = $file;
                    if (str_starts_with($file, 'global::')) {
                        $displayLabel = 'global / ' . str_replace('global::', '', $file);
                    } elseif (str_contains($file, '::')) {
                        $parts = explode('::', $file);
                        if(count($parts) === 2) {
                            $displayLabel = $parts[0] . ' / ' . $parts[1];
                        }
                    }
                    
                    $stats[$code]['files'][] = [
                        'name' => $displayLabel,
                        'key' => $file,
                        'total' => $fileTotal,
                        'translated' => $fileTranslated,
                        'percentage' => $filePercentage
                    ];
                }
            }

            foreach ($this->availableLocales as $code => $name) {
                $total = $stats[$code]['total'];
                $translated = $stats[$code]['translated'];
                $stats[$code]['percentage'] = $total > 0 ? round(($translated / $total) * 100, 1) : 0;
            }

            return $stats;
        });
    }

    private function flattenArray($array, $prefix = '')
    {
        return $this->ts()->flattenArray($array, $prefix);
    }

    private function setNestedValue(&$array, $key, $value)
    {
        $this->ts()->setNestedValue($array, $key, $value);
    }

    private function writeTranslationFile($path, $data)
    {
        $this->ts()->writeTranslationFile($path, $data);
        \Illuminate\Support\Facades\Cache::forget('translation_manager_locale_stats');
    }

    public function exportCSV()
    {
        $filename = "all_translations_{$this->selectedLocale}_{$this->selectedFile}.csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $translations = $this->translations;
        $reference = $this->referenceTranslations;
        
        $callback = function() use($translations, $reference) {
            $file = fopen('php://output', 'w');
            // Add BOM for proper Excel UTF-8 reading
            fputs($file, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($file, ['Key', 'English', 'Translation']);
            
            foreach ($translations as $key => $tr) {
                $enValue = $reference[$key] ?? '';
                fputcsv($file, [$key, $enValue, $tr]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportSelectedExcel($extension = 'xlsx')
    {
        $selectedIds = $this->selectedIds;
        $translations = $this->translations;
        
        if (empty($selectedIds)) {
            $selectedIds = array_keys($translations);
            if (empty($selectedIds)) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('No translations available to export.')]);
                return;
            }
        }

        $filename = "translations_{$this->selectedLocale}_{$this->selectedFile}.csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $translations = $this->translations;
        $reference = $this->referenceTranslations;
        $selectedIds = $this->selectedIds;
        
        $callback = function() use($translations, $reference, $selectedIds) {
            $file = fopen('php://output', 'w');
            // Add BOM for proper Excel UTF-8 reading
            fputs($file, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($file, ['Key', 'English', 'Translation']);
            
            foreach ($selectedIds as $key) {
                if (isset($translations[$key])) {
                    $enValue = $reference[$key] ?? '';
                    fputcsv($file, [$key, $enValue, $translations[$key]]);
                }
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportSelectedPDF()
    {
        $selectedIds = $this->selectedIds;
        $translations = $this->translations;
        $reference = $this->referenceTranslations;

        if (empty($selectedIds)) {
            $selectedIds = array_keys($translations);
            if (empty($selectedIds)) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('No translations available to export.')]);
                return;
            }
        }

        $rows = [];
        foreach ($selectedIds as $key) {
            if (isset($translations[$key])) {
                $enValue = $reference[$key] ?? '';
                $rows[] = [
                    'key' => $key,
                    'english' => $enValue,
                    'translation' => $translations[$key]
                ];
            }
        }

        if (count($rows) === 0) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => __('No valid translations found for the selected items.')]);
            return;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.generic_pdf', [
            'title' => __('Translations') . ' - ' . strtoupper($this->selectedLocale) . ' - ' . $this->selectedFile,
            'columns' => [
                'key' => __('Key'),
                'english' => __('English Reference'),
                'translation' => __('Translation')
            ],
            'rows' => collect($rows)->map(fn($r) => (object)$r),
        ])->setPaper('a4', 'portrait');

        $filename = "translations_{$this->selectedLocale}_{$this->selectedFile}.pdf";

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function exportSelectedTXT()
    {
        $selectedIds = $this->selectedIds;
        $translations = $this->translations;
        $reference = $this->referenceTranslations;

        if (empty($selectedIds)) {
            $selectedIds = array_keys($translations);
            if (empty($selectedIds)) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('No translations available to export.')]);
                return;
            }
        }

        $filename = "translations_{$this->selectedLocale}_{$this->selectedFile}.txt";
        
        $content = "";
        foreach ($selectedIds as $key) {
            if (isset($translations[$key])) {
                $enText = $reference[$key] ?? '';
                $trText = $translations[$key];
                $content .= "KEY: {$key}\n";
                $content .= "EN:  {$enText}\n";
                $content .= "TR:  {$trText}\n";
                $content .= str_repeat('-', 40) . "\n";
            }
        }
        
        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename, [
            "Content-type" => "text/plain; charset=UTF-8",
        ]);
    }

    public function exportSelectedJSON()
    {
        $selectedIds = $this->selectedIds;
        $translations = $this->translations;
        $reference = $this->referenceTranslations;

        if (empty($selectedIds)) {
            $selectedIds = array_keys($translations);
            if (empty($selectedIds)) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('No translations available to export.')]);
                return;
            }
        }

        $filename = "translations_{$this->selectedLocale}_{$this->selectedFile}.json";
        
        $data = [];
        foreach ($selectedIds as $key) {
            if (isset($translations[$key])) {
                $data[$key] = [
                    'english' => $reference[$key] ?? '',
                    'translation' => $translations[$key]
                ];
            }
        }
        
        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, [
            "Content-type" => "application/json; charset=UTF-8",
        ]);
    }

    public function importCSV()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:4096',
        ]);
        
        $path = $this->importFile->getRealPath();
        $file = fopen($path, 'r');
        
        // Skip BOM if exists
        $bom = fread($file, 3);
        if ($bom !== b"\xEF\xBB\xBF") {
            rewind($file);
        }
        
        $header = fgetcsv($file); // skip header
        
        $targetFile = $this->resolveFilePath($this->selectedLocale, $this->selectedFile);
        $existing = File::exists($targetFile) ? (include $targetFile) : [];
        
        $importedCount = 0;
        while ($row = fgetcsv($file)) {
            if (count($row) >= 3) {
                $key = $row[0];
                $translated = $row[2];
                if ($translated !== '') {
                    $this->setNestedValue($existing, $key, $translated);
                    $importedCount++;
                }
            }
        }
        fclose($file);
        
        $this->writeTranslationFile($targetFile, $existing);
        $this->loadTranslations();
        $this->importFile = null;
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('Successfully imported') . " {$importedCount} " . __('translations!'),
        ]);
    }

    public function render()
    {
        $items = $this->translations;
        $activeReference = $this->referenceTranslations;

        // Apply search filter
        if ($this->search) {
            $search = mb_strtolower($this->search);
            $items = [];
            $activeReference = [];
            
            foreach ($this->availableFiles as $file) {
                // Use cached flattened translations from the service instead of raw file reads
                $fileEnTrans = $this->ts()->getFlattenedTranslations('en', $file);
                $fileTrans = $this->ts()->getFlattenedTranslations($this->selectedLocale, $file);
                
                $allKeys = array_unique(array_merge(array_keys($fileEnTrans), array_keys($fileTrans)));
                
                foreach ($allKeys as $k) {
                    $enVal = $fileEnTrans[$k] ?? '';
                    $val = $fileTrans[$k] ?? '';
                    
                    if (str_contains(mb_strtolower($k), $search)
                        || str_contains(mb_strtolower($enVal), $search)
                        || str_contains(mb_strtolower($val), $search)) {
                        
                        $compositeKey = $file . '|||' . $k;
                        $items[$compositeKey] = $val;
                        $activeReference[$compositeKey] = $enVal;
                    }
                }
            }
        }

        // Apply filter mode
        if ($this->filterMode === 'missing') {
            $items = array_filter($items, fn ($v) => $v === '' || $v === null);
        } elseif ($this->filterMode === 'translated') {
            $items = array_filter($items, fn ($v) => $v !== '' && $v !== null);
        } elseif ($this->filterMode === 'has_suggestions') {
            $keysWithPending = \Modules\TranslationManager\Entities\TranslationSuggestion::where('status', 'pending')
                    ->where('file', $this->selectedFile)
                    ->where('locale', $this->selectedLocale)
                    ->pluck('key')->toArray();
            $items = array_filter($items, fn ($v, $k) => in_array($k, $keysWithPending), ARRAY_FILTER_USE_BOTH);
        }

        $page = method_exists($this, 'getPage') ? $this->getPage() : 1;
        $page = intval($page) ?: 1;
        $paginator = new LengthAwarePaginator(
            array_slice($items, ($page - 1) * $this->perPage, $this->perPage, true),
            count($items),
            $this->perPage,
            $page,
            ['path' => url()->current()]
        );

        return view('translationmanager::livewire.translation-manager', [
            'filteredTranslations' => $paginator,
            'localeStats' => $this->getAllLocaleStats(),
            'activeReference' => $activeReference,
        ])->layout('layouts.master');
    }
}
