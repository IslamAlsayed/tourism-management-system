@extends('layouts.master')

@section('title', 'Edit Airline Service')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Airline Service
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update air transport service information
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="#" class="kt-btn kt-btn-outline">
                    Back to Airline
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Airline Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4">
                        <!-- Logo/Image -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div
                                    class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="airline-preview" src="{{ asset('metronic/media/avatars/300-4.png') }}"
                                        alt="Airline Logo" class="w-full h-full object-cover">
                                </div>
                                <label for="logo"
                                    class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="fa-duotone fa-solid fa-camera text-sm"></i>
                                </label>
                                <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload logo or image</div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" required
                                    value="King Khalid International Airport">
                            </div>

                            <!-- Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                    value="مطار الملك خالد الدولي">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">--</option>
                                    <option value="International Airport" selected>International Airport</option>
                                    <option value="Domestic Airport">Domestic Airport</option>
                                    <option value="Regional Airport">Regional Airport</option>
                                    <option value="Airline">Airline</option>
                                    <option value="Charter Service">Charter Service</option>
                                    <option value="Cargo Service">Cargo Service</option>
                                </select>
                            </div>

                            <!-- Code -->
                            <div class="mb-4">
                                <label for="code" class="kt-label required mb-2">IATA Code</label>
                                <input type="text" name="code" id="code" class="kt-input" required maxlength="3"
                                    value="RUH">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div class="mb-4">
                                <label for="country" class="kt-label required mb-2">Country</label>
                                <select name="country" id="country" class="kt-select" required>
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
                                'value' => $user->address,
                            ])

                            <!-- Description -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description',
                                'value' => $user->description,
                            ])
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="kt-label mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input"
                                    value="+966 11 454 3333">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="kt-label mb-2">Email</label>
                                <input type="email" name="email" id="email" class="kt-input"
                                    value="info@kkaia.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input"
                                    value="www.domain.com">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Capacity -->
                            <div class="mb-4">
                                <label for="capacity" class="kt-label mb-2">Capacity</label>
                                <input type="text" name="capacity" id="capacity" class="kt-input"
                                    placeholder="e.g., 35M passengers/year, 150 aircraft" value="35M passengers/year">
                            </div>

                            <!-- Operating Hours -->
                            <div class="mb-4">
                                <label for="operating_hours" class="kt-label mb-2">Operating Hours</label>
                                <input type="text" name="operating_hours" id="operating_hours" class="kt-input"
                                    placeholder="e.g., 24/7 or 6:00 AM - 10:00 PM" value="24/7">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Runways -->
                            <div class="mb-4">
                                <label for="runways" class="kt-label mb-2">Number of Runways</label>
                                <input type="number" name="runways" id="runways" class="kt-input"
                                    placeholder="Enter number of runways" value="4">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="kt-label required mb-2">Status</label>
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Under Maintenance</option>
                                    <option value="construction">Under Construction</option>
                                </select>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Facilities</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="parking" class="kt-checkbox"
                                        value="parking" checked>
                                    <label for="parking" class="kt-label mb-0">Parking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="restaurants" class="kt-checkbox"
                                        value="restaurants" checked>
                                    <label for="restaurants" class="kt-label mb-0">Restaurants</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="shopping" class="kt-checkbox"
                                        value="shopping" checked>
                                    <label for="shopping" class="kt-label mb-0">Shopping</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="wifi" class="kt-checkbox"
                                        value="wifi" checked>
                                    <label for="wifi" class="kt-label mb-0">Free WiFi</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="lounges" class="kt-checkbox"
                                        value="lounges" checked>
                                    <label for="lounges" class="kt-label mb-0">VIP Lounges</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="hotels" class="kt-checkbox"
                                        value="hotels" checked>
                                    <label for="hotels" class="kt-label mb-0">Hotels</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="car_rental" class="kt-checkbox"
                                        value="car_rental" checked>
                                    <label for="car_rental" class="kt-label mb-0">Car Rental</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="medical" class="kt-checkbox"
                                        value="medical" checked>
                                    <label for="medical" class="kt-label mb-0">Medical Center</label>
                                </div>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Services</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="domestic_flights" class="kt-checkbox"
                                        value="domestic_flights" checked>
                                    <label for="domestic_flights" class="kt-label mb-0">Domestic Flights</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="international_flights"
                                        class="kt-checkbox" value="international_flights" checked>
                                    <label for="international_flights" class="kt-label mb-0">International Flights</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="cargo" class="kt-checkbox"
                                        value="cargo" checked>
                                    <label for="cargo" class="kt-label mb-0">Cargo Services</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="charter" class="kt-checkbox"
                                        value="charter" checked>
                                    <label for="charter" class="kt-label mb-0">Charter Flights</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="private_jet" class="kt-checkbox"
                                        value="private_jet" checked>
                                    <label for="private_jet" class="kt-label mb-0">Private Jet</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="helicopter" class="kt-checkbox"
                                        value="helicopter">
                                    <label for="helicopter" class="kt-label mb-0">Helicopter Service</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="maintenance" class="kt-checkbox"
                                        value="maintenance" checked>
                                    <label for="maintenance" class="kt-label mb-0">Aircraft Maintenance</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="training" class="kt-checkbox"
                                        value="training">
                                    <label for="training" class="kt-label mb-0">Pilot Training</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="fa-duotone fa-solid fa-check text-sm me-2"></i>
                                Update Airline Service
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
                                <i class="fa-duotone fa-solid fa-circle-info text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Keep Information Current</div>
                                <div class="text-sm text-secondary-foreground">Regularly update flight schedules and
                                    service information</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-shield-check text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Safety Compliance</div>
                                <div class="text-sm text-secondary-foreground">Ensure all safety regulations and
                                    certifications are maintained</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Service Excellence</div>
                                <div class="text-sm text-secondary-foreground">Monitor customer feedback and service
                                    quality metrics</div>
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
        // Logo preview
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('airline-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto-uppercase IATA code
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
@endpush
