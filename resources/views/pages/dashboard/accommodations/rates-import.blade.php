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
                    @if ($rate['models'] == 'roomRates')
                        <table class="border min-w-full divide-y text-center divide-gray-200 mb-3">
                            <thead class="bg-yellow-200">
                                <tr>
                                    <th class="border px-2">name</th>
                                    <th class="border px-2">accommodation_id</th>
                                    <th class="border px-2">season_id</th>
                                    <th class="border px-2">room_type_id</th>
                                    <th class="border px-2">currency_id</th>
                                    <th class="border px-2">price_per_person_double</th>
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
                            <thead class="bg-yellow-200">
                                <tr>
                                    <th class="border px-2">single_room_supplement</th>
                                    <th class="border px-2">triple_room_discount</th>
                                    <th class="border px-2">third_person_price</th>
                                    <th class="border px-2">extra_bed_price</th>
                                    <th class="border px-2">sea_view_supplement</th>
                                    <th class="border px-2">notes</th>
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
                    @elseif ($rate['models'] == 'mealRates')
                        <table class="border min-w-full divide-y text-center divide-gray-200">
                            <thead class="bg-yellow-200">
                                <tr>
                                    <th class="border px-2">name</th>
                                    <th class="border px-2">accommodation_id</th>
                                    <th class="border px-2">season_id</th>
                                    <th class="border px-2">meal_type_id</th>
                                    <th class="border px-2">price</th>
                                    <th class="border px-2">currency</th>
                                    <th class="border px-2">is_supplement</th>
                                    <th class="border px-2">notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border px-2">Hotel Example</td>
                                    <td class="border px-2">hotel</td>
                                    <td class="border px-2">5</td>
                                    <td class="border px-2">1</td>
                                    <td class="border px-2">50</td>
                                    <td class="border px-2">USD</td>
                                    <td class="border px-2">1</td>
                                    <td class="border px-2">Sample note</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @endif
            </x-import-form>
        </div>
    @endforeach
@endsection
