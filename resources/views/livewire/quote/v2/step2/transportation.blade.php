<div>
    <div class="grid grid-cols-4 gap-4 ps-4">
        @for ($c = 0; $c < $companies; $c++)
            <div class="col-span-1">
                <div class="containerCompanies">
                    <i class="fas fa-plus text-primary addCompany" wire:click="addCompany"></i>
                    <label for="main-companies{{ $c }}" class="kt-label mb-2">Company</label>
                    <select id="main-companies{{ $c }}" name="companies[{{ $c }}]"
                        data-index="{{ $c }}" class="kt-select h-[45px] companyOption">
                        @foreach ($transportCompanies as $company)
                            <option value="{{ $company->id }}">
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-span-3">
                @foreach ($tripData[$c] as $i => $trip)
                    <div class="grid grid-cols-3 gap-3 mb-4 items-end trip">
                        @if ($i > 0)
                            <i class="fas fa-xmark text-red-600 removeTrip"
                                wire:click="removeTrip({{ $c }}, {{ $i }})"></i>
                        @endif

                        {{-- Trip --}}
                        <div data-company="company-trips-{{ $c }}">
                            @if ($i < 1)
                                <label for="main-trip{{ $c . $i }}"
                                    class="kt-label flex justify-between gap-2 mb-2 cursor-pointer">
                                    Trip
                                    <i class="fas fa-plus text-primary" wire:click="addTrip({{ $c }})"></i>
                                </label>
                            @endif
                            <select id="main-trip{{ $c . $i }}"
                                name="trips[{{ $c }}][{{ $i }}][type]"
                                class="kt-select h-[45px]">
                                <option value="">--</option>
                                <option value="full_day">Full day</option>
                                <option value="half_day">Half day</option>
                                <option value="station_day">Station day</option>
                            </select>
                        </div>

                        {{-- Total --}}
                        <div data-company="company-totals-{{ $c }}">
                            @if ($i < 1)
                                <label for="main-total{{ $c . $i }}" class="kt-label mb-2">Total</label>
                            @endif
                            <input id="main-total{{ $c . $i }}" type="number" min="0"
                                name="trips[{{ $c }}][{{ $i }}][total]"
                                class="kt-input h-[45px]" placeholder="0" value="{{ $trip['total'] }}" />
                        </div>

                        {{-- Bus --}}
                        <div data-company="company-buses-{{ $c }}" class="containerBuses">
                            @if ($i < 1)
                                <label for="main-busType{{ $c . $i }}" class="kt-label mb-2">Buses</label>
                            @endif
                            <select id="main-busType{{ $c . $i }}"
                                name="trips[{{ $c }}][{{ $i }}][bused][]" special-multiple>
                                @foreach ($transportCompanies as $company)
                                    @foreach ($company->busTypes as $busType)
                                        <option value="{{ $busType->id }}">
                                            {{ $busType->name }} ({{ $busType->seats }} seats)
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
        @endfor
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/transportation.js') }}"></script>
@endpush
