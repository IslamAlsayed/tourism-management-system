@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\City::count() > 0,
                'route' => route('cities.create'),
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
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">code</th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            origin_city_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            destination_city_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">route_type</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">distance</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">estimated_duration</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Cairo to Alexandria</td>
                        <td class="border-custom px-2">القاهرة إلى الإسكندرية</td>
                        <td class="border-custom px-2">RT-00001</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">2</td>
                        <td class="border-custom px-2">one_way</td>
                        <td class="border-custom px-2">220.50</td>
                        <td class="border-custom px-2">180</td>
                    </tr>
                </tbody>
            </table>

            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">origin_address</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">origin_latitude</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">origin_longitude</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">destination_address</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">destination_latitude</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">destination_longitude</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Tahrir Square</td>
                        <td class="border-custom px-2">30.0444</td>
                        <td class="border-custom px-2">31.2357</td>
                        <td class="border-custom px-2">Corniche Road</td>
                        <td class="border-custom px-2">31.2001</td>
                        <td class="border-custom px-2">29.9187</td>
                    </tr>
                </tbody>
            </table>

            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_toll_road</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">toll_fee</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">road_condition</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">25.00</td>
                        <td class="border-custom px-2">excellent</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">Main highway route</td>
                        <td class="border-custom px-2">Highway route - Available 24/7</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
