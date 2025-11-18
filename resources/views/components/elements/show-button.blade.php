<a href="{{ route(isset($models) ? "$models.show" : '', isset($id) ? $id : '') }}"
    class="kt-btn kt-btn-sm kt-btn-outline bg-success text-white" style="{{ isset($styles) ? $styles : '' }}">
    {!! $text ?? __('main.show') !!}
</a>
