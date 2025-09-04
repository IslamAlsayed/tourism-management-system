@extends('pages.dashboard.quote.layout', ['step' => 4])

@section('form-content')
    <div class="space-y-8">
        <div class="kt-card p-4 mb-4">
            <div class="grid lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-semibold mb-4">Traveler</h4>
                    <div>{{ $booking->first_name }} {{ $booking->last_name }}</div>
                    <div>{{ $booking->email }} <strong>|</strong> {{ $booking->phone }}</div>
                    <div><strong>Nationality:</strong> {{ $booking->nationality ?? '-' }}</div>
                    <div><strong>Dates:</strong> {{ $booking->arrival_date }} → {{ $booking->departure_date }}</div>
                    <div><strong>Pax: </strong> A{{ $booking->adults }} / C{{ $booking->children }} /
                        I{{ $booking->infants }}</div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Hotel (optional)</h4>
                    <div><strong>Hotel:</strong> {{ $booking->hotel->accommodation->name ?? '-' }}</div>
                    <div><strong>Room:</strong> {{ $booking->roomType->name_en ?? '-' }}</div>
                    <div><strong>Season:</strong> {{ $booking->season->season_name ?? '-' }}</div>
                    <div><strong>Currency:</strong> {{ $booking->currency->code ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-4">Transportation</h4>
            <div class="rounded">
                <table class="table w-full text-left">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Days</th>
                            <th>Price/Day</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->transportationCompanies as $t)
                            <tr>
                                <td>{{ $t->name ?? $t->name_en }}</td>
                                <td>{{ $t->pivot->days }}</td>
                                <td>{{ number_format($t->pivot->price_per_day, 2) }}</td>
                                <td>{{ number_format($t->pivot->days * $t->pivot->price_per_day, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500">No transport selected</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-4">Other Services</h4>
            <div class="rounded">
                <table class="table w-full text-left">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->otherServices as $s)
                            <tr>
                                <td>{{ $s->name_en ?? $s->name }}</td>
                                <td>{{ $s->pivot->qty }}</td>
                                <td>{{ number_format($s->pivot->unit_price, 2) }}</td>
                                <td>{{ number_format($s->pivot->qty * $s->pivot->unit_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500">No services selected</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-4">Itinerary</h4>
            <div class="rounded">
                <table class="table w-full text-left">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>City</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->itineraries as $i)
                            <tr>
                                <td>{{ $i->day_number }}</td>
                                <td>{{ $i->city->name }}</td>
                                <td>{{ $i->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500">No itinerary</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.quote.submit', $booking) }}" class="space-y-4">
            @csrf
            <div class="grid lg:grid-cols-3 gap-4">
                <div>
                    <label class="kt-label mb-2">Discount</label>
                    <input type="number" step="0.01" name="discount" class="kt-input" value="{{ old('discount', 0) }}">
                </div>
                <div>
                    <label class="kt-label mb-2">Tax</label>
                    <input type="number" step="0.01" name="tax" class="kt-input" value="{{ old('tax', 0) }}">
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-full">
                    <div class="grid grid-cols-4 gap-4">
                        <span>Subtotal Hotels:</span>
                        <strong>{{ number_format($totals['subtotal_hotels'], 2) }}</strong>
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <span>Subtotal Transport:</span>
                        <strong>{{ number_format($totals['subtotal_transport'], 2) }}</strong>
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <span>Subtotal Services:</span>
                        <strong>{{ number_format($totals['subtotal_services'], 2) }}</strong>
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <span>Discount:</span>
                        <strong>{{ number_format($totals['discount'], 2) }}</strong>
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <span>Tax:</span>
                        <strong>{{ number_format($totals['tax'], 2) }}</strong>
                    </div>
                    <div class="grid grid-cols-4 gap-4 text-lg mt-2">
                        <strong>Grand Total:</strong>
                        <strong>{{ number_format($totals['grand_total'], 2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('dashboard.quote.step3', $booking) }}" class="kt-btn kt-btn-light">Back</a>
                <button class="kt-btn kt-btn-success">Submit & Send</button>
            </div>
        </form>
    </div>
@endsection




{{-- @section('form-content')
    <form action="{{ route('dashboard.quote.submit') }}" method="POST" class="form">
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
                <select name="supplier_ids[]" id="supplier_ids" class="kt-select" data-control="select2" multiple>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ in_array($supplier->id, old('supplier_ids', session('multi_step.supplier_ids', []))) ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
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
@endsection --}}
