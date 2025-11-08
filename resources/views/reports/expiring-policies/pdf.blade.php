<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Expiring Policies Report</title>
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
    <h1>Expiring Policies Report</h1>
    <p>Days Ahead: {{ $daysAhead }}</p>

    @if ($reportData)
    <table>
        <thead>
            <tr>
                <th>Policy Number</th>
                <th>Client Name</th>
                <th>Client Phone</th>
                <th>Policy Type</th>
                <th>Company</th>
                <th>Expiry Date</th>
                <th>Days to Expiry</th>
                <th>Agent</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
            <tr>
                <td>{{ $data->policy_number }}</td>
                <td>{{ $data->client_name }}</td>
                <td>{{ $data->phone_primary }}</td>
                <td>{{ $data->policy_type }}</td>
                <td>{{ $data->company_name }}</td>
                <td>{{ $data->expiry_date }}</td>
                <td>{{ $data->days_to_expiry }}</td>
                <td>{{ $data->agent_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No data available.</p>
    @endif
</body>

</html>