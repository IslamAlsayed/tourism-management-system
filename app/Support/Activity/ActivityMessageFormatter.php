<?php

namespace App\Support\Activity;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Contracts\Support\Arrayable;

class ActivityMessageFormatter
{
    /**
     * Render a concise summary for an activity description while de-duplicating noisy segments.
     */
    public static function summary(Activity $activity, int $limit): string
    {
        $message = self::resolveDescription($activity);

        if ($message == '') {
            return trans('activity.activity_no_description');
        }

        $message = self::cleanMessage($message);

        if ($limit > 0) {
            $message = Str::limit($message, $limit);
        }

        return $message;
    }

    /**
     * Render the full cleaned description for detail views.
     */
    public static function detailed(Activity $activity): string
    {
        $message = self::resolveDescription($activity);

        if ($message == '') {
            return trans('activity.activity_no_description');
        }

        return self::cleanMessage($message);
    }

    /**
     * Resolve the most relevant description text for the given activity.
     */
    protected static function resolveDescription(Activity $activity): string
    {
        $description = (string) ($activity->description ?? '');

        if ($description !== '') {
            return trim($description);
        }

        $properties = $activity->properties;

        if ($properties instanceof Arrayable) {
            $properties = $properties->toArray();
        } elseif (is_object($properties) && method_exists($properties, 'toArray')) {
            $properties = $properties->toArray();
        }

        return trim((string) Arr::get((array) $properties, 'message', ''));
    }

    /**
     * Collapse repeated fragments (notably duplicated view references) and normalise spacing.
     */
    protected static function cleanMessage(string $message): string
    {
        $message = str_replace(["\r\n", "\n", "\r"], ' ', $message);
        $message = preg_replace('/\s+/', ' ', $message) ?? $message;

        if (str_contains($message, '(View:')) {
            preg_match_all('/\(View: [^\)]+\)/', $message, $matches);

            if (!empty($matches[0])) {
                $unique = [];

                foreach ($matches[0] as $segment) {
                    if (!in_array($segment, $unique, true)) {
                        $unique[] = $segment;
                    }
                }

                $message = trim(preg_replace('/\(View: [^\)]+\)/', '', $message) ?? $message);

                if (!empty($unique)) {
                    $message = trim($message . ' ' . implode(' ', $unique));
                }
            }
        }

        return trim($message);
    }
}