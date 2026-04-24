<!-- Restaurant -->
<div wire:key="restaurant-{{ $record->id }}" class="kt-card bg-blue-100 record-restaurant-{{ $record->id }}">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.type_information', ['type' => __('main.restaurant')]) }}
        </h3>
        <div class="kt-card-toolbar">{{ $record->created_at->diffForHumans() }}</div>
    </div>
    <div class="kt-card-body p-4">
        <div class="kt-card background rounded-lg p-4 pt-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="kt-label mb-1">{{ __('main.name') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ $record->name ?: __('main.na') }}</p>
                </div>
                @if ($record->name_ar)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                        <p class="text-sm text-secondary-foreground">{{ $record->name_ar }}
                        </p>
                    </div>
                @endif
                @if ($record->type)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.type') }}</label>
                        <div>
                            <a href="{{ route('types.show', $record->type?->id) }}" class="kt-badge kt-badge-primary">
                                {{ $record->type?->name ?: __('main.na') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endif
                @if ($record->classification)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                        <div>
                            <span class="kt-badge kt-badge-primary">
                                {{ $record->classification ?: __('main.na') }}
                            </span>
                        </div>
                    </div>
                @endif
                @if ($record->stars)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                        <div class="flex items-center gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $record->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                            @endfor
                        </div>
                    </div>
                @endif
                @if ($record->currency)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->currency->name }}
                            <span class="text-primary font-semibold">
                                ({{ $record->currency->code }})
                            </span>
                        </p>
                    </div>
                @endif
                @if ($record->city || $record->country)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.location') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->city?->name ?? '' }}
                            {{ $record->city && $record->country ? ', ' : '' }}
                            {{ $record->country?->name ?? '' }}
                        </p>
                    </div>
                @endif
                @if ($record->general_mobile)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->general_mobile }}</p>
                    </div>
                @endif
                @if ($record->general_email)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->general_email }}</p>
                    </div>
                @endif
                @if ($record->contact_person)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->contact_person }}</p>
                    </div>
                @endif
                @if ($record->street)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.street') }}</label>
                        <p class="text-sm text-secondary-foreground">{{ $record->street }}
                        </p>
                    </div>
                @endif
                <div class="col-span-full flex items-center gap-10 mb-2">
                    <div wire:key="toggle-{{ $record->id }}-is_active">
                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                        <div class="flex items-center gap-2">
                            @livewire('toggle-switch', [
                                'modelId' => $record->id,
                                'modelType' => '\\Modules\\Restaurants\\Entities\\Restaurant',
                                'field' => 'is_active',
                                'value' => (bool) $record->is_active,
                                'table' => 'restaurants',
                            ])
                        </div>
                    </div>
                </div>
            </div>
            @include('components.elements.displayable-rich-text', [
                'record' => $record,
                'column' => 'description',
            ])
            <div class="lg:col-span-2 flex gap-2 mt-4">
                @include('components.elements.show-button', [
                    'models' => 'restaurants',
                    'id' => $record->id,
                ])
                @include('components.elements.edit-button', [
                    'models' => 'restaurants',
                    'id' => $record->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'restaurant',
                    'modelId' => $record->id,
                    'modelType' => '\\Modules\\Restaurants\\Entities\\Restaurant',
                    'table' => 'restaurants',
                ])
            </div>
        </div>
    </div>
</div>
