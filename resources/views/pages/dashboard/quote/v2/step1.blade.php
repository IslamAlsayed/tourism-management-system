@extends('pages.dashboard.quote.v2.layout', ['step' => 1])

@section('form-content')
    <form class="space-y-6" action="{{ route('dashboard.quote.v2.postStep1') }}" method="POST">
        @csrf

        {{-- What will you do --}}
        <div class="mb-4">
            <label class="kt-label mb-2">What will you do:</label>

            <div class="flex gap-2">
                <div class="grid lg:grid-cols-4 gap-2">
                    <div class="mb-2 custom-input">
                        <label>
                            <input type="radio" name="actionStatus[]" class="actionStatus" id="add_file" value="add_file">
                            add file
                        </label>
                    </div>

                    <div class="mb-2 custom-input">
                        <label>
                            <input type="radio" name="actionStatus[]" class="actionStatus" id="edit_file"
                                value="edit_file">
                            Edit File
                        </label>
                    </div>

                    <div class="mb-2 custom-input">
                        <label>
                            <input type="radio" name="actionStatus[]" class="actionStatus" id="delete_file"
                                value="delete_file">
                            Delete File
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- I do this --}}
        <div>
            {{-- Add File --}}
            <div class="mb-4" style="display: none;" data-actionstatus-target="add_file">
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="col-span-2">
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="kt-label mb-2">First Name</label>
                                <input type="text" class="kt-input">
                                @error('first_name')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Last Name</label>
                                <input type="text" class="kt-input">
                                @error('last_name')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Email</label>
                                <input type="email" class="kt-input">
                                @error('email')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Website/URL</label>
                                <input type="url" class="kt-input">
                                @error('website')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Phone</label>
                                <input type="number" min="0000001" max="99999999999999" class="kt-input">
                                @error('phone')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Whatsapp</label>
                                <input type="number" min="0000001" max="99999999999999" class="kt-input">
                                @error('whatsapp')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Traveler Nationality</label>
                                <select class="kt-select" name="nationalitiesOptions[]" id="nationalities2"
                                    special-multiple>
                                    <option value="">Select nationality</option>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                    @endforeach
                                </select>

                                @error('nationality_id')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Traveler Country</label>
                                <select class="kt-select" name="countriesOptions[]" id="countries2" special-multiple>
                                    <option value="">Select country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Currency</label>
                                <select class="kt-select">
                                    <option value="">Select currency</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="grid lg:grid-cols-2 gap-6 col-span-3">
                                <div>
                                    <label class="kt-label mb-2">Arrival Date</label>
                                    <input type="date" class="kt-input">
                                    @error('arrival_date')
                                        <div class="text-red-600 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="kt-label mb-2">Departure Date</label>
                                    <input type="date" class="kt-input">
                                    @error('departure_date')
                                        <div class="text-red-600 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="kt-label mb-2">Adults</label>
                                <input type="number" min="1" class="kt-input">
                                @error('adults')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="kt-label mb-2">Children</label>
                                <input type="number" min="0" class="kt-input">
                            </div>

                            <div>
                                <label class="kt-label mb-2">Infants</label>
                                <input type="number" min="0" class="kt-input">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
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
                                @error('file_type_id')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- File Type Targets --}}
                            <div>
                                <div class="mb-4" style="display: none; visibility: hidden;"
                                    data-filetype-target="Client">
                                    <label class="kt-label mb-2">Client Name</label>
                                    <select class="kt-select" name="client_id">
                                        <option value="">Select client</option>
                                        @foreach ($clients as $key => $client)
                                            <option value="{{ $key }}">{{ $client }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="text-red-600 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4" style="display: none; visibility: hidden;"
                                    data-filetype-target="Tour-Operator">
                                    <label class="kt-label mb-2">Tour Operator</label>
                                    <select class="kt-select" name="tour_operator_id">
                                        <option value="">Select tour operator</option>
                                        @foreach ($tourOperators as $key => $tourOperator)
                                            <option value="{{ $key }}">{{ $tourOperator }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_operator_id')
                                        <div class="text-red-600 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4" style="display: none; visibility: hidden;"
                                    data-filetype-target="Travel-Agent">
                                    <label class="kt-label mb-2">Travel Agent</label>
                                    <select class="kt-select" name="travel_agent_id">
                                        <option value="">Select travel agent</option>
                                        @foreach ($travelAgents as $key => $travelAgent)
                                            <option value="{{ $key }}">{{ $travelAgent }}</option>
                                        @endforeach
                                    </select>
                                    @error('travel_agent_id')
                                        <div class="text-red-600 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4" style="display: none; visibility: hidden;"
                                    data-filetype-target="Other">
                                    <label class="kt-label mb-2">Other</label>
                                    <input type="text" class="kt-input" name="other" placeholder="Enter other">
                                    @error('other')
                                        <div class="text-red-600 text-sm">{{ $message }}</div>
                                    @enderror
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
                                    <input type="radio" class="validOptions" id="for_all_nationalities"
                                        value="for_all_nationalities">
                                    For All nationalities
                                </label>
                            </div>

                            <div class="mb-2 custom-input">
                                <label>
                                    <input type="radio" class="validOptions" id="one_nationality_only"
                                        value="one_nationality_only">
                                    one Nationality only
                                </label>
                            </div>

                            <div class="mb-2 custom-input">
                                <label>
                                    <input type="checkbox" class="validOptions" id="subregions" value="Subregions">
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
                            data-validoption-target="one_nationality_only">
                            <label for="nationalitiesOptions" class="kt-label mb-2">Nationality</label>
                            <select id="nationalitiesOptions" name="nationalitiesOptions[]" special-multiple>
                                @foreach ($nationalities as $nationality)
                                    <option value="{{ $nationality->id }}">
                                        {{ $nationality->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Subregions --}}
                        <div class="mb-4" style="display: none; visibility: hidden;"
                            data-validoption-target="subregions">
                            <label for="subregionsOptions" class="kt-label mb-2">Subregions</label>
                            <select id="subregionsOptions" name="subregionsOptions[]" special-multiple>
                                @foreach ($subregions as $subregion)
                                    <option value="{{ $subregion->id }}">
                                        {{ $subregion->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Edit File --}}
            <div style="display: none; visibility: hidden;" data-actionstatus-target="edit_file">
                Edit file
            </div>

            {{-- Delete File --}}
            <div class="mb-4" style="display: none;" data-actionstatus-target="delete_file">
                <div class="grid lg:grid-cols-3 gap-6">
                    <div>
                        <label class="kt-label mb-2">File REF</label>
                        <input type="text" class="kt-input" placeholder="Enter code">
                        @error('file_ref')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
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
    <script>
        let fileTypeIds = document.querySelectorAll('.fileTypeIds');
        if (fileTypeIds.length > 0) {
            fileTypeIds.forEach((checkbox) => {
                checkbox.addEventListener('change', (event) => {
                    toggleDisplayTarget('filetype', event.target.id);
                });
            });
        }

        let validOptions = document.querySelectorAll('.validOptions');
        if (validOptions.length > 0) {
            validOptions.forEach((radio) => {
                radio.addEventListener('change', (event) => {
                    if (event.target.id == 'for_all_nationalities') {
                        document.querySelector(`[data-validoption-target="one_nationality_only"]`).style
                            .display =
                            'none';
                        return;
                    }

                    toggleDisplayTarget('validoption', event.target.id);
                });
            });
        }

        let actionStatus = document.querySelectorAll('.actionStatus');
        if (actionStatus.length > 0) {
            actionStatus.forEach((radio) => {
                radio.addEventListener('change', (event) => {
                    document.querySelectorAll('[data-actionstatus-target]').forEach((target) => {
                        target.style.display = 'none';
                    });

                    toggleDisplayTarget('actionstatus', event.target.id);
                });
            });
        }

        function toggleDisplayTarget(targetId, elementId) {
            let target = document.querySelector(`[data-${targetId}-target="${elementId}"]`);
            if (target) {
                target.style.display = event.target.checked ? 'block' : 'none';
                target.style.visibility = event.target.checked ? 'visible' : 'hidden';
            }
        }
    </script>
@endpush
