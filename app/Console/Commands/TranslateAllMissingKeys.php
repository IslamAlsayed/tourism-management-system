<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class TranslateAllMissingKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:missing
                            {--key= : The Gemini API Key (required)}
                            {--locales=ar,es,it,fr,de,he,ru,tr,ja : Comma-separated list of target locales}
                            {--force : Force translation of all keys, even if they already exist}
                            {--file= : Specific file to translate (e.g. "global::auth" or "Core::messages")}';

    /**
     * The console command-description.
     *
     * @var string
     */
    protected $description = 'Translates missing locale keys using Gemini AI with a professional tourism context';

    protected $apiKey;
    protected $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->apiKey = $this->option('key');

        if (!$this->apiKey) {
            $this->error('Please provide a Gemini API Key using --key=YOUR_API_KEY');
            return 1;
        }

        $locales = explode(',', $this->option('locales'));
        $targetFile = $this->option('file');
        $force = $this->option('force');

        $this->info("Starting intelligent translation process for: " . implode(', ', $locales));
        if ($force) {
            $this->warn("FORCE MODE ENABLED. This will overwrite existing translations.");
            if (!$this->confirm('Are you sure you want to overwrite existing translations?')) {
                return 0;
            }
        }

        $allEnglishFiles = $this->discoverEnglishFiles();

        if ($targetFile) {
            $allEnglishFiles = array_filter($allEnglishFiles, fn($f) => $f['name'] === $targetFile);
            if (empty($allEnglishFiles)) {
                $this->error("File '$targetFile' not found.");
                return 1;
            }
        }

        foreach ($locales as $locale) {
            $locale = trim($locale);
            $this->info("\n=============================================");
            $this->info("Processing Locale: [" . strtoupper($locale) . "]");
            $this->info("=============================================");

            foreach ($allEnglishFiles as $enFile) {
                $this->line("Reading English file: {$enFile['name']}");
                
                $enData = File::exists($enFile['path']) ? (include $enFile['path']) : [];
                if (empty($enData)) {
                    continue;
                }

                $targetPath = $this->resolveFilePath($locale, $enFile['name']);
                $targetData = File::exists($targetPath) ? (include $targetPath) : [];

                // Flatten both to easily find missing keys
                $flatEn = $this->flattenArray($enData);
                $flatTarget = $this->flattenArray($targetData);

                $missingTranslations = [];

                foreach ($flatEn as $key => $enValue) {
                    // Skip if value is empty
                    if (trim($enValue) === '') continue;

                    if ($force || !isset($flatTarget[$key]) || trim($flatTarget[$key]) === '') {
                        $missingTranslations[$key] = $enValue;
                    }
                }

                if (empty($missingTranslations)) {
                    $this->line(" ✓ No missing translations found for {$enFile['name']} in {$locale}. Skipping.");
                    continue;
                }

                $this->info(" Found " . count($missingTranslations) . " missing keys in {$enFile['name']}. Sending to AI...");

                // Chunking to avoid hitting API token limits (Translating 50 keys at a time)
                $chunks = array_chunk($missingTranslations, 50, true);
                
                $totalChunks = count($chunks);
                $currentChunk = 1;

                $hasChanges = false;
                foreach ($chunks as $chunk) {
                    $this->line("   -> Translating chunk {$currentChunk}/{$totalChunks}...");
                    $translatedChunk = $this->translateWithGemini($chunk, $locale);
                    
                    if ($translatedChunk) {
                        foreach ($translatedChunk as $key => $translatedValue) {
                            $this->setNestedValue($targetData, $key, $translatedValue);
                            $hasChanges = true;
                        }
                    } else {
                        $this->error("   ! Failed to translate chunk {$currentChunk}. API error or unparseable response.");
                    }
                    $currentChunk++;
                    
                    // Small delay to respect rate limits (15 RPM max)
                    sleep(5);
                }

                if ($hasChanges) {
                    $this->writeTranslationFile($targetPath, $targetData);
                    $this->info(" ✓ Saved translated file: {$targetPath}");
                }
            }
        }

        $this->info("\n🎉 Translation completely finished!");
        return 0;
    }

    /**
     * Communicates with Gemini API indicating a pure professional tourism context.
     */
    private function translateWithGemini(array $texts, string $targetLocale)
    {
        $apiKeys = explode(',', $this->apiKey);
        $totalKeys = count($apiKeys);

        // Language specifics for better context
        $localeNames = [
            'ar' => 'Arabic',
            'es' => 'Spanish',
            'it' => 'Italian',
            'fr' => 'French',
            'de' => 'German',
            'he' => 'Hebrew',
            'ru' => 'Russian',
            'tr' => 'Turkish',
            'ja' => 'Japanese',
            'en' => 'English'
        ];

        $targetName = $localeNames[$targetLocale] ?? $targetLocale;

        // Ensure JSON keys are highly unique to avoid AI stripping them out
        $jsonPayload = json_encode($texts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $prompt = <<<EOT
You are an expert, professional translator specializing in exact localization for an enterprise Tourism and Travel Management System database (MixJo).
Your task is to translate a map of English keys to {$targetName} values.

Rules:
1. Translating into: {$targetName}.
2. Context: High-end professional tourism, travel management, system dashboard, booking systems, CRM, UI labels. Avoid street slang or overly literal casual translations. Use correct business and UX terminology for {$targetName}.
3. Variables: Keep Laravel variables exactly as they are without translating them (e.g. :name, :attribute, {amount}). Do NOT touch words starting with ":" or inside "{}".
4. HTML/Formatting: Preserve any HTML tags exactly (like <strong>, <br>).
5. Format: You MUST return ONLY a valid JSON object matching the exact keys provided, where values are the {$targetName} translations. Do not wrap in Markdown blocks like ```json. Do not include any explanations. ONLY return the raw JSON braces.

Input JSON:
{$jsonPayload}
EOT;
        
        // Pick a key based on a global static counter or random
        static $keyIndex = 0;
        $currentApiKey = trim($apiKeys[$keyIndex % $totalKeys]);
        $keyIndex++;

        $response = Http::timeout(60)->post($this->geminiUrl . '?key=' . $currentApiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.1, // Keep it professional and deterministic
                'topK' => 1,
                'topP' => 1,
                'responseMimeType' => 'application/json',
            ],
        ]);

        if ($response->failed()) {
            $this->error('Gemini API Request Failed: ' . $response->body());
            return null;
        }

        $result = $response->json();
        
        $textResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        // Clean up markdown just in case the AI ignores the "raw JSON" instruction
        $textResponse = preg_replace('/```json/i', '', $textResponse);
        $textResponse = preg_replace('/```/i', '', $textResponse);
        $textResponse = trim($textResponse);

        $decoded = json_decode($textResponse, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Gemini API returned invalid JSON: ' . json_last_error_msg());
            $this->line("Raw Response: \n" . substr($textResponse, 0, 500) . "...");
            return null;
        }

        return $decoded;
    }


    private function discoverEnglishFiles()
    {
        $files = [];

        // Global files
        $enPath = resource_path('lang/en');
        if (File::isDirectory($enPath)) {
            foreach (File::files($enPath) as $file) {
                if ($file->getExtension() === 'php') {
                    $files[] = [
                        'name' => 'global::' . $file->getFilenameWithoutExtension(),
                        'path' => $file->getPathname()
                    ];
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
                            $files[] = [
                                'name' => $moduleName . '::' . $file->getFilenameWithoutExtension(),
                                'path' => $file->getPathname()
                            ];
                        }
                    }
                }
            }
        }

        return $files;
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

        return resource_path("lang/{$locale}/{$fileString}.php");
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

        $content = "<?php\n\nreturn " . $this->arrayToString($data) . ";\n";
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
                $lines[] = "{$pad}'{$escapedKey}' => " . $this->arrayToString($value, $indent + 1) . ',';
            } else {
                $escapedValue = str_replace("'", "\\'", $value ?? '');
                $lines[] = "{$pad}'{$escapedKey}' => '{$escapedValue}',";
            }
        }

        return "[\n" . implode("\n", $lines) . "\n{$padClose}]";
    }
}
