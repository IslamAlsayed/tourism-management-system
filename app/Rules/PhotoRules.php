<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class PhotoRules implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // If the value is null, we consider it valid (since it's nullable)
        if ($value === null) {
            return;
        }

        // Check if the file upload is valid
        if (!$value->isValid()) {
            $fail(__('The uploaded file is not valid.'));
            return;
        }

        // Ensure the value is an uploaded file instance
        if (!$value instanceof UploadedFile) {
            $fail('The :attribute must be a valid image file.');
            return;
        }

        // Check file size (5MB max)
        if ($value->getSize() > 5120 * 1024) {
            $fail('The :attribute must not be greater than 5MB.');
            return;
        }

        // You can combine with existing rules manually, e.g. checking MIME type
        if (!in_array($value->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])) {
            $fail('The :attribute must be a JPEG, PNG, JPG, GIF, or WEBP.');
        }
    }
}
