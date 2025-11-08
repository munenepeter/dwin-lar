<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Outstanding Commissions Report</title>
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
    <h1>Outstanding Commissions Report</h1>

    @if ($reportData)
    <table>
        <thead>
            <tr>
                <th>Agent Name</th>
                <th>Employee ID</th>
                <th>Pending Calculations</th>
                <th>Total Outstanding</th>
                <th>Oldest Calculation</th>
                <th>Newest Calculation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
            <tr>
                <td>{{ $data->agent_name }}</td>
                <td>{{ $data->employee_id }}</td>
                <td>{{ $data->pending_calculations }}</td>
                <td>{{ number_format($data->total_outstanding, 2) }}</td>
                <td>{{ $data->oldest_calculation }}</td>
                <td>{{ $data->newest_calculation }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No data available.</p>
    @endif
</body>

</html>