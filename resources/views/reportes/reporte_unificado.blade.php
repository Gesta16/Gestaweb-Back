<!DOCTYPE html>
<html>

<head>
    <title>Reporte Unificado - Gestante {{ $id_usuario }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: #34495e;
            margin-top: 30px;
            margin-bottom: 10px;
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
    <h1>Reporte Unificado - Gestante {{ $id_usuario }}</h1>

    <!-- Sección de Control Prenatal -->
    <h2>Control Prenatal</h2>
    @include('partials.tabla_control_prenatal', ['datos' => $control_prenatal])

    <!-- Sección de Laboratorios - Primer Trimestre -->
    <h2>Laboratorios - Primer Trimestre</h2>
    @include('partials.tabla_laboratorios_primer_trimestre', ['datos' => $laboratorios_primer_trimestre])

    <!-- Sección de Laboratorios - Segundo Trimestre -->
    <h2>Laboratorios - Segundo Trimestre</h2>
    @include('partials.tabla_laboratorios_segundo_trimestre', ['datos' => $laboratorios_segundo_trimestre])

    <!-- Sección de Laboratorios - Tercer Trimestre -->
    <h2>Laboratorios - Tercer Trimestre</h2>
    @include('partials.tabla_laboratorios_tercer_trimestre', ['datos' => $laboratorios_tercer_trimestre])

    <!-- Sección de Laboratorios - ITS -->
    <h2>Laboratorios - ITS</h2>
    @include('partials.tabla_laboratorios_its', ['datos' => $laboratorios_its])

    <!-- Sección de Seguimiento Mensual -->
    <h2>Seguimiento Mensual</h2>
    @include('partials.tabla_seguimiento_mensual', ['datos' => $seguimiento_mensual])

    <!-- Sección de Seguimiento Complementario -->
    <h2>Seguimiento Complementario</h2>
    @include('partials.tabla_seguimiento_complementario', ['datos' => $seguimiento_complementario])

    <!-- Sección de Micronutrientes -->
    <h2>Micronutrientes</h2>
    @include('partials.tabla_micronutrientes', ['datos' => $micronutrientes])

    <!-- Sección de Laboratorios - Intraparto -->
    <h2>Laboratorios - Intraparto</h2>
    @include('partials.tabla_laboratorios_intraparto', ['datos' => $laboratorios_intraparto])

    <!-- Sección de Seguimiento Post Obstétrico -->
    <h2>Seguimiento Post Obstétrico</h2>
    @include('partials.tabla_seguimiento_post_obstetrico', ['datos' => $seguimiento_post_obstetrico])

    <!-- Sección de Finalización de la Gestación -->
    <h2>Finalización de la Gestación</h2>
    @include('partials.tabla_finalizacion_gestacion', ['datos' => $finalizacion_gestacion])

    <!-- Sección de Datos del Recién Nacido -->
    <h2>Datos del Recién Nacido</h2>
    @include('partials.tabla_datos_recien_nacido', ['datos' => $datos_recien_nacido])
</body>

</html>
