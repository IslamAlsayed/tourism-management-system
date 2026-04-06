@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.client')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $client->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $client->personal_email }} • {{ $client->primary_phone }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.crm.clients.edit', $client->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.crm.clients.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.clients')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($client->first_name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.first_name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $client->first_name ?: __('main.unknown') }}
                                </p>
                            </div>
                        @endif
                        @if ($client->last_name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.last_name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $client->last_name ?: __('main.unknown') }}
                                </p>
                            </div>
                        @endif
                        @if ($client->personal_email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.personal_email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $client->personal_email ?: __('main.unknown') }}
                                </p>
                            </div>
                        @endif
                        @if ($client->work_email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.work_email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $client->work_email ?: __('main.unknown') }}
                                </p>
                            </div>
                        @endif
                        @if ($client->primary_phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.primary_phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $client->primary_phone ?: __('main.unknown') }}
                                </p>
                            </div>
                        @endif
                        @if ($client->secondary_phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.secondary_phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $client->secondary_phone ?: __('main.unknown') }}
                                </p>
                            </div>
                        @endif
                        @if ($client->mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->mobile }}</p>
                            </div>
                        @endif
                        @if ($client->home_phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.home_phone') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->home_phone }}</p>
                            </div>
                        @endif
                        @if ($client->work_phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.work_phone') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->work_phone }}</p>
                            </div>
                        @endif
                        @if ($client->fax)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->fax }}</p>
                            </div>
                        @endif
                        @if ($client->timezone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.timezone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-info">
                                        {{ $client->timezone->name }} ({{ $client->timezone->abbreviation }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        @if ($client->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $client->currency->name }}
                                    <span class="text-primary font-semibold">
                                        ({{ $client->currency->code }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        @if ($client->nationality)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.nationality') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->nationality->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $client->id,
                                    'modelType' => '\\App\\Models\\Client',
                                    'field' => 'is_active',
                                    'value' => (bool) $client->is_active,
                                    'table' => 'clients',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $client,
                            'column' => 'description',
                        ])

                        @include('components.elements.displayable-rich-text', [
                            'record' => $client,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap justify-between gap-10">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.region') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $client->region?->name ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $client->subregion?->name ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $client->country?->name ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $client->state?->name ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $client->city?->name ?: __('main.na') }}
                            </p>
                        </div>
                        @if ($client->street)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->street }}</p>
                            </div>
                        @endif
                        @if ($client->box)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.postal_box') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->box }}</p>
                            </div>
                        @endif
                        @if ($client->postal_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $client->postal_code }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $client])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.crm.clients',
                    'id' => $client->id,
                ])
                @include('components.elements.delete-form', [
                    'models' => 'dashboard.crm.clients',
                    'id' => $client->id,
                ])
                <a href="{{ route('dashboard.crm.clients.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.clients')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
