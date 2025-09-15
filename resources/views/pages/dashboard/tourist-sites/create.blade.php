@extends('layouts.master')

@section('title', 'Create New Tourist Site')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Create New Tourist Site
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Add a new tourist site to the system
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
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Tourist Site Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="p-4 space-y-6">
                        <!-- Site Photo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div class="w-24 h-24 mx-auto mb-4 overflow-hidden border-4 border-white rounded-full shadow-lg bg-secondary-light">
                                    <img id="site-preview" src="{{ asset('metronic/media/avatars/300-6.png') }}" alt="Tourist Site Image" class="object-cover w-full h-full">
                                </div>
                                <label for="photo" class="absolute bottom-0 right-0 p-2 text-white rounded-full cursor-pointer bg-primary hover:bg-primary-dark">
                                    <i class="text-sm ki-filled ki-camera"></i>
                                </label>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload tourist site photo</div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <!-- Site Name -->
                            <div class="mb-4">
                                <label for="name" class="mb-2 kt-label required">Site Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" placeholder="Enter site name" required>
                            </div>

                            <!-- Site Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="mb-2 kt-label required">Site Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input" placeholder="أدخل اسم الموقع" required>
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <!-- Site Type -->
                            <div class="mb-4">
                                <label for="type" class="mb-2 kt-label required">Site Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">Select Site Type</option>
                                    <option value="Historical Site">Historical Site</option>
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
                                <label for="category" class="mb-2 kt-label">Category</label>
                                <select name="category" id="category" class="kt-select">
                                    <option value="">Select Category</option>
                                    <option value="Cultural">Cultural</option>
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

                        <div class="grid gap-6 lg:grid-cols-2">
                            <!-- Country -->
                            <div class="mb-4">
                                <label for="country" class="mb-2 kt-label required">Country</label>
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
                                <label for="city" class="mb-2 kt-label required">City</label>
                                <input type="text" name="city" id="city" class="kt-input" placeholder="Enter city name" required>
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="mb-2 kt-label">Address</label>
                                <textarea name="address" id="address" rows="3" class="kt-input" placeholder="Enter full address"></textarea>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="mb-2 kt-label">Description</label>
                                <textarea name="description" id="description" rows="3" class="kt-input" placeholder="Enter site description"></textarea>
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-3">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="mb-2 kt-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input" placeholder="+966 11 123 4567">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="mb-2 kt-label">Email</label>
                                <input type="email" name="email" id="email" class="kt-input" placeholder="info@site.com">
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="mb-2 kt-label">Website</label>
                                <input type="url" name="website" id="website" class="kt-input" placeholder="www.site.com">
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <!-- Entrance Fee -->
                            <div class="mb-4">
                                <label for="entrance_fee" class="mb-2 kt-label">Entrance Fee</label>
                                <input type="text" name="entrance_fee" id="entrance_fee" class="kt-input" placeholder="e.g., 50 SAR, Free">
                            </div>

                            <!-- Opening Hours -->
                            <div class="mb-4">
                                <label for="opening_hours" class="mb-2 kt-label">Opening Hours</label>
                                <input type="text" name="opening_hours" id="opening_hours" class="kt-input" placeholder="e.g., 8:00 AM - 6:00 PM, 24/7">
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <!-- Best Time to Visit -->
                            <div class="mb-4">
                                <label for="best_time" class="mb-2 kt-label">Best Time to Visit</label>
                                <input type="text" name="best_time" id="best_time" class="kt-input" placeholder="e.g., Early morning, Evening">
                            </div>

                            <!-- Duration -->
                            <div class="mb-4">
                                <label for="duration" class="mb-2 kt-label">Recommended Duration</label>
                                <input type="text" name="duration" id="duration" class="kt-input" placeholder="e.g., 2-3 hours, Full day">
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <!-- Coordinates -->
                            <div class="mb-4">
                                <label for="coordinates" class="mb-2 kt-label">GPS Coordinates</label>
                                <input type="text" name="coordinates" id="coordinates" class="kt-input" placeholder="e.g., 24.7136° N, 46.6753° E">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="mb-2 kt-label required">Status</label>
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="under_renovation">Under Renovation</option>
                                    <option value="seasonal">Seasonal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-4">
                            <label class="mb-2 kt-label">Facilities</label>
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="parking" class="kt-checkbox" value="parking">
                                    <label for="parking" class="mb-0 kt-label">Parking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="restrooms" class="kt-checkbox" value="restrooms">
                                    <label for="restrooms" class="mb-0 kt-label">Restrooms</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="restaurants" class="kt-checkbox" value="restaurants">
                                    <label for="restaurants" class="mb-0 kt-label">Restaurants</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="gift_shop" class="kt-checkbox" value="gift_shop">
                                    <label for="gift_shop" class="mb-0 kt-label">Gift Shop</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="wifi" class="kt-checkbox" value="wifi">
                                    <label for="wifi" class="mb-0 kt-label">Free WiFi</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="guided_tours" class="kt-checkbox" value="guided_tours">
                                    <label for="guided_tours" class="mb-0 kt-label">Guided Tours</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="audio_guide" class="kt-checkbox" value="audio_guide">
                                    <label for="audio_guide" class="mb-0 kt-label">Audio Guide</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="facilities[]" id="wheelchair" class="kt-checkbox" value="wheelchair">
                                    <label for="wheelchair" class="mb-0 kt-label">Wheelchair Accessible</label>
                                </div>
                            </div>
                        </div>

                        <!-- Activities -->
                        <div class="mb-4">
                            <label class="mb-2 kt-label">Available Activities</label>
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="photography" class="kt-checkbox" value="photography">
                                    <label for="photography" class="mb-0 kt-label">Photography</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="hiking" class="kt-checkbox" value="hiking">
                                    <label for="hiking" class="mb-0 kt-label">Hiking</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="swimming" class="kt-checkbox" value="swimming">
                                    <label for="swimming" class="mb-0 kt-label">Swimming</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="camping" class="kt-checkbox" value="camping">
                                    <label for="camping" class="mb-0 kt-label">Camping</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="shopping" class="kt-checkbox" value="shopping">
                                    <label for="shopping" class="mb-0 kt-label">Shopping</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="dining" class="kt-checkbox" value="dining">
                                    <label for="dining" class="mb-0 kt-label">Dining</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="entertainment" class="kt-checkbox" value="entertainment">
                                    <label for="entertainment" class="mb-0 kt-label">Entertainment</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" id="education" class="kt-checkbox" value="education">
                                    <label for="education" class="mb-0 kt-label">Educational Tours</label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="mb-2 kt-label">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="4" class="kt-input" placeholder="Enter any additional notes about the tourist site"></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="text-sm ki-filled ki-check me-2"></i>
                                Create Tourist Site
                            </button>
                            <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="text-sm ki-filled ki-plus me-2"></i>
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
                    <h3 class="kt-card-title">Tourist Site Tips</h3>
                </div>
                <div class="p-2 kt-card-body">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-full bg-success-light">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Detailed Information</div>
                                <div class="text-sm text-secondary-foreground">Provide comprehensive information to help tourists plan their visit</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-full bg-warning-light">
                                <i class="ki-filled ki-camera text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">High-Quality Photos</div>
                                <div class="text-sm text-secondary-foreground">Upload attractive photos that showcase the site's beauty</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-full bg-primary-light">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Visitor Experience</div>
                                <div class="text-sm text-secondary-foreground">Focus on creating memorable experiences for visitors</div>
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
                document.getElementById('site-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
