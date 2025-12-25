@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.room')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $room->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('rooms.edit', $room->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
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
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->name_ar ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.max_occupancy') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->max_occupancy ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.occupancy_details') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->occupancy_details ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price_per_person_double') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->price_per_person_double, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.single_room_supplement') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->single_room_supplement, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.triple_room_discount') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->triple_room_discount, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.third_person_price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->third_person_price, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.extra_bed_price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->extra_bed_price, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sea_view_supplement') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->sea_view_supplement, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div wire:key="toggle-{{ $room->id }}-is_active">
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $room->id,
                                    'modelType' => '\\App\\Models\\Room',
                                    'field' => 'is_active',
                                    'value' => (bool) $room->is_active,
                                    'table' => 'rooms',
                                ])
                            </div>
                        </div>
                        @if ($room->description)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-2">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $room->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($room->notes)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $room->notes !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Accommodations or Restaurants -->
            @if (getOrderedModelType('\\', $room->model_type, 2) == ucfirst('accommodation') && $room->model)
                <!-- Accommodations -->
                <div class="kt-card bg-yellow-100 record-accommodations-{{ $room->model->id }}">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.accommodation')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="kt-card bg-white rounded-lg p-4 pt-2" wire:key="accommodation-{{ $room->model->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $room->model->name ?: __('main.na') }}</p>
                                </div>
                                @if ($room->model->name_ar)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $room->model->name_ar }}
                                        </p>
                                    </div>
                                @endif
                                @if ($room->model->type)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                        <div>
                                            <a href="{{ route('types.show', $room->model->type->id) }}"
                                                class="kt-badge kt-badge-primary">
                                                {{ $room->model->type->name ?: __('main.na') }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($room->model->classification)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                        <div>
                                            <span class="kt-badge kt-badge-info">
                                                {{ $room->model->classification ?: __('main.na') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($room->model->stars)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $room->model->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                                @if ($room->model->currency)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->currency->code }} -
                                            {{ $room->model->currency->name }}</p>
                                    </div>
                                @endif
                                @if ($room->model->city || $room->model->country)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->city?->name ?? '' }}
                                            {{ $room->model->city && $room->model->country ? ', ' : '' }}
                                            {{ $room->model->country?->name ?? '' }}
                                        </p>
                                    </div>
                                @endif
                                @if ($room->model->general_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->general_mobile }}</p>
                                    </div>
                                @endif
                                @if ($room->model->general_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->general_email }}</p>
                                    </div>
                                @endif
                                @if ($room->model->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->contact_person }}</p>
                                    </div>
                                @endif
                                @if ($room->model->street)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $room->model->street }}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-span-2 flex items-center gap-10 mb-2">
                                    <div wire:key="toggle-{{ $room->model->id }}-is_active">
                                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                        <div class="flex items-center gap-2">
                                            @livewire('toggle-switch', [
                                                'modelId' => $room->model->id,
                                                'modelType' => '\\App\\Models\\Accommodation',
                                                'field' => 'is_active',
                                                'value' => (bool) $room->model->is_active,
                                                'table' => 'accommodations',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($room->model->notes)
                                <div class="lg:col-span-2 mt-2">
                                    <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $room->model->notes !!}</div>
                                </div>
                            @endif
                            <div class="lg:col-span-2 flex gap-2 mt-2">
                                @include('components.elements.show-button', [
                                    'models' => 'accommodations',
                                    'id' => $room->model->id,
                                ])
                                @include('components.elements.edit-button', [
                                    'models' => 'accommodations',
                                    'id' => $room->model->id,
                                ])
                                @livewire('delete-bottom', [
                                    'type' => 'accommodations',
                                    'modelId' => $room->model->id,
                                    'modelType' => '\\App\\Models\\Accommodation',
                                    'table' => 'accommodations',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(getOrderedModelType('\\', $room->model_type, 2) == ucfirst('restaurant') && $room->model)
                <!-- Restaurants -->
                <div class="kt-card bg-blue-100 record-restaurants-{{ $room->model->id }}">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.restaurant')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="kt-card bg-white rounded-lg p-4 pt-2" wire:key="restaurant-{{ $room->model->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $room->model->name ?: __('main.na') }}</p>
                                </div>
                                @if ($room->model->name_ar)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $room->model->name_ar }}
                                        </p>
                                    </div>
                                @endif
                                @if ($room->model->type)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                        <div>
                                            <a href="{{ route('types.show', $room->model->type->id) }}"
                                                class="kt-badge kt-badge-primary">
                                                {{ $room->model->type->name ?: __('main.na') }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($room->model->classification)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                        <div>
                                            <span class="kt-badge kt-badge-primary">
                                                {{ $room->model->classification ?: __('main.na') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($room->model->stars)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $room->model->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                                @if ($room->model->currency)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->currency->code }} -
                                            {{ $room->model->currency->name }}</p>
                                    </div>
                                @endif
                                @if ($room->model->city || $room->model->country)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->city?->name ?? '' }}
                                            {{ $room->model->city && $room->model->country ? ', ' : '' }}
                                            {{ $room->model->country?->name ?? '' }}
                                        </p>
                                    </div>
                                @endif
                                @if ($room->model->general_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->general_mobile }}</p>
                                    </div>
                                @endif
                                @if ($room->model->general_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->general_email }}</p>
                                    </div>
                                @endif
                                @if ($room->model->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->model->contact_person }}</p>
                                    </div>
                                @endif
                                @if ($room->model->street)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $room->model->street }}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-span-full flex items-center gap-10 mb-2">
                                    <div wire:key="toggle-{{ $room->model->id }}-is_active">
                                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                        <div class="flex items-center gap-2">
                                            @livewire('toggle-switch', [
                                                'modelId' => $room->model->id,
                                                'modelType' => '\\App\\Models\\Accommodation',
                                                'field' => 'is_active',
                                                'value' => (bool) $room->model->is_active,
                                                'table' => 'restaurants',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($room->model->description)
                                <div class="col-span-full mt-2">
                                    <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $room->model->description !!}</div>
                                </div>
                            @endif
                            @if ($room->model->notes)
                                <div class="col-span-full mt-2">
                                    <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                    <div class="text-sm text-secondary-foreground">{!! $room->model->notes !!}</div>
                                </div>
                            @endif
                            <div class="lg:col-span-2 flex gap-2 mt-2">
                                @include('components.elements.show-button', [
                                    'models' => 'restaurants',
                                    'id' => $room->model->id,
                                ])
                                @include('components.elements.edit-button', [
                                    'models' => 'restaurants',
                                    'id' => $room->model->id,
                                ])
                                @livewire('delete-bottom', [
                                    'type' => 'restaurants',
                                    'modelId' => $room->model->id,
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
                    'models' => 'rooms',
                    'id' => $room->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'rooms',
                    'id' => $room->id,
                ])
                <a href="{{ route('rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
