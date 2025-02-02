<!DOCTYPE html>
<html>
<head>
    <style>
        /* Resetear márgenes predeterminados */
        body {
            margin: 0;
            padding: 10px;
            font-family: 'DejaVu Sans', sans-serif;
        }

        /* Encabezado compacto */
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding: 5px;
            border-bottom: 2px solid #333;
        }

        /* Evitar saltos no deseados */
        .registro {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        /* Tablas más compactas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }

        td, th {
            padding: 6px !important;
            font-size: 12px;
        }

        /* Asegurar que el primer registro empiece en la misma página */
        .first-registro {
            page-break-before: avoid;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3 style="margin: 5px 0;">Reporte Personalizado</h3> <!-- Título más pequeño -->
        @if($fechaInicio && $fechaFin)
            <p style="margin: 3px 0; font-size: 12px;">
                Periodo: {{ date('d/m/Y', strtotime($fechaInicio)) }} - {{ date('d/m/Y', strtotime($fechaFin)) }}
            </p>
        @endif
    </div>

    @foreach ($data as $index => $registro)
        <div class="registro {{ $index === 0 ? 'first-registro' : '' }}">
            @if($index > 0)
                <div style="page-break-before: always;"></div> <!-- Salto controlado -->
            @endif
            <table>
                <tbody>
                    @foreach ($registro as $item)
                        <tr>
                            <td class="campo" style="width: 40%;">{{ $item['campo'] }}</td>
                            <td class="valor" style="width: 60%;">{{ $item['valor'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</body>
</html>
