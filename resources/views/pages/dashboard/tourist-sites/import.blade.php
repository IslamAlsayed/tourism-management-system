@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
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

            {{-- Basic Information --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                                name <span class="text-red-600">*</span>
                            </th>
                            <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                            <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                                city_id <span class="text-red-600">*</span>
                            </th>
                            <th class="border px-2" title="{{ __('main.optional') }}">sort_order</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">latitude</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">longitude</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">Great Pyramid of Giza</td>
                            <td class="border px-2">الهرم الأكبر بالجيزة</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">29.9792</td>
                            <td class="border px-2">31.1342</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Location Information --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">site_type</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">supplier_type</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">sites_theme</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">supplier_name</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">unesco_site</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">historical</td>
                            <td class="border px-2">Government</td>
                            <td class="border px-2">Ancient History</td>
                            <td class="border px-2">Egyptian Heritage Foundation</td>
                            <td class="border px-2">1</td>
                            <td class="border px-2">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Main Description --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">description_01</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">
                                One of the Seven Wonders of the Ancient World, the Great Pyramid is an iconic symbol of
                                ancient Egyptian civilization.
                            </td>
                            <td class="border px-2">
                                Built during the reign of Pharaoh Khufu, it stands at 146.5 meters tall.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Additional Descriptions --}}
            <div class="overflow-x-auto">
                <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border px-2" title="{{ __('main.optional') }}">description_02</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">description_03</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-2">The structure was built with approximately 2.3 million limestone blocks.
                            </td>
                            <td class="border px-2">It remained the tallest man-made structure for over 3,800 years.</td>
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
                            <td class="border px-2">The Sphinx, Solar Boat Museum, Pyramid of Khafre, Pyramid of Menkaure
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
                            <th class="border px-2" title="{{ __('main.optional') }}">main_image</th>
                            <th class="border px-2" title="{{ __('main.optional') }}">gallery_images</th>
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
        @endif
    </x-import-form>
@endsection
