@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.season')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $season->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('seasons.edit', $season->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('seasons.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.seasons')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($season->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $season->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($season->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $season->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($season->season_from)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_from') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $season->season_from->format('Y-m-d') ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($season->season_to)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_to') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $season->season_to->format('Y-m-d') ?: __('main.na') }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $season->id,
                                    'modelType' => '\\App\\Models\\Season',
                                    'field' => 'is_active',
                                    'value' => (bool) $season->is_active,
                                    'table' => 'seasons',
                                ])
                            </div>
                        </div>
                        @if ($season->description)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-2">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $season->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($season->notes)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $season->notes !!}
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
                        @if ($season->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $season->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $season->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($season->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $season->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $season->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Accommodations or Restaurants -->
            @if (getOrderedModelType('\\', $season->model_type, 2) == ucfirst('accommodation') && $season->model)
                <!-- Accommodations -->
                <div class="kt-card bg-yellow-100 record-accommodations-{{ $season->model->id }}">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.accommodation')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="kt-card bg-white rounded-lg p-4 pt-2"
                            wire:key="accommodation-{{ $season->model->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $season->model->name ?: __('main.na') }}</p>
                                </div>
                                @if ($season->model->name_ar)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $season->model->name_ar }}
                                        </p>
                                    </div>
                                @endif
                                @if ($season->model->type)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                        <div>
                                            <a href="{{ route('types.show', $season->model->type->id) }}"
                                                class="kt-badge kt-badge-primary">
                                                {{ $season->model->type->name ?: __('main.na') }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($season->model->classification)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                        <div>
                                            <span class="kt-badge kt-badge-info">
                                                {{ $season->model->classification ?: __('main.na') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($season->model->stars)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $season->model->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                                @if ($season->model->currency)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->currency->code }} -
                                            {{ $season->model->currency->name }}</p>
                                    </div>
                                @endif
                                @if ($season->model->city || $season->model->country)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->city?->name ?? '' }}
                                            {{ $season->model->city && $season->model->country ? ', ' : '' }}
                                            {{ $season->model->country?->name ?? '' }}
                                        </p>
                                    </div>
                                @endif
                                @if ($season->model->general_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->general_mobile }}</p>
                                    </div>
                                @endif
                                @if ($season->model->general_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->general_email }}</p>
                                    </div>
                                @endif
                                @if ($season->model->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->contact_person }}</p>
                                    </div>
                                @endif
                                @if ($season->model->street)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $season->model->street }}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-span-2 flex items-center gap-10 mb-2">
                                    <div wire:key="toggle-{{ $season->model->id }}-is_active">
                                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                        <div class="flex items-center gap-2">
                                            @livewire('toggle-switch', [
                                                'modelId' => $season->model->id,
                                                'modelType' => '\\App\\Models\\Accommodation',
                                                'field' => 'is_active',
                                                'value' => (bool) $season->model->is_active,
                                                'table' => 'accommodations',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($season->model->notes)
                                <div class="lg:col-span-2 mt-2">
                                    <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $season->model->notes !!}</div>
                                </div>
                            @endif
                            <div class="lg:col-span-2 flex gap-2 mt-2">
                                @include('components.elements.show-button', [
                                    'models' => 'accommodations',
                                    'id' => $season->model->id,
                                ])
                                @include('components.elements.edit-button', [
                                    'models' => 'accommodations',
                                    'id' => $season->model->id,
                                ])
                                @livewire('delete-bottom', [
                                    'type' => 'accommodations',
                                    'modelId' => $season->model->id,
                                    'modelType' => '\\App\\Models\\Accommodation',
                                    'table' => 'accommodations',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(getOrderedModelType('\\', $season->model_type, 2) == ucfirst('restaurant') && $season->model)
                <!-- Restaurants -->
                <div class="kt-card bg-blue-100 record-restaurants-{{ $season->model->id }}">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.restaurant')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="kt-card bg-white rounded-lg p-4 pt-2" wire:key="restaurant-{{ $season->model->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $season->model->name ?: __('main.na') }}</p>
                                </div>
                                @if ($season->model->name_ar)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $season->model->name_ar }}
                                        </p>
                                    </div>
                                @endif
                                @if ($season->model->type)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                        <div>
                                            <a href="{{ route('types.show', $season->model->type->id) }}"
                                                class="kt-badge kt-badge-primary">
                                                {{ $season->model->type->name ?: __('main.na') }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($season->model->classification)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                        <div>
                                            <span class="kt-badge kt-badge-primary">
                                                {{ $season->model->classification ?: __('main.na') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($season->model->stars)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $season->model->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                                @if ($season->model->currency)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->currency->code }} -
                                            {{ $season->model->currency->name }}</p>
                                    </div>
                                @endif
                                @if ($season->model->city || $season->model->country)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->city?->name ?? '' }}
                                            {{ $season->model->city && $season->model->country ? ', ' : '' }}
                                            {{ $season->model->country?->name ?? '' }}
                                        </p>
                                    </div>
                                @endif
                                @if ($season->model->general_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->general_mobile }}</p>
                                    </div>
                                @endif
                                @if ($season->model->general_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->general_email }}</p>
                                    </div>
                                @endif
                                @if ($season->model->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->model->contact_person }}</p>
                                    </div>
                                @endif
                                @if ($season->model->street)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $season->model->street }}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-span-full flex items-center gap-10 mb-2">
                                    <div wire:key="toggle-{{ $season->model->id }}-is_active">
                                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                        <div class="flex items-center gap-2">
                                            @livewire('toggle-switch', [
                                                'modelId' => $season->model->id,
                                                'modelType' => '\\App\\Models\\Accommodation',
                                                'field' => 'is_active',
                                                'value' => (bool) $season->model->is_active,
                                                'table' => 'restaurants',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($season->model->description)
                                <div class="col-span-full mt-2">
                                    <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $season->model->description !!}</div>
                                </div>
                            @endif
                            @if ($season->model->notes)
                                <div class="col-span-full mt-2">
                                    <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $season->model->notes !!}</div>
                                </div>
                            @endif
                            <div class="lg:col-span-2 flex gap-2 mt-2">
                                @include('components.elements.show-button', [
                                    'models' => 'restaurants',
                                    'id' => $season->model->id,
                                ])
                                @include('components.elements.edit-button', [
                                    'models' => 'restaurants',
                                    'id' => $season->model->id,
                                ])
                                @livewire('delete-bottom', [
                                    'type' => 'restaurants',
                                    'modelId' => $season->model->id,
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
                    'models' => 'seasons',
                    'id' => $season->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'seasons',
                    'id' => $season->id,
                ])
                <a href="{{ route('seasons.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.seasons')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
