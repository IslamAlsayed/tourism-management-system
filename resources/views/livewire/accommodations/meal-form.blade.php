<div>
    {{-- Meals Information --}}
    <div class="kt-card bg-orange-100">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.types_information', ['types' => __('main.meals')]) }}</h3>
            <button type="button" wire:click="addMeal" class="kt-btn bg-primary-600 text-white hover:bg-primary-700">
                {{ __('main.add') }}
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="kt-card-body p-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-end gap-6 mb-4">
                @foreach ($meals as $index => $meal)
                    <div class="kt-card p-4 border-2" wire:key="meal-{{ $meal['id'] }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">{{ __('main.meal') }} #{{ $index + 1 }}</h4>
                            @if (count($meals) > 1)
                                <button type="button" wire:click="removeMeal({{ $index }})"
                                    class="kt-btn kt-btn-sm bg-danger text-white">

                                    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                                        {!! $text ?? __('main.delete') !!}
                                    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                                        <i class="fas fa-trash-can text-white"></i>
                                    @else
                                        <i class="fas fa-trash-can text-white"></i>
                                        {!! $text ?? __('main.delete') !!}
                                    @endif
                                </button>
                            @endif
                        </div>

                        {{-- Basic Information --}}
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

                        {{-- Pricing Information --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 items-end gap-6 mb-4">
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

                            {{-- Price --}}
                            <div class="align-self-end">
                                <label for="meals_{{ $index }}_price" class="kt-label mb-1">
                                    {{ __('main.price') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" step="0.01" name="meals[{{ $index }}][price]"
                                    id="meals_{{ $index }}_price" class="kt-input h-[45px]"
                                    wire:model="meals.{{ $index }}.price"
                                    value="{{ old('meals.' . $index . '.price', 0) }}" min="0">
                                @error('meals.' . $index . '.price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- notes --}}
                        <div class="mb-4">
                            <label for="meals.{{ $index }}.notes"
                                class="kt-label mb-2">{{ __('main.notes') }}</label>
                            <input id="meals.{{ $index }}.notes" type="hidden"
                                name="meals.{{ $index }}.notes"
                                value="{{ old('meals.' . $index . '.notes') }}">
                            <trix-editor input="meals.{{ $index }}.notes"></trix-editor>
                            @error('meals.' . $index . '.notes')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Additional Settings --}}
                        <label class="kt-label mb-2">{{ __('main.additional_settings') }}</label>
                        <div class="flex gap-6">
                            {{-- Is Included --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="meals[{{ $index }}][is_included]" value="0">
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
                                <input type="hidden" name="meals[{{ $index }}][is_supplement]" value="0">
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
