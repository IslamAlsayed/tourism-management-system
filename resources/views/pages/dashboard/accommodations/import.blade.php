@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col">
            <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 p-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h1 class="text-xl font-semibold mb-6">{{ $title }}</h1>
                        <p class="mb-6">{{ $description }}</p>

                        <div id="import-section">
                            <div class="grid grid-cols-1">
                                <div class="inline-flex gap-4 mb-4">
                                    @foreach (['hotels', 'room_types'] as $item)
                                        <div class="custom-input">
                                            <input type="radio" name="accommodationOptions" class="mb-0 toggle-trigger" id="{{ $item }}" data-toggle-target="{{ $item }}" data-toggle-id="{{ $item }}" value="{{ $item }}">
                                            <label for="{{ $item }}">
                                                {{ $item }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="inline-flex gap-4 mb-4">
                                    @foreach (['types', 'accommodations', 'seasons', 'rates', 'rate_nationalities', 'facilities', 'supplements'] as $item)
                                        <div class="custom-input">
                                            <input type="radio" name="accommodationOptions" class="mb-0 toggle-trigger" id="{{ $item }}" data-toggle-target="{{ $item }}" data-toggle-id="{{ $item }}" value="{{ $item }}">
                                            <label for="{{ $item }}">
                                                {{ $item }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-red-600" id="import-error" style="display: none">Please select an option to enable the import functionality.</p>
                            </div>

                            <div>
                                <form action="{{ route("$model.import.post") }}" method="POST" enctype="multipart/form-data" class="w-half">
                                    @csrf
                                    <input type="hidden" name="import_type" id="import_type" value="" />

                                    <div class=" mb-4">
                                        <label for="file" class="inline-block text-gray-700 text-sm font-bold mb-2">
                                            {{ __('main.import_file') }}
                                            <strong>only (.csv,.xlsx,.xls)</strong>
                                        </label>

                                        <input type="file" name="file" id="file" accept=".csv,.xlsx,.xls" class="border rounded p-2 block w-full" onchange="document.getElementById('submit-button').disabled = !this.files.length" />

                                        @error('file')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <button type="submit" class="kt-btn kt-btn-primary" id="submit-button" disabled>
                                            {{ __('main.upload_and_import') }}
                                        </button>
                                        <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline ml-4">
                                            {{ __('main.cancel') }}
                                        </a>
                                    </div>
                                </form>

                                <div class="mt-4">
                                    <a href="{{ route('accommodations.export', 'types') }}" id="export-data" class="kt-btn kt-btn-outline">
                                        {{ __('main.export') }}
                                    </a>
                                </div>

                                <div data-hotels-target="hotels" class="target-trigger" style="display: none">
                                    <strong class="block mt-6 mb-2">Required Fields</strong>
                                    <table class="border min-w-half divide-y text-center divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">name</th>
                                                <th class="border px-2">name_ar</th>
                                                <th class="border px-2">country_id</th>
                                                <th class="border px-2">city_id</th>
                                                <th class="border px-2">region_id</th>
                                                <th class="border px-2">subregion_id</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">CAPTAIN’S MAIN CAMP</td>
                                                <td class="border px-2">CAPTAIN’S MAIN CAMP</td>
                                                <td class="border px-2">1</td>
                                                <td class="border px-2">1</td>
                                                <td class="border px-2">1</td>
                                                <td class="border px-2">1</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <strong class="block mt-6 mb-2">Optional Fields</strong>
                                    <table class="border min-w-half divide-y text-center divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">description</th>
                                                <th class="border px-2">created_by</th>
                                                <th class="border px-2">sales_man</th>
                                                <th class="border px-2">sales_phone</th>
                                                <th class="border px-2">sales_mail</th>
                                                <th class="border px-2">reservation_man</th>
                                                <th class="border px-2">reservation_phone</th>
                                                <th class="border px-2">reservation_mail</th>
                                                <th class="border px-2">accounting_person</th>
                                                <th class="border px-2">accounting_mail</th>
                                                <th class="border px-2">accounting_phone</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div data-room_types-target="room_types" class="target-trigger" style="display: none">
                                    <table class="border min-w-half divide-y text-center divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">name</th>
                                                <th class="border px-2">name_ar</th>
                                                <th class="border px-2">max_occupancy</th>
                                                <th class="border px-2">hotel_id</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">Single room</td>
                                                <td class="border px-2">غرفة مفردة</td>
                                                <td class="border px-2">1A</td>
                                                <td class="border px-2">1</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div data-types-target="types" class="target-trigger" style="display: none">
                                    <table class="border min-w-half divide-y text-center divide-gray-200 mt-6">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">name</th>
                                                <th class="border px-2">name_ar</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">Hotel</td>
                                                <td class="border px-2">فندق</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div data-accommodations-target="accommodations" class="target-trigger" style="display: none">
                                    <strong class="block mt-6 mb-2">Required Fields</strong>
                                    <table class="border min-w-full divide-y text-center divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">name</th>
                                                <th class="border px-2">name_ar</th>
                                                <th class="border px-2">stars</th>
                                                <th class="border px-2">type_id</th>
                                                <th class="border px-2">country_id</th>
                                                <th class="border px-2">city_id</th>
                                                <th class="border px-2">region_id</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">CAPTAIN’S MAIN CAMP</td>
                                                <td class="border px-2">مخيم الكابتن الرئيسي</td>
                                                <td class="border px-2">{{rand(1, 5)}}</td>
                                                <td class="border px-2">45</td>
                                                <td class="border px-2">15</td>
                                                <td class="border px-2">15</td>
                                                <td class="border px-2">15</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <strong class="block mt-6 mb-2">Optional Fields</strong>
                                    <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">trade_name</th>
                                                <th class="border px-2">classification</th>
                                                <th class="border px-2">cat</th>
                                                <th class="border px-2">general_mobile</th>
                                                <th class="border px-2">general_email</th>
                                                <th class="border px-2">email</th>
                                                <th class="border px-2">website</th>
                                                <th class="border px-2">phone</th>
                                                <th class="border px-2">phone_ext</th>
                                                <th class="border px-2">fax</th>
                                                <th class="border px-2">contact_person</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">{{fake()->phoneNumber()}}</td>
                                                <td class="border px-2">{{fake()->email()}}</td>
                                                <td class="border px-2">{{fake()->email()}}</td>
                                                <td class="border px-2">{{fake()->url()}}</td>
                                                <td class="border px-2">{{fake()->phoneNumber()}}</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">contact_mobile</th>
                                                <th class="border px-2">contact_email</th>
                                                <th class="border px-2">description</th>
                                                <th class="border px-2">contract_file_path</th>
                                                <th class="border px-2">is_active</th>
                                                <th class="border px-2">street</th>
                                                <th class="border px-2">box</th>
                                                <th class="border px-2">postal_code</th>
                                                <th class="border px-2">latitude</th>
                                                <th class="border px-2">longitude</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">33.000000</td>
                                                <td class="border px-2">65.000000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div data-seasons-target="seasons" class="target-trigger" style="display: none">
                                    <strong class="block mt-6 mb-2">Required Fields</strong>
                                    <table class="border min-w-half divide-y text-center divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">season_name</th>
                                                <th class="border px-2">season_from</th>
                                                <th class="border px-2">season_to</th>
                                                <th class="border px-2">accommodation_id</th>

                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">fake</td>
                                                <td class="border px-2">1/1/2025</td>
                                                <td class="border px-2">12/29/2025</td>
                                                <td class="border px-2">1</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <strong class="block mt-6 mb-2">Optional Fields</strong>
                                    <table class="border min-w-half divide-y text-center divide-gray-200 mb-4">
                                        <thead>
                                            <tr>
                                                <th class="border px-2">is_special</th>
                                                <th class="border px-2">special_type</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="border px-2">null</td>
                                                <td class="border px-2">null</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div data-rates-target="rates" class="target-trigger" style="display: none">
                                    rates
                                </div>

                                <div data-rate_nationalities-target="rate_nationalities" class="target-trigger" style="display: none">
                                    rate_nationalities
                                </div>

                                <div data-facilities-target="facilities" class="target-trigger" style="display: none">
                                    facilities
                                </div>

                                <div data-supplements-target="supplements" class="target-trigger" style="display: none">
                                    supplements
                                </div>
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
        const importType = document.getElementById('import_type');
        const exportType = document.getElementById('export-data');
        const importError = document.getElementById('import-error');

        document.querySelectorAll(".toggle-trigger").forEach((trigger) => {
            trigger.addEventListener("change", (event) => {
                const targetId = event.target.dataset.toggleTarget;
                importType.value = targetId;
                exportType.href = `/dashboard/accommodations/export/data/${targetId}`;
                updateFormState(true);
            });
        });

        document.addEventListener('click', function (event) {
            if (event.target.closest('#import-section')) {
                updateFormState(true);
            }
        });

        function updateFormState(showError = false) {
            const isEmpty = importType.value === '';
            importType.parentElement.classList.toggle('disabled', isEmpty);
            exportType.parentElement.classList.toggle('disabled', isEmpty);
            if (showError && importError) {
                importError.style.display = isEmpty ? 'block' : 'none';
            }
        }

        updateFormState();
    </script>
@endpush