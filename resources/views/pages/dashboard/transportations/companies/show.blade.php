@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.transportations-company')]))

@push('scripts')
    @include('components.scripts.setup-map')
@endpush

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $company->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $company->code }} • {{ $company->city?->name }},
                    {{ $company->country?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportations.companies.edit', $company->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('transportations.companies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.companies')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Transportation Company Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.transportations-company')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $company->name ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $company->name_ar ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.rating') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($company->rating, 0) }}/5
                                <i class="fas fa-star" style="color: #ffdd00"></i>
                            </p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.code') }}</label>
                            <p class="mt-1 text-gray-900">
                                <span class="kt-badge kt-badge-outline kt-badge-primary">{{ $company->code ?? '-' }}</span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $company->currency?->code ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $company->id,
                                    'modelType' => '\\App\\Models\\TransportationCompany',
                                    'field' => 'is_active',
                                    'value' => (bool) $company->is_active,
                                    'table' => 'transportations_companies',
                                ])
                            </div>
                        </div>
                        @if ($company->seasons)
                            <div class="col-span-full">
                                <label class="kt-label mb-1">{{ __('main.seasons') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($company->seasons as $season)
                                        <a href="{{ route('seasons.show', $season->id) }}" class="kt-badge kt-badge-info">
                                            #{{ $season->id }} | {{ $season->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                        </a>
                                    @empty
                                        <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $company,
                            'column' => 'description',
                        ])
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $company,
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
                            @if ($company->region)
                                <a href="{{ route('regions.show', $company->region?->id) }}" class="block text-sm text-primary underline">
                                    {{ $company->region?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                            @if ($company->subregion)
                                <a href="{{ route('subregions.show', $company->subregion->id) }}" class="block text-sm text-primary underline">
                                    {{ $company->subregion->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($company->country)
                                <a href="{{ route('countries.show', $company->country?->id) }}" class="block text-sm text-primary underline">
                                    {{ $company->country?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            @if ($company->state)
                                <a href="{{ route('states.show', $company->state?->id) }}" class="block text-sm text-primary underline">
                                    {{ $company->state?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($company->city)
                                <a href="{{ route('cities.show', $company->city?->id) }}" class="block text-sm text-primary underline">
                                    {{ $company->city?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $company->street ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.box') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $company->box ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $company->postal_code ?? __('main.na') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.map') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    @if ($company->latitude && $company->longitude)
                        <div>
                            <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $company->latitude }}, {{ $company->longitude }}
                            </p>
                        </div>
                        <div class="col-span-full mt-4">
                            <label class="kt-label block mb-1">{{ __('main.map') }}</label>
                            <a href="https://maps.google.com?q={{ $company->latitude }},{{ $company->longitude }}" target="_blank" class="text-sm text-primary hover:underline">
                                {{ __('main.view_on_google_maps') }}
                            </a>
                            <div class="w-full bg-white p-4 rounded-lg shadow-lg">
                                <div id="map" data-title="{{ $company->title }}" data-latitude="{{ $company->latitude }}" data-longitude="{{ $company->longitude }}"
                                    class="rounded-md overflow-hidden shadow"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-col gap-4">
                        @foreach ($company->contacts as $contact)
                            <h3 class="kt-card-title text-sm text-secondary-foreground mb-0">
                                <span class="kt-badge kt-badge-info">
                                    {{ $contact->department }}
                                </span>
                            </h3>
                            <div class="kt-card p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @if ($contact->email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="mailto:{{ $contact->email }}" class="text-primary hover:underline">
                                                {{ $contact->email }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                @if ($contact->phone)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="tel:{{ $contact->phone }}" class="text-primary hover:underline">
                                                {{ $contact->phone }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                @if ($contact->mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="tel:{{ $contact->mobile }}" class="text-primary hover:underline">
                                                {{ $contact->mobile }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                @if ($contact->phone_ext)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.phone_ext') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $contact->phone_ext }}</p>
                                    </div>
                                @endif
                                @if ($contact->fax)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $contact->fax }}</p>
                                    </div>
                                @endif
                                @if ($company->website)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="{{ $company->website }}" target="_blank" class="text-primary hover:underline">
                                                {{ $company->website }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $company])

            <!-- Vehicle Types -->
            @if ($company->vehicleTypes->count() > 0)
                @include('pages.dashboard.related-components.transportations-vehicle-types', [
                    'record' => $company,
                ])
            @endif

            <!-- Seasons -->
            @if ($company->seasons->count() > 0)
                @include('pages.dashboard.related-components.seasons', [
                    'record' => $company,
                    'type' => 'transportation',
                ])
            @endif

            <!-- Supplements -->
            @if ($company->supplements->count() > 0)
                @include('pages.dashboard.related-components.supplements', [
                    'record' => $company,
                    'type' => 'transportation',
                ])
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'transportations.companies',
                    'id' => $company->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'transportations.companies',
                    'id' => $company->id,
                ])
                <a href="{{ route('transportations.companies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.companies')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
