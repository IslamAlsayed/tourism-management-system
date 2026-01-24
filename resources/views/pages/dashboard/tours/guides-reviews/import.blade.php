@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\TourGuide::count() > 0,
                'route' => route('tours.guides.create'),
                'label' => __('main.tours.guides'),
            ],
        ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            tour_guide_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            rating <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">review</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">46</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">Our tour guide was extremely knowledgeable and friendly</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
