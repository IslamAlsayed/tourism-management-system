<a href="{{ route(isset($models) ? "$models.edit" : '', isset($id) ? $id : '') }}"
    class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white" style="{{ isset($styles) ? $styles : '' }}">

    @if (isset($button_display_mode) && $button_display_mode === 'text')
        {!! $text ?? __('main.edit') !!}
    @else
        <i class="fas fa-edit text-white"></i>
    @endif
</a>
