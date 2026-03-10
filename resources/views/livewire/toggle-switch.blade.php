<div wire:key="toggle-{{ isset($table) && $table ? $table : '' }}-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
    class="flex items-center justify-center" wire:loading.class="opacity-50">
    <label class="kt-switch kt-switch-sm">
        <input type="checkbox"
            id="toggle-{{ isset($table) && $table ? $table : '' }}-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
            wire:click="toggleHold"
            wire:loading.attr="disabled"
            {{ isset($value) && $value ? 'checked' : '' }} />
        <span class="kt-switch-label"></span>
    </label>
</div>
