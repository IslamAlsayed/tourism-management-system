@extends('layouts.master')

@section('title', 'Edit Restaurant')

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Restaurant
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update restaurant information
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="#" class="kt-btn kt-btn-outline">
                    Back to Restaurants
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Restaurant Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4">
                        <!-- Restaurant Photo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div
                                    class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="restaurant-preview" src="{{ asset('metronic/media/avatars/300-2.png') }}"
                                        alt="Restaurant Image" class="w-full h-full object-cover">
                                </div>
                                <label for="photo"
                                    class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="fa-duotone fa-solid fa-camera text-sm"></i>
                                </label>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload restaurant photo</div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" required
                                    value="Al Baik Restaurant">
                            </div>

                            <!-- Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                    value="مطعم البيك">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Restaurant Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">--</option>
                                    <option value="Fine Dining">Fine Dining</option>
                                    <option value="Casual">Casual Dining</option>
                                    <option value="Fast Food" selected>Fast Food</option>
                                    <option value="Traditional">Traditional</option>
                                    <option value="Café">Café</option>
                                    <option value="Buffet">Buffet</option>
                                    <option value="Food Truck">Food Truck</option>
                                </select>
                            </div>

                            <!-- Cuisine -->
                            <div class="mb-4">
                                <label for="cuisine" class="kt-label required mb-2">Cuisine Type</label>
                                <select name="cuisine" id="cuisine" class="kt-select" required>
                                    <option value="">--</option>
                                    <option value="Arabic" selected>Arabic</option>
                                    <option value="Saudi">Saudi</option>
                                    <option value="Middle Eastern">Middle Eastern</option>
                                    <option value="Italian">Italian</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="Chinese">Chinese</option>
                                    <option value="Indian">Indian</option>
                                    <option value="International">International</option>
                                    <option value="Seafood">Seafood</option>
                                    <option value="Steakhouse">Steakhouse</option>
                                </select>
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
                                'value' => old('address', 'King Fahd Road, Riyadh 12345, Saudi Arabia'),
                            ])

                            <!-- Description -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description',
                                'value' => old(
                                    'description',
                                    'Famous for its crispy fried chicken and Arabic cuisine, serving customers for over 40 years.'),
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
                                    value="info@albaik.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input"
                                    value="www.domain.com">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Price Range -->
                            <div class="mb-4">
                                <label for="price_range" class="kt-label required mb-2">Price Range</label>
                                <select name="price_range" id="price_range" class="kt-select" required>
                                    <option value="">--</option>
                                    <option value="$" selected>$ - Budget Friendly</option>
                                    <option value="$$">$$ - Moderate</option>
                                    <option value="$$$">$$$ - Expensive</option>
                                    <option value="$$$$">$$$$ - Very Expensive</option>
                                </select>
                            </div>

                            <!-- Capacity -->
                            <div class="mb-4">
                                <label for="capacity" class="kt-label mb-2">Seating Capacity</label>
                                <input type="number" name="capacity" id="capacity" class="kt-input" value="50">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Opening Hours -->
                            <div class="mb-4">
                                <label for="opening_hours" class="kt-label mb-2">Opening Hours</label>
                                <input type="text" name="opening_hours" id="opening_hours" class="kt-input"
                                    value="6:00 AM - 2:00 AM">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="kt-label required mb-2">Status</label>
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="temporarily_closed">Temporarily Closed</option>
                                </select>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="mb-4">
                            <h4 class="mb-2 font-semibold">{{ __('main.features') }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="delivery" class="kt-checkbox"
                                        value="delivery" checked>
                                    <label for="delivery" class="kt-label mb-0">Delivery</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="takeaway" class="kt-checkbox"
                                        value="takeaway" checked>
                                    <label for="takeaway" class="kt-label mb-0">Takeaway</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="outdoor_seating" class="kt-checkbox"
                                        value="outdoor_seating">
                                    <label for="outdoor_seating" class="kt-label mb-0">Outdoor Seating</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="wifi" class="kt-checkbox"
                                        value="wifi">
                                    <label for="wifi" class="kt-label mb-0">Free WiFi</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="parking" class="kt-checkbox"
                                        value="parking" checked>
                                    <label for="parking" class="kt-label mb-0">Parking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="reservations" class="kt-checkbox"
                                        value="reservations">
                                    <label for="reservations" class="kt-label mb-0">Reservations</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="halal" class="kt-checkbox"
                                        value="halal" checked>
                                    <label for="halal" class="kt-label mb-0">Halal</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="vegetarian" class="kt-checkbox"
                                        value="vegetarian">
                                    <label for="vegetarian" class="kt-label mb-0">Vegetarian Options</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="fa-duotone fa-solid fa-check text-sm me-2"></i>
                                Update Restaurant
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
                                <div class="font-semibold">Keep Menu Updated</div>
                                <div class="text-sm text-secondary-foreground">Regularly update your menu and prices to
                                    maintain accuracy</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-camera text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Refresh Photos</div>
                                <div class="text-sm text-secondary-foreground">Update photos to showcase new dishes and
                                    restaurant improvements</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Monitor Reviews</div>
                                <div class="text-sm text-secondary-foreground">Keep track of customer feedback to improve
                                    your service</div>
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
