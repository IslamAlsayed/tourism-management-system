@php
    $routeName = isset($models) ? "{$models}.show" : null;
    $route = $routeName ? Route::getRoutes()->getByName($routeName) : null;
    $parameterName = $route ? collect($route->parameterNames())->first() : null;

    $routeParams = [];

    // Add the main parameter (id or similar)
    if ($parameterName && isset($id)) {
        $routeParams[$parameterName] = $id;
    }

    // Add type parameter only if it exists in the request
    if (request()->has('type')) {
        $routeParams['type'] = request()->query('type');
    }

    // Filter out null values
    $routeParams = array_filter($routeParams, fn($value) => !is_null($value));
@endphp

@if ($routeName && $route)
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
@endif
