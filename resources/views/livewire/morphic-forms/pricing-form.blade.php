<div>
    {{-- Pricings Information --}}
    <div class="kt-card bg-orange-100">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.types_information', ['types' => __('main.pricings')]) }}</h3>
            <button type="button" wire:click="addPricing" toggle-button class="kt-btn bg-primary-600 text-white hover:bg-primary-700">
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
        <div class="kt-card-body" wire:target="removePricing" wire:loading.class="loading">
            <div class="flex flex-col gap-4 {{ count($pricings) > 0 ? 'p-4' : '' }}">
                @foreach ($pricings as $index => $pricing)
                    <div class="kt-card p-4 border-2" wire:key="pricing-{{ $index }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">{{ __('main.pricing') }} #{{ $index + 1 }}</h4>
                            <button type="button" wire:click="removePricing({{ $index }})"
                                class="kt-btn kt-btn-sm bg-danger text-white {{ count($pricings) > 1 ? '' : 'hidden' }}" toggle-button>

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
                        <div class="grid grid-cols-1 sm:grid-cols-2 items-end gap-6 mb-4">
                            {{-- Vehicle Type --}}
                            <div class="align-self-end">
                                <label for="pricings_{{ $index }}_vehicle_type_id" class="kt-label mb-2">
                                    {{ __('main.vehicle_type') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="pricings[{{ $index }}][vehicle_type_id]" id="pricings_{{ $index }}_vehicle_type_id"
                                    class="kt-select basic-single" wire:model.live="pricings.{{ $index }}.vehicle_type_id">
                                    <option value="" disabled selected></option>
                                    @foreach ($vehicleTypes as $id => $name)
                                        <option value="{{ $id }}" {{ old('pricings.' . $index . '.vehicle_type_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pricings.' . $index . '.vehicle_type_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="align-self-end">
                                <label for="pricings_{{ $index }}_price" class="kt-label mb-1">
                                    {{ __('main.price') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" step="0.01" name="pricings[{{ $index }}][price]" id="pricings_{{ $index }}_price"
                                    class="kt-input h-[45px]" wire:model="pricings.{{ $index }}.price"
                                    value="{{ old('pricings.' . $index . '.price', 0) }}" min="0">
                                @error('pricings.' . $index . '.price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tax --}}
                            <div class="align-self-end">
                                <label for="pricings_{{ $index }}_tax" class="kt-label mb-1">
                                    {{ __('main.tax') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" step="1" minlength="1" maxlength="100" name="pricings[{{ $index }}][tax]"
                                    id="pricings_{{ $index }}_tax" class="kt-input h-[45px]" wire:model="pricings.{{ $index }}.tax"
                                    value="{{ old('pricings.' . $index . '.tax', 0) }}" min="0">
                                @error('pricings.' . $index . '.tax')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pricing Unit --}}
                            <div class="align-self-end">
                                <label for="pricings_{{ $index }}_pricing_unit_id" class="kt-label mb-2">
                                    {{ __('main.pricing_unit') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="pricings[{{ $index }}][pricing_unit_id]" id="pricings_{{ $index }}_pricing_unit_id"
                                    class="kt-select basic-single" wire:model="pricings.{{ $index }}.pricing_unit_id">
                                    <option value="" disabled selected></option>
                                    @foreach ($currencies as $id => $code)
                                        <option value="{{ $id }}" {{ old('pricings.' . $index . '.pricing_unit_id') == $id ? 'selected' : '' }}>
                                            {{ $code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pricings.' . $index . '.pricing_unit_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            <div class="align-self-end">
                                <label for="pricings_{{ $index }}_currency_id" class="kt-label mb-2">
                                    {{ __('main.currency') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="pricings[{{ $index }}][currency_id]" id="pricings_{{ $index }}_currency_id"
                                    class="kt-select basic-single" wire:model="pricings.{{ $index }}.currency_id">
                                    <option value="" disabled selected></option>
                                    @foreach ($currencies as $id => $code)
                                        <option value="{{ $id }}" {{ old('pricings.' . $index . '.currency_id') == $id ? 'selected' : '' }}>
                                            {{ $code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pricings.' . $index . '.currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- description --}}
                        <div class="mb-4">
                            <label for="pricings_{{ $index }}_description" class="kt-label mb-2">{{ __('main.description') }}</label>
                            <input id="pricings_{{ $index }}_description" type="hidden" name="pricings[{{ $index }}][description]"
                                value="{{ old('pricings.' . $index . '.description') }}">
                            <trix-editor input="pricings_{{ $index }}_description"></trix-editor>
                            @error('pricings.' . $index . '.description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Is Active --}}
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="pricings[{{ $index }}][is_active]" value="0">
                            <div class="custom-input">
                                <input type="checkbox" name="pricings[{{ $index }}][is_active]" id="pricing-{{ $index }}-is_active"
                                    wire:model="pricings.{{ $index }}.is_active" value="1"
                                    {{ old('pricings.' . $index . '.is_active', 1) ? 'checked' : '' }} data-kt-datatable-row-check="true">
                                <label for="pricing-{{ $index }}-is_active">{{ __('main.is_active') }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
