<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; }
        h1 { font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #444; padding: 4px 6px; text-align: left; }
        th { background: #343a40; color: #fff; }
    </style>
</head>
<body>
    <h1>Laporan Diagnosa Kerusakan Mobil Toyota Avanza</h1>
    <p>Periode: {{ $start_date }} s/d {{ $end_date }}</p>
    <table>
        <thead>
            <tr><th>No</th><th>Tanggal</th><th>User</th><th>Hasil</th><th>Kecocokan</th></tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
