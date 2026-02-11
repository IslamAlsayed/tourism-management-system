@extends('layouts.master')

@section('content')
    <x-import-form :title="__('main.import_travel-passes')" :description="__('main.import_travel-passes_desc')" models="travel-passes">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => 'travel-passes']) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        <div class="mt-6 mb-2">
            <strong class="block mb-2">{{ __('main.fields') }}</strong>

            <div class="table-responsive">
                <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead>
                        <tr>
                            <th class="border-custom px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                country_id <span class="text-red-600">*</span>
                            </th>
                            <th class="border-custom px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                currency_id <span class="text-red-600">*</span>
                            </th>
                            <th class="border-custom px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                name <span class="text-red-600">*</span>
                            </th>
                            <th class="border-custom px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                pass_type <span class="text-red-600">*</span>
                            </th>
                            <th class="border-custom px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                price <span class="text-red-600">*</span>
                            </th>
                            <th class="border-custom px-2 bg-yellow-200" title="{{ __('main.required') }}">
                                validity_days <span class="text-red-600">*</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="border-custom px-2">66</td>
                            <td class="border-custom px-2">2</td>
                            <td class="border-custom px-2">Jordan Pass - Wanderer</td>
                            <td class="border-custom px-2">wanderer</td>
                            <td class="border-custom px-2">70.00</td>
                            <td class="border-custom px-2">14</td>
                        </tr>
                    </tbody>
                </table>

                <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                    <thead>
                        <tr>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">name_ar</th>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">number_of_entries
                            </th>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">sites_ids</th>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">description</th>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">rules</th>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">is_active</th>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">is_featured</th>
                            <th class="border-custom px-2 bg-blue-100" title="{{ __('main.optional') }}">waives_visa_fee
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">التذكرة الموحدة - تجوال</td>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">1</td>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">1,5,10</td>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">Includes entry to Petra</td>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">Valid for 1 day in Petra</td>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">1</td>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">1</td>
                            <td class="border-custom px-2" title="{{ __('main.optional') }}">1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <div class="alert alert-info">
                    <i class="ki-filled ki-information-2 text-info me-2"></i>
                    <span><strong>pass_type values:</strong> wanderer, explorer, expert, basic, premium, custom</span>
                </div>
                <div class="alert alert-info mt-2">
                    <i class="ki-filled ki-information-2 text-info me-2"></i>
                    <span><strong>sites_ids:</strong> Comma separated IDs of tourist sites (e.g., "1,2,5")</span>
                </div>
            </div>
        </div>
    </x-import-form>
@endsection
