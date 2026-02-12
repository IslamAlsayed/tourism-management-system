@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \Modules\Geography\Entities\City::count() > 0,
            'route' => route('dashboard.geography.cities.create'),
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

            {{-- Basic Information --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                                name <span class="text-red-600">*</span>
                            </th>
                            <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">code</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">site_type</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">category</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">sort_order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Great Pyramid of Giza</td>
                            <td class="border px-2">الهرم الأكبر بالجيزة</td>
                            <td class="border px-2">TS-00001</td>
                            <td class="border px-2">historical</td>
                            <td class="border px-2">Ancient Monument</td>
                            <td class="border px-2">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Location Information --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">currency_id</th>
                            <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                                city_id <span class="text-red-600">*</span>
                            </th>
                            <th class="border px-2" title="{{ __('main.optional') }}">address</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">postal_code</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">latitude</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">longitude</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">Giza Plateau, Cairo</td>
                            <td class="border px-2">12000</td>
                            <td class="border px-2">29.9792</td>
                            <td class="border px-2">31.1342</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Contact Information --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">contact_person</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">phone</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">mobile</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">email</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">website_url</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">facebook_url</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">instagram_url</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Ahmed Hassan</td>
                            <td class="border px-2">+20234512345</td>
                            <td class="border px-2">+201012345678</td>
                            <td class="border px-2">info@giza.com</td>
                            <td class="border px-2">https://giza.com</td>
                            <td class="border px-2">https://facebook.com/giza</td>
                            <td class="border px-2">https://instagram.com/giza</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Social Media (Continued) & Fax --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">twitter_url</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">fax</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">supplier_type</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">supplier_name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">https://twitter.com/giza</td>
                            <td class="border px-2">+20234512346</td>
                            <td class="border px-2">Government</td>
                            <td class="border px-2">Egyptian Heritage Foundation</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Entry Fees (Part 1) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_free_entry</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_adult</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_child</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_student</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_senior</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_group</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">0</td>
                            <td class="border px-2">400.00</td>
                            <td class="border px-2">200.00</td>
                            <td class="border px-2">150.00</td>
                            <td class="border px-2">100.00</td>
                            <td class="border px-2">3000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Entry Fees (Part 2) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_foreigner_adult</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_foreigner_child</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_arab_adult</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_arab_child</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">600.00</td>
                            <td class="border px-2">300.00</td>
                            <td class="border px-2">300.00</td>
                            <td class="border px-2">150.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Entry Fees (Part 3) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_local_adult</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_local_child</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_resident_adult</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entry_fee_resident_child</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_24_7</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">opening_time</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">closing_time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">200.00</td>
                            <td class="border px-2">100.00</td>
                            <td class="border px-2">100.00</td>
                            <td class="border px-2">50.00</td>
                            <td class="border px-2">0</td>
                            <td class="border px-2">08:00</td>
                            <td class="border px-2">17:00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Operating Days & Special Hours --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">operating_days</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">special_hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2 text-start">
                                <pre>["saturday","sunday","monday","tuesday","wednesday","thursday","friday"]</pre>
                            </td>
                            <td class="border px-2 text-start">
                                <pre>{"friday":{"opening":"09:00","closing":"18:00"}}</pre>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Facilities & Services (Part 1) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">wheelchair_accessible</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">free_wifi</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">parking</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">restrooms</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">restaurants</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">gift_shop</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">guided_tours</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">audio_guide</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
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

            {{-- Facilities & Services (Part 3) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">photography</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">hiking</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">swimming</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">camping</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">shopping</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">dining</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">entertainment</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">educational_tours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">1</td>
                            <td class="border px-2">0</td>
                            <td class="border px-2">0</td>
                            <td class="border px-2">0</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">0</td>
                            <td class="border px-2">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Facilities & Services (Part 5) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
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
                            <td class="border px-2">1</td>
                            <td class="border px-2">0</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Additional Pricing & Media --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">local_guide_price</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">club_car_price</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">video_url</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">virtual_tour_url</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">500.00</td>
                            <td class="border px-2">1000.00</td>
                            <td class="border px-2">https://youtube.com/watch?v=xyz</td>
                            <td class="border px-2">https://virtual-tour.com/pyramid</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Visitor Information (Part 1) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">average_rating</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">total_reviews</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">popularity_score</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">estimated_visit_duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">4.85</td>
                            <td class="border px-2">1250</td>
                            <td class="border px-2">95</td>
                            <td class="border px-2">180</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Visitor Information (Part 2) --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">difficulty_level</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">age_restrictions</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">best_visit_time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">easy</td>
                            <td class="border px-2 text-start">
                                <pre>{"min_age":5,"max_age":80}</pre>
                            </td>
                            <td class="border px-2 text-start">
                                <pre>{"months":["october","november","december","january","february","march"]}</pre>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Status & Metadata --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">status</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_featured</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_verified</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">unesco_site</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">has_unified_ticket</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">tags</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">active</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">0</td>
                            <td class="border px-2 text-start">
                                <pre>["ancient","monuments","historical","iconic"]</pre>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Media Files --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">photo</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">gallery</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">https://example.com/pyramid-main.jpg</td>
                            <td class="border px-2 text-start">
                                <pre>
                                    [
                                    "https://example.com/pyramid-1.jpg",
                                    "https://example.com/pyramid-2.jpg",
                                    "https://example.com/pyramid-3.jpg"
                                    ]</pre>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Nearby Attractions --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">nearby_attractions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">The Sphinx, Solar Boat Museum, Pyramid of Khafre, Pyramid of Menkaure</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Description --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">One of the Seven Wonders of the Ancient World, the Great Pyramid is an iconic symbol of ancient Egyptian
                                civilization.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Notes --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Built during the reign of Pharaoh Khufu, it stands at 146.5 meters tall and was built with approximately 2.3
                                million limestone blocks.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </x-import-form>
@endsection
