<div>
    {{-- Seasons Information --}}
    <div class="kt-card bg-blue-100">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.types_information', ['types' => __('main.seasons')]) }}</h3>
            <button type="button" wire:click="addSeason" toggle-button class="kt-btn bg-primary-600 text-white hover:bg-primary-700">
                @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                    {!! $text ?? __('main.add') !!}
                @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                    <i class="fas fa-plus text-white"></i>
                @else
                    <i class="fas fa-plus text-white"></i>
                    {!! $text ?? __('main.add') !!}
                @endif
            </button>
        </div>
        <div class="kt-card-body {{ count($seasons) > 0 ? 'p-4' : '' }}" wire:target="removeSeason" wire:loading.class="loading">
            <div class="flex flex-col gap-4">
                @foreach ($seasons as $index => $season)
                    <div class="kt-card p-4 border-2" wire:key="season-{{ $index }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">{{ __('main.season') }} #{{ $index + 1 }}</h4>
                            <button type="button" wire:click="removeSeason({{ $index }})"
                                class="kt-btn kt-btn-sm bg-danger text-white {{ count($seasons) > 1 ? '' : 'hidden' }}" toggle-button>

                                @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                                    {!! $text ?? __('main.delete') !!}
                                @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                                    <i class="fas fa-trash-can text-white"></i>
                                @else
                                    <i class="fas fa-trash-can text-white"></i>
                                    {!! $text ?? __('main.delete') !!}
                                @endif
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 items-end gap-6 mb-4">
                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="seasons_{{ $index }}_name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="seasons[{{ $index }}][name]" id="seasons_{{ $index }}_name" class="kt-input h-[45px]"
                                    wire:model="seasons.{{ $index }}.name" value="{{ old('seasons.' . $index . '.name') }}">
                                @error('seasons.' . $index . '.name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="seasons_{{ $index }}_name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="seasons[{{ $index }}][name_ar]" id="seasons_{{ $index }}_name_ar"
                                    class="kt-input h-[45px]" wire:model="seasons.{{ $index }}.name_ar"
                                    value="{{ old('seasons.' . $index . '.name_ar') }}">
                                @error('seasons.' . $index . '.name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 items-end gap-6 mb-4">
                            {{-- Season From --}}
                            <div class="align-self-end">
                                <label for="seasons_{{ $index }}_season_from" class="kt-label mb-1">
                                    {{ __('main.season_from') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="date" name="seasons[{{ $index }}][season_from]" id="seasons_{{ $index }}_season_from"
                                    class="kt-input h-[45px]" wire:model="seasons.{{ $index }}.season_from"
                                    value="{{ old('seasons.' . $index . '.season_from', $seasons[$index]['formatted_season_from'] ?? '') }}">
                                @error('seasons.' . $index . '.season_from')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Season To --}}
                            <div class="align-self-end">
                                <label for="seasons_{{ $index }}_season_to" class="kt-label mb-1">
                                    {{ __('main.season_to') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="date" name="seasons[{{ $index }}][season_to]" id="seasons_{{ $index }}_season_to"
                                    class="kt-input h-[45px]" wire:model="seasons.{{ $index }}.season_to"
                                    value="{{ old('seasons.' . $index . '.season_to', $seasons[$index]['formatted_season_to'] ?? '') }}">
                                @error('seasons.' . $index . '.season_to')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- description --}}
                        <div class="mb-4">
                            <label for="seasons_{{ $index }}_description" class="kt-label mb-2">{{ __('main.description') }}</label>
                            <input id="seasons_{{ $index }}_description" type="hidden" name="seasons[{{ $index }}][description]"
                                value="{{ old('seasons.' . $index . '.description') }}">
                            <trix-editor input="seasons_{{ $index }}_description"></trix-editor>
                            @error('seasons.' . $index . '.description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="seasons[{{ $index }}][is_active]" value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="seasons[{{ $index }}][is_active]" id="season-{{ $index }}-is_active"
                                        wire:model="seasons.{{ $index }}.is_active" value="1"
                                        {{ old('seasons.' . $index . '.is_active', 1) ? 'checked' : '' }} data-kt-datatable-row-check="true">
                                    <label for="season-{{ $index }}-is_active">{{ __('main.is_active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
