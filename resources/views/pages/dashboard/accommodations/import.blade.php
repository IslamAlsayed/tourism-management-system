@extends('layouts.master')

@section('content')
    <x-advanced-import-form :title="$title" :description="$description" :models="$models" :cancelRoute="route('accommodations.index')" :hasOptions="true"
        optionName="accommodationOptions" :options="[
            'types',
            'accommodations',
            'seasons',
            'supplements',
            'rates',
            'rate_details',
            'rate_nationalities',
            'hotels',
            'room_types',
        ]" :disabledOptions="['rate_nationalities', 'room_types']" :additionalInputs="[['name' => 'importType', 'id' => 'importType', 'value' => '']]" customExportId="exportData">

        @if (env('DB_Mode') != 'production')
            {{-- Target columns tables --}}
            <div>
                <div data-hotels-target="hotels" class="target-trigger mt-4" style="display: none">
                    <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
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

                    <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
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

                <div data-room_types-target="room_types" class="target-trigger mt-4" style="display: none">
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

                <div data-types-target="types" class="target-trigger mt-4" style="display: none">
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

                <div data-accommodations-target="accommodations" class="target-trigger mt-4" style="display: none">
                    <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
                    <table class="border min-w-half divide-y text-center divide-gray-200">
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
                                <td class="border px-2">{{ rand(1, 5) }}</td>
                                <td class="border px-2">45</td>
                                <td class="border px-2">15</td>
                                <td class="border px-2">15</td>
                                <td class="border px-2">15</td>
                            </tr>
                        </tbody>
                    </table>

                    <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
                    <table class="border min-w-half divide-y text-center divide-gray-200 mb-4">
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

                    <table class="border min-w-half divide-y text-center divide-gray-200 mb-4">
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

                <div data-seasons-target="seasons" class="target-trigger mt-4" style="display: none">
                    <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
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

                    <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
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

                <div data-supplements-target="supplements" class="target-trigger mt-4" style="display: none">
                    <table class="border min-w-half divide-y text-center divide-gray-200">
                        <thead>
                            <tr>
                                <th class="border px-2">name</th>
                                <th class="border px-2">price</th>
                                <th class="border px-2">accommodation_id</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="border px-2">New Year Gala Dinner</td>
                                <td class="border px-2">50</td>
                                <td class="border px-2">1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div data-rates-target="rates" class="target-trigger mt-4" style="display: none">
                    <table class="border min-w-half divide-y text-center divide-gray-200">
                        <thead>
                            <tr>
                                <th class="border px-2">price</th>
                                <th class="border px-2">currency_id</th>
                                <th class="border px-2">accommodation_id</th>
                                <th class="border px-2">season_id</th>
                                <th class="border px-2">room_type_id</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="border px-2">50.00</td>
                                <td class="border px-2">1</td>
                                <td class="border px-2">1</td>
                                <td class="border px-2">1</td>
                                <td class="border px-2">1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div data-rate_details-target="rate_details" class="target-trigger mt-4" style="display: none">
                    <table class="border min-w-half divide-y text-center divide-gray-200">
                        <thead>
                            <tr>
                                <th class="border px-2">rate_id</th>
                                <th class="border px-2">room_type_id</th>
                                <th class="border px-2">price</th>
                                <th class="border px-2">price_type</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="border px-2">1</td>
                                <td class="border px-2">null</td>
                                <td class="border px-2">50.00</td>
                                <td class="border px-2">double_room</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div data-rate_nationalities-target="rate_nationalities" class="target-trigger mt-4"
                    style="display: none">
                    rate_nationalities
                </div>

                <div data-facilities-target="facilities" class="target-trigger mt-4" style="display: none">
                    facilities
                </div>
            </div>
        @endif
    </x-advanced-import-form>
@endsection

@push('scripts')
    <script>
        // Additional JavaScript for accommodations-specific functionality
        document.addEventListener('DOMContentLoaded', function() {
            const importForm = document.getElementById('importForm');
            const importType = document.getElementById('importType');
            const exportType = document.getElementById('exportData');
            const importError = document.getElementById('importError');

            // Override the default behavior for accommodations
            document.querySelectorAll(".toggle-trigger").forEach((trigger) => {
                trigger.addEventListener("change", (event) => {
                    const targetId = event.target.dataset.toggleTarget;
                    const model = exportType.dataset.model;
                    importType.value = targetId;
                    exportType.href = `export/${model}/data/${targetId}`;
                    importForm.action = `import/${model}/data/${targetId}`;
                    updateFormState(true);
                });
            });

            document.addEventListener('click', function(event) {
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
        });
    </script>
@endpush
