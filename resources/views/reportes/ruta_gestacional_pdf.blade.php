<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Ruta Gestacional</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .no-data {
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>
    <h1>Reporte de Ruta Gestacional</h1>
    <h2>{{ $data['nombre'] ?? 'Nombre no disponible' }}</h2>

    @switch($data['tipo_reporte'] ?? '')
        @case('Control Prenatal')
            @include('partials.tabla_control_prenatal', ['datos' => $data['datos'] ?? []])
        @break

        @case('Laboratorios - Primer Trimestre')
            @include('partials.tabla_laboratorios_primer_trimestre', ['datos' => $data['datos'] ?? []])
        @break

        @case('Laboratorios - Segundo Trimestre')
            @include('partials.tabla_laboratorios_segundo_trimestre', ['datos' => $data['datos'] ?? []])
        @break

        @case('Laboratorios - Tercer Trimestre')
            @include('partials.tabla_laboratorios_tercer_trimestre', ['datos' => $data['datos'] ?? []])
        @break

        @case('Laboratorios - Its')
            @include('partials.tabla_laboratorios_its', ['datos' => $data['datos'] ?? []])
        @break

        @case('Laboratorios - Intraparto')
            @include('partials.tabla_laboratorios_intraparto', ['datos' => $data['datos'] ?? []])
        @break

        @case('Seguimiento Mensual')
            @include('partials.tabla_seguimiento_mensual', ['datos' => $data['datos'] ?? []])
        @break

        @case('Seguimiento Complementario')
            @include('partials.tabla_seguimiento_complementario', ['datos' => $data['datos'] ?? []])
        @break

        @case('Micronutrientes')
            @include('partials.tabla_micronutrientes', ['datos' => $data['datos'] ?? []])
        @break

        @case('Seguimiento Post Obstetrico')
            @include('partials.tabla_seguimiento_post_obstetrico', ['datos' => $data['datos'] ?? []])
        @break

        @case('Finalización de la Gestación')
            @include('partials.tabla_finalizacion_gestacion', ['datos' => $data['datos'] ?? []])
        @break

        @case('Datos del Recién Nacido')
            @include('partials.tabla_datos_recien_nacido', ['datos' => $data['datos'] ?? []])
        @break

        @default
            <p>No se encontró un template para el reporte seleccionado.</p>
    @endswitch
</body>

</html>
