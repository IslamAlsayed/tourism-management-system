@php
    $routeName = isset($models) ? "{$models}.edit" : null;
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

@if ($routeName)
    <a href="{{ route($routeName, $routeParams) }}" class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white"
        style="{{ $styles ?? '' }}" wire:ignore>

        @if (getActiveUser()->button_display_mode === 'text')
            {!! $text ?? __('main.edit') !!}
        @elseif (getActiveUser()->button_display_mode === 'icon')
            <i class="fas fa-edit text-white"></i>
        @else
            <i class="fas fa-edit text-white"></i>
            {!! $text ?? __('main.edit') !!}
        @endif
    </a>
@endif
