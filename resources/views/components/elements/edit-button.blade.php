<a href="{{ route(isset($models) ? "$models.edit" : '', isset($id) ? $id : '') }}"
    class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white" style="{{ isset($styles) ? $styles : '' }}">
    {!! $text ?? __('main.edit') !!}
</a>
