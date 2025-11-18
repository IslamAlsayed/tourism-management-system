<div class="custom-input">
    <input type="checkbox" name="{{ isset($name) ? $name : '' }}" id="{{ isset($id) ? $id : '' }}"
        value="{{ isset($value) ? $value : '' }}" {{ isset($checked) && $checked ? 'checked' : '' }}
        data-kt-datatable-row-check="true">
    <label for="{{ isset($id) ? $id : '' }}">{{ isset($label) ? $label : '' }}</label>
</div>
