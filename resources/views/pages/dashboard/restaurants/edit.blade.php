@extends('layouts.master')

@section('title', 'Edit Restaurant')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Restaurant
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update the restaurant information in the system
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                    Back to Restaurants
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            {{-- Accommodation Form --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-6" method="POST" action="{{ route('restaurants.update', $restaurant->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Restaurant Photo --}}
                        @include('components.input-image', [
                            'modelKey' => $restaurant->name ?? 'R',
                            'column' => 'restaurant',
                            'columnName' => 'photo',
                            'photoUrl' => $restaurant->photo ? asset('storage/' . $restaurant->photo) : '',
                        ])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Name --}}
                            <div class="">
                                <label for="name" class="kt-label mb-2">Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $restaurant->name }}">
                            </div>

                            {{-- Name Arabic --}}
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $restaurant->name_ar }}">
                            </div>

                            {{-- Type --}}
                            <div class="">
                                <label for="type" class="kt-label mb-2">Type</label>
                                <select name="type_id" id="type_id" class="kt-select h-[45px]" special-search
                                    value={{ $restaurant->type_id }}>
                                    <option value="">--</option>
                                    @foreach ($types as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ $id == $restaurant->type_id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.edit', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'record' => $restaurant,
                                'multiple' => false,
                            ])

                            {{-- Rating --}}
                            <div class="">
                                <label for="rating" class="kt-label mb-2">Rating</label>
                                <select name="rating" id="rating" class="kt-select h-[45px]" special-search
                                    value="{{ $restaurant->rating }}">
                                    <option value="">--</option>
                                    @foreach (range(1, 5) as $item)
                                        <option value="{{ $item }}"
                                            {{ $restaurant->rating == $item ? 'selected' : '' }}>
                                            {{ $item }} Star{{ $item > 1 ? 's' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Specialty --}}
                            <div class="">
                                <label for="specialty" class="kt-label mb-2">Specialty</label>
                                <input type="text" name="specialty" id="specialty" class="kt-input h-[45px]"
                                    value="{{ $restaurant->specialty }}">
                            </div>

                            {{-- Company Name (Arabic) --}}
                            <div class="">
                                <label for="company_name_ar" class="kt-label mb-2">Company Name
                                    (Arabic)</label>
                                <input type="text" name="company_name_ar" id="company_name_ar" class="kt-input h-[45px]"
                                    value="{{ $restaurant->company_name_ar }}">
                            </div>

                            {{-- phone_01 --}}
                            <div class="">
                                <label for="phone_01" class="kt-label mb-2">Phone 01</label>
                                <input type="text" name="phone_01" id="phone_01" class="kt-input h-[45px]"
                                    value="{{ $restaurant->phone_01 }}">
                            </div>

                            {{-- phone_02 --}}
                            <div class="">
                                <label for="phone_02" class="kt-label mb-2">Phone 02</label>
                                <input type="text" name="phone_02" id="phone_02" class="kt-input h-[45px]"
                                    value="{{ $restaurant->phone_02 }}">
                            </div>

                            {{-- fax --}}
                            <div class="">
                                <label for="fax" class="kt-label mb-2">Fax</label>
                                <input type="text" name="fax" id="fax" class="kt-input h-[45px]"
                                    value="{{ $restaurant->fax }}">
                            </div>

                            {{-- email_01 --}}
                            <div class="">
                                <label for="email_01" class="kt-label mb-2">Email 1</label>
                                <input type="text" name="email_01" id="email_01" class="kt-input h-[45px]"
                                    value="{{ $restaurant->email_01 }}">
                            </div>

                            {{-- email_02 --}}
                            <div class="">
                                <label for="email_02" class="kt-label mb-2">Email 2</label>
                                <input type="text" name="email_02" id="email_02" class="kt-input h-[45px]"
                                    value="{{ $restaurant->email_02 }}">
                            </div>

                            {{-- Contact Person --}}
                            <div class="">
                                <label for="contact_person" class="kt-label mb-2">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="kt-input h-[45px]" value="{{ $restaurant->contact_person }}">
                            </div>

                            {{-- Box --}}
                            <div class="">
                                <label for="box" class="kt-label mb-2">Box</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]"
                                    value="{{ $restaurant->box }}">
                            </div>

                            {{-- Postal Code --}}
                            <div class="">
                                <label for="postal_code" class="kt-label mb-2">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    value="{{ $restaurant->postal_code }}">
                            </div>

                            {{-- Mobile --}}
                            <div class="">
                                <label for="mobile" class="kt-label mb-2">Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]"
                                    value="{{ $restaurant->mobile }}">
                            </div>

                            {{-- Website --}}
                            <div class="">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="text" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ $restaurant->website }}">
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="mb-4">
                            <label for="notes" class="kt-label mb-2">Notes</label>
                            <input id="notes" type="hidden" name="notes" value="{{ $restaurant->notes ?? '' }}">
                            <trix-editor input="notes"></trix-editor>
                        </div>

                        <div class="flex items-center gap-3 mb-4">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox" value="1"
                                {{ $restaurant->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="kt-label mb-0">{{ __('main.is_active') }}</label>
                        </div>

                        {{-- Facilities --}}
                        <div class="">
                            <h4 class="mb-2 font-semibold">{{ __('main.facilities') }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="wheelchair_accessible" value="0">
                                    <input type="checkbox" name="wheelchair_accessible" id="wheelchair_accessible"
                                        class="kt-checkbox" value="1"
                                        {{ $restaurant->wheelchair_accessible ? 'checked' : '' }}>
                                    <label for="wheelchair_accessible"
                                        class="kt-label mb-0">{{ __('main.wheelchair_accessible') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="free_wifi" value="0">
                                    <input type="checkbox" name="free_wifi" id="free_wifi" class="kt-checkbox"
                                        value="1" {{ $restaurant->free_wifi ? 'checked' : '' }}>
                                    <label for="free_wifi" class="kt-label mb-0">{{ __('main.free_wifi') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="parking" value="0">
                                    <input type="checkbox" name="parking" id="parking" class="kt-checkbox"
                                        value="1" {{ $restaurant->parking ? 'checked' : '' }}>
                                    <label for="parking" class="kt-label mb-0">{{ __('main.parking') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="swimming_pool" value="0">
                                    <input type="checkbox" name="swimming_pool" id="swimming_pool" class="kt-checkbox"
                                        value="1" {{ $restaurant->swimming_pool ? 'checked' : '' }}>
                                    <label for="swimming_pool"
                                        class="kt-label mb-0">{{ __('main.swimming_pool') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="gym" value="0">
                                    <input type="checkbox" name="gym" id="gym" class="kt-checkbox"
                                        value="1" {{ $restaurant->gym ? 'checked' : '' }}>
                                    <label for="gym" class="kt-label mb-0">{{ __('main.gym') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="indoor" value="0">
                                    <input type="checkbox" name="indoor" id="indoor" class="kt-checkbox"
                                        value="1" {{ $restaurant->indoor ? 'checked' : '' }}>
                                    <label for="indoor" class="kt-label mb-0">{{ __('main.indoor') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="outdoor" value="0">
                                    <input type="checkbox" name="outdoor" id="outdoor" class="kt-checkbox"
                                        value="1" {{ $restaurant->outdoor ? 'checked' : '' }}>
                                    <label for="outdoor" class="kt-label mb-0">{{ __('main.outdoor') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="spa" value="0">
                                    <input type="checkbox" name="spa" id="spa" class="kt-checkbox"
                                        value="1" {{ $restaurant->spa ? 'checked' : '' }}>
                                    <label for="spa" class="kt-label mb-0">{{ __('main.spa') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Update Submit Buttons -->
                        @include('components.elements.update-submit', ['models' => 'restaurants'])
                    </form>
                </div>
            </div>

            {{-- Tips --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Restaurant Tips</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Complete Information</div>
                                <div class="text-sm text-secondary-foreground">
                                    Provide detailed information to help guests make informed decisions
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">High Quality Photos</div>
                                <div class="text-sm text-secondary-foreground">
                                    Upload clear, high-resolution photos of your restaurant
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Accurate Rating</div>
                                <div class="text-sm text-secondary-foreground">
                                    Select the appropriate star rating based on your facilities and services
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id", "edit");
                filterByForeignId("subregion_id", "country", "country_id", "edit");
                filterByForeignId("country_id", "state", "state_id", "edit");
                filterByForeignId("state_id", "city", "city_id", "edit");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-cascading')
