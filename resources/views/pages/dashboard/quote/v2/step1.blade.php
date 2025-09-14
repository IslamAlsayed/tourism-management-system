@extends('pages.dashboard.quote.v2.layout', ['step' => 1])

@section('form-content')
    <form class="space-y-6" action="{{ route('dashboard.quote.v2.postStep1') }}" method="POST">
        @csrf
        <div class="mb-4">
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="col-span-2">
                    <div class="grid grid-cols-2 gap-4">
                        {{-- File Type Id --}}
                        <div class="mb-4">
                            <label class="kt-label mb-2">File Type</label>
                            <div class="inline-flex flex-wrap items-center gap-3">
                                @foreach ($fileTypes as $fileTypeId => $fileType)
                                    <div class="custom-input">
                                        <input type="checkbox" name="fileTypeIds[]" class="mb-0 fileTypeIds"
                                            id="{{ str_replace(' ', '-', $fileType) }}" value="{{ $fileType }}">
                                        <label for="{{ str_replace(' ', '-', $fileType) }}">
                                            {{ $fileType }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('fileTypeIds')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- File Type Targets --}}
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div style="display: none; visibility: hidden;" data-filetype-target="Client">
                            <label for="client_id" class="kt-label mb-2">Client Name</label>
                            <select id="client_id" name="client_id" class="kt-select h-[45px]">
                                <option value="">--</option>
                                @foreach ($clients as $key => $client)
                                    <option value="{{ $key }}">
                                        {{ $client }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="display: none; visibility: hidden;" data-filetype-target="Tour-Operator">
                            <label for="tour_operator_id" class="kt-label mb-2">Tour Operator</label>
                            <select id="tour_operator_id" name="tour_operator_id" class="kt-select h-[45px]">
                                <option value="">--</option>
                                @foreach ($tourOperators as $key => $tourOperator)
                                    <option value="{{ $key }}">
                                        {{ $tourOperator }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tour_operator_id')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="display: none; visibility: hidden;" data-filetype-target="Travel-Agent">
                            <label for="travel_agent_id" class="kt-label mb-2">Travel Agent</label>
                            <select id="travel_agent_id" name="travel_agent_id" class="kt-select h-[45px]">
                                <option value="">--</option>
                                @foreach ($travelAgents as $key => $travelAgent)
                                    <option value="{{ $key }}">
                                        {{ $travelAgent }}
                                    </option>
                                @endforeach
                            </select>
                            @error('travel_agent_id')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="display: none; visibility: hidden;" data-filetype-target="Other">
                            <label for="other" class="kt-label mb-2">Other</label>
                            <input type="text" id="other" name="other" class="kt-input h-[45px]"
                                placeholder="Enter other">
                            @error('other')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        {{-- [first name, last name, email] --}}
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="kt-label mb-2">First Name</label>
                                <input type="text" name="first_name" class="kt-input h-[45px]">
                                @error('first_name')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Last Name</label>
                                <input type="text" name="last_name" class="kt-input h-[45px]">
                                @error('last_name')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Email</label>
                                <input type="email" name="email" class="kt-input h-[45px]">
                                @error('email')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- [website, phone, whatsapp] --}}
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="kt-label mb-2">Website/URL</label>
                                <input type="url" name="website" class="kt-input h-[45px]">
                                @error('website')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Phone</label>
                                <input type="number" name="phone" min="0000001" max="99999999999999"
                                    class="kt-input h-[45px]">
                                @error('phone')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Whatsapp</label>
                                <input type="number" name="whatsapp" min="0000001" max="99999999999999"
                                    class="kt-input h-[45px]">
                                @error('whatsapp')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- [nationalities2, countries2] --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="nationalities2" class="kt-label mb-2">Traveler Nationality</label>
                                <select id="nationalities2" name="nationalities2[]" class="kt-select h-[45px]"
                                    special-multiple>
                                    <option value="">--</option>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">
                                            {{ $nationality->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('nationalities2')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="countries2" class="kt-label mb-2">Traveler Country</label>
                                <select id="countries2" name="countries2[]" class="kt-select h-[45px]" special-multiple>
                                    <option value="">--</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('countries2')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- [currency_id, arrival_date, departure_date] --}}
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="currency_id" class="kt-label mb-2">Currency</label>
                                <select id="currency_id" name="currency_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">
                                            {{ $currency->name }} ({{ $currency->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="arrival_date" class="kt-label mb-2">Arrival Date</label>
                                <input type="datetime-local" id="arrival_date" name="arrival_date"
                                    class="kt-input h-[45px]">
                                @error('arrival_date')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="departure_date" class="kt-label mb-2">Departure Date</label>
                                <input type="datetime-local" id="departure_date" name="departure_date"
                                    class="kt-input h-[45px]">
                                @error('departure_date')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- [Adults, Children, Infants] --}}
                        <div class="grid lg:grid-cols-3 gap-4 col-span-3">
                            <div>
                                <label for="adults" class="kt-label mb-2">Adults</label>
                                <input type="number" id="adults" name="adults" min="1"
                                    class="kt-input h-[45px]">
                            </div>

                            <div>
                                <label for="children" class="kt-label mb-2">Children</label>
                                <input type="number" id="Children" name="children" min="0"
                                    class="kt-input h-[45px]">
                            </div>

                            <div>
                                <label for="infants" class="kt-label mb-2">Infants</label>
                                <input type="number" id="Infants" name="infants" min="0"
                                    class="kt-input h-[45px]">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Can be valid --}}
                <div class="col-span-1" id="validOptions">
                    {{-- Can be valid for Ids --}}
                    <div class="mb-4">
                        <label class="kt-label mb-2">Can be valid for :-</label>

                        <div class="mb-2 custom-input">
                            <label>
                                <input type="radio" name="nationalitiesOptions" class="validOptions"
                                    id="for_all_nationalities_checkbox">
                                For All nationalities
                            </label>
                        </div>

                        <div class="mb-2 custom-input">
                            <label>
                                <input type="radio" name="nationalitiesOptions" class="validOptions"
                                    id="one_nationality_only_checkbox">
                                one Nationality only
                            </label>
                        </div>

                        <div class="mb-2 custom-input">
                            <label>
                                <input type="checkbox" name="subregionsOption" class="validOptions"
                                    id="subregions_checkbox">
                                Subregions
                            </label>
                        </div>

                        @error('reference')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Can be valid for Targets --}}
                    {{-- Nationality --}}
                    <div class="mb-4" style="display: none; visibility: hidden;"
                        data-validoption-target="one_nationality_only_checkbox">
                        <label for="nationalities" class="kt-label mb-2">Nationality</label>
                        <select id="nationalities" name="nationalities[]" special-multiple>
                            <option value="">--</option>
                            @foreach ($nationalities as $nationality)
                                <option value="{{ $nationality->id }}">
                                    {{ $nationality->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Subregions --}}
                    <div class="mb-4" style="display: none; visibility: hidden;"
                        data-validoption-target="subregions_checkbox">
                        <label for="subregions" class="kt-label mb-2">Subregions</label>
                        <select id="subregions" name="subregions[]" special-multiple>
                            <option value="">--</option>
                            @foreach ($subregions as $subregion)
                                <option value="{{ $subregion->id }}">
                                    {{ $subregion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/step1.js') }}"></script>
@endpush
