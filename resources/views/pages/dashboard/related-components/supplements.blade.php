<!-- Supplements -->
<div class="kt-card bg-pink-100">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.supplements') }}
            (<span class="font-semibold text-primary">{{ $record->supplements->count() }}</span>)
        </h3>
        <div class="kt-card-toolbar">
            <a href="{{ route('dashboard.accommodations.supplements.create', isset($type) ? ['type' => $type, randomToken()] : []) }}"
                class="kt-btn kt-btn-sm kt-btn-primary">
                <i class="ki-filled ki-plus text-sm me-1"></i>
                {{ __('main.add_type', ['type' => __('main.supplement')]) }}
            </a>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid lg:grid-cols-2 gap-4">
            @forelse($record->supplements as $supplement)
                <div wire:key="supplement-{{ $supplement->id }}" class="kt-card background rounded-lg p-4 pt-2 record-supplements-{{ $supplement->id }}">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $supplement->name ?: __('main.na') }}</p>
                        </div>
                        @if ($supplement->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $supplement->name_ar }}</p>
                            </div>
                        @endif
                        @if ($supplement->description)
                            <div class="col-span-2">
                                <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $supplement->description }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($supplement->price, 2) . ' ' . $settings->app_default_currency }}
                                {{ $supplement->currency?->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price_type') }}</label>
                            <div class="flex flex-wrap gap-2">
                                <span class="kt-badge kt-badge-info">{{ __('main.' . $supplement->price_type) }}</span>
                            </div>
                        </div>
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $supplement->id }}-is_mandatory">
                                <label class="kt-label mb-1">{{ __('main.is_mandatory') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $supplement->id,
                                        'modelType' => '\\App\\Models\\Supplement',
                                        'field' => 'is_mandatory',
                                        'value' => (bool) $supplement->is_mandatory,
                                        'table' => 'supplements',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $supplement->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $supplement->id,
                                        'modelType' => '\\App\\Models\\Supplement',
                                        'field' => 'is_active',
                                        'value' => (bool) $supplement->is_active,
                                        'table' => 'supplements',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('components.elements.displayable-rich-text', [
                        'record' => $supplement,
                        'column' => 'description',
                    ])
                    <div class="lg:col-span-2 flex gap-2 mt-4">
                        @include('components.elements.show-button', [
                            'models' => 'supplements',
                            'id' => $supplement->id,
                        ])
                        @include('components.elements.edit-button', [
                            'models' => 'supplements',
                            'id' => $supplement->id,
                        ])
                        @livewire('delete-bottom', [
                            'type' => 'supplements',
                            'modelId' => $supplement->id,
                            'modelType' => '\\App\\Models\\Supplement',
                            'table' => 'supplements',
                        ])
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-secondary-foreground">
                    <i class="ki-filled ki-information text-4xl mb-2"></i>
                    <p>{{ __('main.no_supplements_available') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
