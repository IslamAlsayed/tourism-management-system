@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
        [
            'condition' => \App\Models\TransportationCompany::count() > 0,
            'route' => route('transportation-companies.index'),
            'label' => __('main.transportation_companies'),
        ],
    ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">min_seats</th>
                        <th class="border px-2">max_seats</th>
                        <th class="border px-2">seats</th>
                        <th class="border px-2">company_id</th>
                        <th class="border px-2">bus_type_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Sedans car</td>
                        <td class="border px-2">31</td>
                        <td class="border px-2">49</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
