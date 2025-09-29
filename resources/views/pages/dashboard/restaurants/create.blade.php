@extends('layouts.master')

@section('title', 'Create New Restaurant')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Create New Restaurant
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Add a new restaurant to the system
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
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Accommodation Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4" method="POST" action="{{ route('restaurants.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Restaurant Photo -->
                        @include('components.input-image', ['columnName' => 'restaurant'])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            <!-- Name -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    placeholder="Enter accommodation name" required>
                            </div>

                            <!-- Name Arabic -->
                            <div class="">
                                <label for="name_ar" class="kt-label required mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    placeholder="أدخل اسم الإقامة" required>
                            </div>

                            <!-- Country -->
                            <div class="">
                                <label for="country_id" class="kt-label required mb-2">Country</label>
                                <select name="country_id" id="country_id" class="kt-select h-[45px]" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- City -->
                            <div class="">
                                <label for="city_id" class="kt-label required mb-2">City</label>
                                <select name="city_id" id="city_id" class="kt-select h-[45px]" required>
                                    <option value="">Select City</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Region -->
                            <div class="">
                                <label for="region_id" class="kt-label required mb-2">Region</label>
                                <select name="region_id" id="region_id" class="kt-select h-[45px]" required>
                                    <option value="">Select Region</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subregion -->
                            <div class="">
                                <label for="subregion_id" class="kt-label required mb-2">Subregion</label>
                                <select name="subregion_id" id="subregion_id" class="kt-select h-[45px]" required>
                                    <option value="">Select Subregion</option>
                                    @foreach ($subregions as $subregion)
                                        <option value="{{ $subregion->id }}">{{ $subregion->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type -->
                            <div class="">
                                <label for="type" class="kt-label required mb-2">Type</label>
                                <select name="type" id="type" class="kt-select h-[45px]">
                                    <option value="">Select Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Rating -->
                            <div class="">
                                <label for="rating" class="kt-label required mb-2">Star Rating</label>
                                <select name="rating" id="rating" class="kt-select h-[45px]" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>

                            <!-- Specialty -->
                            <div class="">
                                <label for="specialty" class="kt-label required mb-2">Specialty</label>
                                <input type="text" name="specialty" id="specialty" class="kt-input h-[45px]"
                                    placeholder="Enter company name in Arabic" required>
                            </div>

                            <!-- Company Name (Arabic) -->
                            <div class="">
                                <label for="company_name_ar" class="kt-label required mb-2">Company Name
                                    (Arabic)</label>
                                <input type="text" name="company_name_ar" id="company_name_ar"
                                    class="kt-input h-[45px]" placeholder="Enter company name in Arabic" required>
                            </div>

                            <!-- phone_01 -->
                            <div class="">
                                <label for="phone_01" class="kt-label required mb-2">Phone 01</label>
                                <input type="text" name="phone_01" id="phone_01" class="kt-input h-[45px]"
                                    placeholder="Enter phone number" required>
                            </div>

                            <!-- phone_02 -->
                            <div class="">
                                <label for="phone_02" class="kt-label required mb-2">Phone 02</label>
                                <input type="text" name="phone_02" id="phone_02" class="kt-input h-[45px]"
                                    placeholder="Enter phone number" required>
                            </div>

                            <!-- fax -->
                            <div class="">
                                <label for="fax" class="kt-label required mb-2">Fax</label>
                                <input type="text" name="fax" id="fax" class="kt-input h-[45px]"
                                    placeholder="Enter fax number" required>
                            </div>

                            <!-- email_01 -->
                            <div class="">
                                <label for="email_01" class="kt-label required mb-2">Email 1</label>
                                <input type="text" name="email_01" id="email_01" class="kt-input h-[45px]"
                                    placeholder="Enter email_01 number" required>
                            </div>

                            <!-- email_02 -->
                            <div class="">
                                <label for="email_02" class="kt-label required mb-2">Email 2</label>
                                <input type="text" name="email_02" id="email_02" class="kt-input h-[45px]"
                                    placeholder="Enter email_02 number" required>
                            </div>

                            <!-- Contact Person -->
                            <div class="">
                                <label for="contact_person" class="kt-label required mb-2">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="kt-input h-[45px]" placeholder="Enter contact person name" required>
                            </div>

                            <!-- Box -->
                            <div class="">
                                <label for="box" class="kt-label required mb-2">Box</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]"
                                    placeholder="Enter box number" required>
                            </div>

                            <!-- Postal Code -->
                            <div class="">
                                <label for="postal_code" class="kt-label required mb-2">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    placeholder="Enter postal code" required>
                            </div>

                            <!-- Mobile -->
                            <div class="">
                                <label for="mobile" class="kt-label required mb-2">Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]"
                                    placeholder="Enter mobile number" required>
                            </div>

                            <!-- Website -->
                            <div class="">
                                <label for="website" class="kt-label required mb-2">Website</label>
                                <input type="text" name="website" id="website" class="kt-input h-[45px]"
                                    placeholder="Enter website URL" required>
                            </div>

                            <!-- Note -->
                            <div class="">
                                <label for="note" class="kt-label mb-2">Note</label>
                                <textarea name="note" id="note" rows="3" class="kt-input h-[45px]"
                                    placeholder="Enter any additional notes"></textarea>
                            </div>

                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1">
                                    <label for="is_active" class="kt-label mb-0">{{ __('main.is_active') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Facilities</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="wheelchair_accessible" value="0">
                                    <input type="checkbox" name="wheelchair_accessible" id="wheelchair_accessible"
                                        class="kt-checkbox" value="1">
                                    <label for="wheelchair_accessible"
                                        class="kt-label mb-0">{{ __('main.wheelchair_accessible') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="free_wifi" value="0">
                                    <input type="checkbox" name="free_wifi" id="free_wifi" class="kt-checkbox"
                                        value="1">
                                    <label for="free_wifi" class="kt-label mb-0">{{ __('main.free_wifi') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="parking" value="0">
                                    <input type="checkbox" name="parking" id="parking" class="kt-checkbox"
                                        value="1">
                                    <label for="parking" class="kt-label mb-0">{{ __('main.parking') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="swimming_pool" value="0">
                                    <input type="checkbox" name="swimming_pool" id="swimming_pool" class="kt-checkbox"
                                        value="1">
                                    <label for="swimming_pool"
                                        class="kt-label mb-0">{{ __('main.swimming_pool') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="gym" value="0">
                                    <input type="checkbox" name="gym" id="gym" class="kt-checkbox"
                                        value="1">
                                    <label for="gym" class="kt-label mb-0">{{ __('main.gym') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="indoor" value="0">
                                    <input type="checkbox" name="indoor" id="indoor" class="kt-checkbox"
                                        value="1">
                                    <label for="indoor" class="kt-label mb-0">{{ __('main.indoor') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="outdoor" value="0">
                                    <input type="checkbox" name="outdoor" id="outdoor" class="kt-checkbox"
                                        value="1">
                                    <label for="outdoor" class="kt-label mb-0">{{ __('main.outdoor') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="spa" value="0">
                                    <input type="checkbox" name="spa" id="spa" class="kt-checkbox"
                                        value="1">
                                    <label for="spa" class="kt-label mb-0">{{ __('main.spa') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Create Restaurant
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                Save and Add Another
                            </button>
                            <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
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
                                <div class="text-sm text-secondary-foreground">Provide detailed information to help guests
                                    make informed decisions</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                {{-- <i class="ki-filled ki-camera text-warning"></i> --}}
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">High Quality Photos</div>
                                <div class="text-sm text-secondary-foreground">Upload clear, high-resolution photos of your
                                    restaurant</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Accurate Rating</div>
                                <div class="text-sm text-secondary-foreground">Select the appropriate star rating based on
                                    your facilities and services</div>
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
        // Photo preview
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('restaurant-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
