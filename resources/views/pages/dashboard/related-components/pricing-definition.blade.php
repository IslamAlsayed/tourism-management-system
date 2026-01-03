<!-- Pricing Definition -->
<div wire:key="season-{{ $record->id }}" class="kt-card bg-yellow-100 record-pricing-definition-{{ $record->id }}">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.type_information', ['type' => __('main.pricing-definition')]) }}
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
                @if ($record->key)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.key') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            <span class="kt-badge kt-badge-secondary">{{ $record->key }}</span>
                        </p>
                    </div>
                @endif
                @if ($record->category)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.category') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            <span class="kt-badge kt-badge-info">{{ $record->category }}</span>
                        </p>
                    </div>
                @endif
                <div class="col-span-2 flex items-center gap-10 mb-2">
                    <div wire:key="toggle-{{ $record->id }}-is_active">
                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                        <div class="flex items-center gap-2">
                            @livewire('toggle-switch', [
                                'modelId' => $record->id,
                                'modelType' => '\\App\\Models\\PricingDefinition',
                                'field' => 'is_active',
                                'value' => (bool) $record->is_active,
                                'table' => 'pricing_definitions',
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
                    'models' => 'pricing-definitions',
                    'id' => $record->id,
                ])
                @include('components.elements.edit-button', [
                    'models' => 'pricing-definitions',
                    'id' => $record->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'pricing-definition',
                    'modelId' => $record->id,
                    'modelType' => '\\App\\Models\\PricingDefinition',
                    'table' => 'pricing_definitions',
                ])
            </div>
        </div>
    </div>
</div>
