@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
        [
            'condition' => \App\Models\Country::count() > 0,
            'route' => route('countries.index'),
            'label' => __('main.countries_'),
        ],
    ]">

        <div class="mt-4">
            <a href="{{ route('export.data', ['model' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_Mode') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">city_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Fakhreddin</td>
                        <td class="border px-2">فخر الدين السياحية</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2">type</th>
                        <th class="border px-2">cat</th>
                        <th class="border px-2">company_name_ar</th>
                        <th class="border px-2">specialty</th>
                        <th class="border px-2">phone_01</th>
                        <th class="border px-2">fax</th>
                        <th class="border px-2">phone_02</th>
                        <th class="border px-2">contact_person</th>
                        <th class="border px-2">email_01</th>
                        <th class="border px-2">email_02</th>
                        <th class="border px-2">box</th>
                        <th class="border px-2">postal_code</th>
                        <th class="border px-2">street</th>
                        <th class="border px-2">mobile</th>
                        <th class="border px-2">website</th>
                        <th class="border px-2">note</th>
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
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
