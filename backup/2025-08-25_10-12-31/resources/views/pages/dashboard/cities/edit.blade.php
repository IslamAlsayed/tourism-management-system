@extends('pages.dashboard.layouts.edit')

@php
    $title = 'Edit City';
    $subtitle = 'Update city information';
    $backUrl = route('cities.index');
    $formAction = route('cities.update', $city->id);
@endphp

@section('form-content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="col-span-1 xl:col-span-3">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">City Name</label>
                <input type="text" name="name" value="{{ $city->name }}"
                    class="w-full px-4 py-2 border rounded focus:ring focus:border-blue-400" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Country</label>
                <select name="country_id" class="w-full px-4 py-2 border rounded focus:ring focus:border-blue-400" required>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @selected($country->id == $city->country_id)>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Update City
                </button>
            </div>
        </div>
    </div>
@endsection
