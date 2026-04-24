@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4">
        <div class="w-full max-w-5xl mx-auto">
            <div class="kt-card">
                <div class="kt-card-body">
                    {{-- Stepper --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            @php($labels = ['Traveler Info', 'Services', 'Itinerary', 'Review'])
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-9 h-9 rounded-full flex items-center justify-center {{ ($step ?? 1) >= $i ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $i }}
                                    </div>
                                    <div class="hidden md:block">
                                        <div class="font-semibold">{{ $labels[$i - 1] }}</div>
                                    </div>
                                </div>
                                @if ($i < 4)
                                    <div class="flex-1 h-1 mx-2 {{ ($step ?? 1) > $i ? 'bg-primary' : 'bg-gray-200' }}"></div>
                                @endif
                            @endfor
                        </div>
                    </div>

                    @yield('form-content')
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @section('content')
    <div class="kt-container-fixed">
        <div class="flex justify-center">
            <div class="w-full max-w-4xl">
                <div class="card card-flush mb-6">
                    <div class="card-header">
                        <h3 class="card-title">Multi-Step Booking Form</h3>
                    </div>
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
@endpush --}}
