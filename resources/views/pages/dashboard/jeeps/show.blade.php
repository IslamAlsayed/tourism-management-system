@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.jeep')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $jeep->originCity?->name ?? __('main.na') }} → {{ $jeep->destinationCity?->name ?? __('main.na') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('jeeps.edit', $jeep->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('jeeps.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.jeeps')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div class="col-span-full">
                            <label class="kt-label mb-1">{{ __('main.route') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $jeep->route }}</p>
                        </div>
                        @if ($jeep->route_ar)
                            <div class="col-span-full">
                                <label class="kt-label mb-1">{{ __('main.route_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $jeep->route_ar }}</p>
                            </div>
                        @endif
                        @if ($jeep->originCity)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.origin_city') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $jeep->originCity->name }}</p>
                            </div>
                        @endif
                        @if ($jeep->destinationCity)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.destination_city') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $jeep->destinationCity->name }}</p>
                            </div>
                        @endif
                        @if ($jeep->company)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.company') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $jeep->company->name }}</p>
                            </div>
                        @endif
                        <div class="col-span-full">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 items-center gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.status') }}</label>
                                    <select class="kt-input kt-input-sm basic-single js-async-field" data-model="jeeps" data-id="{{ $jeep->id }}" data-field="status">
                                        <option value="active" {{ $jeep->status === 'active' ? 'selected' : '' }}>
                                            {{ __('main.active') }}
                                        </option>
                                        <option value="maintenance" {{ $jeep->status === 'maintenance' ? 'selected' : '' }}>
                                            {{ __('main.maintenance') }}
                                        </option>
                                        <option value="retired" {{ $jeep->status === 'retired' ? 'selected' : '' }}>
                                            {{ __('main.retired') }}
                                        </option>
                                    </select>

                                    <div class="hidden js-loader">
                                        <div class="loader-spinner"></div>
                                    </div>
                                </div>
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                    <div class="flex items-center gap-2">
                                        @livewire('toggle-switch', [
                                            'modelId' => $jeep->id,
                                            'modelType' => '\\App\\Models\\Jeep',
                                            'field' => 'is_active',
                                            'value' => (bool) $jeep->is_active,
                                            'table' => 'jeeps',
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $jeep,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $jeep,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Route Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.route_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 10px 70px">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.duration') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $jeep->duration ?? '-' }} {{ $jeep->duration ? __('main.' . $jeep->duration_unit) : '' }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.distance') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $jeep->distance ?? '-' }} {{ $jeep->distance ? __('main.' . $jeep->distance_unit) : '' }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.car_seats') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $jeep->car_seats ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.pricing_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 10px 70px">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $jeep->price ? number_format($jeep->price, 2) : '-' }}
                                @if ($jeep->currency)
                                    <span class="text-primary font-semibold">{{ $jeep->currency->code }}</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price_type') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ __('main.' . $jeep->price_type) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => 'vehicle']) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 10px 70px">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.vehicle_model') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $jeep->vehicle_model ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.model_year') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $jeep->model_year ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.license_plate') }}</label>
                            <p class="text-sm text-secondary-foreground font-mono">{{ $jeep->license_plate ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.features') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 10px 40px;">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.has_ac') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $jeep->id,
                                    'modelType' => '\\App\\Models\\Jeep',
                                    'field' => 'has_ac',
                                    'value' => (bool) $jeep->has_ac,
                                    'table' => 'jeeps',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.has_driver') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $jeep->id,
                                    'modelType' => '\\App\\Models\\Jeep',
                                    'field' => 'has_driver',
                                    'value' => (bool) $jeep->has_driver,
                                    'table' => 'jeeps',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_4x4') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $jeep->id,
                                    'modelType' => '\\App\\Models\\Jeep',
                                    'field' => 'is_4x4',
                                    'value' => (bool) $jeep->is_4x4,
                                    'table' => 'jeeps',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.has_camping_gear') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $jeep->id,
                                    'modelType' => '\\App\\Models\\Jeep',
                                    'field' => 'has_camping_gear',
                                    'value' => (bool) $jeep->has_camping_gear,
                                    'table' => 'jeeps',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $jeep->id,
                                    'modelType' => '\\App\\Models\\Jeep',
                                    'field' => 'is_active',
                                    'value' => (bool) $jeep->is_active,
                                    'table' => 'jeeps',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_featured') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $jeep->id,
                                    'modelType' => '\\App\\Models\\Jeep',
                                    'field' => 'is_featured',
                                    'value' => (bool) $jeep->is_featured,
                                    'table' => 'jeeps',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Route Itinerary -->
            @if (!empty($jeep->route_itinerary) && count(json_decode($jeep->route_itinerary)) > 0)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.route_itinerary') }}
                            <strong class="text-primary">({{ count(json_decode($jeep->route_itinerary)) }})</strong>
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-4">
                                @foreach (json_decode($jeep->route_itinerary) as $index => $item)
                                    <div class="flex items-center gap-3 p-2 bg-gray-50 rounded">
                                        <span class="text-sm font-semibold text-primary">{{ $index + 1 }}.</span>
                                        <span class="text-sm text-secondary-foreground">{{ $item->value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.route_itinerary') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <p class="text-sm text-secondary-foreground">{{ __('main.no_data_available') }}</p>
                    </div>
                </div>
            @endif

            <!-- Media Files -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.media_resources') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-col gap-6">
                        @if ($jeep->photo)
                            <div class="flex flex-col w-fit">
                                <label class="kt-label mb-2">{{ __('main.photo') }}</label>
                                <div class="image-container">
                                    @if ($jeep->photo)
                                        <img src="{{ asset('storage/' . $jeep->photo) }}" alt="Main Image" class="w-auto h-[250px] object-cover shadow" loading="lazy">
                                    @else
                                        <div class="h-40 bg-gray-200 flex items-center justify-center">
                                            <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                        </div>
                                    @endif
                                    <div class="image-overlay">
                                        <a href="{{ $jeep->photo ? asset('storage/' . $jeep->photo) : '#' }}" download="{{ $jeep->photo }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                            <i class="fas fa-download text-sm me-1"></i>
                                            <span>{{ __('main.download') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($jeep->gallery && count($jeep->gallery) > 0)
                            <div>
                                <label class="kt-label mb-3">{{ __('main.gallery_images') }}
                                    <span class="text-xs text-primary">
                                        ({{ count($jeep->gallery) }} {{ __('main.images') }})
                                    </span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach ($jeep->gallery as $index => $image)
                                        <div class="image-container">
                                            @if ($image)
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ __('main.gallery') }} {{ $index + 1 }}" class="w-full h-32 object-cover" loading="lazy">
                                            @else
                                                <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                                    <p class="text-xs text-secondary-foreground">{{ __('main.na') }}</p>
                                                </div>
                                            @endif
                                            <div class="image-overlay">
                                                <a href="{{ $image ? asset('storage/' . $image) : '#' }}" download="{{ $image }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                                    <i class="fas fa-download text-sm me-1"></i>
                                                    <span>{{ __('main.download') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $jeep])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'jeeps',
                    'id' => $jeep->id,
                ])
                @include('components.elements.delete-form', [
                    'models' => 'jeeps',
                    'id' => $jeep->id,
                ])
                <a href="{{ route('jeeps.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.jeeps')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.basic-single').select2();

            $(document).on('focus', '.js-async-field', function() {
                $(this).data('old-value', this.value);
            });

            $(document).on('change', '.js-async-field', async function() {
                const $select = $(this);
                const wrapper = $select.closest('div');
                const loader = wrapper.find('.js-loader');

                const payload = {
                    model: $select.data('model'),
                    id: $select.data('id'),
                    field: $select.data('field'),
                    value: $select.val(),
                };

                loader.removeClass('hidden');
                $select.prop('disabled', true);

                try {
                    const res = await fetch('{{ route('patch.toggleField') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify(payload),
                    });

                    const data = await res.json();

                    if (!res.ok || !data.success) {
                        throw data;
                    }

                    window.showToast({
                        type: 'success',
                        message: data.message || `{{ __('messages.field_updated_successfully', ['field' => ':field', 'status' => ':status']) }}`.replace(':field', payload
                            .field).replace(':status', payload.value)
                    });
                } catch (e) {
                    $select.val($select.data('old-value')).trigger('change.select2');
                    window.showToast({
                        type: 'error',
                        message: e.message || '{{ __('messages.something_went_wrong') }}'
                    });
                } finally {
                    loader.addClass('hidden');
                    $select.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
