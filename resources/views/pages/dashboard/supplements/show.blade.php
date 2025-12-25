@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.supplement')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $supplement->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $supplement->accommodation?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('supplements.edit', $supplement->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Supplement Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.supplement')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($supplement->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $supplement->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($supplement->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $supplement->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($supplement->price)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($supplement->price, 2) }}
                                    {{ $settings->app_default_currency }}
                                    @if ($supplement->currency)
                                        {{ $supplement->currency->code }}
                                    @endif
                                </p>
                            </div>
                        @endif
                        @if ($supplement->price_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price_type') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <span class="kt-badge kt-badge-info">{{ $supplement->price_type }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($supplement->applicable_date)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.applicable_date') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $supplement->applicable_date->format('Y-m-d') }}
                                </p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $supplement->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $supplement->id,
                                        'modelType' => '\\App\\Models\\supplement',
                                        'field' => 'is_active',
                                        'value' => (bool) $supplement->is_active,
                                        'table' => 'supplements',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $supplement->id }}-is_mandatory">
                                <label class="kt-label mb-1">{{ __('main.is_mandatory') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $supplement->id,
                                        'modelType' => '\\App\\Models\\supplement',
                                        'field' => 'is_mandatory',
                                        'value' => (bool) $supplement->is_mandatory,
                                        'table' => 'supplements',
                                    ])
                                </div>
                            </div>
                        </div>
                        @if ($supplement->description)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-2">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $supplement->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($supplement->notes)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $supplement->notes !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($supplement->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $supplement->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $supplement->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($supplement->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $supplement->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $supplement->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Accommodations or Restaurants -->
            @if (getOrderedModelType('\\', $supplement->model_type, 2) == ucfirst('accommodation') && $supplement->model)
                <!-- Accommodations -->
                <div class="kt-card bg-yellow-100 record-accommodations-{{ $supplement->model->id }}">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.accommodation')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="kt-card bg-white rounded-lg p-4 pt-2"
                            wire:key="accommodation-{{ $supplement->model->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $supplement->model->name ?: __('main.na') }}</p>
                                </div>
                                @if ($supplement->model->name_ar)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $supplement->model->name_ar }}
                                        </p>
                                    </div>
                                @endif
                                @if ($supplement->model->type)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                        <div>
                                            <a href="{{ route('types.show', $supplement->model->type->id) }}"
                                                class="kt-badge kt-badge-primary">
                                                {{ $supplement->model->type->name ?: __('main.na') }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($supplement->model->classification)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                        <div>
                                            <span class="kt-badge kt-badge-info">
                                                {{ $supplement->model->classification ?: __('main.na') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($supplement->model->stars)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $supplement->model->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                                @if ($supplement->model->currency)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->currency->code }} -
                                            {{ $supplement->model->currency->name }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->city || $supplement->model->country)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->city?->name ?? '' }}
                                            {{ $supplement->model->city && $supplement->model->country ? ', ' : '' }}
                                            {{ $supplement->model->country?->name ?? '' }}
                                        </p>
                                    </div>
                                @endif
                                @if ($supplement->model->general_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->general_mobile }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->general_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->general_email }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->contact_person }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->street)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $supplement->model->street }}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-span-2 flex items-center gap-10 mb-2">
                                    <div wire:key="toggle-{{ $supplement->model->id }}-is_active">
                                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                        <div class="flex items-center gap-2">
                                            @livewire('toggle-switch', [
                                                'modelId' => $supplement->model->id,
                                                'modelType' => '\\App\\Models\\Accommodation',
                                                'field' => 'is_active',
                                                'value' => (bool) $supplement->model->is_active,
                                                'table' => 'accommodations',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($supplement->model->notes)
                                <div class="lg:col-span-2 mt-2">
                                    <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $supplement->model->notes !!}</div>
                                </div>
                            @endif
                            <div class="lg:col-span-2 flex gap-2 mt-2">
                                @include('components.elements.show-button', [
                                    'models' => 'accommodations',
                                    'id' => $supplement->model->id,
                                ])
                                @include('components.elements.edit-button', [
                                    'models' => 'accommodations',
                                    'id' => $supplement->model->id,
                                ])
                                @livewire('delete-bottom', [
                                    'type' => 'accommodations',
                                    'modelId' => $supplement->model->id,
                                    'modelType' => '\\App\\Models\\Accommodation',
                                    'table' => 'accommodations',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(getOrderedModelType('\\', $supplement->model_type, 2) == ucfirst('restaurant') && $supplement->model)
                <!-- Restaurants -->
                <div class="kt-card bg-blue-100 record-restaurants-{{ $supplement->model->id }}">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.restaurant')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="kt-card bg-white rounded-lg p-4 pt-2"
                            wire:key="restaurant-{{ $supplement->model->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $supplement->model->name ?: __('main.na') }}</p>
                                </div>
                                @if ($supplement->model->name_ar)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $supplement->model->name_ar }}
                                        </p>
                                    </div>
                                @endif
                                @if ($supplement->model->type)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                        <div>
                                            <a href="{{ route('types.show', $supplement->model->type->id) }}"
                                                class="kt-badge kt-badge-primary">
                                                {{ $supplement->model->type->name ?: __('main.na') }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($supplement->model->classification)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                        <div>
                                            <span class="kt-badge kt-badge-primary">
                                                {{ $supplement->model->classification ?: __('main.na') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($supplement->model->stars)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $supplement->model->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                                @if ($supplement->model->currency)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->currency->code }} -
                                            {{ $supplement->model->currency->name }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->city || $supplement->model->country)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->city?->name ?? '' }}
                                            {{ $supplement->model->city && $supplement->model->country ? ', ' : '' }}
                                            {{ $supplement->model->country?->name ?? '' }}
                                        </p>
                                    </div>
                                @endif
                                @if ($supplement->model->general_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->general_mobile }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->general_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->general_email }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->model->contact_person }}</p>
                                    </div>
                                @endif
                                @if ($supplement->model->street)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $supplement->model->street }}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-span-full flex items-center gap-10 mb-2">
                                    <div wire:key="toggle-{{ $supplement->model->id }}-is_active">
                                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                        <div class="flex items-center gap-2">
                                            @livewire('toggle-switch', [
                                                'modelId' => $supplement->model->id,
                                                'modelType' => '\\App\\Models\\Accommodation',
                                                'field' => 'is_active',
                                                'value' => (bool) $supplement->model->is_active,
                                                'table' => 'restaurants',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($supplement->model->description)
                                <div class="col-span-full mt-2">
                                    <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $supplement->model->description !!}</div>
                                </div>
                            @endif
                            @if ($supplement->model->notes)
                                <div class="col-span-full mt-2">
                                    <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $supplement->model->notes !!}</div>
                                </div>
                            @endif
                            <div class="lg:col-span-2 flex gap-2 mt-2">
                                @include('components.elements.show-button', [
                                    'models' => 'restaurants',
                                    'id' => $supplement->model->id,
                                ])
                                @include('components.elements.edit-button', [
                                    'models' => 'restaurants',
                                    'id' => $supplement->model->id,
                                ])
                                @livewire('delete-bottom', [
                                    'type' => 'restaurants',
                                    'modelId' => $supplement->model->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'table' => 'restaurants',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Associated Type Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.no_associated_type')]) }}
                        </h3>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('accommodations.create') }}" class="kt-btn bg-primary text-white"
                                toggle-button>
                                {{ __('main.create_type', ['type' => __('main.accommodation')]) }}
                            </a>
                            <a href="{{ route('restaurants.create') }}" class="kt-btn bg-primary text-white"
                                toggle-button>
                                {{ __('main.create_type', ['type' => __('main.restaurant')]) }}
                            </a>
                        </div>
                    </div>
                    <div class="kt-card-body p-4">
                        <p class="text-sm text-secondary-foreground">
                            {{ __('main.no_associated_type_details', ['type' => __('main.season')]) }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'supplements',
                    'id' => $supplement->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'supplements',
                    'id' => $supplement->id,
                ])
                <a href="{{ route('supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
