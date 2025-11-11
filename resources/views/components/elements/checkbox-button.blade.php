<div class="custom-input">
    <span class="pseudo-checkbox" style="{{ isset($styles) ? $styles : '' }}"></span>
    <input type="checkbox" name="{{ isset($name) ? $name : '' }}" id="{{ isset($id) ? $id : '' }}"
        value="{{ isset($value) ? $value : '' }}" data-kt-datatable-row-check="true">
    <label for="{{ isset($id) ? $id : '' }}">{!! isset($label) ? $label : '' !!}</label>
</div>
