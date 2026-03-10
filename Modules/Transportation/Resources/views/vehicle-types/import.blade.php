@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \Modules\Transportation\Entities\Company::count() > 0,
                'route' => route('dashboard.transportation.companies.create'),
                'label' => __('main.transportations-companies'),
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
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            company_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">min_capacity</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">max_capacity</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Microbus</td>
                        <td class="border-custom px-2">ميكروباص</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">10</td>
                        <td class="border-custom px-2">15</td>
                </tbody>
            </table>

            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">has_luggage</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_air_conditioning</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">A comfortable microbus for city tours.</td>
                        <td class="border-custom px-2">Includes Wi-Fi and refreshments.</td </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
