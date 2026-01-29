<!-- Vehicle Type -->
<div wire:key="vehicleType-{{ $record->id }}" class="kt-card bg-violet-100 record-transportation-vehicle-type-{{ $record->id }}">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.type_information', ['type' => __('main.vehicle-type')]) }}
        </h3>
        <div class="kt-card-toolbar">{{ $record->created_at->diffForHumans() }}</div>
    </div>
    <div class="kt-card-body p-4">
        <div class="kt-card background rounded-lg p-4 pt-2">
            <div class="grid lg:grid-cols-2 gap-4">
                <div>
                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ $record->name ?: __('main.na') }}</p>
                </div>
                @if ($record->name_ar)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                        <p class="text-sm text-secondary-foreground">{{ $record->name_ar }}</p>
                    </div>
                @endif
                @if ($record->min_capacity)
                    <div>
                        <label class="kt-label mb-1">
                            {{ __('main.min_capacity') }} {{ __('main.pax') }}
                        </label>
                        <p class="text-sm text-secondary-foreground">{{ $record->min_capacity }}</p>
                    </div>
                @endif
                @if ($record->max_capacity)
                    <div>
                        <label class="kt-label mb-1">
                            {{ __('main.max_capacity') }} {{ __('main.pax') }}
                        </label>
                        <p class="text-sm text-secondary-foreground">{{ $record->max_capacity }}</p>
                    </div>
                @endif
                <div class="col-span-2 flex items-center gap-10 mb-2">
                    <div wire:key="toggle-{{ $record->id }}-is_active">
                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                        <div class="flex items-center gap-2">
                            @livewire('toggle-switch', [
                                'modelId' => $record->id,
                                'modelType' => '\\App\\Models\\TransportationVehicleType',
                                'field' => 'is_active',
                                'value' => (bool) $record->is_active,
                                'table' => 'transportations_vehicle_types',
                            ])
                        </div>
                    </div>
                    <div wire:key="toggle-{{ $record->id }}-has_luggage">
                        <label class="kt-label mb-1">{{ __('main.has_luggage') }}</label>
                        <div class="flex items-center gap-2">
                            @livewire('toggle-switch', [
                                'modelId' => $record->id,
                                'modelType' => '\\App\\Models\\TransportationVehicleType',
                                'field' => 'has_luggage',
                                'value' => (bool) $record->has_luggage,
                                'table' => 'transportations_vehicle_types',
                            ])
                        </div>
                    </div>
                    <div wire:key="toggle-{{ $record->id }}-is_air_conditioning">
                        <label class="kt-label mb-1">{{ __('main.is_air_conditioning') }}</label>
                        <div class="flex items-center gap-2">
                            @livewire('toggle-switch', [
                                'modelId' => $record->id,
                                'modelType' => '\\App\\Models\\TransportationVehicleType',
                                'field' => 'is_air_conditioning',
                                'value' => (bool) $record->is_air_conditioning,
                                'table' => 'transportations_vehicle_types',
                            ])
                        </div>
                    </div>
                </div>
            </div>
            @include('components.elements.displayable-rich-text', [
                'record' => $record,
                'column' => 'description',
            ])
            @include('components.elements.displayable-rich-text', [
                'record' => $record,
                'column' => 'notes',
            ])
            <div class="lg:col-span-2 flex gap-2 mt-4">
                @include('components.elements.show-button', [
                    'models' => 'transportations.vehicle-types',
                    'id' => $record->id,
                ])
                @include('components.elements.edit-button', [
                    'models' => 'transportations.vehicle-types',
                    'id' => $record->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'transportation-vehicle-type',
                    'modelId' => $record->id,
                    'modelType' => '\\App\\Models\\TransportationVehicleType',
                    'table' => 'transportations_vehicle_types',
                ])
            </div>
        </div>
    </div>
</div>
