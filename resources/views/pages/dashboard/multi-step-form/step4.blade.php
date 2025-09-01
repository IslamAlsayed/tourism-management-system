@extends('pages.dashboard.multi-step-form.layout', ['step' => 4])

@section('form-content')
    <form action="{{ route('dashboard.multi-step-form.submit') }}" method="POST" class="form">
        @csrf

        <div class="mb-6">
            <h4 class="text-dark text-xl font-semibold mb-2">{{ __('step :number', ['number' => 4]) }} :
                {{ __('Transportation & Other Services') }}</h4>
            <p class="text-gray-600">
                {{ __('Select transportation companies, other services, and suppliers for your booking') }}</p>
        </div>

        <!-- Hidden fields to carry previous selections -->
        <input type="hidden" name="currency_id" value="{{ session('multi_step.currency_id') }}">
        <input type="hidden" name="hotel_id" value="{{ session('multi_step.hotel_id') }}">
        <input type="hidden" name="room_type_id" value="{{ session('multi_step.room_type_id') }}">
        <input type="hidden" name="season_id" value="{{ session('multi_step.hotel_season_id') }}">

        @foreach (session('multi_step.rate_ids', []) as $rateId)
            <input type="hidden" name="rate_ids[]" value="{{ $rateId }}">
        @endforeach

        @foreach (session('multi_step.supplement_ids', []) as $supplementId)
            <input type="hidden" name="supplement_ids[]" value="{{ $supplementId }}">
        @endforeach

        @foreach (session('multi_step.policy_ids', []) as $policyId)
            <input type="hidden" name="policy_ids[]" value="{{ $policyId }}">
        @endforeach

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="mb-4">
                <!-- Transportation Companies -->
                <label class="kt-label mb-2">
                    {{ __('main.transportation_companies') }}
                </label>

                @forelse ($transportationCompanies as $company)
                    <div>
                        <input class="form-check-input supplement-checkbox" type="checkbox" value="{{ $company->id }}"
                            name="transportation_company_ids[]" id="transportation_company_{{ $company->id }}"
                            {{ in_array($company->id, old('transportation_company_ids', session('multi_step.transportation_company_ids', []))) ? 'checked' : '' }} />
                        <label for="transportation_company_{{ $company->id }}" class="kt-label mb-2">
                            {{ $company->name }}
                        </label>
                    </div>
                @empty
                    <p class="text-gray-600">{{ __('main.no_transportation_companies') }}</p>
                @endforelse
                @error('transportation_company_ids')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <!-- Other Services -->
                <label class="kt-label mb-2">{{ __('main.other_services') }}</label>

                @forelse ($otherServices as $service)
                    <div>
                        <input class="form-check-input supplement-checkbox" type="checkbox" value="{{ $service->id }}"
                            name="other_service_ids[]" id="other_service_{{ $service->id }}"
                            {{ in_array($service->id, old('other_service_ids', session('multi_step.other_service_ids', []))) ? 'checked' : '' }} />
                        <label for="other_service_{{ $service->id }}" class="kt-label mb-2">
                            {{ $service->name_en }} ({{ number_format($service->price, 2) }})
                        </label>
                    </div>
                @empty
                    <p class="text-gray-600">{{ __('main.no_other_services') }}</p>
                @endforelse
                @error('other_service_ids')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <!-- Suppliers -->
                <label for="supplier_ids" class="kt-label mb-2">{{ __('main.suppliers') }}</label>

                @forelse ($suppliers as $supplier)
                    <div>
                        <input class="form-check-input supplement-checkbox" type="checkbox" value="{{ $supplier->id }}"
                            name="supplier_ids[]" id="supplier_{{ $supplier->id }}"
                            {{ in_array($supplier->id, old('supplier_ids', session('multi_step.supplier_ids', []))) ? 'checked' : '' }} />
                        <label for="supplier_{{ $supplier->id }}" class="kt-label mb-2">
                            {{ $supplier->name }}
                        </label>
                    </div>
                @empty
                    <p class="text-gray-600">{{ __('main.no_suppliers') }}</p>
                @endforelse
                {{-- <select name="supplier_ids[]" id="supplier_ids" class="kt-select" data-control="select2" multiple>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ in_array($supplier->id, old('supplier_ids', session('multi_step.supplier_ids', []))) ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select> --}}
                @error('supplier_ids')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-8">
            <a href="{{ url()->previous() }}" class="btn btn-light">
                <i class="ki-duotone ki-arrow-left me-2"></i>
                Previous Step
            </a>
            <button type="submit" class="btn btn-success">
                <i class="ki-duotone ki-check fs-2 me-2"></i>
                Complete Booking
            </button>
        </div>
    </form>
@endsection
