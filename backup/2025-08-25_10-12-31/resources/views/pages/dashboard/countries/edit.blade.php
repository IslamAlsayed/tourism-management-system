@extends('pages.dashboard.layouts.edit')

@php
    $title = 'Edit Country';
    $subtitle = 'Update country information';
    $backUrl = route('countries.index');
    $formAction = route('countries.update', $country->id);
@endphp


@section('form-content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="col-span-1 xl:col-span-3">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ $country->name }}"
                    class="w-full px-4 py-2 border rounded focus:ring focus:border-blue-400" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Code</label>
                <input type="text" name="code" value="{{ $country->code }}"
                    class="w-full px-4 py-2 border rounded focus:ring focus:border-blue-400" required maxlength="3">
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Update Country
                </button>
            </div>
        </div>
    </div>
@endsection
