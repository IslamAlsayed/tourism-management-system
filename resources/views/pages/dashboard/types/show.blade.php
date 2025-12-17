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
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
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
                            <p class="text-sm text-secondary-foreground">{{ $type['name'] ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $type['name_ar'] ?: __('main.na') }}</p>
                        </div>
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
                            <p class="text-sm text-secondary-foreground">{{ $type['created_at']?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $type['updated_at']?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accommodations -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.accommodations') }}</h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('accommodations.create') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.accommodation')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4" wire:ignore>
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($type->accommodations as $accommodation)
                            <div wire:key="accommodation-{{ $accommodation->id }}"
                                class="kt-card bg-gray-50 rounded-lg p-4 pt-2">
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $accommodation->name }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($accommodation->price, 2) }}
                                            {{ $accommodation->currency?->code }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $accommodation->classification }}
                                        </p>
                                    </div>
                                    @if ($accommodation->stars)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                            <div class="flex items-center gap-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $accommodation->stars)
                                                        <i class="fas fa-star text-yellow-500 text-sm"></i>
                                                    @else
                                                        <i class="fas fa-star text-gray-300 text-sm"></i>
                                                    @endif
                                                @endfor
                                            </div>
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
                                    <div class="lg:col-span-2">
                                        <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                        <p class="text-sm text-secondary-foreground">{!! $accommodation->notes !!}</p>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-2">
                                    @include('components.elements.show-button', [
                                        'models' => 'accommodations',
                                        'id' => $accommodation->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'accommodations',
                                        'id' => $accommodation->id,
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                                <a href="{{ route('types.create') }}" class="kt-btn kt-btn-sm kt-btn-primary mt-4">
                                    <i class="ki-filled ki-plus text-sm me-1"></i>
                                    {{ __('main.add_first_accommodation') }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'types',
                    'id' => $type['id'],
                ])
                @livewire('delete-bottom', [
                    'type' => 'type',
                    'modelId' => $type['id'],
                    'modelType' => '\\App\\Models\\Type',
                    'table' => 'types',
                ])
                <a href="{{ route('types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.types')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
