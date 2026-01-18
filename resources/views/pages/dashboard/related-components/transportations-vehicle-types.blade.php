<!-- Vehicle Types -->
<div class="kt-card bg-yellow-100">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.vehicle-types') }}
            (<span class="font-semibold text-primary">{{ $company->vehicleTypes->count() }}</span>)
        </h3>
        <div class="kt-card-toolbar">
            <a href="{{ route('transportations.vehicle-types.create', [Str::random(120), 'type' => 'transportation']) }}"
                class="kt-btn kt-btn-sm kt-btn-primary">
                <i class="ki-filled ki-plus text-sm me-1"></i>
                {{ __('main.add_type', ['type' => __('main.vehicle-type')]) }}
            </a>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid lg:grid-cols-2 gap-4">
            @forelse($company->vehicleTypes as $vehicleType)
                <div wire:key="vehicleType-{{ $vehicleType->id }}"
                    class="kt-card background rounded-lg p-4 pt-2 record-transportation-vehicle-types-{{ $vehicleType->id }}">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $vehicleType->name ?: __('main.na') }}</p>
                        </div>
                        @if ($vehicleType->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->name_ar }}</p>
                            </div>
                        @endif
                        @if ($vehicleType->min_capacity)
                            <div>
                                <label class="kt-label mb-1">
                                    {{ __('main.min_capacity') }} {{ __('main.pax') }}
                                </label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->min_capacity }}</p>
                            </div>
                        @endif
                        @if ($vehicleType->max_capacity)
                            <div>
                                <label class="kt-label mb-1">
                                    {{ __('main.max_capacity') }} {{ __('main.pax') }}
                                </label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->max_capacity }}</p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $vehicleType->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $vehicleType->id,
                                        'modelType' => '\\App\\Models\\TransportationVehicleType',
                                        'field' => 'is_active',
                                        'value' => (bool) $vehicleType->is_active,
                                        'table' => 'transportations_vehicle_types',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $vehicleType->id }}-has_luggage">
                                <label class="kt-label mb-1">{{ __('main.has_luggage') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $vehicleType->id,
                                        'modelType' => '\\App\\Models\\TransportationVehicleType',
                                        'field' => 'has_luggage',
                                        'value' => (bool) $vehicleType->has_luggage,
                                        'table' => 'transportations_vehicle_types',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $vehicleType->id }}-is_air_conditioning">
                                <label class="kt-label mb-1">{{ __('main.is_air_conditioning') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $vehicleType->id,
                                        'modelType' => '\\App\\Models\\TransportationVehicleType',
                                        'field' => 'is_air_conditioning',
                                        'value' => (bool) $vehicleType->is_air_conditioning,
                                        'table' => 'transportations_vehicle_types',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('components.elements.display-desc-or-notes', [
                        'record' => $vehicleType,
                        'column' => 'description',
                    ])
                    @include('components.elements.display-desc-or-notes', [
                        'record' => $vehicleType,
                        'column' => 'notes',
                    ])
                    <div class="lg:col-span-2 flex gap-2 mt-4">
                        @include('components.elements.show-button', [
                            'models' => 'transportations.vehicle-types',
                            'id' => $vehicleType->id,
                        ])
                        @include('components.elements.edit-button', [
                            'models' => 'transportations.vehicle-types',
                            'id' => $vehicleType->id,
                        ])
                        @livewire('delete-bottom', [
                            'type' => 'transportation-vehicle-types',
                            'modelId' => $vehicleType->id,
                            'modelType' => '\\App\\Models\\TransportationVehicleType',
                            'table' => 'transportations_vehicle_types',
                        ])
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-secondary-foreground">
                    <i class="ki-filled ki-information text-4xl mb-2"></i>
                    <p>{{ __('main.no_data_available') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
