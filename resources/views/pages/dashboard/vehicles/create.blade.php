@extends('layouts.master')

@section('title', 'Create New Vehicle')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Create New Vehicle
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Add a new vehicle to the system
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="#" class="kt-btn kt-btn-outline">
                    Back to Vehicles
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Vehicle Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4">
                        <!-- Vehicle Photo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div
                                    class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="vehicle-preview" src="{{ asset('metronic/media/avatars/300-5.png') }}"
                                        alt="Vehicle Image" class="w-full h-full object-cover">
                                </div>
                                <label for="photo"
                                    class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">Upload vehicle photo</div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Vehicle Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">Vehicle Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input" required>
                            </div>

                            <!-- Vehicle Name Arabic -->
                            <div class="mb-4">
                                <label for="name_ar" class="kt-label required mb-2">Vehicle Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input" required>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Vehicle Type -->
                            <div class="mb-4">
                                <label for="type" class="kt-label required mb-2">Vehicle Type</label>
                                <select name="type" id="type" class="kt-select" required>
                                    <option value="">--</option>
                                    <option value="Tourist Bus">Tourist Bus</option>
                                    <option value="Transport Vehicle">Transport Vehicle</option>
                                    <option value="4x4 Vehicle">4x4 Vehicle</option>
                                    <option value="Luxury Car">Luxury Car</option>
                                    <option value="Minibus">Minibus</option>
                                    <option value="Van">Van</option>
                                    <option value="Pickup Truck">Pickup Truck</option>
                                    <option value="Motorcycle">Motorcycle</option>
                                </select>
                            </div>

                            <!-- Company -->
                            <div class="mb-4">
                                <label for="company" class="kt-label required mb-2">Company</label>
                                <select name="company" id="company" class="kt-select" required>
                                    <option value="">--</option>
                                    <option value="SAPTCO">SAPTCO</option>
                                    <option value="Desert Safari Tours">Desert Safari Tours</option>
                                    <option value="City Transport">City Transport</option>
                                    <option value="Luxury Tours">Luxury Tours</option>
                                    <option value="Adventure Tours">Adventure Tours</option>
                                    <option value="Premium Transport">Premium Transport</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Make -->
                            <div class="mb-4">
                                <label for="make" class="kt-label required mb-2">Make</label>
                                <input type="text" name="make" id="make" class="kt-input" required>
                            </div>

                            <!-- Model -->
                            <div class="mb-4">
                                <label for="model" class="kt-label required mb-2">Model</label>
                                <input type="text" name="model" id="model" class="kt-input" required>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Year -->
                            <div class="mb-4">
                                <label for="year" class="kt-label required mb-2">Year</label>
                                <input type="number" name="year" id="year" class="kt-input" required min="1990"
                                    max="2025">
                            </div>

                            <!-- Capacity -->
                            <div class="mb-4">
                                <label for="capacity" class="kt-label required mb-2">Seating Capacity</label>
                                <input type="number" name="capacity" id="capacity" class="kt-input" required
                                    min="1" max="100">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Plate Number -->
                            <div class="mb-4">
                                <label for="plate_number" class="kt-label required mb-2">Plate Number</label>
                                <input type="text" name="plate_number" id="plate_number" class="kt-input" required>
                            </div>

                            <!-- VIN -->
                            <div class="mb-4">
                                <label for="vin" class="kt-label mb-2">VIN Number</label>
                                <input type="text" name="vin" id="vin" class="kt-input">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Color -->
                            <div class="mb-4">
                                <label for="color" class="kt-label mb-2">Color</label>
                                <input type="text" name="color" id="color" class="kt-input">
                            </div>

                            <!-- Fuel Type -->
                            <div class="mb-4">
                                <label for="fuel_type" class="kt-label mb-2">Fuel Type</label>
                                <select name="fuel_type" id="fuel_type" class="kt-select">
                                    <option value="">--</option>
                                    <option value="Gasoline">Gasoline</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Hybrid">Hybrid</option>
                                    <option value="Electric">Electric</option>
                                    <option value="LPG">LPG</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Driver -->
                            <div class="mb-4">
                                <label for="driver" class="kt-label mb-2">Assigned Driver</label>
                                <input type="text" name="driver" id="driver" class="kt-input">
                            </div>

                            <!-- Location -->
                            <div class="mb-4">
                                <label for="location" class="kt-label required mb-2">Current Location</label>
                                <input type="text" name="location" id="location" class="kt-input" required>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Purchase Date -->
                            <div class="mb-4">
                                <label for="purchase_date" class="kt-label mb-2">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" class="kt-input">
                            </div>

                            <!-- Last Service Date -->
                            <div class="mb-4">
                                <label for="last_service_date" class="kt-label mb-2">Last Service Date</label>
                                <input type="date" name="last_service_date" id="last_service_date" class="kt-input">
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Insurance Expiry -->
                            <div class="mb-4">
                                <label for="insurance_expiry" class="kt-label mb-2">Insurance Expiry Date</label>
                                <input type="date" name="insurance_expiry" id="insurance_expiry" class="kt-input">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="kt-label required mb-2">Status</label>
                                <select name="status" id="status" class="kt-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Under Maintenance</option>
                                    <option value="repair">Under Repair</option>
                                    <option value="retired">Retired</option>
                                </select>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">Vehicle Features</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="air_conditioning" class="kt-checkbox"
                                        value="air_conditioning">
                                    <label for="air_conditioning" class="kt-label mb-0">Air Conditioning</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="wifi" class="kt-checkbox"
                                        value="wifi">
                                    <label for="wifi" class="kt-label mb-0">WiFi</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="entertainment" class="kt-checkbox"
                                        value="entertainment">
                                    <label for="entertainment" class="kt-label mb-0">Entertainment System</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="usb_ports" class="kt-checkbox"
                                        value="usb_ports">
                                    <label for="usb_ports" class="kt-label mb-0">USB Ports</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="gps" class="kt-checkbox"
                                        value="gps">
                                    <label for="gps" class="kt-label mb-0">GPS Navigation</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="camera" class="kt-checkbox"
                                        value="camera">
                                    <label for="camera" class="kt-label mb-0">Backup Camera</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="safety" class="kt-checkbox"
                                        value="safety">
                                    <label for="safety" class="kt-label mb-0">Safety Equipment</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="features[]" id="wheelchair" class="kt-checkbox"
                                        value="wheelchair">
                                    <label for="wheelchair" class="kt-label mb-0">Wheelchair Accessible</label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="kt-label mb-2">Notes</label>
                            <input id="notes" type="hidden" name="notes" value="{{ old('notes') }}">
                            <trix-editor input="notes"></trix-editor>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Create Vehicle
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
                    <h3 class="kt-card-title">Vehicle Management Tips</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Complete Documentation</div>
                                <div class="text-sm text-secondary-foreground">Keep all vehicle documents, insurance, and
                                    maintenance records up to date</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-shield-tick text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Regular Maintenance</div>
                                <div class="text-sm text-secondary-foreground">Schedule regular maintenance to ensure
                                    vehicle safety and reliability</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Driver Assignment</div>
                                <div class="text-sm text-secondary-foreground">Assign qualified drivers and track their
                                    performance</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
