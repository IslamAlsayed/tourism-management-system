@php
    $routeName = isset($models) ? "{$models}.show" : null;
    $route = $routeName ? Route::getRoutes()->getByName($routeName) : null;
    $parameterName = $route ? collect($route->parameterNames())->first() : null;

    $routeParams = array_filter(
        [
            $parameterName => $id ?? null,
            'type' => request()->query('type'),
        ],
        fn($value) => !is_null($value),
    );
@endphp

<a href="{{ route($routeName, $routeParams) }}" class="kt-btn kt-btn-sm kt-btn-outline bg-yellow-500 text-white"
    style="{{ $styles ?? '' }}" wire:ignore>

    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.show') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-eye text-white"></i>
    @else
        <i class="fas fa-eye text-white"></i>
        {!! $text ?? __('main.show') !!}
    @endif
</a>
