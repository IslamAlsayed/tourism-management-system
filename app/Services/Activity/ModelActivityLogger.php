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
            activity(config('activitylog.model_log_name'))
                ->causedBy(Auth::user())
                ->performedOn($model)
                ->event($event)
                ->withProperties($this->buildProperties($model, $event))
                ->log(class_basename($model) . ' ' . $event);
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
        $properties = [
            'event' => $event,
            'model' => [
                'class' => get_class($model),
                'id' => $model->getKey(),
            ],
            'changes' => $this->extractModelChanges($model, $event),
            'context' => array_filter([
                'url' => $this->requestData('fullUrl'),
                'ip' => $this->requestData('ip'),
                'user_agent' => $this->requestData('userAgent'),
                'method' => $this->requestData('method'),
            ]),
        ];

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

        $attributes = Arr::except($attributes, array_merge($model->getHidden(), [
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ]));

        $attributes = Arr::except($attributes, [
            'created_at',
            'updated_at',
            'deleted_at',
        ]);

        if ($keys === null && count($attributes) > 25) {
            $attributes = array_slice($attributes, 0, 25, true);
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
     * Format a human-readable log description with translation support.
     */
    protected function formatLogDescription(Model $model, string $event): string
    {
        $modelBasename = class_basename($model);
        $modelKey = strtolower($modelBasename);

        // Try to get translated model name
        $translatedModel = trans("main.type_{$modelKey}");

        // If translation not found, use the basename
        if ($translatedModel === "main.type_{$modelKey}") {
            $translatedModel = $modelBasename;
        }

        // Try to get translated event
        $translatedEvent = trans("main.{$event}");

        // If translation not found, use the event as is
        if ($translatedEvent === "main.{$event}") {
            $translatedEvent = $event;
        }

        return $translatedModel . ' ' . $translatedEvent;
    }
}