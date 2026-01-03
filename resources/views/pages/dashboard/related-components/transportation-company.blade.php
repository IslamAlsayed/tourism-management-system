<!-- Companies -->
<div wire:key="company-{{ $record->id }}" class="kt-card bg-blue-100 record-transportation-company-{{ $record->id }}">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.type_information', ['type' => __('main.transportation-company')]) }}
        </h3>
        <div class="kt-card-toolbar">{{ $record->created_at->diffForHumans() }}</div>
    </div>
    <div class="kt-card-body p-4">
        <div class="kt-card background rounded-lg p-4 pt-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                @if ($record->name)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->name ?: __('main.na') }}
                        </p>
                    </div>
                @endif
                @if ($record->name_ar)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->name_ar ?: __('main.na') }}
                        </p>
                    </div>
                @endif
                @if ($record->rating)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.rating') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ number_format($record->rating, 0) }}/5
                            <i class="fas fa-star" style="color: #ffdd00"></i>
                        </p>
                    </div>
                @endif
                <div class="col-span-2 flex items-center gap-10 mb-2">
                    <div wire:key="toggle-{{ $record->id }}-is_active">
                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                        <div class="flex items-center gap-2">
                            @livewire('toggle-switch', [
                                'modelId' => $record->id,
                                'modelType' => '\\App\\Models\\TransportationCompany',
                                'field' => 'is_active',
                                'value' => (bool) $record->is_active,
                                'table' => 'transportation_companies',
                            ])
                        </div>
                    </div>
                </div>
            </div>
            @if ($record->description)
                <div class="col-span-full border-custom rounded-lg p-4">
                    <label class="kt-label mb-1">{{ __('main.description') }}</label>
                    <div class="text-sm text-secondary-foreground prose max-w-none">
                        {!! $record->description !!}
                    </div>
                </div>
            @endif
            <div class="lg:col-span-2 flex gap-2 mt-4">
                @include('components.elements.show-button', [
                    'models' => 'transportation.companies',
                    'id' => $record->id,
                ])
                @include('components.elements.edit-button', [
                    'models' => 'transportation.companies',
                    'id' => $record->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'transportation-company',
                    'modelId' => $record->id,
                    'modelType' => '\\App\\Models\\TransportationCompany',
                    'table' => 'transportation_companies',
                ])
            </div>
        </div>
    </div>
</div>
