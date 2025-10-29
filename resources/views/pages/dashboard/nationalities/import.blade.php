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
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (config('app.db_mode') != 'production')
            <table class="border min-w-half divide-y text-center divide-gray-200 mt-6">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">is_active</th>
                        <th class="border px-2">country_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Egyptian</td>
                        <td class="border px-2">مصري</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">65</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
