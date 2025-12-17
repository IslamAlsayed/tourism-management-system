<div>
    {{-- Rooms Information --}}
    <div class="kt-card bg-green-100">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.types_information', ['types' => __('main.rooms')]) }}</h3>
            <button type="button" wire:click="addRoom" class="kt-btn bg-primary-600 text-white hover:bg-primary-700">

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
        <div class="kt-card-body p-4">
            <div class="flex flex-col gap-4">
                @foreach ($rooms as $index => $room)
                    <div class="kt-card p-4 border-2" wire:key="room-{{ $room['id'] }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">{{ __('main.room') }} #{{ $index + 1 }}</h4>
                            @if (count($rooms) > 1)
                                <button type="button" wire:click="removeRoom({{ $index }})"
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
                                <label for="rooms_{{ $index }}_name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="rooms[{{ $index }}][name]"
                                    id="rooms_{{ $index }}_name" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.name"
                                    value="{{ old('rooms.' . $index . '.name') }}">
                                @error('rooms.' . $index . '.name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="rooms_{{ $index }}_name_ar"
                                    class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="rooms[{{ $index }}][name_ar]"
                                    id="rooms_{{ $index }}_name_ar" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.name_ar"
                                    value="{{ old('rooms.' . $index . '.name_ar') }}">
                                @error('rooms.' . $index . '.name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Occupancy Details --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 items-end gap-6 mb-4">
                            {{-- Max Occupancy --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_max_occupancy" class="kt-label mb-2">
                                    {{ __('main.max_occupancy') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" name="rooms[{{ $index }}][max_occupancy]"
                                    id="rooms_{{ $index }}_max_occupancy" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.max_occupancy"
                                    value="{{ old('rooms.' . $index . '.max_occupancy') }}" minLength="1">
                                @error('rooms.' . $index . '.max_occupancy')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Occupancy Details --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_occupancy_details" class="kt-label mb-2">
                                    {{ __('main.occupancy_details') }}
                                </label>
                                <input type="text" name="rooms[{{ $index }}][occupancy_details]"
                                    id="rooms_{{ $index }}_occupancy_details" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.occupancy_details"
                                    value="{{ old('rooms.' . $index . '.occupancy_details') }}">
                                @error('rooms.' . $index . '.occupancy_details')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pricing Information --}}
                        <h5 class="text-md font-semibold mb-3 mt-4">
                            {{ __('main.type_information', ['type' => __('main.pricing')]) }}</h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6 mb-4">
                            {{-- Currency --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_currency_id" class="kt-label mb-2">
                                    {{ __('main.currency') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="rooms[{{ $index }}][currency_id]"
                                    id="rooms_{{ $index }}_currency_id" class="kt-select basic-single"
                                    wire:model="rooms.{{ $index }}.currency_id">
                                    <option value="" disabled selected></option>
                                    @foreach ($currencies as $id => $code)
                                        <option value="{{ $id }}"
                                            {{ old('rooms.' . $index . '.currency_id') == $id ? 'selected' : '' }}>
                                            {{ $code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rooms.' . $index . '.currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price Per Person Double --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_price_per_person_double" class="kt-label mb-1">
                                    {{ __('main.price_per_person_double') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" step="0.01"
                                    name="rooms[{{ $index }}][price_per_person_double]"
                                    id="rooms_{{ $index }}_price_per_person_double" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.price_per_person_double"
                                    value="{{ old('rooms.' . $index . '.price_per_person_double', 0) }}"
                                    minLength="0">
                                @error('rooms.' . $index . '.price_per_person_double')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Single Room Supplement --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_single_room_supplement" class="kt-label mb-1">
                                    {{ __('main.single_room_supplement') }}
                                </label>
                                <input type="number" step="0.01"
                                    name="rooms[{{ $index }}][single_room_supplement]"
                                    id="rooms_{{ $index }}_single_room_supplement" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.single_room_supplement"
                                    value="{{ old('rooms.' . $index . '.single_room_supplement', 0) }}" minLength="0">
                                @error('rooms.' . $index . '.single_room_supplement')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Triple Room Discount --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_triple_room_discount" class="kt-label mb-1">
                                    {{ __('main.triple_room_discount') }}
                                </label>
                                <input type="number" step="0.01"
                                    name="rooms[{{ $index }}][triple_room_discount]"
                                    id="rooms_{{ $index }}_triple_room_discount" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.triple_room_discount"
                                    value="{{ old('rooms.' . $index . '.triple_room_discount', 0) }}" minLength="0">
                                @error('rooms.' . $index . '.triple_room_discount')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Third Person Price --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_third_person_price" class="kt-label mb-1">
                                    {{ __('main.third_person_price') }}
                                </label>
                                <input type="number" step="0.01"
                                    name="rooms[{{ $index }}][third_person_price]"
                                    id="rooms_{{ $index }}_third_person_price" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.third_person_price"
                                    value="{{ old('rooms.' . $index . '.third_person_price', 0) }}" minLength="0">
                                @error('rooms.' . $index . '.third_person_price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Extra Bed Price --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_extra_bed_price" class="kt-label mb-1">
                                    {{ __('main.extra_bed_price') }}
                                </label>
                                <input type="number" step="0.01"
                                    name="rooms[{{ $index }}][extra_bed_price]"
                                    id="rooms_{{ $index }}_extra_bed_price" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.extra_bed_price"
                                    value="{{ old('rooms.' . $index . '.extra_bed_price', 0) }}" minLength="0">
                                @error('rooms.' . $index . '.extra_bed_price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sea View Supplement --}}
                            <div class="align-self-end">
                                <label for="rooms_{{ $index }}_sea_view_supplement" class="kt-label mb-1">
                                    {{ __('main.sea_view_supplement') }}
                                </label>
                                <input type="number" step="0.01"
                                    name="rooms[{{ $index }}][sea_view_supplement]"
                                    id="rooms_{{ $index }}_sea_view_supplement" class="kt-input h-[45px]"
                                    wire:model="rooms.{{ $index }}.sea_view_supplement"
                                    value="{{ old('rooms.' . $index . '.sea_view_supplement', 0) }}" minLength="0">
                                @error('rooms.' . $index . '.sea_view_supplement')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- notes --}}
                        <div class="mb-4">
                            <label for="rooms.{{ $index }}.notes"
                                class="kt-label mb-2">{{ __('main.notes') }}</label>
                            <input id="rooms.{{ $index }}.notes" type="hidden"
                                name="rooms.{{ $index }}.notes"
                                value="{{ old('rooms.' . $index . '.notes') }}">
                            <trix-editor input="rooms.{{ $index }}.notes"></trix-editor>
                            @error('rooms.' . $index . '.notes')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Additional Settings --}}
                        <label class="kt-label mb-2">{{ __('main.additional_settings') }}</label>
                        <div class="flex gap-6">
                            {{-- Is Active --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="rooms[{{ $index }}][is_active]" value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="rooms[{{ $index }}][is_active]"
                                        id="room-{{ $index }}-is_active"
                                        wire:model="rooms.{{ $index }}.is_active" value="1"
                                        {{ old('rooms.' . $index . '.is_active', 1) ? 'checked' : '' }}
                                        data-kt-datatable-row-check="true">
                                    <label
                                        for="room-{{ $index }}-is_active">{{ __('main.is_active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
