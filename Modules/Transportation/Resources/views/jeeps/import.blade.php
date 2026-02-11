@extends('layouts.master')

@section('content')
    <div class="kt-container-fixed">

        <!-- Hero Section -->
        <div class="bg-primary/5 border border-primary/10 rounded-xl p-8 mb-8 flex flex-col items-center text-center">
            <div class="size-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                <i class="fa-solid fa-truck-monster text-3xl text-primary"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ __('main.import_types', ['types' => __('main.jeeps')]) }}
            </h1>
            <p class="text-gray-600 max-w-2xl text-lg">
                Import Jeep Safari trips, routes, pricing, and vehicle details in bulk.
            </p>
        </div>

        <!-- Steps Indicator (Wizard Style) -->
        <div class="flex justify-between items-center mb-10 overflow-x-auto pb-4 gap-4">
            <!-- Step 1: Download -->
            <div class="flex items-center gap-3 min-w-[200px]">
                <div class="flex flex-col items-center">
                    <div class="size-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-md ring-4 ring-white relative z-10">
                        1</div>
                </div>
                <div class="flex-grow h-1 bg-primary/20 rounded-full w-20"></div>
                <div class="flex flex-col">
                    <span class="font-bold text-gray-900 text-sm">Download Template</span>
                    <span class="text-xs text-gray-500">Get the CSV structure</span>
                </div>
            </div>

            <!-- Step 2: Prepare -->
            <div class="flex items-center gap-3 min-w-[200px]">
                <div class="flex-grow h-1 bg-primary/20 rounded-full w-20"></div>
                <div class="flex flex-col items-center">
                    <div class="size-10 rounded-full bg-white border-2 border-primary text-primary flex items-center justify-center font-bold shadow-sm relative z-10">
                        2</div>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-gray-900 text-sm">Prepare Data</span>
                    <span class="text-xs text-gray-500">Fill in the columns</span>
                </div>
            </div>

            <!-- Step 3: Upload -->
            <div class="flex items-center gap-3 min-w-[200px]">
                <div class="flex-grow h-1 bg-primary/20 rounded-full w-20"></div>
                <div class="flex flex-col items-center">
                    <div class="size-10 rounded-full bg-white border-2 border-gray-300 text-gray-400 flex items-center justify-center font-bold shadow-sm relative z-10">
                        3</div>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-gray-900 text-sm">Upload & Import</span>
                    <span class="text-xs text-gray-500">Validate and save</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Upload Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sticky top-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ki-filled ki-file-up text-primary"></i> Upload File
                    </h3>

                    <form action="{{ route('import.data.post', ['models' => 'jeeps']) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select CSV/Excel File</label>
                            <input type="file" name="file" class="file-input w-full p-2 border border-gray-300 rounded-lg text-sm focus:border-primary focus:ring-primary" accept=".csv,.xlsx"
                                required>
                            <p class="text-xs text-gray-500 mt-2">Max size: 10MB</p>
                        </div>

                        <div class="space-y-3 mb-6">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 bg-gray-50 cursor-pointer hover:bg-white hover:border-gray-300 transition-all">
                                <input type="checkbox" name="has_header" value="1" class="rounded text-primary focus:ring-primary" checked>
                                <span class="text-sm font-medium text-gray-700">File has header row</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 bg-gray-50 cursor-pointer hover:bg-white hover:border-gray-300 transition-all">
                                <input type="checkbox" name="update_existing" value="1" class="rounded text-primary focus:ring-primary">
                                <span class="text-sm font-medium text-gray-700">Update existing records</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full btn btn-primary flex items-center justify-center gap-2 py-3">
                            <i class="ki-filled ki-check-circle"></i> Start Import Process
                        </button>

                        <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                            <a href="{{ route('export.data', ['models' => 'jeeps', 'type' => 'jeeps']) }}" class="text-sm text-primary font-medium hover:underline">Download Current Data (CSV)</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Columns Reference -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Group 1: Route Info -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="font-bold text-gray-900">1. Route & Trip Info</h4>
                        <span class="text-xs font-mono bg-blue-100 text-blue-700 px-2 py-1 rounded">Required</span>
                    </div>
                    <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <code class="text-primary font-medium">route</code> <span class="text-red-500">*</span>
                        <code class="text-primary font-medium">route_ar</code> <span class="text-red-500">*</span>
                        <code class="text-gray-600">duration</code>
                        <code class="text-gray-600">distance</code>
                        <code class="text-gray-600">description</code>
                    </div>
                </div>

                <!-- Group 2: Pricing & Vehicle -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="font-bold text-gray-900">2. Pricing & Vehicle Details</h4>
                    </div>
                    <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <code class="text-gray-600">price</code>
                        <code class="text-gray-600">currency_id</code>
                        <code class="text-gray-600">car_seats</code> (default: 4)
                        <code class="text-gray-600">vehicle_model</code>
                        <code class="text-gray-600">model_year</code>
                        <code class="text-gray-600">license_plate</code>
                    </div>
                </div>

                <!-- Group 3: Location -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="font-bold text-gray-900">3. Location (IDs)</h4>
                    </div>
                    <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <code class="text-gray-600">country_id</code>
                        <code class="text-gray-600">state_id</code>
                        <code class="text-gray-600">city_id</code>
                        <code class="text-gray-600">region_id</code>
                    </div>
                </div>

                <!-- Group 4: Features & Status -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="font-bold text-gray-900">4. Features (1=Yes, 0=No)</h4>
                    </div>
                    <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <code class="text-gray-600">has_ac</code>
                        <code class="text-gray-600">has_driver</code>
                        <code class="text-gray-600">is_4x4</code>
                        <code class="text-gray-600">has_camping_gear</code>
                        <code class="text-gray-600">status</code> (active/maintenance/retired)
                    </div>
                </div>

                <!-- Demo Table -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h4 class="font-bold text-gray-900">Example Data Row</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="kt-table table-auto text-sm whitespace-nowrap">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border-r">route</th>
                                    <th class="px-4 py-2 border-r">duration</th>
                                    <th class="px-4 py-2 border-r">price</th>
                                    <th class="px-4 py-2 border-r">currency_id</th>
                                    <th class="px-4 py-2 border-r">is_4x4</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                <tr>
                                    <td class="px-4 py-2 border-r">Sunset Safari</td>
                                    <td class="px-4 py-2 border-r">4 Hours</td>
                                    <td class="px-4 py-2 border-r">150.00</td>
                                    <td class="px-4 py-2 border-r">1</td>
                                    <td class="px-4 py-2 border-r">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
