@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\TouristSite::count() > 0,
                'route' => route('tourist-sites.index'),
                'label' => __('main.tourist_sites'),
            ],
            [
                'condition' => \App\Models\Currency::count() > 0,
                'route' => route('currencies.index'),
                'label' => __('main.currencies'),
            ],
        ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>

            <!-- Table 1: Basic Information -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            site_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            currency_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">include_unified_ticket</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">total_day_visit</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">sort_order</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">15</td>
                        <td class="border-custom px-2">130</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">3.00</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">52</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 2: Pricing - Foreigners -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-green-100">Foreigners</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_adult_foreigners</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_child_foreigners</th>
                        <th class="border-custom px-2 bg-green-100">Local</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_adult_local</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_child_local</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2 bg-green-50"></td>
                        <td class="border-custom px-2">26.00</td>
                        <td class="border-custom px-2">29.00</td>
                        <td class="border-custom px-2 bg-green-50"></td>
                        <td class="border-custom px-2">88.00</td>
                        <td class="border-custom px-2">17.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 3: Pricing - Arab & Residents -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-green-100">Arab</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_adult_arab</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_child_arab</th>
                        <th class="border-custom px-2 bg-green-100">Residents</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_adult_residents</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">per_child_residents</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2 bg-green-50"></td>
                        <td class="border-custom px-2">35.00</td>
                        <td class="border-custom px-2">38.00</td>
                        <td class="border-custom px-2 bg-green-50"></td>
                        <td class="border-custom px-2">98.00</td>
                        <td class="border-custom px-2">61.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 4: Non-accommodated Visitors -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">non_accommodated_visitors_adult
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">non_accommodated_visitors_child
                        </th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">3.00</td>
                        <td class="border-custom px-2">59.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 5: Operating Hours -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-purple-100">Summer</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">summer_opening_time</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">summer_closing_time</th>
                        <th class="border-custom px-2 bg-purple-100">Winter</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">winter_opening_time</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">winter_closing_time</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2 bg-purple-50"></td>
                        <td class="border-custom px-2">18:35</td>
                        <td class="border-custom px-2">01:37</td>
                        <td class="border-custom px-2 bg-purple-50"></td>
                        <td class="border-custom px-2">16:57</td>
                        <td class="border-custom px-2">15:34</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 6: Operating Days & Holidays (CSV Format) -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">operating_days (CSV)</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">day_off (CSV)</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">annual_holidays (CSV)</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2 text-left">saturday,sunday,monday,wednesday,thursday</td>
                        <td class="border-custom px-2 text-left">saturday,sunday,monday,wednesday,thursday,friday</td>
                        <td class="border-custom px-2 text-left">2014-08-04,2019-06-02,1982-12-02</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 7: Yearly Holidays (CSV) -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">yearly_holidays (CSV)</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2 text-left">Ramadan,Eid al-Fitr,Islamic New Year,Islamic New Year</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 8: Contact Information -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">person_name_01</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">person_name_02</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">phone</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">fax</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Forrest Mcclain</td>
                        <td class="border-custom px-2">Tasha Mcmillan</td>
                        <td class="border-custom px-2">+1 (269) 855-2522</td>
                        <td class="border-custom px-2">+1 (142) 483-7649</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 9: Contact - Mobile & Email -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">mobile_01</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">mobile_02</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">email_01</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">email_02</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">website</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">+1 (111) 839-4478</td>
                        <td class="border-custom px-2">+1 (594) 838-9575</td>
                        <td class="border-custom px-2">pahapupu@mailinator.com</td>
                        <td class="border-custom px-2">momo@mailinator.com</td>
                        <td class="border-custom px-2">https://www.jiro.net</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 10: Local Guide -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">local_guide_available</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">local_guide_fees_01</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">local_guide_fees_02</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">local_guide_fees_03</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">local_guide_fees_04</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">local_guide_fees_05</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">13.00</td>
                        <td class="border-custom px-2">85.00</td>
                        <td class="border-custom px-2">46.00</td>
                        <td class="border-custom px-2">58.00</td>
                        <td class="border-custom px-2">100.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 11: Payment & Club Cars -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">credit_cards</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_cars_available</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">1</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 12: Club Car Prices (01-04) -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_01</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_02</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_03</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_04</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">119.00</td>
                        <td class="border-custom px-2">446.00</td>
                        <td class="border-custom px-2">289.00</td>
                        <td class="border-custom px-2">950.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 13: Club Car Prices (05-08) -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_05</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_06</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_07</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">club_car_prices_08</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">705.00</td>
                        <td class="border-custom px-2">251.00</td>
                        <td class="border-custom px-2">76.00</td>
                        <td class="border-custom px-2">279.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 14: Additional Fields -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">ext1</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">ext2</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">ext3</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Sed soluta proident</td>
                        <td class="border-custom px-2">Quia non veniam quo</td>
                        <td class="border-custom px-2">Irure ea ut dolore p</td>
                    </tr>
                </tbody>
            </table>

            <!-- Table 15: Description & Notes -->
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Service description text here</td>
                        <td class="border-custom px-2">Additional notes here</td>
                    </tr>
                </tbody>
            </table>

            <div class="bg-blue-50 border border-blue-300 rounded p-4 mt-4">
                <p class="text-sm text-blue-800"><strong>ملاحظات مهمة:</strong></p>
                <ul class="text-sm text-blue-800 list-disc pl-5 mt-2">
                    <li>الحقول المحددة بـ <span class="text-red-600">*</span> إلزامية</li>
                    <li>يجب أن تكون قيم site_id و currency_id موجودة في النظام</li>
                    <li>الحقول التي تتضمن (CSV) يجب أن تكون مفصولة بفواصل: <code>item1,item2,item3</code></li>
                    <li>القيم المنطقية (boolean) يجب أن تكون: 1 (نعم) أو 0 (لا)</li>
                    <li>قيم الأسعار يجب أن تكون أرقام عشرية: <code>100.00</code></li>
                    <li>الأوقات بصيغة: <code>HH:MM</code></li>
                    <li>التواريخ بصيغة: <code>YYYY-MM-DD</code></li>
                </ul>
            </div>
        @endif
    </x-import-form>
@endsection
