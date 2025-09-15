@extends('layouts.master')

@section('title', 'Create New Crossing/Port')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Create New Crossing/Port
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Add a new crossing or port to the system
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="#" class="kt-btn kt-btn-outline">
                    Back to Crossings & Ports
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Crossing/Port Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4">
                        <!-- Logo/Image -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="crossing-preview" src="{{ asset('metronic/media/avatars/300-7.png') }}" alt="Crossing/Port Logo" class="w-full h-full object-cover">
                                </div>
                                <label for="logo" class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload logo or image</div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" placeholder="Enter name" required>
                            </div>

                            <!-- Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label required mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input" placeholder="أدخل الاسم" required>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">Select Type</option>
                                    <option value="Land Crossing">Land Crossing</option>
                                    <option value="International Airport">International Airport</option>
                                    <option value="Domestic Airport">Domestic Airport</option>
                                    <option value="Seaport">Seaport</option>
                                    <option value="River Port">River Port</option>
                                    <option value="Border Post">Border Post</option>
                                    <option value="Customs Point">Customs Point</option>
                                </select>
                            </div>

                            <!-- Code -->
                            <div class="mb-4">
                                <label for="code" class="kt-label required mb-2">Code</label>
                                <input type="text" name="code" id="code" class="kt-input" placeholder="e.g., RUH, KFC" required maxlength="10">
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
                                <input type="text" name="city" id="city" class="kt-input" placeholder="Enter city name" required>
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
                                <textarea name="description" id="description" rows="3" class="kt-input" placeholder="Enter description"></textarea>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="kt-label mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input" placeholder="+966 11 123 4567">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="kt-label mb-2">Email</label>
                                <input type="email" name="email" id="email" class="kt-input" placeholder="info@crossing.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input" placeholder="www.crossing.com">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Capacity -->
                            <div class="mb-4">
                                <label for="capacity" class="kt-label mb-2">Capacity</label>
                                <input type="text" name="capacity" id="capacity" class="kt-input" placeholder="e.g., 35M passengers/year, 50,000 vehicles/day">
                            </div>

                            <!-- Operating Hours -->
                            <div class="mb-4">
                                <label for="operating_hours" class="kt-label mb-2">Operating Hours</label>
                                <input type="text" name="operating_hours" id="operating_hours" class="kt-input" placeholder="e.g., 24/7, 6:00 AM - 10:00 PM">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Coordinates -->
                            <div class="mb-4">
                                <label for="coordinates" class="kt-label mb-2">GPS Coordinates</label>
                                <input type="text" name="coordinates" id="coordinates" class="kt-input" placeholder="e.g., 24.7136° N, 46.6753° E">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="kt-label required mb-2">Status</label>
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Under Maintenance</option>
                                    <option value="construction">Under Construction</option>
                                </select>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Available Services</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="customs" class="kt-checkbox" value="customs">
                                    <label for="customs" class="kt-label mb-0">Customs</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="immigration" class="kt-checkbox" value="immigration">
                                    <label for="immigration" class="kt-label mb-0">Immigration</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="security" class="kt-checkbox" value="security">
                                    <label for="security" class="kt-label mb-0">Security</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="parking" class="kt-checkbox" value="parking">
                                    <label for="parking" class="kt-label mb-0">Parking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="restaurants" class="kt-checkbox" value="restaurants">
                                    <label for="restaurants" class="kt-label mb-0">Restaurants</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="shopping" class="kt-checkbox" value="shopping">
                                    <label for="shopping" class="kt-label mb-0">Shopping</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="wifi" class="kt-checkbox" value="wifi">
                                    <label for="wifi" class="kt-label mb-0">Free WiFi</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="lounges" class="kt-checkbox" value="lounges">
                                    <label for="lounges" class="kt-label mb-0">VIP Lounges</label>
                                </div>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Facilities</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="restrooms" class="kt-checkbox" value="restrooms">
                                    <label for="restrooms" class="kt-label mb-0">Restrooms</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="medical" class="kt-checkbox" value="medical">
                                    <label for="medical" class="kt-label mb-0">Medical Center</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="banking" class="kt-checkbox" value="banking">
                                    <label for="banking" class="kt-label mb-0">Banking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="currency_exchange" class="kt-checkbox" value="currency_exchange">
                                    <label for="currency_exchange" class="kt-label mb-0">Currency Exchange</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="car_rental" class="kt-checkbox" value="car_rental">
                                    <label for="car_rental" class="kt-label mb-0">Car Rental</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="hotels" class="kt-checkbox" value="hotels">
                                    <label for="hotels" class="kt-label mb-0">Hotels</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="transportation" class="kt-checkbox" value="transportation">
                                    <label for="transportation" class="kt-label mb-0">Transportation</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="information" class="kt-checkbox" value="information">
                                    <label for="information" class="kt-label mb-0">Information Desk</label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="kt-label mb-2">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="4" class="kt-input" placeholder="Enter any additional notes about the crossing/port"></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Create Crossing/Port
                            </button>
                            <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
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
                    <h3 class="kt-card-title">Crossing/Port Tips</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Accurate Codes</div>
                                <div class="text-sm text-secondary-foreground">Use correct IATA/ICAO codes for airports and standard codes for other facilities</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-shield-tick text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Security Standards</div>
                                <div class="text-sm text-secondary-foreground">Ensure all security protocols and safety measures are properly documented</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Service Quality</div>
                                <div class="text-sm text-secondary-foreground">Maintain high service standards for efficient passenger and cargo processing</div>
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
                document.getElementById('crossing-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-uppercase code
    document.getElementById('code').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
</script>
@endpush


