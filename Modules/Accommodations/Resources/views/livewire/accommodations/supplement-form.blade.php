<div>
    {{-- Supplements Information --}}
    <div class="kt-card bg-pink-100">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.types_information', ['types' => __('main.supplements')]) }}</h3>
            <button type="button" wire:click="addSupplement"
                class="kt-btn bg-primary-600 text-white hover:bg-primary-700">
                {{ __('main.add') }}
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="kt-card-body p-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-end gap-6">
                @foreach ($supplements as $index => $supplement)
                    <div class="kt-card p-4 border-2" wire:key="supplement-{{ $supplement['id'] }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">{{ __('main.supplement') }} #{{ $index + 1 }}</h4>
                            @if (count($supplements) > 1)
                                <button type="button" wire:click="removeSupplement({{ $index }})"
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
                                <label for="supplements_{{ $index }}_name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="supplements[{{ $index }}][name]"
                                    id="supplements_{{ $index }}_name" class="kt-input h-[45px]"
                                    wire:model="supplements.{{ $index }}.name"
                                    value="{{ old('supplements.' . $index . '.name') }}">
                                @error('supplements.' . $index . '.name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="supplements_{{ $index }}_name_ar"
                                    class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="supplements[{{ $index }}][name_ar]"
                                    id="supplements_{{ $index }}_name_ar" class="kt-input h-[45px]"
                                    wire:model="supplements.{{ $index }}.name_ar"
                                    value="{{ old('supplements.' . $index . '.name_ar') }}">
                                @error('supplements.' . $index . '.name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">
                            {{-- Currency --}}
                            <div class="align-self-end">
                                <label for="supplements_{{ $index }}_currency_id" class="kt-label mb-2">
                                    {{ __('main.currency') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="supplements[{{ $index }}][currency_id]"
                                    id="supplements_{{ $index }}_currency_id" class="kt-select basic-single"
                                    wire:model="supplements.{{ $index }}.currency_id">
                                    <option value="" disabled selected></option>
                                    @foreach ($currencies as $id => $code)
                                        <option value="{{ $id }}"
                                            {{ old('supplements.' . $index . '.currency_id') == $id ? 'selected' : '' }}>
                                            {{ $code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplements.' . $index . '.currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="align-self-end">
                                <label for="supplements_{{ $index }}_price" class="kt-label mb-1">
                                    {{ __('main.price') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" step="0.01" name="supplements[{{ $index }}][price]"
                                    id="supplements_{{ $index }}_price" class="kt-input h-[45px]"
                                    wire:model="supplements.{{ $index }}.price"
                                    value="{{ old('supplements.' . $index . '.price', 0) }}" min="0">
                                @error('supplements.' . $index . '.price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price Type --}}
                            <div class="align-self-end">
                                <label for="supplements_{{ $index }}_price_type" class="kt-label mb-2">
                                    {{ __('main.price_type') }}
                                </label>
                                <select name="supplements[{{ $index }}][price_type]"
                                    id="supplements_{{ $index }}_price_type" class="kt-select basic-single"
                                    wire:model="supplements.{{ $index }}.price_type">
                                    <option value="per_person"
                                        {{ old('supplements.' . $index . '.price_type', 'per_person') == 'per_person' ? 'selected' : '' }}>
                                        {{ __('main.per_person') }}
                                    </option>
                                    <option value="per_room"
                                        {{ old('supplements.' . $index . '.price_type') == 'per_room' ? 'selected' : '' }}>
                                        {{ __('main.per_room') }}
                                    </option>
                                    <option value="per_night"
                                        {{ old('supplements.' . $index . '.price_type') == 'per_night' ? 'selected' : '' }}>
                                        {{ __('main.per_night') }}
                                    </option>
                                    <option value="one_time"
                                        {{ old('supplements.' . $index . '.price_type') == 'one_time' ? 'selected' : '' }}>
                                        {{ __('main.one_time') }}
                                    </option>
                                </select>
                                @error('supplements.' . $index . '.price_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- notes --}}
                        <div class="mb-4">
                            <label for="supplements.{{ $index }}.notes"
                                class="kt-label mb-2">{{ __('main.notes') }}</label>
                            <input id="supplements.{{ $index }}.notes" type="hidden"
                                name="supplements.{{ $index }}.notes"
                                value="{{ old('supplements.' . $index . '.notes') }}">
                            <trix-editor input="supplements.{{ $index }}.notes"></trix-editor>
                            @error('supplements.' . $index . '.notes')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Additional Settings --}}
                        <div class="flex gap-6">
                            {{-- Is Mandatory --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="supplements[{{ $index }}][is_mandatory]"
                                    value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="supplements[{{ $index }}][is_mandatory]"
                                        id="supplement-{{ $index }}-is_mandatory"
                                        wire:model="supplements.{{ $index }}.is_mandatory" value="1"
                                        {{ old('supplements.' . $index . '.is_mandatory', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="supplement-{{ $index }}-is_mandatory">{{ __('main.is_mandatory') }}</label>
                                </div>
                            </div>

                            {{-- Is Active --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="supplements[{{ $index }}][is_active]"
                                    value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="supplements[{{ $index }}][is_active]"
                                        id="supplement-{{ $index }}-is_active"
                                        wire:model="supplements.{{ $index }}.is_active" value="1"
                                        {{ old('supplements.' . $index . '.is_active', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="supplement-{{ $index }}-is_active">{{ __('main.is_active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
