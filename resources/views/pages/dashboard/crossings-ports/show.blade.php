@extends('layouts.master')

@section('title', __('main.view_type', ['type' => __('main.crossing_port')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $crossingPort->display_name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.view_type_description', ['type' => __('main.crossing_port')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('crossings-ports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.crossing_ports')]) }}
                </a>
                <a href="{{ route('crossings-ports.edit', $crossingPort->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    {{ __('main.edit') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if ($crossingPort->name)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.name') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->name ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->name_ar)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.name_ar') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->name_ar ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->code)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.code') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->code ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->type)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.type') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->getTypeLabel() }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->operating_hours)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.operating_hours') }}</label><br />
                                <span class="kt-badge kt-badge-info">{{ $crossingPort->operating_hours }}</span>
                            </div>
                        @endif

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_24_7') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_24_7',
                                    'value' => (bool) $crossingPort->is_24_7,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_active',
                                    'value' => (bool) $crossingPort->is_active,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_commercial') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_commercial',
                                    'value' => (bool) $crossingPort->is_commercial,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_passenger') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_passenger',
                                    'value' => (bool) $crossingPort->is_passenger,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_international') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_international',
                                    'value' => (bool) $crossingPort->is_international,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_major') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_major',
                                    'value' => (bool) $crossingPort->is_major,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                    </div>

                    @if ($crossingPort->notes)
                        <div class="mt-6">
                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $crossingPort->notes !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Visa Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.visa')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if ($crossingPort->visa_required)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.visa_required') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_required ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->visa_fee)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.visa_fee') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_fee ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->visa_fee_currency)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.visa_fee_currency') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_fee_currency ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->visa_duration)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.visa_duration') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_duration ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->visa_application_url)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.visa_application_url') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_application_url ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->visa_policy_source)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.visa_policy_source') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_policy_source ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->visa_last_update)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.visa_last_update') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_last_update ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->visa_conditions)
                            <div class="col-span-full">
                                <label class="font-medium text-gray-900">{{ __('main.visa_conditions') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->visa_conditions ?? '-' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Location Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.region') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->region?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.country') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->country?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.state') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->state?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.city') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->city?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.coordinates') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->coordinates ?? '-' }}</p>
                        </div>

                        @if ($crossingPort->elevation)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.elevation') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->elevation }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($crossingPort->address)
                        <div class="mt-6">
                            <label class="kt-label mb-1">{{ __('main.address') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $crossingPort->address !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Operating Information --}}
            <div class="kt-card hidden">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operating_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.24_hours') }}</label>
                            <span
                                class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $crossingPort->is_24_hours ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $crossingPort->is_24_hours ? __('main.yes') : __('main.no') }}
                            </span>
                        </div>

                        @if ($crossingPort->opening_time)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.opening_time') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->opening_time->format('H:i') }}</p>
                            </div>
                        @endif

                        @if ($crossingPort->closing_time)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.closing_time') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->closing_time->format('H:i') }}</p>
                            </div>
                        @endif

                        @if ($crossingPort->capacity)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.capacity') }}</label>
                                <p class="mt-1 text-gray-500">{{ number_format($crossingPort->capacity) }}
                                    {{ __('main.passengers_per_hour') }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($crossingPort->facilities && count($crossingPort->facilities) > 0)
                        <div class="mt-6">
                            <label class="font-medium text-gray-900">{{ __('main.facilities') }}</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($crossingPort->facilities as $facility)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $facility)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($crossingPort->services && count($crossingPort->services) > 0)
                        <div class="mt-6">
                            <label class="font-medium text-gray-900">{{ __('main.services') }}</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($crossingPort->services as $service)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ ucfirst(str_replace('_', ' ', $service)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Contact Information --}}
            @if ($crossingPort->phone || $crossingPort->email || $crossingPort->website)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @if ($crossingPort->phone)
                                <div>
                                    <label class="font-medium text-gray-900">{{ __('main.phone') }}</label>
                                    <p class="mt-1 text-gray-500">
                                        <a href="tel:{{ $crossingPort->phone }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            {{ $crossingPort->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if ($crossingPort->email)
                                <div>
                                    <label class="font-medium text-gray-900">{{ __('main.email') }}</label>
                                    <p class="mt-1 text-gray-500">
                                        <a href="mailto:{{ $crossingPort->email }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            {{ $crossingPort->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if ($crossingPort->website)
                                <div>
                                    <label class="font-medium text-gray-900">{{ __('main.website') }}</label>
                                    <p class="mt-1 text-gray-500">
                                        <a href="{{ $crossingPort->website }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800">
                                            {{ $crossingPort->website }} <i class="fas fa-external-link-alt text-xs"></i>
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Additional Information --}}
            @if (
                $crossingPort->notes ||
                    $crossingPort->notes_ar ||
                    $crossingPort->customs_office ||
                    $crossingPort->immigration_office)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if ($crossingPort->customs_office)
                                <div>
                                    <label class="font-medium text-gray-900">{{ __('main.customs_office') }}</label>
                                    <p class="mt-1 text-gray-500">{{ $crossingPort->customs_office }}</p>
                                </div>
                            @endif

                            @if ($crossingPort->immigration_office)
                                <div>
                                    <label class="font-medium text-gray-900">{{ __('main.immigration_office') }}</label>
                                    <p class="mt-1 text-gray-500">{{ $crossingPort->immigration_office }}</p>
                                </div>
                            @endif

                            @if ($crossingPort->notes)
                                <div class="col-span-full">
                                    <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                    <div class="text-sm text-secondary-foreground prose max-w-none">
                                        {!! $crossingPort->notes !!}
                                    </div>
                                </div>
                            @endif

                            @if ($crossingPort->notes_ar)
                                <div class="col-span-full">
                                    <label class="kt-label mb-1">{{ __('main.notes_ar') }}</label>
                                    <div class="text-sm text-secondary-foreground prose max-w-none">
                                        {!! $crossingPort->notes_ar !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- System Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.system_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($crossingPort->creator)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.created_by') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.created_at') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                        @if ($crossingPort->updater)
                            <div>
                                <label class="font-medium text-gray-900">{{ __('main.updated_by') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="font-medium text-gray-900">{{ __('main.updated_at') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'crossings-ports',
                    'id' => $crossingPort->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'crossings-port',
                    'modelId' => $crossingPort->id,
                    'modelType' => '\\App\\Models\\CrossingsPort',
                    'table' => 'crossings_ports',
                ])
                <a href="{{ route('crossings-ports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.crossings_ports')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
