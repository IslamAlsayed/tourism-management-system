<a href="{{ route(isset($models) ? "$models.edit" : '', isset($id) ? $id : '') }}" wire:ignore
    class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white" style="{{ isset($styles) ? $styles : '' }}">

    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.edit') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-edit text-white"></i>
    @else
        <i class="fas fa-edit text-white"></i>
        {!! $text ?? __('main.edit') !!}
    @endif
</a>
