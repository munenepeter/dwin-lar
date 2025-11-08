<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Agent Performance Report</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Agent Performance Report</h1>
    <p>Agent: {{ $agents->find(request('agent_id'))?->full_name }}</p>
    <p>Period: {{ request('start_date') }} to {{ request('end_date') }}</p>

    @if ($reportData)
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Policies Sold</th>
                <th>Total Premium</th>
                <th>Avg. Premium</th>
                <th>Total Commission</th>
                <th>Unique Clients</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
            <tr>
                <td>{{ $data->sale_date }}</td>
                <td>{{ $data->policies_sold }}</td>
                <td>{{ number_format($data->total_premium, 2) }}</td>
                <td>{{ number_format($data->avg_premium, 2) }}</td>
                <td>{{ number_format($data->total_commission, 2) }}</td>
                <td>{{ $data->unique_clients }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No data available.</p>
    @endif
</body>

</html>