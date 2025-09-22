@extends('layouts.master')

@section('title', 'Create New Accommodation')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Create New Accommodation
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Add a new accommodation to the system
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
        <div class="grid gap-5 lg:gap-7.5">
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
                                <input type="text" name="name" id="name" class="kt-input"
                                    placeholder="Enter accommodation name" required>
                            </div>

                            <!-- Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label required mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                    placeholder="أدخل اسم الإقامة" required>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Accommodation Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">Select Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                    {{-- <option value="Hotel">Hotel</option>
                                    <option value="Resort">Resort</option>
                                    <option value="Camp">Tourist Camp</option>
                                    <option value="Hostel">Hostel</option>
                                    <option value="Lodge">Lodge</option>
                                    <option value="Apartment">Hotel Apartment</option> --}}
                                </select>
                            </div>

                            <!-- Rating -->
                            <div class="mb-4">
                                <label for="rating" class="kt-label required mb-2">Star Rating</label>
                                <select name="rating" id="rating" class="kt-select" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div class="mb-4">
                                <label for="country" class="kt-label required mb-2">Country</label>
                                <select name="country" id="country" class="kt-select" required>
                                    <option value="">Select Country</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
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
                                <input type="text" name="city" id="city" class="kt-input"
                                    placeholder="Enter city name" required>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="kt-label mb-2">Address</label>
                                <textarea name="address" id="address" rows="3" class="kt-input" placeholder="Enter full address"></textarea>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="kt-label mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" class="kt-input"
                                    placeholder="Enter accommodation description"></textarea>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="kt-label mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input"
                                    placeholder="+966 11 123 4567">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="kt-label mb-2">Email</label>
                                <input type="email" name="email" id="email" class="kt-input"
                                    placeholder="info@accommodation.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input"
                                    placeholder="www.accommodation.com">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Number of Rooms -->
                            <div class="mb-4">
                                <label for="rooms" class="kt-label required mb-2">Number of Rooms</label>
                                <input type="number" name="rooms" id="rooms" class="kt-input"
                                    placeholder="Enter number of rooms" required>
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
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Under Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Facilities</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="wifi" class="kt-checkbox"
                                        value="wifi">
                                    <label for="wifi" class="kt-label mb-0">Free WiFi</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="parking" class="kt-checkbox"
                                        value="parking">
                                    <label for="parking" class="kt-label mb-0">Parking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="pool" class="kt-checkbox"
                                        value="pool">
                                    <label for="pool" class="kt-label mb-0">Swimming Pool</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="gym" class="kt-checkbox"
                                        value="gym">
                                    <label for="gym" class="kt-label mb-0">Gym</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="restaurant" class="kt-checkbox"
                                        value="restaurant">
                                    <label for="restaurant" class="kt-label mb-0">Restaurant</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="spa" class="kt-checkbox"
                                        value="spa">
                                    <label for="spa" class="kt-label mb-0">Spa</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="airport_shuttle" class="kt-checkbox"
                                        value="airport_shuttle">
                                    <label for="airport_shuttle" class="kt-label mb-0">Airport Shuttle</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="pet_friendly" class="kt-checkbox"
                                        value="pet_friendly">
                                    <label for="pet_friendly" class="kt-label mb-0">Pet Friendly</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Create Accommodation
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                Save and Add Another
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
                    <h3 class="kt-card-title">Accommodation Tips</h3>
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
                                <i class="ki-filled ki-camera text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">High Quality Photos</div>
                                <div class="text-sm text-secondary-foreground">Upload clear, high-resolution photos of your
                                    accommodation</div>
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
                    document.getElementById('accommodation-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
