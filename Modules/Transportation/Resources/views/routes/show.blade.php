@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.transportations-route')]))

@push('scripts')
    @include('components.scripts.setup-map')
@endpush

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $route->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $route->code }} • {{ $route->originCity?->name }} → {{ $route->destinationCity?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.transportation.routes.edit', $route->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.transportation.routes.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-routes')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Route Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.route_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($route->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $route->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($route->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $route->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($route->code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.code') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $route->code }}
                                </p>
                            </div>
                        @endif
                        @if ($route->route_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.route_type') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ __('main.' . $route->route_type) }}
                                </p>
                            </div>
                        @endif
                        @if ($route->distance)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.distance') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $route->formatted_distance }}
                                </p>
                            </div>
                        @endif
                        @if ($route->estimated_duration)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.estimated_duration') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $route->formatted_duration }}
                                </p>
                            </div>
                        @endif
                        @if ($route->road_condition)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.road_condition') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ __('main.' . $route->road_condition) }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_toll_road') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                @if ($route->is_toll_road)
                                    <span class="kt-badge kt-badge-success">{{ __('main.yes') }}</span>
                                    @if ($route->toll_fee)
                                        ({{ number_format($route->toll_fee, 2) }})
                                    @endif
                                @else
                                    <span class="kt-badge kt-badge-secondary">{{ __('main.no') }}</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $route->id,
                                    'modelType' => '\\Modules\\Transportation\\Entities\\Route',
                                    'field' => 'is_active',
                                    'value' => (bool) $route->is_active,
                                    'table' => 'transportations_routes',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $routes,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $routes,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Origin Location -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.origin_city') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($route->originCity)
                                <a href="{{ route('dashboard.geography.cities.show', $route->originCity->id) }}" class="block text-sm text-primary underline">
                                    {{ $route->originCity->name }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        @if ($route->origin_address)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $route->origin_address }}</p>
                            </div>
                        @endif
                        @if ($route->origin_latitude && $route->origin_longitude)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $route->origin_latitude }}, {{ $route->origin_longitude }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Destination Location -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.destination_city') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($route->destinationCity)
                                <a href="{{ route('dashboard.geography.cities.show', $route->destinationCity->id) }}" class="block text-sm text-primary underline">
                                    {{ $route->destinationCity->name }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        @if ($route->destination_address)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $route->destination_address }}</p>
                            </div>
                        @endif
                        @if ($route->destination_latitude && $route->destination_longitude)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $route->destination_latitude }}, {{ $route->destination_longitude }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Route Assignments -->
            @if ($route->assignments && $route->assignments->count() > 0)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.route_assignments') }}
                            <span class="kt-badge kt-badge-primary ms-2">{{ $route->assignments->count() }}</span>
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('main.company') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('main.vehicle_type') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('main.price') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('main.schedule') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('main.status') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('main.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($route->assignments as $assignment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('dashboard.transportation.companies.show', $assignment->company_id) }}"
                                                    class="text-primary hover:underline">
                                                    {{ $assignment->company->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $assignment->vehicleType->name ?? __('main.na') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $assignment->formatted_price }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                @if ($assignment->departure_time)
                                                    {{ $assignment->departure_time }}
                                                @endif
                                                @if ($assignment->frequency_per_day)
                                                    ({{ $assignment->frequency_per_day }}x/{{ __('main.day') }})
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($assignment->is_active && $assignment->isCurrentlyValid())
                                                    <span class="kt-badge kt-badge-success">{{ __('main.active') }}</span>
                                                @else
                                                    <span class="kt-badge kt-badge-secondary">{{ __('main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('dashboard.transportation.route-assignments.show', $assignment->id) }}"
                                                    class="text-primary hover:underline">
                                                    {{ __('main.view') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $route])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.transportation.routes',
                    'id' => $route->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'transportations.routes',
                    'id' => $route->id,
                ])
                <a href="{{ route('dashboard.transportation.routes.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-routes')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
