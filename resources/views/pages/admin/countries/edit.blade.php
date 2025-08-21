@extends('pages.admin.layouts.edit')

@php
    $title = 'Edit Country';
    $subtitle = 'Update country information';
    $backUrl = route('admin.countries.index');
    $formAction = route('admin.countries.update', $country->id);
@endphp

@section('form-content')
    <div class="row mb-5">
        <div class="col-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ $country->name }}" class="form-control" required>
        </div>
        <div class="col-6">
            <label class="form-label">Code</label>
            <input type="text" name="code" value="{{ $country->code }}" class="form-control" required maxlength="3">
        </div>
    </div>
@endsection
