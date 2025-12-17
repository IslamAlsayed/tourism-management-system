<?php

namespace App\Services\Activity;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use DateTimeInterface;

class ModelActivityLogger
{
    /**
     * Record a model activity event when the configuration allows it.
     */
    public function log(Model $model, string $event): void
    {
        if (!config('activitylog.enabled')) {
            return;
        }

        if (!Schema::hasTable(config('activitylog.table_name', 'activity_log'))) {
            return;
        }

        // Don't log when running seeders
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }

        $config = config('activitylog.auto_log_models', []);

        if (!is_array($config)) {
            return;
        }

        $config = array_merge([
            'enabled' => true,
            'only' => [],
            'except' => [],
        ], $config);

        if (!$this->shouldLogModel($model, $config)) {
            return;
        }

        try {
            $logMessage = $this->buildLogMessage($model, $event);

            activity(config('activitylog.model_log_name'))
                ->causedBy(Auth::user())
                ->performedOn($model)
                ->event($event)
                ->withProperties($this->buildProperties($model, $event))
                ->log($logMessage);
        } catch (\Throwable $exception) {
            Log::warning('Failed to log model activity', [
                'model' => get_class($model),
                'event' => $event,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Determine if the model should be logged by checking configuration.
     */
    protected function shouldLogModel(Model $model, array $config): bool
    {
        if (!$config['enabled']) {
            return false;
        }

        $class = get_class($model);

        if (method_exists($model, 'shouldSkipActivityLogging') && $model->shouldSkipActivityLogging()) {
            return false;
        }

        if (property_exists($model, 'activitylogDisabled') && $model->activitylogDisabled === true) {
            return false;
        }

        if (!empty($config['only']) && !in_array($class, $config['only'], true)) {
            return false;
        }

        if (!empty($config['except']) && in_array($class, $config['except'], true)) {
            return false;
        }

        return true;
    }

    /**
     * Build useful properties to provide context inside the activity log.
     */
    protected function buildProperties(Model $model, string $event): array
    {
        $changes = $this->extractModelChanges($model, $event);

        $properties = [
            'model' => [
                'class' => class_basename($model),
                'id' => $model->getKey(),
                'table' => $model->getTable(),
            ],
            'changes' => $changes,
            'summary' => $this->buildChangesSummary($changes, $event),
        ];

        // Only add context for important operations or errors
        if (in_array($event, ['deleted', 'force_deleted']) || app()->bound('request') && request()->isMethod('DELETE')) {
            $properties['context'] = array_filter([
                'ip' => $this->requestData('ip'),
                'method' => $this->requestData('method'),
            ]);
        }

        return array_filter($properties, function ($value) {
            return $value !== null && $value !== [] && $value !== '';
        });
    }

    /**
     * Safely access request context helpers if a request is bound.
     */
    protected function requestData(string $method): string
    {
        if (!app()->bound('request')) {
            return '';
        }

        $request = request();

        if (!$request || !method_exists($request, $method)) {
            return '';
        }

        return (string) $request->{$method}();
    }

    /**
     * Extract a concise snapshot of model changes for storage.
     */
    protected function extractModelChanges(Model $model, string $event): array
    {
        $changes = [];

        if ($event === 'created') {
            $snapshot = $this->prepareAttributeSnapshot($model, $model->getAttributes());

            if (!empty($snapshot)) {
                $changes['current'] = $snapshot;
            }
        } elseif ($event === 'updated') {
            $changedKeys = array_keys($model->getChanges());

            if (!empty($changedKeys)) {
                $current = $this->prepareAttributeSnapshot($model, Arr::only($model->getAttributes(), $changedKeys));
                $previous = $this->prepareAttributeSnapshot($model, Arr::only($model->getOriginal(), $changedKeys));

                if (!empty($current)) {
                    $changes['current'] = $current;
                }

                if (!empty($previous)) {
                    $changes['previous'] = $previous;
                }
            }
        } elseif (in_array($event, ['deleted', 'force_deleted'], true)) {
            $snapshot = $this->prepareAttributeSnapshot($model, $model->getOriginal());

            if (!empty($snapshot)) {
                $changes['previous'] = $snapshot;
            }
        } elseif ($event === 'restored') {
            $snapshot = $this->prepareAttributeSnapshot($model, $model->getAttributes());

            if (!empty($snapshot)) {
                $changes['current'] = $snapshot;
            }
        }

        return $changes;
    }

    /**
     * Reduce attribute payloads to only meaningful keys and values.
     */
    protected function prepareAttributeSnapshot(Model $model, array $attributes): array
    {
        if (empty($attributes)) {
            return [];
        }

        $filtered = $this->filterAttributes($model, $attributes);

        if (empty($filtered)) {
            return [];
        }

        foreach ($filtered as $key => $value) {
            $filtered[$key] = $this->normaliseValue($value);
        }

        return $filtered;
    }

    /**
     * Filter attributes based on model configuration and sensible defaults.
     */
    protected function filterAttributes(Model $model, array $attributes): array
    {
        $keys = $this->loggableAttributeKeys($model);

        if ($keys !== null) {
            $attributes = Arr::only($attributes, $keys);
        }

        // Exclude sensitive and unnecessary fields
        $excludeFields = array_merge($model->getHidden(), [
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
            'created_at',
            'updated_at',
            'deleted_at',
            'email_verified_at',
            'last_login_at',
            'last_login_ip',
            'user_status',
            'session_id',
        ]);

        $attributes = Arr::except($attributes, $excludeFields);

        // Limit to important attributes only
        if ($keys === null && count($attributes) > 10) {
            $attributes = array_slice($attributes, 0, 10, true);
        }

        return $attributes;
    }

    /**
     * Determine which attribute keys should be tracked for the given model.
     */
    protected function loggableAttributeKeys(Model $model): ?array
    {
        if (method_exists($model, 'getActivitylogTrackedAttributes')) {
            $keys = $model->getActivitylogTrackedAttributes();

            if (is_array($keys) && !empty($keys)) {
                return $keys;
            }
        }

        if (property_exists($model, 'activitylogTrackedAttributes') && is_array($model->activitylogTrackedAttributes) && !empty($model->activitylogTrackedAttributes)) {
            return $model->activitylogTrackedAttributes;
        }

        $fillable = $model->getFillable();

        if (!empty($fillable)) {
            return $fillable;
        }

        return null;
    }

    /**
     * Shrink logged values to avoid excessive payloads.
     */
    protected function normaliseValue(mixed $value): mixed
    {
        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format(DateTimeInterface::ATOM);
        }

        if (is_string($value)) {
            // Clean UTF-8 encoding - check if string is already valid UTF-8
            if (!mb_check_encoding($value, 'UTF-8')) {
                // Try to convert from common encodings to UTF-8
                $encodings = ['Windows-1252', 'ISO-8859-1', 'ISO-8859-15'];
                foreach ($encodings as $encoding) {
                    if (mb_check_encoding($value, $encoding)) {
                        $value = mb_convert_encoding($value, 'UTF-8', $encoding);
                        break;
                    }
                }
                // If still not valid UTF-8, use iconv with //IGNORE
                if (!mb_check_encoding($value, 'UTF-8')) {
                    $value = @iconv('UTF-8', 'UTF-8//IGNORE', $value) ?: $value;
                }
            }

            // Remove control characters except newlines and tabs
            $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
            return Str::limit($value, 500);
        }

        if (is_numeric($value) || is_bool($value) || $value === null) {
            return $value;
        }

        if (is_array($value)) {
            return $this->normaliseArray($value);
        }

        if ($value instanceof \JsonSerializable) {
            return $this->normaliseArray((array) $value->jsonSerialize());
        }

        if ($value instanceof \Stringable) {
            $stringValue = (string) $value;
            // Clean UTF-8 encoding
            $stringValue = mb_convert_encoding($stringValue, 'UTF-8', 'UTF-8//IGNORE');
            $stringValue = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $stringValue);
            return Str::limit($stringValue, 500);
        }

        if (is_object($value) && method_exists($value, 'toArray')) {
            return $this->normaliseArray((array) $value->toArray());
        }

        $stringValue = (string) $value;
        // Clean UTF-8 encoding
        $stringValue = mb_convert_encoding($stringValue, 'UTF-8', 'UTF-8//IGNORE');
        $stringValue = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $stringValue);
        return Str::limit($stringValue, 500);
    }

    /**
     * Convert nested arrays into a trimmed JSON string.
     */
    protected function normaliseArray(array $value): string
    {
        if (count($value) > 20) {
            $value = array_slice($value, 0, 20, true);
        }

        // Clean array values recursively
        array_walk_recursive($value, function (&$item) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8//IGNORE');
                $item = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $item);
            }
        });

        $encoded = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($encoded === false) {
            return '[unserializable array]';
        }

        return Str::limit($encoded, 500);
    }

    /**
     * Build a descriptive log message with key details.
     */
    protected function buildLogMessage(Model $model, string $event): string
    {
        $modelBasename = class_basename($model);
        $modelKey = strtolower($modelBasename);
        $translatedModel = trans("main.type_{$modelKey}");

        if ($translatedModel === "main.type_{$modelKey}") {
            $translatedModel = $modelBasename;
        }

        $translatedEvent = trans("main.{$event}");
        if ($translatedEvent === "main.{$event}") {
            $translatedEvent = $event;
        }

        $message = "{$translatedModel} {$translatedEvent}";

        // Add ID for reference
        if ($model->getKey()) {
            $message .= " (ID: {$model->getKey()})";
        }

        // Add name/title if exists for quick identification
        $identifierField = $this->getModelIdentifierField($model);
        if ($identifierField && isset($model->{$identifierField})) {
            $identifier = Str::limit($model->{$identifierField}, 50);
            $message .= " - {$identifier}";
        }

        return $message;
    }

    /**
     * Get the field that best identifies the model.
     */
    protected function getModelIdentifierField(Model $model): ?string
    {
        $possibleFields = ['name', 'title', 'label', 'email', 'username'];

        foreach ($possibleFields as $field) {
            if (isset($model->{$field})) {
                return $field;
            }
        }

        return null;
    }

    /**
     * Build a summary of changes for quick understanding.
     */
    protected function buildChangesSummary(array $changes, string $event): ?string
    {
        if (empty($changes)) {
            return null;
        }

        $summary = [];

        if (isset($changes['current']) && isset($changes['previous'])) {
            // Updated - show what changed
            $current = $changes['current'];
            $previous = $changes['previous'];

            foreach ($current as $key => $value) {
                if (isset($previous[$key]) && $previous[$key] !== $value) {
                    $summary[] = "{$key}: {$previous[$key]} → {$value}";
                }
            }
        } elseif (isset($changes['current'])) {
            // Created - show key fields
            $current = $changes['current'];
            $importantFields = array_slice($current, 0, 3, true);
            foreach ($importantFields as $key => $value) {
                $summary[] = "{$key}: {$value}";
            }
        } elseif (isset($changes['previous'])) {
            // Deleted - show what was deleted
            $previous = $changes['previous'];
            $importantFields = array_slice($previous, 0, 3, true);
            foreach ($importantFields as $key => $value) {
                $summary[] = "{$key}: {$value}";
            }
        }

        return !empty($summary) ? implode(', ', $summary) : null;
    }
}