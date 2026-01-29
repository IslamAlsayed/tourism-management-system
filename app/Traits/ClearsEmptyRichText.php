<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait ClearsEmptyRichText
{
    protected static function bootClearsEmptyRichText()
    {
        static::saving(function (Model $model) {
            if (! method_exists($model, 'getRichTextFields')) {
                return;
            }

            foreach (array_keys($model->getRichTextFields()) as $field) {
                $value = $model->{$field};

                if (is_null($value)) {
                    continue;
                }

                // body بعد strip
                $plain = trim(strip_tags($value->body ?? ''));

                if ($plain === '') {
                    $relation = "richText" . Str::studly($field);

                    $model->{$relation}?->delete();
                }
            }
        });
    }
}
