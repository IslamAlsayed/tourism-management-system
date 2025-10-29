<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .booking-info {
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 30px;
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
        }

        h2 {
            color: #3498db;
            font-size: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 50px;
            font-size: 12px;
            text-align: center;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .text-right {
            text-align: right;
        }

        .itinerary-day {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #3498db;
        }

        .meal-included {
            display: inline-block;
            padding: 2px 8px;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 3px;
            margin-right: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Booking Summary</h1>
            <p>Reference: {{ $booking_name }} | Date: {{ date('F d, Y') }}</p>
        </div>

        <div class="booking-info">
            <h2>Client Information</h2>
            <table>
                <tr>
                    <td width="25%"><strong>Client Name:</strong></td>
                    <td width="25%">{{ $client_name }}</td>
                    <td width="25%"><strong>Reference:</strong></td>
                    <td width="25%">{{ $booking_name }}</td>
                </tr>
                <tr>
                    <td><strong>Arrival Date:</strong></td>
                    <td>{{ $booking->arrival_date }}</td>
                    <td><strong>Departure Date:</strong></td>
                    <td>{{ $booking->departure_date }}</td>
                </tr>
                <tr>
                    <td><strong>Adults:</strong></td>
                    <td>{{ $booking->adults }}</td>
                    <td><strong>Children:</strong></td>
                    <td>{{ $booking->children }}</td>
                </tr>
            </table>
        </div>

        @if (!empty($accommodations))
            <div class="section">
                <h2>Accommodations</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Accommodation</th>
                            <th>Room Type</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Rooms</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accommodations as $index => $accommodation)
                            <tr>
                                <td>{{ $accommodationNames[$accommodation['accommodation_id']] ?? 'Unknown' }}</td>
                                <td>{{ $roomTypeNames[$accommodation['room_type_id']] ?? 'Unknown' }}</td>
                                <td>{{ $accommodation['check_in_date'] }}</td>
                                <td>{{ $accommodation['check_out_date'] }}</td>
                                <td>{{ $accommodation['rooms'] }}</td>
                                <td class="text-right">{{ $currency }}
                                    {{ number_format($accommodationTotals[$index] ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="5" class="text-right">Accommodations Subtotal:</td>
                            <td class="text-right">{{ $currency }} {{ number_format($accommodationsTotal, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        @if (!empty($transportation))
            <div class="section">
                <h2>Transportation</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Vehicle</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Date</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transportation as $transport)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $transport['type'])) }}</td>
                                <td>{{ ucfirst($transport['vehicle_type']) }}</td>
                                <td>{{ $transport['from_location'] }}</td>
                                <td>{{ $transport['to_location'] }}</td>
                                <td>{{ $transport['date'] }}</td>
                                <td class="text-right">{{ $currency }} {{ number_format($transport['price'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="5" class="text-right">Transportation Subtotal:</td>
                            <td class="text-right">{{ $currency }} {{ number_format($transportationTotal, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        @if (!empty($services))
            <div class="section">
                <h2>Additional Services</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $service['name'] }}</td>
                                <td>{{ $service['date'] }}</td>
                                <td>{{ $service['description'] }}</td>
                                <td class="text-right">{{ $currency }} {{ number_format($service['price'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3" class="text-right">Services Subtotal:</td>
                            <td class="text-right">{{ $currency }} {{ number_format($servicesTotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        @if (!empty($itinerary))
            <div class="section">
                <h2>Itinerary</h2>

                @foreach ($itinerary as $dayIndex => $day)
                    <div class="itinerary-day">
                        <h3>Day {{ $dayIndex + 1 }}: {{ $day['title'] }}
                            ({{ date('l, F j, Y', strtotime($day['date'])) }})</h3>
                        <p><strong>Location:</strong> {{ $cityNames[$day['city_id']] ?? 'Not specified' }}</p>
                        <p>{{ $day['description'] }}</p>

                        @if (!empty($day['activities']))
                            <p><strong>Activities:</strong></p>
                            <ul>
                                @foreach ($day['activities'] as $activity)
                                    <li>{{ $activity['time'] ?? '' }} {{ $activity['name'] }} -
                                        {{ $activity['details'] ?? '' }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <p><strong>Meals:</strong>
                            @if ($day['meals']['breakfast'] ?? false)
                                <span class="meal-included">Breakfast</span>
                            @endif
                            @if ($day['meals']['lunch'] ?? false)
                                <span class="meal-included">Lunch</span>
                            @endif
                            @if ($day['meals']['dinner'] ?? false)
                                <span class="meal-included">Dinner</span>
                            @endif
                            @if (!($day['meals']['breakfast'] ?? false) && !($day['meals']['lunch'] ?? false) && !($day['meals']['dinner'] ?? false))
                                No meals included
                            @endif
                        </p>

                        @if (!empty($day['notes']))
                            <p><strong>Notes:</strong> {{ $day['notes'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="section">
            <h2>Summary</h2>
            <table>
                <tr>
                    <td width="80%" class="text-right">Subtotal:</td>
                    <td width="20%" class="text-right">{{ $currency }} {{ number_format($subtotal, 2) }}</td>
                </tr>
                @if ($discount > 0)
                    <tr>
                        <td class="text-right">Discount:</td>
                        <td class="text-right">- {{ $currency }} {{ number_format($discount, 2) }}</td>
                    </tr>
                @endif
                @if ($tax > 0)
                    <tr>
                        <td class="text-right">Tax:</td>
                        <td class="text-right">+ {{ $currency }} {{ number_format($tax, 2) }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="text-right"><strong>Grand Total:</strong></td>
                    <td class="text-right"><strong>{{ $currency }} {{ number_format($total, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for choosing our services!</p>
            <p>This document was generated on {{ date('F d, Y') }}</p>
            <p>© {{ date('Y') }} MixJo Travel & Tourism</p>
        </div>
    </div>
</body>

</html>
