@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (config('app.db_mode') != 'production')
            <table class="border min-w-full divide-y text-center text-sm divide-gray-200 mt-6">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            offset (seconds) <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">abbreviation</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">abbreviation_dst</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">country_code</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">gmt_offset_name</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">sort_order</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">supports_dst</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Africa/Cairo</td>
                        <td class="border px-2">7200</td>
                        <td class="border px-2">EET</td>
                        <td class="border px-2">EEST</td>
                        <td class="border px-2">EG</td>
                        <td class="border px-2">UTC+02:00</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Eastern European Time zone</td>
                    </tr>
                    <tr>
                        <td class="border px-2">America/New_York</td>
                        <td class="border px-2">-18000</td>
                        <td class="border px-2">EST</td>
                        <td class="border px-2">EDT</td>
                        <td class="border px-2">US</td>
                        <td class="border px-2">UTC-05:00</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Eastern US time zone</td>
                    </tr>
                    <tr>
                        <td class="border px-2">Europe/London</td>
                        <td class="border px-2">0</td>
                        <td class="border px-2">GMT</td>
                        <td class="border px-2">BST</td>
                        <td class="border px-2">GB</td>
                        <td class="border px-2">UTC+00:00</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">United Kingdom time zone</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
