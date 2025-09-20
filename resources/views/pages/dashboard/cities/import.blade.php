@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col">
            <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 p-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h1 class="text-xl font-semibold mb-6">{{ $title }}</h1>
                        <p class="mb-6">{{ $description }}</p>

                        <form action="{{ route("$model.import.post") }}" method="POST" enctype="multipart/form-data" class="w-half">
                            @csrf
                            <div class="mb-4">
                                <label for="file" class="inline-block text-gray-700 text-sm font-bold mb-2">
                                    {{ __('main.import_file') }}
                                    <strong>only (.csv,.xlsx,.xls)</strong>
                                </label>

                                <input type="file" name="file" id="file" accept=".csv,.xlsx,.xls" class="border rounded p-2 block w-full" onchange="document.getElementById('submit-button').disabled = !this.files.length" />

                                @error('file')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            @if (\App\Models\Country::count() == 0 || \App\Models\State::count() == 0)
                                <div class="kt-alert bg-danger text-white flex items-center mb-4">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ __('main.you_must_add') }}
                                    @if (\App\Models\Country::count() == 0)
                                        <a href="{{ route('countries.index') }}" class="text-primary underline">
                                            {{ __('main.countries_') }}
                                        </a>
                                    @endif
                                    @if (\App\Models\State::count() == 0)
                                        {{ __('main.and') }}
                                        <a href="{{ route('states.index') }}" class="text-primary underline">
                                            {{ __('main.states_') }}
                                        </a>
                                    @endif
                                    {{ __('main.first') }}.
                                </div>
                            @endif

                            <div class="flex items-center gap-4">
                                <button type="submit" class="kt-btn kt-btn-primary" id="submit-button" disabled>
                                    {{ __('main.upload_and_import') }}
                                </button>
                                <a href="{{ route("$model.index") }}" class="kt-btn kt-btn-outline ml-4">
                                    {{ __('main.cancel') }}
                                </a>
                            </div>
                        </form>

                        <div class="mt-4">
                            <a href="{{ route("$model.export") }}" class="kt-btn kt-btn-outline">
                                {{ __('main.export') }}
                            </a>
                        </div>

                        <strong class="block mt-6 mb-2">Required Fields</strong>
                        <table class="border min-w-half divide-y text-center divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border px-2">name</th>
                                    <th class="border px-2">name_ar</th>
                                    <th class="border px-2">state_id</th>
                                    <th class="border px-2">country_id</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border px-2">Andorra la Vella</td>
                                    <td class="border px-2">أندورا</td>
                                    <td class="border px-2">488</td>
                                    <td class="border px-2">6</td>
                                </tr>
                            </tbody>
                        </table>

                        <strong class="block mt-6 mb-2">Optional Fields</strong>
                        <table class="border min-w-full divide-y text-center divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border px-2">latitude</th>
                                    <th class="border px-2">longitude</th>
                                    <th class="border px-2">wikiDataId</th>
                                    <th class="border px-2">population</th>
                                    <th class="border px-2">timezone</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="border px-2">42.50779</td>
                                    <td class="border px-2">1.52109</td>
                                    <td class="border px-2">Q1863</td>
                                    <td class="border px-2">468416843</td>
                                    <td class="border px-2">
                                        [{"tzName": "Afghanistan Time","zoneName":"Asia/Kabul",...}]
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection