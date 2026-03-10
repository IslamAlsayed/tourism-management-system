@php
    // Extract raw HTML body from RichText model objects to avoid JSON serialization.
    // When HasRichText trait is used, $value is a RichText Eloquent model, not a string.
    // Blade's {{ }} escapes it via e() which calls json_encode on objects, showing raw JSON.
$rawValue = $value ?? old($name ?? $column);
if (is_object($rawValue)) {
    // RichText model: extract body->toHtml() or body as string, or empty
    if (isset($rawValue->body) && $rawValue->body !== null) {
        $rawValue = (string) $rawValue->body;
    } else {
        $rawValue = '';
        }
    }
@endphp

<div class="{{ isset($classes) ? $classes : '' }}">
    <label for="{{ $name ?? $column }}" class="kt-label mb-2">
        {{ __('main.' . ($name ?? $column)) }}
        @if (isset($placeholder) && $placeholder)
            <span class="text-sm text-primary">({{ $placeholder }})</span>
        @endif
    </label>

    <input id="{{ $name ?? $column }}" type="hidden" name="{{ $name ?? $column }}" value="{{ $rawValue }}">

    <trix-editor input="{{ $name ?? $column }}"
        placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}">
    </trix-editor>

    @error($name ?? $column)
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
