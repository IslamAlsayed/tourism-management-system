@extends('layouts.app')

@section('title', __('main.import_companies'))

@section('content')
    <div class="container-fluid py-6 px-6">
        <!-- Page Header -->
        <div class="page-header d-print-none mb-6">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ $title }}
                    </h2>
                    <p class="text-muted mt-2">{{ $description }}</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('dashboard.transportation.companies.index') }}" class="kt-btn kt-btn-outline kt-btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('main.back') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="kt-card-body">
                        <h5 class="card-title mb-4">{{ __('main.upload_excel_file') }}</h5>

                        <form action="{{ route('transportations.import-export.companies-import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- File Input -->
                            <div class="mb-4">
                                <label class="form-label" for="file">
                                    {{ __('main.select_file') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".csv,.xlsx"
                                    required>
                                @error('file')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    {{ __('main.accepted_formats') }}: CSV, XLSX
                                </small>
                            </div>

                            <!-- Instructions -->
                            <div class="alert alert-info" role="alert">
                                <h6 class="alert-heading">
                                    <i class="fas fa-info-circle me-2"></i>{{ __('main.import_instructions') }}
                                </h6>
                                <ul class="mb-0">
                                    <li>{{ __('main.excel_must_have_headers') }}</li>
                                    <li>{{ __('main.ensure_correct_columns') }}</li>
                                    <li>{{ __('main.duplicate_companies_will_be_updated') }}</li>
                                    <li>{{ __('main.empty_values_set_to_null') }}</li>
                                </ul>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="kt-btn kt-btn-primary kt-btn-lg">
                                    <i class="fas fa-upload me-2"></i>{{ __('main.import_companies') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Export Section -->
                <div class="card mt-4">
                    <div class="kt-card-body">
                        <h5 class="card-title mb-4">{{ __('main.or_export_existing') }}</h5>

                        <form action="{{ route('transportations.import-export.companies-export') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label" for="include_relations">
                                    {{ __('main.include_relations') }}
                                </label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="include_relations" name="include_relations" value="1" checked>
                                    <label class="form-check-label" for="include_relations">
                                        {{ __('main.export_related_data') }}
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="kt-btn kt-btn-success kt-btn-lg">
                                    <i class="fas fa-download me-2"></i>{{ __('main.export_companies') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
