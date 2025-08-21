@extends('pages.admin.layouts.edit')

@php
    $title = 'Edit Currency';
    $subtitle = 'Update currency information';
    $backUrl = route('admin.currencies.index');
    $formAction = route('admin.currencies.update', $currency->id);
@endphp

@section('form-content')
    <div class="row mb-5">
        <div class="col-4">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ $currency->name }}" class="form-control" required>
        </div>
        <div class="col-4">
            <label class="form-label">Code</label>
            <input type="text" name="code" value="{{ $currency->code }}" class="form-control" required maxlength="3">
        </div>
        <div class="col-4">
            <label class="form-label">Symbol</label>
            <input type="text" name="symbol" value="{{ $currency->symbol }}" class="form-control" required maxlength="5">
        </div>
    </div>
@endsection
