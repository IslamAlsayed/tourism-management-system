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
            <table class="border-custom min-w-full divide-y text-center divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_included</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Chicken Salad</td>
                        <td class="border-custom px-2">سلطة دجاج</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">Fresh salad with grilled chicken</td>
                        <td class="border-custom px-2">Served with vinaigrette dressing</td>
                    </tr>
                    <tr>
                        <td class="border-custom px-2">Vegetable Soup</td>
                        <td class="border-custom px-2">شوربة خضار</td>
                        <td class="border-custom px-2">0</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">Soup made with seasonal vegetables</td>
                        <td class="border-custom px-2">Served hot</td>
                    </tr>
                    <tr>
                        <td class="border-custom px-2">Beef Steak</td>
                        <td class="border-custom px-2">شريحة لحم</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">0</td>
                        <td class="border-custom px-2">Grilled beef steak served with sauce</td>
                        <td class="border-custom px-2">Best served medium-rare</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
