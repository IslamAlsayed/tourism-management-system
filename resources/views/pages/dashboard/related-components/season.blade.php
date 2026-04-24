<!-- Seasons -->
<div wire:key="season-{{ $record->id }}" class="kt-card bg-blue-100 record-season-{{ $record->id }}">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.type_information', ['type' => __('main.season')]) }}
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
                @if ($record->season_from)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.season_from') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->season_from->format('Y-m-d') }}</p>
                    </div>
                @endif
                @if ($record->season_to)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.season_to') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $record->season_to->format('Y-m-d') }}</p>
                    </div>
                @endif
                <div class="col-span-2 flex items-center gap-10 mb-2">
                    <div wire:key="toggle-{{ $record->id }}-is_active">
                        <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                        <div class="flex items-center gap-2">
                            @livewire('toggle-switch', [
                                'modelId' => $record->id,
                                'modelType' => '\\Modules\\Accommodations\\Entities\\Season',
                                'field' => 'is_active',
                                'value' => (bool) $record->is_active,
                                'table' => 'seasons',
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
                    'models' => 'seasons',
                    'id' => $record->id,
                ])
                @include('components.elements.edit-button', [
                    'models' => 'seasons',
                    'id' => $record->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'season',
                    'modelId' => $record->id,
                    'modelType' => '\\Modules\\Accommodations\\Entities\\Season',
                    'table' => 'seasons',
                ])
            </div>
        </div>
    </div>
</div>
