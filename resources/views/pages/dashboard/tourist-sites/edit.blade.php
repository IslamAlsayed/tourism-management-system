@extends('layouts.master')

@section('title', 'Edit Tourist Site')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Tourist Site
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update tourist site information
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="#" class="kt-btn kt-btn-outline">
                    Back to Tourist Sites
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Tourist Site Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4">
                        <!-- Site Photo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div
                                    class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="site-preview" src="{{ asset('metronic/media/avatars/300-6.png') }}"
                                        alt="Tourist Site Image" class="w-full h-full object-cover">
                                </div>
                                <label for="photo"
                                    class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload tourist site photo</div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Site Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">Site Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" required
                                    value="Al-Ula Heritage Site">
                            </div>

                            <!-- Site Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label required mb-2">Site Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input" required
                                    value="موقع العلا التراثي">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Site Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Site Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">--</option>
                                    <option value="Historical Site" selected>Historical Site</option>
                                    <option value="Natural Wonder">Natural Wonder</option>
                                    <option value="Museum">Museum</option>
                                    <option value="Landmark">Landmark</option>
                                    <option value="Shopping Center">Shopping Center</option>
                                    <option value="Historic District">Historic District</option>
                                    <option value="Religious Site">Religious Site</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Park">Park</option>
                                    <option value="Beach">Beach</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label for="category" class="kt-label mb-2">Category</label>
                                <select name="category" id="category" class="kt-select">
                                    <option value="">--</option>
                                    <option value="Cultural" selected>Cultural</option>
                                    <option value="Adventure">Adventure</option>
                                    <option value="Family">Family</option>
                                    <option value="Educational">Educational</option>
                                    <option value="Religious">Religious</option>
                                    <option value="Nature">Nature</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Shopping">Shopping</option>
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
                                    value="Al-Ula">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="kt-label mb-2">Address</label>
                                <textarea name="address" id="address" rows="3" class="kt-input">Al-Ula Heritage Site, Al-Ula 43512, Saudi Arabia</textarea>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="kt-label mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" class="kt-input">Ancient Nabatean city with rock-cut tombs and archaeological wonders dating back thousands of years.</textarea>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="kt-label mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input"
                                    value="+966 14 884 4444">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="kt-label mb-2">Email</label>
                                <input type="email" name="email" id="email" class="kt-input"
                                    value="info@experiencealula.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input"
                                    value="www.experiencealula.com">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Entrance Fee -->
                            <div class="mb-4">
                                <label for="entrance_fee" class="kt-label mb-2">Entrance Fee</label>
                                <input type="text" name="entrance_fee" id="entrance_fee" class="kt-input"
                                    value="150 SAR">
                            </div>

                            <!-- Opening Hours -->
                            <div class="mb-4">
                                <label for="opening_hours" class="kt-label mb-2">Opening Hours</label>
                                <input type="text" name="opening_hours" id="opening_hours" class="kt-input"
                                    value="8:00 AM - 6:00 PM">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Best Time to Visit -->
                            <div class="mb-4">
                                <label for="best_time" class="kt-label mb-2">Best Time to Visit</label>
                                <input type="text" name="best_time" id="best_time" class="kt-input"
                                    value="Early morning or late afternoon">
                            </div>

                            <!-- Duration -->
                            <div class="mb-4">
                                <label for="duration" class="kt-label mb-2">Recommended Duration</label>
                                <input type="text" name="duration" id="duration" class="kt-input"
                                    value="3-4 hours">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Coordinates -->
                            <div class="mb-4">
                                <label for="coordinates" class="kt-label mb-2">GPS Coordinates</label>
                                <input type="text" name="coordinates" id="coordinates" class="kt-input"
                                    value="26.6089° N, 37.9128° E">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="kt-label required mb-2">Status</label>
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="under_renovation">Under Renovation</option>
                                    <option value="seasonal">Seasonal</option>
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
                                    <input type="checkbox" name="facilities[]" id="restrooms" class="kt-checkbox"
                                        value="restrooms" checked>
                                    <label for="restrooms" class="kt-label mb-0">Restrooms</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="restaurants" class="kt-checkbox"
                                        value="restaurants" checked>
                                    <label for="restaurants" class="kt-label mb-0">Restaurants</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="gift_shop" class="kt-checkbox"
                                        value="gift_shop" checked>
                                    <label for="gift_shop" class="kt-label mb-0">Gift Shop</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="wifi" class="kt-checkbox"
                                        value="wifi" checked>
                                    <label for="wifi" class="kt-label mb-0">Free WiFi</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="guided_tours" class="kt-checkbox"
                                        value="guided_tours" checked>
                                    <label for="guided_tours" class="kt-label mb-0">Guided Tours</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="audio_guide" class="kt-checkbox"
                                        value="audio_guide" checked>
                                    <label for="audio_guide" class="kt-label mb-0">Audio Guide</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="wheelchair" class="kt-checkbox"
                                        value="wheelchair">
                                    <label for="wheelchair" class="kt-label mb-0">Wheelchair Accessible</label>
                                </div>
                            </div>
                        </div>

                        <!-- Activities -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Available Activities</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="photography" class="kt-checkbox"
                                        value="photography" checked>
                                    <label for="photography" class="kt-label mb-0">Photography</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="hiking" class="kt-checkbox"
                                        value="hiking" checked>
                                    <label for="hiking" class="kt-label mb-0">Hiking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="swimming" class="kt-checkbox"
                                        value="swimming">
                                    <label for="swimming" class="kt-label mb-0">Swimming</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="camping" class="kt-checkbox"
                                        value="camping">
                                    <label for="camping" class="kt-label mb-0">Camping</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="shopping" class="kt-checkbox"
                                        value="shopping" checked>
                                    <label for="shopping" class="kt-label mb-0">Shopping</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="dining" class="kt-checkbox"
                                        value="dining" checked>
                                    <label for="dining" class="kt-label mb-0">Dining</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="entertainment" class="kt-checkbox"
                                        value="entertainment">
                                    <label for="entertainment" class="kt-label mb-0">Entertainment</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="education" class="kt-checkbox"
                                        value="education" checked>
                                    <label for="education" class="kt-label mb-0">Educational Tours</label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="kt-label mb-2">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="4" class="kt-input">UNESCO World Heritage site with ongoing archaeological discoveries. Best visited during cooler months.</textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Update Tourist Site
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
                                <div class="font-semibold">Keep Information Current</div>
                                <div class="text-sm text-secondary-foreground">Regularly update opening hours, fees, and
                                    special events</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-camera text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Refresh Photos</div>
                                <div class="text-sm text-secondary-foreground">Update photos to reflect seasonal changes
                                    and improvements</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Monitor Reviews</div>
                                <div class="text-sm text-secondary-foreground">Track visitor feedback to improve the
                                    tourist experience</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
