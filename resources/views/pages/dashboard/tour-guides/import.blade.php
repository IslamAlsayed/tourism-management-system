@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models">
        <div class="mt-4">
            <a href="{{ route('export.data', ['model' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (config('app.db_mode') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">email</th>
                        <th class="border px-2">national_guide_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">currency_id</th>
                        <th class="border px-2">guide_type</th>
                        <th class="border px-2">tourism_ministry_code</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">islam</td>
                        <td class="border px-2">اسلام</td>
                        <td class="border px-2">email@gmail.com</td>
                        <td class="border px-2">6786445</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">General</td>
                        <td class="border px-2">464</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">mobile_01</th>
                        <th class="border px-2">mobile_02</th>
                        <th class="border px-2">home_city</th>
                        <th class="border px-2">birth_year</th>
                        <th class="border px-2">gender</th>
                        <th class="border px-2">fd_day_fees</th>
                        <th class="border px-2">hd_day_fees</th>
                        <th class="border px-2">extra_fees_1</th>
                        <th class="border px-2">extra_fees_2</th>
                        <th class="border px-2">status</th>
                        <th class="border px-2">notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">+456786445</td>
                        <td class="border px-2">+784345844</td>
                        <td class="border px-2">Yamen</td>
                        <td class="border px-2">20-05-2025</td>
                        <td class="border px-2">male</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Lorem, ipsum dolor.</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
