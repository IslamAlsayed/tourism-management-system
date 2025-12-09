@extends('layouts.master')

@section('content')
    <div class="container-xxl">
        <div class="card">
            <!-- Card Header -->
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1">
                        <i class="ki-filled ki-chart-line-up"></i>
                        {{ __('main.import accommodations') }}
                    </h3>
                    <div class="text-gray-500 fw-semibold fs-6">
                        {{ __('main.upload excel file to import accommodations data') }}
                    </div>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('accommodations.import.sample') }}" class="btn btn-sm btn-light-primary">
                        <i class="ki-filled ki-download"></i>
                        {{ __('main.download sample file') }}
                    </a>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body pt-0">
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-success">{{ __('main.success') }}</h4>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                        <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-danger">{{ __('main.error') }}</h4>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('accommodations.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Important Notes -->
                    <div class="notice d-flex bg-light-info rounded border-info border border-dashed p-6 mb-10">
                        <i class="ki-duotone ki-information-5 fs-2tx text-info me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-stack flex-grow-1">
                            <div class="fw-semibold">
                                <h4 class="text-gray-900 fw-bold mb-2">{{ __('main.important notes') }}</h4>
                                <div class="fs-6 text-gray-700">
                                    <ul class="mb-0">
                                        <li>{{ __('main.first row must contain column names') }}</li>
                                        <li>{{ __('main.required columns') }}: <code class="text-danger">name</code>, <code
                                                class="text-danger">season_from</code>, <code
                                                class="text-danger">season_to</code></li>
                                        <li>{{ __('main.supported formats') }}: .xlsx, .xls, .csv</li>
                                        <li>{{ __('main.max file size') }}: 10MB</li>
                                        <li>{{ __('main.existing accommodations will be updated') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-10">
                        <label class="form-label required fw-semibold fs-6 mb-2">
                            <i class="ki-filled ki-file"></i>
                            {{ __('main.select excel file') }}
                        </label>
                        <input type="file" class="form-control form-control-solid @error('file') is-invalid @enderror"
                            name="file" accept=".xlsx,.xls,.csv" required />
                        @error('file')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div>{{ $message }}</div>
                            </div>
                        @enderror
                        <div class="form-text">
                            {{ __('main.allowed formats') }}: Excel (.xlsx, .xls) {{ __('main.or') }} CSV (.csv)
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('accommodations.index') }}" class="btn btn-light me-3">
                            <i class="ki-filled ki-left"></i>
                            {{ __('main.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-filled ki-cloud-add"></i>
                            {{ __('main.import data') }}
                        </button>
                    </div>
                </form>

                <!-- Separator -->
                <div class="separator separator-dashed my-10"></div>

                <!-- Excel File Structure -->
                <div class="mb-10">
                    <h3 class="fw-bold mb-5">
                        <i class="ki-filled ki-information"></i>
                        {{ __('main.excel file structure') }}
                    </h3>

                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th class="min-w-200px">{{ __('main.column name') }}</th>
                                    <th class="min-w-300px">{{ __('main.description') }}</th>
                                    <th class="min-w-100px">{{ __('main.required') }}</th>
                                    <th class="min-w-150px">{{ __('main.example') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">name</code></td>
                                    <td>{{ __('main.accommodation name') }} ({{ __('main.english') }})</td>
                                    <td><span class="badge badge-light-danger">{{ __('main.required') }}</span></td>
                                    <td><span class="text-gray-600">Hilton Cairo</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">name_ar</code></td>
                                    <td>{{ __('main.accommodation name') }} ({{ __('main.arabic') }})</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">هيلتون القاهرة</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">season_from</code></td>
                                    <td>{{ __('main.season start date') }}</td>
                                    <td><span class="badge badge-light-danger">{{ __('main.required') }}</span></td>
                                    <td><span class="text-gray-600">2025-01-01</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">season_to</code></td>
                                    <td>{{ __('main.season end date') }}</td>
                                    <td><span class="badge badge-light-danger">{{ __('main.required') }}</span></td>
                                    <td><span class="text-gray-600">2025-03-31</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">type</code></td>
                                    <td>{{ __('main.accommodation type') }}</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">Hotel, Resort, Camp</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">classification</code></td>
                                    <td>{{ __('main.classification') }}</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">5 Stars</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">currency</code></td>
                                    <td>{{ __('main.currency') }}</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">USD, EUR, JOD</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">room_type</code></td>
                                    <td>{{ __('main.room type') }}</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">Single, Double, Triple</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">p.p.double_room</code></td>
                                    <td>{{ __('main.price per person double room') }}</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">100</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">single_room_supp</code></td>
                                    <td>{{ __('main.single room supplement') }}</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">30</span></td>
                                </tr>
                                <tr>
                                    <td><code class="bg-light-primary text-primary">breakfast_meal</code></td>
                                    <td>{{ __('main.breakfast meal price') }}</td>
                                    <td><span class="badge badge-light-secondary">{{ __('main.optional') }}</span></td>
                                    <td><span class="text-gray-600">15</span></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <small>{{ __('main.and more columns') }}...
                                            {{ __('main.download sample file for complete list') }}</small>
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
