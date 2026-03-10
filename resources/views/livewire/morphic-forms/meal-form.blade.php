<div>
    {{-- Meals Information --}}
    <div class="kt-card bg-orange-100">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.types_information', ['types' => __('main.meals')]) }}</h3>
            <button type="button" wire:click="addMeal" toggle-button
                class="kt-btn bg-primary-600 text-white hover:bg-primary-700">
                {{ __('main.add') }}
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="kt-card-body" wire:target="removeMeal" wire:loading.class="loading">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-end gap-6 {{ count($meals) > 0 ? 'p-4' : '' }}">
                @foreach ($meals as $index => $meal)
                    <div class="kt-card p-4 border-2" wire:key="meal-{{ $index }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">{{ __('main.meal') }} #{{ $index + 1 }}</h4>
                            <button type="button" wire:click="removeMeal({{ $index }})"
                                class="kt-btn kt-btn-sm bg-danger text-white {{ count($meals) > 1 ? '' : 'hidden' }}"
                                toggle-button>

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

                        {{-- Basic Information --}}
                        <input type="hidden" name="meals[{{ $index }}][id]"
                            value="{{ $meal['meal_id'] ?? '' }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 items-end gap-6 mb-4">
                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="meals_{{ $index }}_name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="meals[{{ $index }}][name]"
                                    id="meals_{{ $index }}_name" class="kt-input h-[45px]"
                                    wire:model="meals.{{ $index }}.name"
                                    value="{{ old('meals.' . $index . '.name') }}">
                                @error('meals.' . $index . '.name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="meals_{{ $index }}_name_ar"
                                    class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="meals[{{ $index }}][name_ar]"
                                    id="meals_{{ $index }}_name_ar" class="kt-input h-[45px]"
                                    wire:model="meals.{{ $index }}.name_ar"
                                    value="{{ old('meals.' . $index . '.name_ar') }}">
                                @error('meals.' . $index . '.name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Meal Type --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6 mb-4">
                            <div class="align-self-end">
                                <label for="meals_{{ $index }}_type" class="kt-label mb-2">
                                    {{ __('main.meal_type') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="meals[{{ $index }}][type]" id="meals_{{ $index }}_type"
                                    class="kt-select basic-single" wire:model="meals.{{ $index }}.type"
                                    required>
                                    <option value="" disabled selected></option>
                                    <option value="breakfast">{{ __('main.breakfast') }}</option>
                                    <option value="lunch">{{ __('main.lunch') }}</option>
                                    <option value="dinner">{{ __('main.dinner') }}</option>
                                    <option value="other">{{ __('main.other') }}</option>
                                </select>
                                @error('meals.' . $index . '.type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pricing Information --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6 mb-4">
                            {{-- Season --}}
                            <div class="align-self-end">
                                <label for="meals_{{ $index }}_season_id" class="kt-label mb-2">
                                    {{ __('main.season') }}
                                </label>
                                <select name="meals[{{ $index }}][season_id]"
                                    id="meals_{{ $index }}_season_id" class="kt-select basic-single"
                                    wire:model="meals.{{ $index }}.season_id">
                                    <option value="" selected>{{ __('main.fixed_price_all_year') }}</option>
                                    @foreach ($seasons as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('meals.' . $index . '.season_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('meals.' . $index . '.season_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            <div class="align-self-end">
                                <label for="meals_{{ $index }}_currency_id" class="kt-label mb-2">
                                    {{ __('main.currency') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="meals[{{ $index }}][currency_id]"
                                    id="meals_{{ $index }}_currency_id" class="kt-select basic-single"
                                    wire:model="meals.{{ $index }}.currency_id">
                                    <option value="" disabled selected></option>
                                    @foreach ($currencies as $id => $code)
                                        <option value="{{ $id }}"
                                            {{ old('meals.' . $index . '.currency_id') == $id ? 'selected' : '' }}>
                                            {{ $code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('meals.' . $index . '.currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- FIT Pricing -->
                        <div class="mt-4 mb-2">
                            <h4 class="text-md font-semibold text-primary mb-4">{{ __('main.fit_pricing') }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div class="align-self-end">
                                    <label for="meals_{{ $index }}_fit_price_adult"
                                        class="kt-label">{{ __('main.price_adult') }}</label>
                                    <input type="number" step="0.01"
                                        name="meals[{{ $index }}][fit_price_adult]"
                                        id="meals_{{ $index }}_fit_price_adult" class="kt-input h-[45px]"
                                        wire:model="meals.{{ $index }}.fit_price_adult" placeholder="0.00">
                                </div>
                                <div class="align-self-end">
                                    <label for="meals_{{ $index }}_fit_price_child_6_11"
                                        class="kt-label">{{ __('main.price_child_6_11') }}</label>
                                    <input type="number" step="0.01"
                                        name="meals[{{ $index }}][fit_price_child_6_11]"
                                        id="meals_{{ $index }}_fit_price_child_6_11" class="kt-input h-[45px]"
                                        wire:model="meals.{{ $index }}.fit_price_child_6_11"
                                        placeholder="0.00">
                                </div>
                                <div class="align-self-end">
                                    <label for="meals_{{ $index }}_fit_price_child_under_6"
                                        class="kt-label">{{ __('main.price_child_under_6') }}</label>
                                    <input type="number" step="0.01"
                                        name="meals[{{ $index }}][fit_price_child_under_6]"
                                        id="meals_{{ $index }}_fit_price_child_under_6"
                                        class="kt-input h-[45px]"
                                        wire:model="meals.{{ $index }}.fit_price_child_under_6"
                                        placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- Group Pricing -->
                        <div class="mt-8 mb-2 border-t pt-6">
                            <h4 class="text-md font-semibold text-primary mb-4">{{ __('main.group_pricing') }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                {{-- Min Group Size --}}
                                <div class="align-self-end">
                                    <label for="meals_{{ $index }}_min_group_size"
                                        class="kt-label mb-1">{{ __('main.min_group_size') }}</label>
                                    <input type="number" name="meals[{{ $index }}][min_group_size]"
                                        id="meals_{{ $index }}_min_group_size" class="kt-input h-[45px]"
                                        wire:model="meals.{{ $index }}.min_group_size" min="1">
                                    @error('meals.' . $index . '.min_group_size')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="align-self-end">
                                    <label for="meals_{{ $index }}_group_price_adult"
                                        class="kt-label">{{ __('main.price_adult') }}</label>
                                    <input type="number" step="0.01"
                                        name="meals[{{ $index }}][group_price_adult]"
                                        id="meals_{{ $index }}_group_price_adult" class="kt-input h-[45px]"
                                        wire:model="meals.{{ $index }}.group_price_adult" placeholder="0.00">
                                </div>
                                <div class="align-self-end">
                                    <label for="meals_{{ $index }}_group_price_child_6_11"
                                        class="kt-label">{{ __('main.price_child_6_11') }}</label>
                                    <input type="number" step="0.01"
                                        name="meals[{{ $index }}][group_price_child_6_11]"
                                        id="meals_{{ $index }}_group_price_child_6_11"
                                        class="kt-input h-[45px]"
                                        wire:model="meals.{{ $index }}.group_price_child_6_11"
                                        placeholder="0.00">
                                </div>
                                <div class="align-self-end">
                                    <label for="meals_{{ $index }}_group_price_child_under_6"
                                        class="kt-label">{{ __('main.price_child_under_6') }}</label>
                                    <input type="number" step="0.01"
                                        name="meals[{{ $index }}][group_price_child_under_6]"
                                        id="meals_{{ $index }}_group_price_child_under_6"
                                        class="kt-input h-[45px]"
                                        wire:model="meals.{{ $index }}.group_price_child_under_6"
                                        placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        {{-- description --}}
                        <div class="mb-4">
                            <label for="meals_{{ $index }}_description"
                                class="kt-label mb-2">{{ __('main.description') }}</label>
                            <input id="meals_{{ $index }}_description" type="hidden"
                                name="meals[{{ $index }}][description]"
                                value="{{ old('meals.' . $index . '.description') }}">
                            <trix-editor input="meals_{{ $index }}_description"></trix-editor>
                            @error('meals.' . $index . '.description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="mb-4">
                            <label for="meals_{{ $index }}_notes"
                                class="kt-label mb-2">{{ __('main.notes') }}</label>
                            <input id="meals_{{ $index }}_notes" type="hidden"
                                name="meals[{{ $index }}][notes]"
                                value="{{ old('meals.' . $index . '.notes') }}">
                            <trix-editor input="meals_{{ $index }}_notes"></trix-editor>
                            @error('meals.' . $index . '.notes')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Additional Settings --}}
                        <div class="flex gap-6">
                            {{-- Is Included --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="meals[{{ $index }}][is_included]"
                                    value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="meals[{{ $index }}][is_included]"
                                        id="meal-{{ $index }}-is_included"
                                        wire:model="meals.{{ $index }}.is_included" value="1"
                                        {{ old('meals.' . $index . '.is_included', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="meal-{{ $index }}-is_included">{{ __('main.is_included') }}</label>
                                </div>
                            </div>

                            {{-- Is Supplement --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="meals[{{ $index }}][is_supplement]"
                                    value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="meals[{{ $index }}][is_supplement]"
                                        id="meal-{{ $index }}-is_supplement"
                                        wire:model="meals.{{ $index }}.is_supplement" value="1"
                                        {{ old('meals.' . $index . '.is_supplement', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="meal-{{ $index }}-is_supplement">{{ __('main.is_supplement') }}</label>
                                </div>
                            </div>

                            {{-- Is Active --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="meals[{{ $index }}][is_active]" value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="meals[{{ $index }}][is_active]"
                                        id="meal-{{ $index }}-is_active"
                                        wire:model="meals.{{ $index }}.is_active" value="1"
                                        {{ old('meals.' . $index . '.is_active', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="meal-{{ $index }}-is_active">{{ __('main.is_active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
