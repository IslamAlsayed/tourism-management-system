@php
    $routeName = isset($models) ? "{$models}.show" : null;
    $routeParams = [];
    if (isset($id)) $routeParams[] = $id;
    if (request()->has('type')) $routeParams['type'] = request()->query('type');
@endphp

@if ($routeName && Route::has($routeName))
    <a href="{{ route($routeName, $routeParams) }}"
       class="kt-btn kt-btn-sm text-white bg-yellow-500 hover:bg-yellow-600 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 px-3 py-1.5 gap-2 rounded-full font-semibold"
       title="{{ $text ?? __('main.show') }}"
       style="{{ $styles ?? '' }}"
       wire:ignore>
        <i class="ki-outline ki-eye text-base"></i>
        <span>{{ $text ?? __('main.show') }}</span>
    </a>
@endif
