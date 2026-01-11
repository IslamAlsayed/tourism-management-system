<!-- Seasons -->
<div class="kt-card bg-blue-100">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.seasons') }}
            (<span class="font-semibold text-primary">{{ $record->seasons->count() }}</span>)
        </h3>
        <div class="kt-card-toolbar">
            <a href="{{ route('seasons.create', isset($type) ? ['type' => $type, randomToken()] : []) }}"
                class="kt-btn kt-btn-sm kt-btn-primary">
                <i class="ki-filled ki-plus text-sm me-1"></i>
                {{ __('main.add_type', ['type' => __('main.season')]) }}
            </a>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid lg:grid-cols-2 gap-4">
            @forelse($record->seasons as $season)
                <div wire:key="season-{{ $season->id }}"
                    class="kt-card background rounded-lg p-4 pt-2 record-seasons-{{ $season->id }}">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $season->name ?: __('main.na') }}</p>
                        </div>
                        @if ($season->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $season->name_ar }}</p>
                            </div>
                        @endif
                        @if ($season->season_from)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_from') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $season->season_from->format('Y-m-d') }}</p>
                            </div>
                        @endif
                        @if ($season->season_to)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_to') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $season->season_to->format('Y-m-d') }}</p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $season->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $season->id,
                                        'modelType' => '\\App\\Models\\Season',
                                        'field' => 'is_active',
                                        'value' => (bool) $season->is_active,
                                        'table' => 'seasons',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($season->description)
                        <div class="col-span-full border-custom rounded-lg p-4">
                            <label class="kt-label mb-1">{{ __('main.description') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $season->description !!}
                            </div>
                        </div>
                    @endif
                    <div class="lg:col-span-2 flex gap-2 mt-4">
                        @include('components.elements.show-button', [
                            'models' => 'seasons',
                            'id' => $season->id,
                        ])
                        @include('components.elements.edit-button', [
                            'models' => 'seasons',
                            'id' => $season->id,
                        ])
                        @livewire('delete-bottom', [
                            'type' => 'seasons',
                            'modelId' => $season->id,
                            'modelType' => '\\App\\Models\\Season',
                            'table' => 'seasons',
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
