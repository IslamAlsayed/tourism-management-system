<div class="{{ isset($classes) ? $classes : '' }}">
    <label for="{{ $name ?? ($column ?? 'description') }}"
        class="kt-label mb-2">{{ __('main.' . ($name ?? ($column ?? 'description'))) }}</label>
    <input id="{{ $name ?? ($column ?? 'description') }}" type="hidden" name="{{ $name ?? ($column ?? 'description') }}"
        value="{{ $value ?? old($name ?? ($column ?? 'description')) }}">
    <trix-editor input="{{ $name ?? ($column ?? 'description') }}"></trix-editor>
    @error($name ?? ($column ?? 'description'))
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
