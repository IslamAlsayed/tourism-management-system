@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col">
            <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 p-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h1 class="text-xl font-semibold mb-6">{{ $title }}</h1>
                        <p class="mb-6">{{ $description }}</p>

                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                                role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @if (session('import_errors'))
                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6"
                                role="alert">
                                <span class="font-bold block mb-2">{{ __('main.import_errors') }}:</span>
                                <ul class="list-disc pl-5">
                                    @foreach (session('import_errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('currencies.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6">
                                <label for="file" class="block text-gray-700 text-sm font-bold mb-2">
                                    {{ __('main.import_file') }}
                                </label>

                                <input type="file" name="file" id="file" accept=".csv,.xlsx,.xls"
                                    class="border p-2" /> {{-- <input type="file" name="file" id="file" accept=".csv,.xlsx,.xls"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"> --}}
                                @error('file')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                                <h3 class="font-semibold mb-2">{{ __('main.required_columns') }}:</h3>
                                <ul class="list-disc pl-5">
                                    <li>code ({{ __('main.required') }})</li>
                                    <li>name ({{ __('main.required') }})</li>
                                    <li>symbol ({{ __('main.required') }})</li>
                                    <li>name_ar</li>
                                    <li>exchange_rate</li>
                                    <li>is_active</li>
                                    <li>... {{ __('main.other_optional_fields') }}</li>
                                </ul>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="kt-btn kt-btn-primary">
                                    {{ __('main.upload_and_import') }}
                                </button>
                                <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline ml-4">
                                    {{ __('main.cancel') }}
                                </a>
                            </div>
                        </form>

                        <div class="mt-8">
                            <h3 class="font-semibold mb-2">{{ __('main.sample_file') }}:</h3>
                            <p class="mb-4">{{ __('main.download_sample_file') }}</p>
                            <a href="{{ route('currencies.sample-import') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.download_sample') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
