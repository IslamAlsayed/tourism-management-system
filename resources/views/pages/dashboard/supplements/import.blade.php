@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\Accommodation::count() > 0,
                'route' => route('accommodations.index'),
                'label' => __('main.accommodations'),
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
                            model_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            model_type <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            price <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.required') }}">is_mandatory</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Breakfast Supplement</td>
                        <td class="border-custom px-2">إضافة إفطار</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">restaurant</td>
                        <td class="border-custom px-2">15.00</td>
                        <td class="border-custom px-2">1</td>
                    </tr>
                    <tr>
                        <td class="border-custom px-2">Late Checkout</td>
                        <td class="border-custom px-2">تسجيل خروج متأخر</td>
                        <td class="border-custom px-2">2</td>
                        <td class="border-custom px-2">accommodation</td>
                        <td class="border-custom px-2">30.00</td>
                        <td class="border-custom px-2">0</td>
                    </tr>
                    <tr>
                        <td class="border-custom px-2">Airport Transfer</td>
                        <td class="border-custom px-2">نقل من المطار</td>
                        <td class="border-custom px-2">3</td>
                        <td class="border-custom px-2">transportation-company</td>
                        <td class="border-custom px-2">50.00</td>
                        <td class="border-custom px-2">1</td>
                    </tr>
                </tbody>
            </table>
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">price_type</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">applicable_date</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">2025-01-01</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">Applies during holidays</td>
                        <td class="border-custom px-2">Includes coffee and juice</td>
                    </tr>
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">2025-02-15</td>
                        <td class="border-custom px-2">0</td>
                        <td class="border-custom px-2">Applies for late checkouts</td>
                        <td class="border-custom px-2">Until 4pm</td>
                    </tr>
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">2025-03-10</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">Applies for airport pickups</td>
                        <td class="border-custom px-2">One way only</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
