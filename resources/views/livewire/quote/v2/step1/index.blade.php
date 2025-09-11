@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/multi-select/style.css') }}">
@endpush

<form class="space-y-6" action="{{ route('dashboard.quote.v2.postStep1') }}" method="POST">
    @csrf
    <div class="grid lg:grid-cols-3 gap-4">
        <div class="mb-4">
            <label class="kt-label mb-2">File Type</label>
            <div class="inline-flex flex-wrap items-center gap-3">
                @foreach ($fileTypes as $fileTypeId => $fileType)
                    <div class="custom-input">
                        <input type="checkbox" name="fileTypeIds[]" class="mb-0" id="{{ $fileTypeId }}">
                        <label for="{{ $fileTypeId }}">
                            {{ $fileType }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('file_type_id')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            @foreach ($fileTypeIds as $fileTypeId => $type)
                @if (strtolower($type) == strtolower('Client'))
                    <div class="mb-4">
                        <label class="kt-label mb-2">Client Name</label>
                        <select class="kt-select">
                            <option value="">Select client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client }}">{{ $client }}</option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                @elseif (strtolower($type) == strtolower('Tour Operator'))
                    <div class="mb-4">
                        <label class="kt-label mb-2">Tour Operator</label>
                        <select class="kt-select">
                            <option value="">Select tour operator</option>
                            @foreach ($tourOperators as $tourOperator)
                                <option value="{{ $tourOperator }}">{{ $tourOperator }}</option>
                            @endforeach
                        </select>
                        @error('tour_operator_id')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                @elseif (strtolower($type) == strtolower('travel agent'))
                    <div class="mb-4">
                        <label class="kt-label mb-2">Travel Agent</label>
                        <select class="kt-select">
                            <option value="">Select travel agent</option>
                            @foreach ($travelAgents as $travelAgent)
                                <option value="{{ $travelAgent }}">{{ $travelAgent }}</option>
                            @endforeach
                        </select>
                        @error('travel_agent_id')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                @elseif (strtolower($type) == strtolower('other'))
                    <div class="mb-4">
                        <label class="kt-label mb-2">Other</label>
                        <input type="text" class="kt-input">
                        @error('other')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            @endforeach
        </div>

        <div>
            <div class="mb-4">
                <label class="kt-label mb-2">Can be valid for :-</label>

                <div class="mb-2 custom-input">
                    <label>
                        <input type="radio" name="nationality_option" id="for_all_nationalities"
                            value="for_all_nationalities">
                        For All nationalities
                    </label>
                </div>

                <div class="mb-2 custom-input">
                    <label>
                        <input type="radio" name="nationality_option" id="01_nationality_only"
                            value="01_nationality_only">
                        01 Nationality only
                    </label>
                </div>

                <div class="mb-2 custom-input">
                    <label>
                        <input type="checkbox" name="nationality_option" id="subregions" value="Subregions">
                        Subregions
                    </label>
                </div>

                @error('reference')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- @if (array_key_exists('01_nationality_only', $moreOptions)) --}}
            <div class="mb-4">
                <label for="nationalities" class="kt-label mb-2">Nationality</label>
                <select id="nationalities" name="nationalitiesOptions[]" multiple>
                    @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality->id }}">
                            {{ $nationality->name }}</option>
                    @endforeach
                </select>
                <!-- Hidden inputs container for nationalities -->
                <div id="nationalities-hidden-container"></div>
            </div>
            {{-- @endif --}}

            {{-- @if (array_key_exists('subregions', $moreOptions)) --}}
            <div class="mb-4">
                <label class="kt-label mb-2">Subregions</label>
                <select id="subregions" name="subregionsOptions[]" multiple>
                    @foreach ($subregions as $subregion)
                        <option value="{{ $subregion->id }}">
                            {{ $subregion->name }}</option>
                    @endforeach
                </select>
                <!-- Hidden inputs container for subregions -->
                <div id="subregions-hidden-container"></div>
            </div>
            {{-- @endif --}}
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="kt-btn kt-btn-primary">Next</button>
    </div>
</form>

@push('scripts')
    <script src="{{ asset('assets/multi-select/script.js') }}"></script>
@endpush
