@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\Currency::count() > 0,
                'route' => route('currencies.index'),
                'label' => __('main.currencies'),
            ],
            [
                'condition' => \App\Models\Region::count() > 0,
                'route' => route('regions.index'),
                'label' => __('main.regions'),
            ],
            [
                'condition' => \App\Models\Subregion::count() > 0,
                'route' => route('subregions.index'),
                'label' => __('main.subregions'),
            ],
            [
                'condition' => \App\Models\Country::count() > 0,
                'route' => route('countries.index'),
                'label' => __('main.countries'),
            ],
            [
                'condition' => \App\Models\State::count() > 0,
                'route' => route('states.index'),
                'label' => __('main.states'),
            ],
            [
                'condition' => \App\Models\City::count() > 0,
                'route' => route('cities.index'),
                'label' => __('main.cities'),
            ],
        ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>

            {{-- Location Info --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                                name <span class="text-red-600">*</span>
                            </th>
                            <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">code</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">currency_id</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">region_id</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">subregion_id</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">country_id</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">state_id</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">city_id</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Great Pyramid of Giza</td>
                            <td class="border px-2">الهرم الأكبر بالجيزة</td>
                            <td class="border px-2">PYR-GIZA</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Site Type & Features --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">latitude</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">longitude</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">site_type</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">category</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">translation</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">special_events</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">group_bookings</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">online_booking</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">mobile_app</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">virtual_tours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">29.9792</td>
                            <td class="border px-2">31.1342</td>
                            <td class="border px-2">historical</td>
                            <td class="border px-2">monument</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Facilities --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">has_parking</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">has_restaurant</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">has_gift_shop</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">has_restrooms</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">video_url</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">virtual_tour_url</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">https://youtube.com/v/xyz</td>
                            <td class="border px-2">https://virtualtour.com/pyramid</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Rating & Visit Info --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">rating</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">total_reviews</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">popularity_score</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">estimated_visit_duration</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">difficulty_level</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">age_restrictions</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">best_visit_time</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">tags</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">4.9</td>
                            <td class="border px-2">1000</td>
                            <td class="border px-2">99</td>
                            <td class="border px-2">120</td>
                            <td class="border px-2">medium</td>
                            <td class="border px-2">["18+"]</td>
                            <td class="border px-2">["Spring"]</td>
                            <td class="border px-2">["historical","pyramid"]</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Address Details --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">address</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">area</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">zone</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">district</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">neighborhood</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">block</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">building</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">floor</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">apartment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Giza, Egypt</td>
                            <td class="border px-2">Giza Area</td>
                            <td class="border px-2">Zone 1</td>
                            <td class="border px-2">District 1</td>
                            <td class="border px-2">Neighborhood 1</td>
                            <td class="border px-2">Block 1</td>
                            <td class="border px-2">Building 1</td>
                            <td class="border px-2">2</td>
                            <td class="border px-2">5</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Contact Info --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">landmark</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">directions</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">contact_person</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">whatsapp</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">telegram</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">snapchat</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">tiktok</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">youtube</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Near Sphinx</td>
                            <td class="border px-2">Follow the main road</td>
                            <td class="border px-2">Ahmed Ali</td>
                            <td class="border px-2">+201234567890</td>
                            <td class="border px-2">@giza_tour</td>
                            <td class="border px-2">giza_snap</td>
                            <td class="border px-2">giza_tiktok</td>
                            <td class="border px-2">giza_youtube</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Ticket Prices --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">ticket_type</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">ticket_price</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">ticket_price_children</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">ticket_price_students</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">ticket_price_seniors</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">ticket_price_groups</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Standard</td>
                            <td class="border px-2">200.00</td>
                            <td class="border px-2">100.00</td>
                            <td class="border px-2">150.00</td>
                            <td class="border px-2">80.00</td>
                            <td class="border px-2">1000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Opening Hours --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">ticket_options</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">discounts</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">special_offers</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">opening_hours</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">holiday_hours</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">closed_dates</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">event_schedules</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">["VIP","Family"]</td>
                            <td class="border px-2">["10% off"]</td>
                            <td class="border px-2">["Free guide"]</td>
                            <td class="border px-2">{"Sun-Thu":"08:00-17:00"}</td>
                            <td class="border px-2">{"Friday":"12:00-17:00"}</td>
                            <td class="border px-2">["2026-01-01"]</td>
                            <td class="border px-2">["Event1"]</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Services & Features --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">facilities</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">accessibility_features</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">safety_features</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">health_measures</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">covid_measures</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">["WiFi","Parking"]</td>
                            <td class="border px-2">["Wheelchair"]</td>
                            <td class="border px-2">["CCTV"]</td>
                            <td class="border px-2">["Sanitizer"]</td>
                            <td class="border px-2">["Masks"]</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Activities & Programs --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">services</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">activities</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">events</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">workshops</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">tours</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">programs</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">packages</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">["Guide"]</td>
                            <td class="border px-2">["Hiking"]</td>
                            <td class="border px-2">["Festival"]</td>
                            <td class="border px-2">["Workshop1"]</td>
                            <td class="border px-2">["Tour1"]</td>
                            <td class="border px-2">["Program1"]</td>
                            <td class="border px-2">["Package1"]</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Documents & Media Files --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">media_files</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">documents</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">links</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">brochures</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">menus</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">maps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">["media1.pdf"]</td>
                            <td class="border px-2">["doc1.pdf"]</td>
                            <td class="border px-2">["https://link.com"]</td>
                            <td class="border px-2">["brochure.pdf"]</td>
                            <td class="border px-2">["menu.pdf"]</td>
                            <td class="border px-2">["map.pdf"]</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- SEO & Meta --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">translations</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">custom_fields</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">extra</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">slug</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">meta_title</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">meta_description</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">meta_keywords</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">["ar","en"]</td>
                            <td class="border px-2">{"custom1":"value"}</td>
                            <td class="border px-2">{"extra1":"value"}</td>
                            <td class="border px-2">great-pyramid-giza</td>
                            <td class="border px-2">Great Pyramid</td>
                            <td class="border px-2">Visit the Great Pyramid</td>
                            <td class="border px-2">["pyramid","giza"]</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Import/Export Info --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">last_imported_at</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">last_exported_at</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">import_metadata</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">export_metadata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">2026-01-01</td>
                            <td class="border px-2">2026-01-02</td>
                            <td class="border px-2">{"source":"excel"}</td>
                            <td class="border px-2">{"format":"json"}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Description & Notes --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_featured</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_verified</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">created_by</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">updated_by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">Description sample</td>
                            <td class="border px-2">Notes sample</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </x-import-form>
@endsection
