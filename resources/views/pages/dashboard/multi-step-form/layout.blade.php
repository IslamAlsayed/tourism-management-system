@extends('layouts.master')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex justify-center">
            <div class="w-full max-w-4xl">
                <div class="card card-flush mb-6">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Multi-Step Booking Form</h3>
                    </div> --}}
                    <div class="card-body">
                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex flex-wrap justify-between">
                                <div class="flex items-center mb-3 lg:mb-0 gap-2">
                                    <div class="flex-shrink-0 mr-2">
                                        <div
                                            class="kt-badge kt-badge-primary stepper-icon {{ $step >= 1 ? 'stepper-icon-active' : '' }}">
                                            1
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Currency</h3>
                                            <div class="stepper-desc">Select currency</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center mb-3 lg:mb-0 gap-2">
                                    <div class="flex-shrink-0 mr-2">
                                        <div
                                            class="kt-badge kt-badge-primary stepper-icon {{ $step >= 2 ? 'stepper-icon-active' : '' }}">
                                            2
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Hotel Information</h3>
                                            <div class="stepper-desc">Select hotel, room type and season</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center mb-3 lg:mb-0 gap-2">
                                    <div class="flex-shrink-0 mr-2">
                                        <div
                                            class="kt-badge kt-badge-primary stepper-icon {{ $step >= 3 ? 'stepper-icon-active' : '' }}">
                                            3
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Rates & Policies</h3>
                                            <div class="stepper-desc">Select rates, supplements and policies</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center mb-3 lg:mb-0 gap-2">
                                    <div class="flex-shrink-0 mr-2">
                                        <div
                                            class="kt-badge kt-badge-primary stepper-icon {{ $step >= 4 ? 'stepper-icon-active' : '' }}">
                                            4
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Additional Services</h3>
                                            <div class="stepper-desc">Select transportation and other services</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="progress mt-4 h-3">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ ($step - 1) * 33.33 }}%" aria-valuenow="{{ ($step - 1) * 33.33 }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <!-- Content -->
                        @yield('form-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stepper-icon {
            width: 35px;
            height: 35px;
            display: flex;
            gap: 10px;
            font-size: 1.25rem;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, transform 0.3s;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize select2 for multiple selects
            $('.select2-selection').select2({
                theme: 'bootstrap-5'
            });

            // Form validation
            $('.next-step').click(function(e) {
                const form = $(this).closest('form');
                if (!form[0].checkValidity()) {
                    e.preventDefault();
                    form.addClass('was-validated');
                }
            });
        });
    </script>
@endpush
