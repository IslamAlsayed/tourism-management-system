<?php

namespace Modules\TranslationManager\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

class TranslationService
{
    /**
     * Resolve the absolute path to a translation file.
     *
     * @param string $locale
     * @param string $fileString
     * @return string
     */
    public function resolveFilePath(string $locale, string $fileString)
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

    /**
     * Flatten a multidimensional array into dot notation.
     *
     * @param array $array
     * @param string $prefix
     * @return array
     */
    public function flattenArray(array $array, string $prefix = '')
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $prefix . $key . '.'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }
        return $result;
    }

    /**
     * Get and flatten translations for a specific locale and file, with caching.
     * 
     * @param string $locale
     * @param string $file
     * @return array
     */
    public function getFlattenedTranslations(string $locale, string $file)
    {
        // Cache key specific to locale and file
        $cacheKey = "translations_flattened_{$locale}_{$file}";
        
        return Cache::remember($cacheKey, now()->addHours(24), function () use ($locale, $file) {
            try {
                $filePath = $this->resolveFilePath($locale, $file);
                $translations = File::exists($filePath) ? (include $filePath) : [];
                
                if (!is_array($translations)) {
                    $translations = [];
                }
                
                return $this->flattenArray($translations);
            } catch (\Exception $e) {
                Log::error("TranslationService: Failed to load or parse translation file", [
                    'locale' => $locale,
                    'file' => $file,
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    /**
     * Clear the cache for a specific translation file.
     * 
     * @param string $locale
     * @param string $file
     * @return void
     */
    public function clearCache(string $locale, string $file)
    {
        Cache::forget("translations_flattened_{$locale}_{$file}");
    }

    /**
     * Set a nested value in an array using dot notation.
     *
     * @param array &$array
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setNestedValue(array &$array, string $key, $value)
    {
        Arr::set($array, $key, $value);
    }

    /**
     * Write translations safely to file.
     *
     * @param string $filePath
     * @param array $translations
     * @return bool
     * @throws \Exception
     */
    public function writeTranslationFile(string $filePath, array $translations)
    {
        $directory = dirname($filePath);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        $export = var_export($translations, true);
        
        // Optimize array syntax from array() to []
        $export = preg_replace('/^([ ]*)(.*)/m', '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [trim(' ['), ']$1', ' => ['], $array);
        $export = join(PHP_EOL, array_filter(["["] + $array));
        
        $content = "<?php\n\nreturn " . $export . ";\n";

        if (File::put($filePath, $content) === false) {
            throw new \Exception("Failed to write translation file to: {$filePath}");
        }

        return true;
    }
    
    /**
     * Save a specific translation key to a file and clear cache.
     * 
     * @param string $locale
     * @param string $file
     * @param string $key
     * @param string $value
     * @return void
     * @throws \Exception
     */
    public function saveTranslation(string $locale, string $file, string $key, string $value)
    {
        $targetFile = $this->resolveFilePath($locale, $file);
        
        $existing = File::exists($targetFile) ? (include $targetFile) : [];
        if (!is_array($existing)) {
            $existing = [];
        }

        $this->setNestedValue($existing, $key, $value);
        
        // Will throw explicitly rather than failing silently if permissions are an issue
        $this->writeTranslationFile($targetFile, $existing);
        
        // Always invalidate cache after writing
        $this->clearCache($locale, $file);
    }
}
