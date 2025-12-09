@extends('layouts.master')

@section('title', __('main.import_rates'))

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ __('main.import_rates') }}</h1>
            <a href="{{ route('accommodations.rates.index') }}" class="btn btn-secondary">
                <i class="ki-filled ki-arrow-left"></i> {{ __('main.back') }}
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ __('main.import_instructions') }}</h5>
                <ol class="mb-3">
                    <li>{{ __('main.download_sample_file') }}</li>
                    <li>{{ __('main.fill_data_in_excel') }}</li>
                    <li>{{ __('main.upload_completed_file') }}</li>
                </ol>
                <div class="d-flex gap-2">
                    <a href="{{ route('accommodations.rates.sample-room') }}" class="btn btn-info">
                        <i class="ki-filled ki-download"></i> {{ __('main.download_room_rates_sample') }}
                    </a>
                    <a href="{{ route('accommodations.rates.sample-meal') }}" class="btn btn-warning">
                        <i class="ki-filled ki-download"></i> {{ __('main.download_meal_rates_sample') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('accommodations.rates.import.post') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="rate_type" class="form-label required">{{ __('main.rate_type') }}</label>
                        <select class="form-select @error('rate_type') is-invalid @enderror" id="rate_type" name="rate_type"
                            required>
                            <option value="">{{ __('main.select') }}</option>
                            <option value="room" {{ old('rate_type') == 'room' ? 'selected' : '' }}>
                                {{ __('main.room_rates') }}</option>
                            <option value="meal" {{ old('rate_type') == 'meal' ? 'selected' : '' }}>
                                {{ __('main.meal_rates') }}</option>
                        </select>
                        @error('rate_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label required">{{ __('main.select_excel_file') }}</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                            name="file" accept=".xlsx,.xls,.csv" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">{{ __('main.accepted_formats') }}: .xlsx, .xls, .csv</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="ki-filled ki-upload"></i> {{ __('main.import') }}
                        </button>
                        <a href="{{ route('accommodations.rates.index') }}" class="btn btn-secondary">
                            {{ __('main.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
