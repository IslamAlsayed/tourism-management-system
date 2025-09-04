@extends('pages.dashboard.multi-step-form.layout', ['step' => 4])

@section('form-content')
    <form action="{{ route('dashboard.multi-step-form.submit') }}" method="POST" class="form" id="kt_form_4">
        @csrf

        <div class="mb-6">
            <h4 class="text-dark text-xl font-semibold mb-2">Step 4: Transportation & Other Services</h4>
            <p class="text-gray-600">Select transportation, other services and suppliers for your booking</p>
        </div>

        <!-- Hidden fields to carry over the previous selections -->
        <input type="hidden" name="currency_id" value="{{ request('currency_id') }}">
        <input type="hidden" name="hotel_id" value="{{ request('hotel_id') }}">
        <input type="hidden" name="room_type_id" value="{{ request('room_type_id') }}">
        <input type="hidden" name="season_id" value="{{ request('season_id') }}">

        @foreach (request('rate_ids', []) as $rateId)
            <input type="hidden" name="rate_ids[]" value="{{ $rateId }}">
        @endforeach

        @foreach (request('supplement_ids', []) as $supplementId)
            <input type="hidden" name="supplement_ids[]" value="{{ $supplementId }}">
        @endforeach

        @foreach (request('policy_ids', []) as $policyId)
            <input type="hidden" name="policy_ids[]" value="{{ $policyId }}">
        @endforeach

        <div class="mb-8">
            <label class="form-label">Transportation Companies</label>
            <select class="form-select form-select-solid" data-control="select2"
                data-placeholder="Select transportation companies" data-allow-clear="true"
                name="transportation_company_ids[]" multiple="multiple">
                @foreach ($transportationCompanies as $company)
                    <option value="{{ $company->id }}">{{ $company->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <div class="mb-8">
                <label class="form-label">Other Services</label>
                <select class="form-select form-select-solid" data-control="select2"
                    data-placeholder="Select other services" data-allow-clear="true" name="other_service_ids[]"
                    multiple="multiple">
                    @foreach ($otherServices as $service)
                        <option value="{{ $service->id }}">
                            {{ $service->name_en }} ({{ $service->price }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-8">
                <label class="form-label">Suppliers</label>
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select suppliers"
                    data-allow-clear="true" name="supplier_ids[]" multiple="multiple">
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between mt-8">
                <button type="button" class="btn btn-light" onclick="window.history.back();">
                    <i class="ki-duotone ki-arrow-left me-2"><span class="path1"></span><span class="path2"></span></i>
                    Previous Step
                </button>
                <button type="submit" class="btn btn-success" id="submit-form">
                    <i class="ki-duotone ki-check fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>
                    Complete Booking
                </button>
            </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle form submission with AJAX
            $('#kt_form_4').on('submit', function(e) {
                e.preventDefault();

                if (!this.checkValidity()) {
                    e.stopPropagation();
                    $(this).addClass('was-validated');
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Show success message with Metronic SweetAlert
                            Swal.fire({
                                text: 'Your booking has been submitted successfully.',
                                icon: 'success',
                                buttonsStyling: false,
                                confirmButtonText: 'View Details',
                                showCancelButton: true,
                                cancelButtonText: 'Close',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                    cancelButton: 'btn btn-light'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Display the JSON response in a modal
                                    $('#json-response-modal .modal-body pre').text(
                                        JSON.stringify(response.data, null, 2)
                                    );
                                    $('#json-response-modal').modal('show');
                                } else {
                                    // Redirect to dashboard
                                    window.location.href = "{{ route('dashboard') }}";
                                }
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                text: 'There was an error submitting your booking.',
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Try Again',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        }
                    },
                    error: function() {
                        // Show error message
                        Swal.fire({
                            text: 'There was an error submitting your booking.',
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Try Again',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

<!-- Modal for displaying JSON response -->
<div class="modal fade" id="json-response-modal" tabindex="-1" aria-labelledby="json-response-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-4" id="json-response-modal-label">Booking Details</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <pre class="bg-light p-5 rounded" style="max-height: 400px; overflow-y: auto;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
