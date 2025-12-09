@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models">
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
                        <th class="border px-2">accommodation_id</th>
                        <th class="border px-2">season_id</th>
                        <th class="border px-2">notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Special rates for summer season</td>
                    </tr>
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">Winter season discounts</td>
                    </tr>
                    <tr>
                        <td class="border px-2">2</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2"></td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                <p class="font-semibold text-blue-800 mb-2">{{ __('main.notes') }}:</p>
                <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                    <li><strong>accommodation_id</strong>: {{ __('main.accommodation_id_must_exist') }}</li>
                    <li><strong>season_id</strong>: {{ __('main.season_id_must_exist') }}</li>
                    <li><strong>notes</strong>: {{ __('main.optional_field') }}</li>
                </ul>
            </div>
        @endif
    </x-import-form>
@endsection
