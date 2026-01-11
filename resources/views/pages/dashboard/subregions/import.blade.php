@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
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
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            region_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2">wiki_data_id</th>
                        <th class="border px-2">is_active</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Middle East</td>
                        <td class="border px-2">الشرق الأوسط</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Q7204</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
