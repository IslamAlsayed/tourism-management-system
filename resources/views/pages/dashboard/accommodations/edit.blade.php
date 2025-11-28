@extends('layouts.master')

@section('title', 'Edit Accommodation')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Accommodation
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update accommodation information
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="#" class="kt-btn kt-btn-outline">
                    Back to Accommodations
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Accommodation Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4">
                        <!-- Accommodation Photo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div
                                    class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="accommodation-preview" src="{{ asset('metronic/media/avatars/300-1.png') }}"
                                        alt="Accommodation Image" class="w-full h-full object-cover">
                                </div>
                                <label for="photo"
                                    class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload accommodation photo</div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" required
                                    value="Grand Plaza Hotel">
                            </div>

                            <!-- Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label required mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input" required
                                    value="فندق جراند بلازا">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Accommodation Type</label>
                                <select name="type" id="type" class="kt-select" special-search required>
                                    <option value="">--</option>
                                    <option value="Hotel" selected>Hotel</option>
                                    <option value="Resort">Resort</option>
                                    <option value="Camp">Tourist Camp</option>
                                    <option value="Hostel">Hostel</option>
                                    <option value="Lodge">Lodge</option>
                                    <option value="Apartment">Hotel Apartment</option>
                                </select>
                            </div>

                            <!-- Rating -->
                            <div class="mb-4">
                                <label for="rating" class="kt-label required mb-2">Star Rating</label>
                                <select name="rating" id="rating" class="kt-select" special-search required>
                                    <option value="">--</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5" selected>5 Stars</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div class="mb-4">
                                <label for="country" class="kt-label required mb-2">Country</label>
                                <select name="country" id="country" class="kt-select" special-search required>
                                    <option value="">--</option>
                                    <option value="Saudi Arabia" selected>Saudi Arabia</option>
                                    <option value="UAE">United Arab Emirates</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Oman">Oman</option>
                                </select>
                            </div>

                            <!-- City -->
                            <div class="mb-4">
                                <label for="city" class="kt-label required mb-2">City</label>
                                <input type="text" name="city" id="city" class="kt-input" required
                                    value="Riyadh">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Address -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'address',
                                'value' => $accommodation->address,
                            ])

                            <!-- Description -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description',
                                'value' => $accommodation->description,
                            ])
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="kt-label mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input"
                                    value="+966 11 123 4567">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="kt-label mb-2">Email</label>
                                <input type="email" name="email" id="email" class="kt-input"
                                    value="info@grandplaza.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input"
                                    value="www.grandplaza.com">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Number of Rooms -->
                            <div class="mb-4">
                                <label for="rooms" class="kt-label required mb-2">Number of Rooms</label>
                                <input type="number" name="rooms" id="rooms" class="kt-input" required
                                    value="250">
                            </div>

                            <!-- Check-in Time -->
                            <div class="mb-4">
                                <label for="checkin_time" class="kt-label mb-2">Check-in Time</label>
                                <input type="time" name="checkin_time" id="checkin_time" class="kt-input"
                                    value="15:00">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Check-out Time -->
                            <div class="mb-4">
                                <label for="checkout_time" class="kt-label mb-2">Check-out Time</label>
                                <input type="time" name="checkout_time" id="checkout_time" class="kt-input"
                                    value="12:00">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="kt-label required mb-2">Status</label>
                                <select name="status" id="status" class="kt-select" special-search required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Under Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-4">
                            <h4 class="mb-2 font-semibold">{{ __('main.facilities') }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'wifi',
                                        'value' => '1',
                                        'checked' => in_array('wifi', $accommodation->facilities ?? []),
                                        'label' => __('main.free_wifi'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'parking',
                                        'value' => '1',
                                        'checked' => in_array('parking', $accommodation->facilities ?? []),
                                        'label' => __('main.parking'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'pool',
                                        'value' => '1',
                                        'checked' => in_array('pool', $accommodation->facilities ?? []),
                                        'label' => __('main.swimming_pool'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'gym',
                                        'value' => '1',
                                        'checked' => in_array('gym', $accommodation->facilities ?? []),
                                        'label' => __('main.gym'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'restaurant',
                                        'value' => '1',
                                        'checked' => in_array('restaurant', $accommodation->facilities ?? []),
                                        'label' => __('main.restaurant'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'spa',
                                        'value' => '1',
                                        'checked' => in_array('spa', $accommodation->facilities ?? []),
                                        'label' => __('main.spa'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'airport_shuttle',
                                        'value' => '1',
                                        'checked' => in_array('airport_shuttle', $accommodation->facilities ?? []),
                                        'label' => __('main.airport_shuttle'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="facilities[]" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'facilities[]',
                                        'id' => 'pet_friendly',
                                        'value' => '1',
                                        'checked' => in_array('pet_friendly', $accommodation->facilities ?? []),
                                        'label' => __('main.pet_friendly'),
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Update Accommodation
                            </button>
                            <a href="#" class="kt-btn kt-btn-outline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Update Tips</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Keep Information Updated</div>
                                <div class="text-sm text-secondary-foreground">Regularly update your accommodation
                                    information to maintain accuracy</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-camera text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Refresh Photos</div>
                                <div class="text-sm text-secondary-foreground">Update photos to reflect current conditions
                                    and improvements</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Monitor Reviews</div>
                                <div class="text-sm text-secondary-foreground">Keep track of guest feedback to improve your
                                    services</div>
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
                    document.getElementById('accommodation-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
