<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Users Export</title>
    <style>
        body {
            font-family: DejaVu Sans, DejaVuSans, Helvetica, Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f3f3f3;
        }

        .header {
            text-align: center;
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>{{ __('main.users') }}</h2>
        <p>{{ now()->toDateTimeString() }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.email') }}</th>
                <th>{{ __('main.created_at') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ optional($user->created_at)->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
