@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :view="$view">
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
                        <th class="border px-2">tour_guide_id</th>
                        <th class="border px-2">rating</th>
                        <th class="border px-2">review</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">464645</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">test review</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
