{{-- Meals --}}
<div class="kt-card bg-orange-100">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.meals') }}
            (<span class="font-semibold text-primary">{{ $record->meals->count() }}</span>)
        </h3>
        <div class="kt-card-toolbar">
            <a href="{{ route('meals.create', isset($type) ? ['type' => $type, randomToken()] : []) }}"
                class="kt-btn kt-btn-sm kt-btn-primary">
                <i class="ki-filled ki-plus text-sm me-1"></i>
                {{ __('main.add_type', ['type' => __('main.meal')]) }}
            </a>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid lg:grid-cols-2 gap-4">
            @forelse($record->meals as $meal)
                <div wire:key="meal-{{ $meal->id }}"
                    class="kt-card background rounded-lg p-4 pt-2 record-meals-{{ $meal->id }}">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $meal->name ?: __('main.na') }}</p>
                        </div>
                        @if ($meal->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $meal->name_ar }}</p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $meal->id }}-is_included">
                                <label class="kt-label mb-1">{{ __('main.is_included') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $meal->id,
                                        'modelType' => '\\App\\Models\\Meal',
                                        'field' => 'is_included',
                                        'value' => (bool) $meal->is_included,
                                        'table' => 'meals',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $meal->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $meal->id,
                                        'modelType' => '\\App\\Models\\Meal',
                                        'field' => 'is_active',
                                        'value' => (bool) $meal->is_active,
                                        'table' => 'meals',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Meal Pricing Information --}}
                    @if ($meal->season || $meal->price)
                        <div class="lg:col-span-2 mt-3 border-custom-t pt-3">
                            <label
                                class="kt-label mb-2">{{ __('main.type_information', ['type' => __('main.pricing')]) }}</label>
                            <div class="bg-blue-100 p-3 rounded-lg">
                                @if ($meal->season)
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-medium text-sm">{{ $meal->season->name }}</span>
                                        <span
                                            class="text-xs text-gray-500">{{ $meal->season->season_from->format('Y-m-d') }}
                                            → {{ $meal->season->season_to->format('Y-m-d') }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center gap-4 text-sm">
                                    @if ($meal->price)
                                        <div>
                                            <span class="text-gray-600">{{ __('main.price') }}:</span>
                                            <span class="font-semibold text-lg">{{ number_format($meal->price, 2) }}
                                                {{ $meal->currency?->code }}</span>
                                        </div>
                                    @endif
                                    @if ($meal->is_included)
                                        <span class="kt-badge kt-badge-success">{{ __('main.included') }}</span>
                                    @endif
                                    @if ($meal->is_supplement)
                                        <span class="kt-badge kt-badge-info">{{ __('main.supplement') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    @include('components.elements.display-desc-or-notes', [
                        'record' => $meal,
                        'column' => 'description',
                    ])
                    <div class="lg:col-span-2 flex gap-2 mt-4">
                        @include('components.elements.show-button', [
                            'models' => 'meals',
                            'id' => $meal->id,
                        ])
                        @include('components.elements.edit-button', [
                            'models' => 'meals',
                            'id' => $meal->id,
                        ])
                        @livewire('delete-bottom', [
                            'type' => 'meals',
                            'modelId' => $meal->id,
                            'modelType' => '\\App\\Models\\Meal',
                            'table' => 'meals',
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
