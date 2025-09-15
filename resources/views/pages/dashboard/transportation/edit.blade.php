@extends('layouts.master')

@section('title', 'Edit Transportation Service')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Transportation Service
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update transportation service information
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="#" class="kt-btn kt-btn-outline">
                    Back to Transportation
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Transportation Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4">
                        <!-- Company Logo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="company-preview" src="{{ asset('metronic/media/avatars/300-3.png') }}" alt="Company Logo" class="w-full h-full object-cover">
                                </div>
                                <label for="logo" class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload company logo</div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">Company Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" placeholder="Enter company name" required value="SAPTCO Bus Company">
                            </div>

                            <!-- Company Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label required mb-2">Company Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input" placeholder="أدخل اسم الشركة" required value="شركة سابتكو للنقل">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Service Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Service Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">Select Service Type</option>
                                    <option value="Bus Service" selected>Bus Service</option>
                                    <option value="Car Rental">Car Rental</option>
                                    <option value="Limousine">Limousine Service</option>
                                    <option value="Taxi Service">Taxi Service</option>
                                    <option value="Tourist Transport">Tourist Transport</option>
                                    <option value="Premium Transport">Premium Transport</option>
                                    <option value="Airport Transfer">Airport Transfer</option>
                                    <option value="City Tour">City Tour</option>
                                </select>
                            </div>

                            <!-- Fleet Size -->
                            <div class="mb-4">
                                <label for="fleet_size" class="kt-label required mb-2">Fleet Size</label>
                                <input type="number" name="fleet_size" id="fleet_size" class="kt-input" placeholder="Enter number of vehicles" required value="500">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div class="mb-4">
                                <label for="country" class="kt-label required mb-2">Country</label>
                                <select name="country" id="country" class="kt-select" required>
                                    <option value="">Select Country</option>
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
                                <input type="text" name="city" id="city" class="kt-input" placeholder="Enter city name" required value="Riyadh">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="kt-label mb-2">Address</label>
                                <textarea name="address" id="address" rows="3" class="kt-input" placeholder="Enter full address">King Fahd Road, Riyadh 12345, Saudi Arabia</textarea>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="kt-label mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" class="kt-input" placeholder="Enter service description">Leading bus transportation company providing reliable and comfortable travel services across Saudi Arabia.</textarea>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="kt-label mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input" placeholder="+966 11 123 4567" value="+966 11 123 4567">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="kt-label mb-2">Email</label>
                                <input type="email" name="email" id="email" class="kt-input" placeholder="info@company.com" value="info@saptco.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input" placeholder="www.company.com" value="www.saptco.com">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Price Range -->
                            <div class="mb-4">
                                <label for="price_range" class="kt-label required mb-2">Price Range</label>
                                <select name="price_range" id="price_range" class="kt-select" required>
                                    <option value="">Select Price Range</option>
                                    <option value="$">$ - Budget Friendly</option>
                                    <option value="$$" selected>$$ - Moderate</option>
                                    <option value="$$$">$$$ - Expensive</option>
                                    <option value="$$$$">$$$$ - Very Expensive</option>
                                </select>
                            </div>

                            <!-- Operating Hours -->
                            <div class="mb-4">
                                <label for="operating_hours" class="kt-label mb-2">Operating Hours</label>
                                <input type="text" name="operating_hours" id="operating_hours" class="kt-input" placeholder="e.g., 24/7 or 6:00 AM - 10:00 PM" value="24/7">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- License Number -->
                            <div class="mb-4">
                                <label for="license_number" class="kt-label mb-2">License Number</label>
                                <input type="text" name="license_number" id="license_number" class="kt-input" placeholder="Enter license number" value="TR-2024-001">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="kt-label required mb-2">Status</label>
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Available Services</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="airport_pickup" class="kt-checkbox" value="airport_pickup" checked>
                                    <label for="airport_pickup" class="kt-label mb-0">Airport Pickup</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="city_tours" class="kt-checkbox" value="city_tours" checked>
                                    <label for="city_tours" class="kt-label mb-0">City Tours</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="desert_safari" class="kt-checkbox" value="desert_safari">
                                    <label for="desert_safari" class="kt-label mb-0">Desert Safari</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="long_distance" class="kt-checkbox" value="long_distance" checked>
                                    <label for="long_distance" class="kt-label mb-0">Long Distance</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="hourly_rental" class="kt-checkbox" value="hourly_rental">
                                    <label for="hourly_rental" class="kt-label mb-0">Hourly Rental</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="daily_rental" class="kt-checkbox" value="daily_rental">
                                    <label for="daily_rental" class="kt-label mb-0">Daily Rental</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="driver_service" class="kt-checkbox" value="driver_service" checked>
                                    <label for="driver_service" class="kt-label mb-0">Driver Service</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" id="group_transport" class="kt-checkbox" value="group_transport" checked>
                                    <label for="group_transport" class="kt-label mb-0">Group Transport</label>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Types -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Vehicle Types</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="sedan" class="kt-checkbox" value="sedan">
                                    <label for="sedan" class="kt-label mb-0">Sedan</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="suv" class="kt-checkbox" value="suv">
                                    <label for="suv" class="kt-label mb-0">SUV</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="bus" class="kt-checkbox" value="bus" checked>
                                    <label for="bus" class="kt-label mb-0">Bus</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="limousine" class="kt-checkbox" value="limousine">
                                    <label for="limousine" class="kt-label mb-0">Limousine</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="van" class="kt-checkbox" value="van" checked>
                                    <label for="van" class="kt-label mb-0">Van</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="pickup" class="kt-checkbox" value="pickup">
                                    <label for="pickup" class="kt-label mb-0">Pickup Truck</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="motorcycle" class="kt-checkbox" value="motorcycle">
                                    <label for="motorcycle" class="kt-label mb-0">Motorcycle</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="vehicle_types[]" id="bicycle" class="kt-checkbox" value="bicycle">
                                    <label for="bicycle" class="kt-label mb-0">Bicycle</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Update Transportation Service
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
                                <div class="font-semibold">Keep Fleet Updated</div>
                                <div class="text-sm text-secondary-foreground">Regularly update your fleet information and vehicle status</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-shield-tick text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Maintain Licenses</div>
                                <div class="text-sm text-secondary-foreground">Ensure all licenses and permits remain valid and up to date</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Monitor Performance</div>
                                <div class="text-sm text-secondary-foreground">Track customer feedback and service quality metrics</div>
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
                document.getElementById('company-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush


