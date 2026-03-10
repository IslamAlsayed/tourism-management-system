<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Export' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, DejaVuSans, Helvetica, Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px 6px;
            text-align: left;
            font-size: 10px;
        }

        th {
            background: #f3f3f3;
        }

        .header {
            text-align: center;
            margin-bottom: 6px;
        }

        /* allow wrapping inside cells instead of overflowing horizontally */
        td {
            white-space: normal;
            word-break: break-word;
        }

        /* reduce table padding on small fonts */
        @media print {

            th,
            td {
                padding: 3px 4px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>{{ $title ?? '' }}</h2>
        <p>{{ now()->toDateTimeString() }}</p>
    </div>
    <table>
        <thead>
            @php
                // Normalize columns: support both ['col1','col2'] and ['col_key' => 'Label']
                $colMap = [];
                foreach ($columns as $k => $v) {
                    if (is_int($k)) {
                        $colKey = $v;
                        $label = __('main.' . $colKey);
                        // If translation not defined, fallback to readable key
                        if ($label === 'main.' . $colKey) {
                            $label = ucfirst(str_replace('_', ' ', $colKey));
                        }
                    } else {
                        $colKey = $k;
                        $label = $v;
                    }
                    $colMap[] = ['key' => $colKey, 'label' => $label];
                }
            @endphp

            <tr>
                @foreach ($colMap as $c)
                    <th>{{ $c['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($colMap as $c)
                        @php
                            $value = data_get($row, $c['key']);
                            $display = '';

                            if ($value instanceof \Illuminate\Support\Collection) {
                                $display = $value->pluck('name')->filter()->implode(', ');
                                if ($display === '') {
                                    $display = $value->pluck('title')->filter()->implode(', ');
                                }
                                if ($display === '') {
                                    $display = $value->pluck('id')->filter()->implode(', ');
                                }
                            } elseif (is_object($value)) {
                                if (isset($value->name) && $value->name !== null) {
                                    $display = $value->name;
                                } elseif (isset($value->title) && $value->title !== null) {
                                    $display = $value->title;
                                } else {
                                    // Try string cast as last resort
                                    $display = (string) $value;
                                }
                            } else {
                                $display = $value;
                            }
                        @endphp
                        <td>{{ $display }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
