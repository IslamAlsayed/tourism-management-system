<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Summary</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #f8f9fa;
            border-bottom: 3px solid #0056b3;
        }

        .content {
            padding: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }

        h1 {
            color: #0056b3;
            margin: 0;
        }

        h2 {
            color: #0056b3;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-top: 30px;
        }

        .booking-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .cta-button {
            display: inline-block;
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-primary {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmation</h1>
            <p>Thank you for booking with MixJo Travel & Tourism</p>
        </div>

        <div class="content">
            <p>Dear {{ $booking->client_name }},</p>

            <p>Your booking has been successfully processed. Please find the details of your reservation below:</p>

            <div class="booking-details">
                <p><strong>Booking Reference:</strong> {{ $booking->booking_name }}</p>
                <p><strong>Travel Dates:</strong> {{ $booking->arrival_date }} to {{ $booking->departure_date }}</p>
                <p><strong>Number of Guests:</strong> {{ $booking->adults }} Adults, {{ $booking->children }} Children
                </p>
            </div>

            <p>We have attached a PDF document with the complete details of your booking, including:</p>

            <ul>
                <li>Accommodation details</li>
                <li>Transportation arrangements</li>
                <li>Additional services</li>
                <li>Detailed itinerary</li>
                <li>Payment summary</li>
            </ul>

            <p>Please review the attached document carefully and contact us if you have any questions or need to make
                any changes.</p>

            <p>If you have any questions or need further assistance, please don't hesitate to contact us at <a
                    href="mailto:info@mixjo.com">info@mixjo.com</a> or call us at +962-6-1234567.</p>

            <p>We wish you a pleasant journey!</p>

            <p>Best regards,<br>
                MixJo Travel & Tourism Team</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} MixJo Travel & Tourism. All rights reserved.</p>
            <p>This email was sent to {{ $booking->client_email }}</p>
            <p class="text-muted">Please do not reply to this email as it was sent from an unmonitored address.</p>
        </div>
    </div>
</body>

</html>
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
