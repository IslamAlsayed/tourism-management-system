@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col">
            <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 p-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h1 class="text-xl font-semibold mb-6">{{ $title }}</h1>
                        <p class="mb-6">{{ $description }}</p>

                        <form action="{{ route('countries.import.post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6">
                                <label for="file" class="block text-gray-700 text-sm font-bold mb-2">
                                    {{ __('main.import_file') }}
                                    <strong>only (.csv,.xlsx,.xls)</strong>
                                </label>

                                <input type="file" name="file" id="file" accept=".csv,.xlsx,.xls"
                                    class="border rounded p-2"
                                    onchange="document.getElementById('submit-button').disabled = !this.files.length" />

                                @error('file')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="kt-btn kt-btn-primary" id="submit-button" disabled>
                                    {{ __('main.upload_and_import') }}
                                </button>
                                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline ml-4">
                                    {{ __('main.cancel') }}
                                </a>
                            </div>
                        </form>

                        <div class="mt-4">
                            <a href="{{ route('countries.export') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.export') }}
                            </a>
                        </div>

                        <strong class="block mt-6 mb-2">Required Fields</strong>
                        <table class="border min-w-full divide-y text-center divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border">name</th>
                                    <th class="border">name_ar</th>
                                    <th class="border">iso2</th>
                                    <th class="border">iso3</th>
                                    <th class="border">timezone</th>
                                    <th class="border">currency_id</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border">Afghanistan</td>
                                    <td class="border">أفغانستان</td>
                                    <td class="border">AF</td>
                                    <td class="border">AFG</td>
                                    <td class="border">[{"tzName": "Afghanistan Time","zoneName": "Asia/Kabul","gmtOffset":
                                        16200,"abbreviation": "AFT","gmtOffsetName": "UTC+04:30"}]</td>
                                    <td class="border">1</td>
                                </tr>
                            </tbody>
                        </table>

                        <strong class="block mt-6 mb-2">Optional Fields</strong>
                        <table class="border min-w-full divide-y text-center divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border">numeric_code</th>
                                    <th class="border">phone_code</th>
                                    <th class="border">capital</th>
                                    <th class="border">tld</th>
                                    <th class="border">native</th>
                                    <th class="border">latitude</th>
                                    <th class="border">longitude</th>
                                    <th class="border">emoji</th>
                                    <th class="border">emojiU</th>
                                    <th class="border">population</th>
                                    <th class="border">flag_url</th>
                                    <th class="border">flag_emoji</th>
                                    <th class="border">continent</th>
                                    <th class="border">area</th>
                                    <th class="border">is_active</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border">4</td>
                                    <td class="border">93</td>
                                    <td class="border">Kabul</td>
                                    <td class="border">.af</td>
                                    <td class="border">افغانستان</td>
                                    <td class="border">33.000000</td>
                                    <td class="border">65.000000</td>
                                    <td class="border">🇦🇫</td>
                                    <td class="border">U+1F1E6 U+1F1EB</td>
                                    <td class="border">484641454</td>
                                    <td class="border">null</td>
                                    <td class="border">null</td>
                                    <td class="border">null</td>
                                    <td class="border">1</td>
                                    <td class="border">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
