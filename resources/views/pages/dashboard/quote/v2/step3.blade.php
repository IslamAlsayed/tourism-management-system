@extends('pages.dashboard.quote.v1.layout', ['step' => 3])

@section('form-content')
    <form action="{{ route('dashboard.quote.v2.postStep3') }}" class="form" id="kt_form_3" method="POST">
        @csrf

        <div>
            <label for="countries1" class="kt-label mb-2">Country 1</label>
            <select id="countries1" name="countriesOptions[]" special-multiple>
                <option value="">--</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            @error('countriesOptions')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="countries2" class="kt-label mb-2">Country 2</label>
            <select id="countries2" name="countriesOptions[]" special-multiple>
                <option value="">--</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            @error('countriesOptions')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-between">
            <button class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
@endsection



{{-- @section('form-content')
    <form action="{{ route('dashboard.quote.step4') }}" method="POST" class="form" id="kt_form_3">
        @csrf

        <div class="mb-6">
            <h4 class="text-dark text-xl font-semibold mb-2">{{ __('step :number', ['number' => 3]) }}:
                {{ __('Rates, Supplements & Policies') }}</h4>
            <p class="text-gray-600">{{ __('Select rates, supplements and policies for your booking') }}</p>
        </div>

        <!-- Hidden fields to carry over the previous selections -->
        <input type="hidden" name="currency_id" value="{{ request('currency_id') }}">
        <input type="hidden" name="hotel_id" value="{{ request('hotel_id') }}">
        <input type="hidden" name="room_type_id" value="{{ request('room_type_id') }}">
        <input type="hidden" name="season_id" value="{{ request('season_id') }}">

        <div class="grid lg:grid-cols-1 gap-6">
            <div class="mb-8">
                <label class="form-label required">Available Rates</label>
                <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
                    <div class="kt-scrollable-x-auto" wire:target="search" wire:loading.class="loading">
                        <table class="kt-table table-auto text-nowrap" data-kt-datatable-table="true">
                            <thead>
                                <tr>
                                    <th class="w-[60px] px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCountries" class="kt-checkbox kt-checkbox-sm">
                                    </th>
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.id') }}</th>
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.name') }}</th>
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.price') }}</th>
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.per_person') }}</th>
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.mandatory') }}</th>
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.applicable_date') }}</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hotelSupplements as $supplement)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input supplement-checkbox" type="checkbox"
                                                    name="supplement_ids[]" value="{{ $supplement['id'] }}"
                                                    id="supplement_{{ $supplement['id'] }}"
                                                    {{ in_array($supplement['id'], old('supplement_ids', session('multi_step.supplement_ids', []))) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>{{ $supplement['name'] }}</td>
                                        <td>{{ number_format($supplement['price'], 2) }}</td>
                                        <td>
                                            {!! $supplement['is_per_person']
                                                ? '<span class="badge bg-success">Yes</span>'
                                                : '<span class="badge bg-secondary">No</span>' !!}
                                        </td>
                                        <td>
                                            {!! $supplement['is_mandatory']
                                                ? '<span class="badge bg-danger">Mandatory</span>'
                                                : '<span class="badge bg-info">Optional</span>' !!}
                                        </td>
                                        <td>{{ $supplement['applicable_date'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-gray-500 py-5">
                                            No rates available for the selected options.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @error('supplement_ids')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="mb-4">
                <!-- Supplement -->
                <label for="supplement_id" class="kt-label mb-2">{{ __('main.supplement') }}</label>
                <select name="supplement_id" id="supplement_id" class="kt-select h-[45px]">
                    @foreach ($hotelSupplements as $supplement)
                        <option value="{{ $supplement->id }}"
                            {{ old('supplement_id') == $supplement->id ? 'selected' : '' }}>
                            {{ $supplement->name }}
                        </option>
                    @endforeach
                </select>
                <div class="fv-plugins-message-container invalid-feedback">
                    Please select a supplement.
                </div>
            </div>

            <div class="mb-4">
                <!-- Policy -->
                <label for="hotel_policy_id" class="kt-label mb-2">{{ __('main.policy') }}</label>
                <select name="hotel_policy_id" id="hotel_policy_id" class="kt-select h-[45px]">
                    @foreach ($hotelPolicies as $policy)
                        <option value="{{ $policy->id }}" {{ old('hotel_policy_id') == $policy->id ? 'selected' : '' }}>
                            {{ $policy->policy_type }} </option>
                    @endforeach
                </select>
                <div class="fv-plugins-message-container invalid-feedback">
                    Please select a policy.
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-8">
            <button type="button" class="btn btn-light" onclick="window.history.back();">
                <i class="ki-duotone ki-arrow-left me-2"><span class="path1"></span><span class="path2"></span></i>
                Previous Step
            </button>
            <button type="submit" class="btn btn-primary next-step">
                Next Step <i class="ki-duotone ki-arrow-right ms-2"><span class="path1"></span><span
                        class="path2"></span></i>
            </button>
        </div>
    </form>
@endsection --}}
