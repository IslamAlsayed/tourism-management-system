<div class="{{ isset($classes) ? $classes : '' }}">
    <label for="{{ $name ?? $column }}" class="kt-label mb-2">
        {{ __('main.' . ($name ?? $column)) }}
        @if (isset($placeholder) && $placeholder)
            <span class="text-sm text-primary">({{ $placeholder }})</span>
        @endif
    </label>

    <input id="{{ $name ?? $column }}" type="hidden" name="{{ $name ?? $column }}"
        value="{{ $value ?? old($name ?? $column) }}">

    <trix-editor input="{{ $name ?? $column }}"
        placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}">
    </trix-editor>

    @error($name ?? $column)
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
