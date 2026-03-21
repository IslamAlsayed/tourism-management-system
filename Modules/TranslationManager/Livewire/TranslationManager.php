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

class TranslationManager extends Component
{
    use WithPagination, WithFileUploads;

    public $perPage = 15;
    
    public $importFile;

    public $selectedFile = 'main';

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

    protected $listeners = ['refreshTranslations' => 'loadTranslations'];

    public function mount()
    {
        $this->discoverFiles();
        $this->discoverLocales();
        $this->loadTranslations();
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
        if (str_starts_with($fileString, 'global::')) {
            $name = str_replace('global::', '', $fileString);
            return resource_path("lang/{$locale}/{$name}.php");
        }

        // Module file
        $parts = explode('::', $fileString);
        if (count($parts) === 2) {
            $moduleName = $parts[0];
            $fileName = $parts[1];
            return base_path("Modules/{$moduleName}/Resources/lang/{$locale}/{$fileName}.php");
        }

        // Fallback
        return resource_path("lang/{$locale}/{$fileString}.php");
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
        $enFile = $this->resolveFilePath('en', $this->selectedFile);
        $targetFile = $this->resolveFilePath($this->selectedLocale, $this->selectedFile);

        $this->referenceTranslations = File::exists($enFile) ? (include $enFile) : [];
        $targetTranslations = File::exists($targetFile) ? (include $targetFile) : [];

        // Flatten nested arrays
        $this->referenceTranslations = $this->flattenArray($this->referenceTranslations);
        $targetTranslations = $this->flattenArray($targetTranslations);

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
        $this->editingValue = $this->translations[$key] ?? '';
    }

    public function saveTranslation()
    {
        if (! $this->editingKey) {
            return;
        }

        $targetFile = $this->resolveFilePath($this->selectedLocale, $this->selectedFile);

        // Read existing file
        $existing = File::exists($targetFile) ? (include $targetFile) : [];

        // Update the specific key (support nested keys with dot notation)
        $this->setNestedValue($existing, $this->editingKey, $this->editingValue);

        // Write back
        $this->writeTranslationFile($targetFile, $existing);

        // Update local state
        $this->translations[$this->editingKey] = $this->editingValue;
        $this->editingKey = null;
        $this->editingValue = '';

        // Recalculate stats
        $total = count($this->referenceTranslations);
        $translated = count(array_filter($this->translations, fn ($v) => $v !== '' && $v !== null));
        $hasSuggestions = \Modules\TranslationManager\Entities\TranslationSuggestion::where('status', 'pending')
                    ->where('file', $this->selectedFile)
                    ->where('locale', $this->selectedLocale)
                    ->count();
        $this->stats = [
            'total' => $total,
            'translated' => $translated,
            'missing' => $total - $translated,
            'has_suggestions' => $hasSuggestions,
            'percentage' => $total > 0 ? round(($translated / $total) * 100, 1) : 0,
        ];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('Saved successfully'),
        ]);
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

        $enFile = $this->resolveFilePath('en', $this->selectedFile);
        $existing = File::exists($enFile) ? (include $enFile) : [];

        // Save to English (Reference)
        $this->setNestedValue($existing, $this->newKeyName, $this->newKeyValue);
        $this->writeTranslationFile($enFile, $existing);

        $this->newKeyName = '';
        $this->newKeyValue = '';
        
        $this->loadTranslations();
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('New translation text added successfully!'),
        ]);
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
        $suggestion = TranslationSuggestion::findOrFail($id);

        // Apply the translation
        $targetFile = $this->resolveFilePath($suggestion->locale, $suggestion->file);
        $existing = File::exists($targetFile) ? (include $targetFile) : [];
        $this->setNestedValue($existing, $suggestion->key, $suggestion->suggested_value);
        $this->writeTranslationFile($targetFile, $existing);

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
        $stats = [];
        $enFile = $this->resolveFilePath('en', $this->selectedFile);
        $enTranslations = File::exists($enFile) ? $this->flattenArray(include $enFile) : [];
        $total = count($enTranslations);

        foreach ($this->availableLocales as $code => $name) {
            $targetFile = $this->resolveFilePath($code, $this->selectedFile);
            $targetTranslations = File::exists($targetFile) ? $this->flattenArray(include $targetFile) : [];

            $translated = 0;
            foreach ($enTranslations as $key => $val) {
                if (isset($targetTranslations[$key]) && $targetTranslations[$key] !== '' && $targetTranslations[$key] !== null) {
                    $translated++;
                }
            }

            $stats[$code] = [
                'name' => $name,
                'photo' => $this->localePhotos[$code] ?? null,
                'total' => $total,
                'translated' => $translated,
                'missing' => $total - $translated,
                'percentage' => $total > 0 ? round(($translated / $total) * 100, 1) : 0,
            ];
        }

        return $stats;
    }

    private function flattenArray($array, $prefix = '')
    {
        $result = [];
        foreach ($array as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    private function setNestedValue(&$array, $key, $value)
    {
        $keys = explode('.', $key);
        $current = &$array;

        foreach ($keys as $k) {
            if (! isset($current[$k]) || ! is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }

        $current = $value;
    }

    private function writeTranslationFile($path, $data)
    {
        $dir = dirname($path);
        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $content = "<?php\n\nreturn ".$this->arrayToString($data).";\n";
        File::put($path, $content);
    }

    private function arrayToString($array, $indent = 1)
    {
        $pad = str_repeat('    ', $indent);
        $padClose = str_repeat('    ', $indent - 1);
        $lines = [];

        foreach ($array as $key => $value) {
            $escapedKey = str_replace("'", "\\'", $key);
            if (is_array($value)) {
                $lines[] = "{$pad}'{$escapedKey}' => ".$this->arrayToString($value, $indent + 1).',';
            } else {
                $escapedValue = str_replace("'", "\\'", $value ?? '');
                $lines[] = "{$pad}'{$escapedKey}' => '{$escapedValue}',";
            }
        }

        return "[\n".implode("\n", $lines)."\n{$padClose}]";
    }

    public function exportCSV()
    {
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
        
        $callback = function() use($translations, $reference) {
            $file = fopen('php://output', 'w');
            // Add BOM for proper Excel UTF-8 reading
            fputs($file, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($file, ['Key', 'English', 'Translation']);
            
            foreach ($translations as $key => $targetValue) {
                $enValue = $reference[$key] ?? '';
                fputcsv($file, [$key, $enValue, $targetValue]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
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

        // Apply search filter
        if ($this->search) {
            $search = mb_strtolower($this->search);
            $items = array_filter($items, function ($value, $key) use ($search) {
                $enValue = $this->referenceTranslations[$key] ?? '';
                return str_contains(mb_strtolower($key), $search)
                    || str_contains(mb_strtolower($enValue), $search)
                    || str_contains(mb_strtolower($value), $search);
            }, ARRAY_FILTER_USE_BOTH);
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
        ])->layout('layouts.master');
    }
}
