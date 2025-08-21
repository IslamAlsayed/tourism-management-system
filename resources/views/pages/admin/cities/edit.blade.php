@extends('pages.admin.layouts.edit')

@php
    $title = 'Edit City';
    $subtitle = 'Update city information';
    $backUrl = route('admin.cities.index');
    $formAction = route('admin.cities.update', $city->id);
@endphp

@section('form-content')
    <div class="row mb-5">
        <div class="col-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ $city->name }}" class="form-control" required>
        </div>
        <div class="col-6">
            <label class="form-label">Country</label>
            <select name="country_id" class="form-select" required>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" @selected($city->country_id == $country->id)>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
