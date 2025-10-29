@extends('pages.dashboard.quote.v2.layout', ['step' => 2])

@section('form-content')
    <form class="space-y-6" action="{{ route('dashboard.quote.v2.postStep2') }}" method="POST">
        @csrf

        <div class="mb-4">
            {{-- Program Details Id --}}
            <livewire:quote.v2.step2.programDetails />

            {{-- File Type Targets --}}
            <div>
                {{-- Accommodation Target --}}
                <div class="mb-4" style="display: none; visibility: hidden;" data-programdetail-target="accommodation">
                    {{-- Countries and Cities --}}
                    <div class="grid lg:grid-cols-2 gap-4 mb-4">
                        {{-- Countries --}}
                        <div>
                            <label for="countries" class="kt-label mb-2">Country</label>
                            <select id="countries" name="countriesOptions[]" special-multiple>
                                <option value="">--</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('countriesOptions')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cities --}}
                        <div>
                            <label for="cities" class="kt-label mb-2">City</label>
                            <select id="cities" name="citiesOptions[]" special-multiple>
                                <option value="">--</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('citiesOptions')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @foreach (['hotels', 'resorts', 'hostels', 'camps'] as $item)
                        <div>
                            <div class="custom-input mb-4">
                                <input type="checkbox" name="accommodationOptions[]" id="{{ $item }}"
                                    class="mb-0 accommodationOptions" value="{{ $item }}">
                                <label for="{{ $item }}">
                                    {{ $item }}
                                </label>
                            </div>

                            {{-- Accommodation --}}
                            <div class="mb-4" style="display: none; visibility: hidden;"
                                data-accommodationoption-target="{{ $item }}">

                                @switch($item)
                                    {{-- Hotels --}}
                                    @case('hotels')
                                        <div class="kt-card p-4 mb-4">
                                            <div class="mb-4">
                                                <label for="stars" class="kt-label mb-2">Stars:</label>
                                                <div>
                                                    <div class="inline-flex flex-wrap items-center gap-6">
                                                        @foreach ($stars as $star)
                                                            <div class="custom-input">
                                                                <input type="checkbox" name="starsOptions[]"
                                                                    class="mb-0 starsOptions" id="{{ $star }}"
                                                                    value="{{ $star }}">

                                                                <label for="{{ $star }}" special-multiple-checkbox>
                                                                    {{ $star }}

                                                                    @for ($i = 0; $i < $star; $i++)
                                                                        <i class="fas fa-star" style="color: #ffdd00"></i>
                                                                    @endfor
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @error('starsOptions')
                                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- All Hotels --}}
                                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4" id="containerHotels">
                                            <div>
                                                <label for="all-hotels" class="kt-label mb-2">
                                                    All Hotels
                                                </label>
                                                <select id="all-hotels" name="hotelsOptions[]" data-type="hotels" special-multiple>
                                                    @foreach ($hotels as $hotel)
                                                        <option value="{{ $hotel->id }}">
                                                            {{ $hotel->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('hotelsOptions')
                                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @break

                                    {{-- Resorts --}}
                                    @case('resorts')
                                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4" id="containerResorts">
                                            <div>
                                                <label for="main-resorts" class="kt-label mb-2">
                                                    Resorts
                                                </label>
                                                <select id="main-resorts" name="resortsOptions[]" data-type="resorts"
                                                    special-multiple>
                                                    @foreach ([] as $resort)
                                                        <option value="{{ $resort->id }}">
                                                            {{ $resort->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('resortsOptions')
                                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @break

                                    {{-- Hostels --}}
                                    @case('hostels')
                                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4" id="containerHostels">
                                            <div>
                                                <label for="main-hostels" class="kt-label mb-2">
                                                    Hostels
                                                </label>
                                                <select id="main-hostels" name="hostelsOptions[]" data-type="hostels"
                                                    special-multiple>
                                                    @foreach ([] as $hostel)
                                                        <option value="{{ $hostel->id }}">
                                                            {{ $hostel->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('hostelsOptions')
                                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @break

                                    {{-- Camps --}}
                                    @case('camps')
                                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4" id="containerCamps">
                                            <div>
                                                <label for="main-camps" class="kt-label mb-2">
                                                    Camps
                                                </label>
                                                <select id="main-camps" name="campsOptions[]" data-type="camps" special-multiple>
                                                    @foreach ([] as $camp)
                                                        <option value="{{ $camp->id }}">
                                                            {{ $camp->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('campsOptions')
                                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Transportation Target --}}
                <div class="mb-4" style="display: none; visibility: hidden;" data-programdetail-target="transportation">
                    <livewire:quote.v2.step2.transportation />
                </div>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('dashboard.quote.v2.step1') }}" class="kt-btn kt-btn-light">Back</a>
            <button class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        let programDetailIds = document.querySelectorAll('.programDetailIds');

        if (programDetailIds.length > 0) {
            programDetailIds.forEach((checkbox) => {
                checkbox.addEventListener('change', (event) => {
                    toggleDisplayTarget('programdetail', event.target.id);
                });
            });
        }

        let starsOptions = document.querySelectorAll('.starsOptions');

        if (starsOptions.length > 0) {
            starsOptions.forEach((checkbox) => {
                checkbox.addEventListener('change', (event) => {
                    toggleDisplayTarget('programdetail', event.target.id);
                });
            });
        }

        let accommodationOptions = document.querySelectorAll('.accommodationOptions');

        if (accommodationOptions.length > 0) {
            accommodationOptions.forEach((checkbox) => {
                checkbox.addEventListener('change', (event) => {
                    toggleDisplayTarget('accommodationoption', event.target.id);
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
