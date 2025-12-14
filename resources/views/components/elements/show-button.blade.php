<a href="{{ route(isset($models) ? "$models.show" : '', isset($id) ? $id : '') }}"
    class="kt-btn kt-btn-sm kt-btn-outline bg-yellow-500 text-white" style="{{ isset($styles) ? $styles : '' }}">

    @if (isset($button_display_mode) && $button_display_mode === 'text')
        {!! $text ?? __('main.show') !!}
    @else
        <i class="fas fa-eye text-white"></i>
    @endif
</a>
