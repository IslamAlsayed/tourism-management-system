<div>
    {{-- vehicle_types Information --}}
    <div class="kt-card bg-orange-100">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.types_information', ['types' => __('main.vehicle_types')]) }}</h3>
            <button type="button" wire:click="addVehicleType" toggle-button
                class="kt-btn bg-primary-600 text-white hover:bg-primary-700">
                {{ __('main.add') }}
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="kt-card-body" wire:target="removeVehicleType" wire:loading.class="loading">
            <div class="flex flex-col gap-4 {{ count($vehicleTypes) > 0 ? 'p-4' : '' }}">
                @foreach ($vehicleTypes as $index => $vehicleType)
                    <div class="kt-card p-4 border-2" wire:key="vehicle_type-{{ $index }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">{{ __('main.vehicle_type') }} #{{ $index + 1 }}</h4>
                            <button type="button" wire:click="removeVehicleType({{ $index }})"
                                class="kt-btn kt-btn-sm bg-danger text-white {{ count($vehicleTypes) > 1 ? '' : 'hidden' }}"
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 items-end gap-6 mb-4">
                            <!-- Transportation Company -->
                            <div class="align-self-end">
                                <label for="vehicle_types_{{ $index }}_company_id" class="kt-label mb-2">
                                    {{ __('main.company') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="vehicle_types[{{ $index }}][company_id]"
                                    id="vehicle_types_{{ $index }}_company_id" class="kt-select basic-single"
                                    wire:model.live="vehicleTypes.{{ $index }}.company_id">
                                    <option value="" disabled selected></option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company['id'] }}"
                                            {{ old('vehicle_types.' . $index . '.company_id') == $company['id'] ? 'selected' : '' }}>
                                            {{ $company['name'] }} ({{ $company['code'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_types.' . $index . '.company_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="vehicle_types_{{ $index }}_name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="vehicle_types[{{ $index }}][name]"
                                    id="vehicle_types_{{ $index }}_name" class="kt-input h-[45px]"
                                    wire:model.live="vehicleTypes.{{ $index }}.name"
                                    value="{{ old('vehicle_types.' . $index . '.name') }}">
                                @error('vehicle_types.' . $index . '.name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="vehicle_types_{{ $index }}_name_ar"
                                    class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="vehicle_types[{{ $index }}][name_ar]"
                                    id="vehicle_types_{{ $index }}_name_ar" class="kt-input h-[45px]"
                                    wire:model.live="vehicleTypes.{{ $index }}.name_ar"
                                    value="{{ old('vehicle_types.' . $index . '.name_ar') }}">
                                @error('vehicle_types.' . $index . '.name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Min Capacity --}}
                            <div>
                                <label for="vehicle_types_{{ $index }}_min_capacity"
                                    class="kt-label mb-2">{{ __('main.min_capacity') }}</label>
                                <input type="number" name="vehicle_types[{{ $index }}][min_capacity]"
                                    id="vehicle_types_{{ $index }}_min_capacity" class="kt-input h-[45px]"
                                    wire:model.live="vehicleTypes.{{ $index }}.min_capacity"
                                    value="{{ old('vehicle_types.' . $index . '.min_capacity') }}">
                                @error('vehicle_types.' . $index . '.min_capacity')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Max Capacity --}}
                            <div>
                                <label for="vehicle_types_{{ $index }}_max_capacity"
                                    class="kt-label mb-2">{{ __('main.max_capacity') }}</label>
                                <input type="number" name="vehicle_types[{{ $index }}][max_capacity]"
                                    id="vehicle_types_{{ $index }}_max_capacity" class="kt-input h-[45px]"
                                    wire:model.live="vehicleTypes.{{ $index }}.max_capacity"
                                    value="{{ old('vehicle_types.' . $index . '.max_capacity') }}">
                                @error('vehicle_types.' . $index . '.max_capacity')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- description --}}
                        <div class="mb-4">
                            <label for="vehicle_types_{{ $index }}_description"
                                class="kt-label mb-2">{{ __('main.description') }}</label>
                            <input id="vehicle_types_{{ $index }}_description" type="hidden"
                                name="vehicle_types[{{ $index }}][description]"
                                wire:model.lazy="vehicleTypes.{{ $index }}.description"
                                value="{{ old('vehicle_types.' . $index . '.description') }}">
                            <trix-editor input="vehicle_types_{{ $index }}_description"></trix-editor>
                            @error('vehicle_types.' . $index . '.description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Additional Settings --}}
                        <div class="flex flex-wrap gap-6">
                            {{-- Is Included --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="vehicle_types[{{ $index }}][is_active]"
                                    value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="vehicle_types[{{ $index }}][is_active]"
                                        id="vehicle_type-{{ $index }}-is_active"
                                        wire:model.live="vehicleTypes.{{ $index }}.is_active" value="1"
                                        {{ old('vehicle_types.' . $index . '.is_active', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="vehicle_type-{{ $index }}-is_active">{{ __('main.is_active') }}</label>
                                </div>
                            </div>

                            {{-- Is Supplement --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="vehicle_types[{{ $index }}][has_luggage]"
                                    value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="vehicle_types[{{ $index }}][has_luggage]"
                                        id="vehicle_type-{{ $index }}-has_luggage"
                                        wire:model.live="vehicleTypes.{{ $index }}.has_luggage" value="1"
                                        {{ old('vehicle_types.' . $index . '.has_luggage', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="vehicle_type-{{ $index }}-has_luggage">{{ __('main.has_luggage') }}</label>
                                </div>
                            </div>

                            {{-- Is Active --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="vehicle_types[{{ $index }}][is_air_conditioning]"
                                    value="0">
                                <div class="custom-input">
                                    <input type="checkbox"
                                        name="vehicle_types[{{ $index }}][is_air_conditioning]"
                                        id="vehicle_type-{{ $index }}-is_air_conditioning"
                                        wire:model.live="vehicleTypes.{{ $index }}.is_air_conditioning"
                                        value="1"
                                        {{ old('vehicle_types.' . $index . '.is_air_conditioning', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="vehicle_type-{{ $index }}-is_air_conditioning">{{ __('main.is_air_conditioning') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
