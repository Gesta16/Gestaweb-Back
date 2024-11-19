<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido a GestaWeb</title>
</head>
<body>
    <h1>Bienvenido al sistema, {{ $operador->nom_operador }} {{ $operador->ape_operador }}</h1>
    <p>Tu usuario (cédula) es: {{ $operador->documento_operador }}</p>
    <p>Tu contraseña es: {{ $password }}</p>
    <p>Gracias por unirte a nosotros.</p>
</body>
</html>
