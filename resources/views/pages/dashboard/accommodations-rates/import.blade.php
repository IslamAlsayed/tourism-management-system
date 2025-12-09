@extends('layouts.master')

@section('content')
    @foreach ($rates as $key => $rate)
        <div class="mb-6">
            <x-import-form :title="$rate['title']" :description="$rate['description']" :models="$rate['model']">
                <div class="mt-4">
                    <a href="{{ route('export.data', ['models' => $rate['model']]) }}" class="kt-btn kt-btn-outline">
                        {{ __('main.export') }}
                    </a>
                </div>

                @if (env('DB_MODE') != 'production')
                    <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
                    @if ($rate['models'] == 'AccommodationRoomRate')
                        <table class="border min-w-full divide-y text-center divide-gray-200 mb-3">
                            <thead>
                                <tr>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        name <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        accommodation_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        season_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        room_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        currency_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">
                                        price_per_person_double
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border px-2">Hotel Example</td>
                                    <td class="border px-2">hotel</td>
                                    <td class="border px-2">5</td>
                                    <td class="border px-2">1</td>
                                    <td class="border px-2">2</td>
                                    <td class="border px-2">100</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="border min-w-full divide-y text-center divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border px-2" title="{{ __('main.optional') }}">single_room_supplement</th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">triple_room_discount</th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">third_person_price</th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">extra_bed_price</th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">sea_view_supplement</th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border px-2">20</td>
                                    <td class="border px-2">-10</td>
                                    <td class="border px-2">80</td>
                                    <td class="border px-2">30</td>
                                    <td class="border px-2">15</td>
                                    <td class="border px-2">Sample note</td>
                                </tr>
                            </tbody>
                        </table>
                    @elseif ($rate['models'] == 'AccommodationMealRate')
                        <table class="border min-w-full divide-y text-center divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        name <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        accommodation_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        season_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        meal_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        currency_id <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                        price <span class="text-red-600">*</span>
                                    </th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">is_supplement</th>
                                    <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border px-2">Hotel Example</td>
                                    <td class="border px-2">hotel</td>
                                    <td class="border px-2">5</td>
                                    <td class="border px-2">1</td>
                                    <td class="border px-2">1</td>
                                    <td class="border px-2">50</td>
                                    <td class="border px-2">1</td>
                                    <td class="border px-2">Sample note</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @endif

                @slot('customLogic')
                    <input type="hidden" name="model" value="{{ $rate['models'] }}">
                @endslot
            </x-import-form>
        </div>
    @endforeach
@endsection
