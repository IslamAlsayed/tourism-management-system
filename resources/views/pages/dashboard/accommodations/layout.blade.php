@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col">
            <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 p-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h1 class="text-xl font-semibold mb-6">{{ $title }}</h1>
                        <p class="mb-6">{{ $description }}</p>

                        <div class="inline-flex gap-4">
                            @foreach (['types', 'seasons', 'rates', 'rate_nationalities', 'facilities', 'supplements'] as $item)
                                <div class="custom-input mb-4">
                                    <input type="radio" name="accommodationOptions" class="mb-0 toggle-trigger" id="{{ $item }}" data-toggle-target="{{ $item }}" data-toggle-id="{{ $item }}" value="{{ $item }}">
                                    <label for="{{ $item }}">
                                        {{ $item }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div data-types-target="types" class="target-trigger" style="display: none">
                            <form action="{{ route("$model.import.post") }}" method="POST" enctype="multipart/form-data" class="w-half">
                                @csrf
                                <input type="hidden" name="import_type" value="types" />

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
                                <a href="{{ route("$model.export", 'types') }}" class="kt-btn kt-btn-outline">
                                    {{ __('main.export') }}
                                </a>
                            </div>

                            <table class="border min-w-half divide-y text-center divide-gray-200 mt-6">
                                <thead>
                                    <tr>
                                        <th class="border px-2">name</th>
                                        <th class="border px-2">name_ar</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="border px-2">Hotel</td>
                                        <td class="border px-2">فندق</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div data-seasons-target="seasons" class="target-trigger" style="display: none">
                            seasons
                        </div>

                        <div data-rates-target="rates" class="target-trigger" style="display: none">
                            rates
                        </div>

                        <div data-rate_nationalities-target="rate_nationalities" class="target-trigger" style="display: none">
                            rate_nationalities
                        </div>

                        <div data-facilities-target="facilities" class="target-trigger" style="display: none">
                            facilities
                        </div>

                        <div data-supplements-target="supplements" class="target-trigger" style="display: none">
                            supplements
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection