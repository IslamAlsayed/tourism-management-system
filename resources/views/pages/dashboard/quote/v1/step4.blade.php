@extends('pages.dashboard.quote.v1.layout', ['step' => 4])

@section('form-content')
    <div class="space-y-8">
        {{-- Information --}}
        <div class="kt-card p-4 mb-4">
            <div class="grid lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-semibold mb-4">Traveler</h4>
                    <div>{{ $booking->first_name }} {{ $booking->last_name }}</div>
                    <div>{{ $booking->email }} <strong>|</strong> {{ $booking->phone }}</div>
                    <div><strong>Nationality:</strong> {{ $booking->nationality->name ?? '-' }}</div>
                    <div><strong>Dates:</strong> {{ $booking->arrival_date }} → {{ $booking->departure_date }}
                        ({{ $booking->nights }} nights)</div>
                    <div>
                        <strong>Pax: </strong> A{{ $booking->adults }} / C{{ $booking->children }} /
                        I{{ $booking->infants }}
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Hotel (optional)</h4>
                    <div><strong>Hotel:</strong> {{ $booking->hotel->accommodation?->name ?? '-' }}</div>
                    <div><strong>Rooms:</strong>
                        [@foreach ($booking->roomTypes as $key => $room)
                            {{ $room->pivot->quantity . ' x ' . $room->name ?? '-' }} {{ $key > 0 ? ', ' : '' }}
                        @endforeach]
                    </div>
                    <div><strong>Season:</strong> {{ $booking->season->season_name ?? '-' }}</div>
                    <div><strong>Currency:</strong> {{ $booking->currency->code ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Transportation --}}
        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-4">Transportation</h4>
            <div class="rounded">
                <table class="table w-full text-left">
                    @if (!$booking->transportation->isEmpty())
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Days</th>
                                <th>Price/Day</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    @endif
                    <tbody>
                        @forelse($booking->transportation as $transport)
                            <tr>
                                <td>{{ $transport->company->name }}</td>
                                <td>{{ $transport->day }}</td>
                                <td>
                                    {{ $booking->currency->symbol ?? '' }}
                                    {{ number_format($transport->price_per_day, 2) }}
                                </td>
                                <td>
                                    {{ $booking->currency->symbol ?? '' }}
                                    {{ number_format($transport->day * $transport->price_per_day, 2) }}
                                </td>
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

        {{-- Other Services --}}
        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-4">Other Services</h4>
            <div class="rounded">
                <table class="table w-full text-left">
                    @if (!$booking->otherServices->isEmpty())
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    @endif
                    <tbody>
                        @forelse($booking->otherServices as $services)
                            <tr>
                                <td>{{ $services->name }}</td>
                                <td>{{ $services->pivot->quantity }}x</td>
                                <td>
                                    {{ $booking->currency->symbol }}
                                    {{ number_format($services->price, 2) }}
                                </td>
                                <td>
                                    {{ $booking->currency->symbol }}
                                    {{ number_format($services->pivot->quantity * $services->price, 2) }}
                                </td>
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

        {{-- Itinerary --}}
        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-4">Itinerary</h4>
            <div class="rounded">
                <table class="table w-full text-left">
                    @if (!$booking->itineraries->isEmpty())
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>City</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                    @endif
                    <tbody>
                        @forelse($booking->itineraries as $itinerary)
                            <tr>
                                <td>{{ $itinerary->day_number }}</td>
                                <td>{{ $itinerary->city?->name }}</td>
                                <td>{{ $itinerary->description ?: '--' }}</td>
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

        <form method="POST" action="{{ route('dashboard.v1.quote.submit', $booking->id) }}" class="space-y-4">
            @csrf

            {{-- Totals --}}
            <livewire:quote.v1.step4.totals :id="$booking->id" />

            <div class="flex justify-between">
                <a href="{{ route('dashboard.v1.quote.step3', $booking) }}" class="kt-btn kt-btn-light">Back</a>
                <button class="kt-btn kt-btn-success">Submit & Send</button>
            </div>
        </form>
    </div>
@endsection
