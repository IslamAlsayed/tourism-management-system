@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $type['name'] }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('types.edit', $type['id']) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.type')]) }}
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
                        @if ($type['name'])
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $type['name'] ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($type['name_ar'])
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $type['name_ar'] ?: __('main.na') }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $type['id'],
                                    'modelType' => '\\App\\Models\\Type',
                                    'field' => 'is_active',
                                    'value' => (bool) $type['is_active'],
                                    'table' => 'types',
                                ])
                            </div>
                        </div>
                        @if ($type['description'])
                            <div class="col-span-full mt-2 border-custom-t pt-2">
                                <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $type['description'] !!}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $type['created_at']?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $type['updated_at']?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accommodations -->
            @if (count($type->accommodations) > 0)
                <div class="kt-card bg-blue-100">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.accommodation')]) }}
                            <span class="text-primary font-semibold">({{ count($type->accommodations) }})</span>
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex flex-col gap-4">
                            @foreach ($type->accommodations as $accommodation)
                                <div wire:key="accommodation-{{ $accommodation->id }}"
                                    class="kt-card p-4 record-accommodations-{{ $accommodation->id }}">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                            <p class="text-sm text-secondary-foreground">
                                                {{ $accommodation->name ?: __('main.na') }}</p>
                                        </div>
                                        @if ($accommodation->name_ar)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                                <p class="text-sm text-secondary-foreground">
                                                    {{ $accommodation->name_ar }}
                                                </p>
                                            </div>
                                        @endif
                                        @if ($accommodation->classification)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                                <div>
                                                    <span class="kt-badge kt-badge-primary">
                                                        {{ $accommodation->classification ?: __('main.na') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($accommodation->stars)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                                <div class="flex items-center gap-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fas fa-star {{ $i <= $accommodation->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endif
                                        @if ($accommodation->currency)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                                <p class="text-sm text-secondary-foreground">
                                                    {{ $accommodation->currency->code }} -
                                                    {{ $accommodation->currency->name }}</p>
                                            </div>
                                        @endif
                                        @if ($accommodation->city || $accommodation->country)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                                <p class="text-sm text-secondary-foreground">
                                                    {{ $accommodation->city?->name ?? '' }}
                                                    {{ $accommodation->city && $accommodation->country ? ', ' : '' }}
                                                    {{ $accommodation->country?->name ?? '' }}
                                                </p>
                                            </div>
                                        @endif
                                        @if ($accommodation->general_mobile)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                                <p class="text-sm text-secondary-foreground">
                                                    {{ $accommodation->general_mobile }}</p>
                                            </div>
                                        @endif
                                        @if ($accommodation->general_email)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                                <p class="text-sm text-secondary-foreground">
                                                    {{ $accommodation->general_email }}</p>
                                            </div>
                                        @endif
                                        @if ($accommodation->contact_person)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                                <p class="text-sm text-secondary-foreground">
                                                    {{ $accommodation->contact_person }}</p>
                                            </div>
                                        @endif
                                        @if ($accommodation->street)
                                            <div>
                                                <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                                <p class="text-sm text-secondary-foreground">
                                                    {{ $accommodation->street }}
                                                </p>
                                            </div>
                                        @endif
                                        <div class="col-span-2 flex items-center gap-10 mb-2">
                                            <div wire:key="toggle-{{ $accommodation->id }}-is_active">
                                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                                <div class="flex items-center gap-2">
                                                    @livewire('toggle-switch', [
                                                        'modelId' => $accommodation->id,
                                                        'modelType' => '\\App\\Models\\Accommodation',
                                                        'field' => 'is_active',
                                                        'value' => (bool) $accommodation->is_active,
                                                        'table' => 'accommodations',
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($accommodation->notes)
                                        <div class="lg:col-span-2 mt-2">
                                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                            <div class="text-sm text-secondary-foreground">{!! $accommodation->notes !!}</div>
                                        </div>
                                    @endif
                                    <div class="lg:col-span-2 flex gap-2 mt-4">
                                        @include('components.elements.show-button', [
                                            'models' => 'accommodations',
                                            'id' => $accommodation->id,
                                        ])
                                        @include('components.elements.edit-button', [
                                            'models' => 'accommodations',
                                            'id' => $accommodation->id,
                                        ])
                                        @livewire('delete-bottom', [
                                            'type' => 'accommodations',
                                            'modelId' => $accommodation->id,
                                            'modelType' => '\\App\\Models\\Accommodation',
                                            'table' => 'accommodations',
                                        ])
                                    </div>
                                </div>
                            @endforeach
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
                            <a href="{{ route('restaurants.create') }}" class="kt-btn bg-primary text-white" toggle-button>
                                {{ __('main.create_type', ['type' => __('main.restaurant')]) }}
                            </a>
                        </div>
                    </div>
                    <div class="kt-card-body p-4">
                        <p class="text-sm text-secondary-foreground">
                            {{ __('main.no_associated_type_details', ['type' => __('main.type')]) }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'types',
                    'id' => $type['id'],
                ])
                @include('components.elements.delete-form', [
                    'model' => 'types',
                    'id' => $type['id'],
                ])
                <a href="{{ route('types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.types')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
