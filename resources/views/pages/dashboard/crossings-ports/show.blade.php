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
        <div class="space-y-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.name') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.name_ar') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->name_ar ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.code') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->code ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.type') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->getTypeLabel() }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.status') }}</label>
                            <span
                                class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if ($crossingPort->status === 'active') bg-green-100 text-green-800
                                @elseif($crossingPort->status === 'inactive') bg-red-100 text-red-800
                                @elseif($crossingPort->status === 'under_construction') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $crossingPort->getStatusLabel() }}
                            </span>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.operational') }}</label>
                            <span
                                class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $crossingPort->is_operational ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $crossingPort->is_operational ? __('main.yes') : __('main.no') }}
                            </span>
                        </div>
                    </div>

                    @if ($crossingPort->description || $crossingPort->description_ar)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            @if ($crossingPort->description)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.description') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->description }}</p>
                                </div>
                            @endif

                            @if ($crossingPort->description_ar)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.description_ar') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->description_ar }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
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
                            <label class="font-medium text-gray-700">{{ __('main.region') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->region?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.country') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->country?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.state') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->state?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.city') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->city?->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.coordinates') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->coordinates ?? '-' }}</p>
                        </div>

                        @if ($crossingPort->elevation)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.elevation') }}</label>
                                <p class="mt-1 text-gray-900">{{ $crossingPort->elevation }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($crossingPort->address || $crossingPort->address_ar)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            @if ($crossingPort->address)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.address') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->address }}</p>
                                </div>
                            @endif

                            @if ($crossingPort->address_ar)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.address_ar') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->address_ar }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Operating Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operating_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.24_hours') }}</label>
                            <span
                                class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $crossingPort->is_24_hours ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $crossingPort->is_24_hours ? __('main.yes') : __('main.no') }}
                            </span>
                        </div>

                        @if ($crossingPort->opening_time)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.opening_time') }}</label>
                                <p class="mt-1 text-gray-900">{{ $crossingPort->opening_time->format('H:i') }}</p>
                            </div>
                        @endif

                        @if ($crossingPort->closing_time)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.closing_time') }}</label>
                                <p class="mt-1 text-gray-900">{{ $crossingPort->closing_time->format('H:i') }}</p>
                            </div>
                        @endif

                        @if ($crossingPort->capacity)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.capacity') }}</label>
                                <p class="mt-1 text-gray-900">{{ number_format($crossingPort->capacity) }}
                                    {{ __('main.passengers_per_hour') }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($crossingPort->facilities && count($crossingPort->facilities) > 0)
                        <div class="mt-6">
                            <label class="font-medium text-gray-700">{{ __('main.facilities') }}</label>
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
                            <label class="font-medium text-gray-700">{{ __('main.services') }}</label>
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
                                    <label class="font-medium text-gray-700">{{ __('main.phone') }}</label>
                                    <p class="mt-1 text-gray-900">
                                        <a href="tel:{{ $crossingPort->phone }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $crossingPort->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if ($crossingPort->email)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.email') }}</label>
                                    <p class="mt-1 text-gray-900">
                                        <a href="mailto:{{ $crossingPort->email }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            {{ $crossingPort->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if ($crossingPort->website)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.website') }}</label>
                                    <p class="mt-1 text-gray-900">
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
                                    <label class="font-medium text-gray-700">{{ __('main.customs_office') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->customs_office }}</p>
                                </div>
                            @endif

                            @if ($crossingPort->immigration_office)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.immigration_office') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->immigration_office }}</p>
                                </div>
                            @endif

                            @if ($crossingPort->notes)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.notes') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->notes }}</p>
                                </div>
                            @endif

                            @if ($crossingPort->notes_ar)
                                <div>
                                    <label class="font-medium text-gray-700">{{ __('main.notes_ar') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $crossingPort->notes_ar }}</p>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.created_at') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.updated_at') }}</label>
                            <p class="mt-1 text-gray-900">{{ $crossingPort->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>

                        @if ($crossingPort->creator)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.created_by') }}</label>
                                <p class="mt-1 text-gray-900">{{ $crossingPort->creator->name }}</p>
                            </div>
                        @endif

                        @if ($crossingPort->updater)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.updated_by') }}</label>
                                <p class="mt-1 text-gray-900">{{ $crossingPort->updater->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
