<div class="custom-input {{ isset($disabled) && $disabled ? 'disabled-option' : '' }}">
    <input type="{{ isset($type) ? $type : 'checkbox' }}" name="{{ isset($name) ? $name : '' }}" id="{{ isset($id) ? $id : '' }}" wire:model.live="selectedIds"
        value="{{ isset($value) ? $value : '' }}" {{ isset($checked) && $checked ? 'checked' : '' }} {{ isset($disabled) && $disabled ? 'disabled' : '' }}
        {!! isset($customize) && $customize ? $customize : '' !!}>
    <label for="{{ isset($id) ? $id : '' }}">{{ isset($label) ? $label : '' }}</label>
    @if (isset($checkboxSlot))
        {{ $checkboxSlot }}
    @endif
</div>
