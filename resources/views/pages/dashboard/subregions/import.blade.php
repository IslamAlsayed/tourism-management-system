@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :view="$view" :requirements="[
        [
            'condition' => \App\Models\Region::count() > 0,
            'route' => route('regions.create'),
            'label' => __('main.regions_'),
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
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">region_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">region</td>
                        <td class="border px-2">منطقة</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">wiki_data_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Q155</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
