<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte</h1>
    <table>
        <thead>
            <tr>
                @foreach ($encabezados as $encabezado)
                    <th>{{ $encabezado }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $fila)
                <tr>
                    @foreach ($fila as $dato)
                        <td>{{ $dato }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
