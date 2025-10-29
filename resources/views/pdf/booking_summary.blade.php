<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Quote #{{ $booking->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            margin: 0 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <h2>Quotation Summary #{{ $booking->id }}</h2>
    <p><strong>Traveler:</strong> {{ $booking->first_name }} {{ $booking->last_name }} — {{ $booking->email }} |
        {{ $booking->phone }}</p>
    <p><strong>Dates:</strong> {{ $booking->arrival_date }} → {{ $booking->departure_date }} — Pax:
        A{{ $booking->adults }}, C{{ $booking->children }}, I{{ $booking->infants }}</p>

    <h3>Transportation</h3>
    <table>
        <thead>
            <tr>
                <th>Company</th>
                <th>Days</th>
                <th>Price/Day</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($booking->transportationCompanies as $t)
                <tr>
                    <td>{{ $t->name ?? $t->name_en }}</td>
                    <td>{{ $t->pivot->days }}</td>
                    <td>{{ number_format($t->pivot->price_per_day, 2) }}</td>
                    <td>{{ number_format($t->pivot->days * $t->pivot->price_per_day, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Other Services</h3>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($booking->otherServices as $s)
                <tr>
                    <td>{{ $s->name_en ?? $s->name }}</td>
                    <td>{{ $s->pivot->qty }}</td>
                    <td>{{ number_format($s->pivot->unit_price, 2) }}</td>
                    <td>{{ number_format($s->pivot->qty * $s->pivot->unit_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Itinerary</h3>
    <table>
        <thead>
            <tr>
                <th>Day</th>
                <th>City</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($booking->itineraries as $i)
                <tr>
                    <td>{{ $i->day_number }}</td>
                    <td>{{ $i->city }}</td>
                    <td>{{ $i->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Totals</h3>
    <table>
        <tbody>
            <tr>
                <td>Subtotal Hotels</td>
                <td>{{ number_format($totals['subtotal_hotels'], 2) }}</td>
            </tr>
            <tr>
                <td>Subtotal Transport</td>
                <td>{{ number_format($totals['subtotal_transport'], 2) }}</td>
            </tr>
            <tr>
                <td>Subtotal Services</td>
                <td>{{ number_format($totals['subtotal_services'], 2) }}</td>
            </tr>
            <tr>
                <td>Discount</td>
                <td>{{ number_format($totals['discount'], 2) }}</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>{{ number_format($totals['tax'], 2) }}</td>
            </tr>
            <tr>
                <th>Grand Total</th>
                <th>{{ number_format($totals['grand_total'], 2) }}</th>
            </tr>
        </tbody>
    </table>
</body>

</html>
