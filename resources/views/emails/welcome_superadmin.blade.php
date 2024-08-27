<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido al sistema, {{ $superAdmin->nom_superadmin }} {{ $superAdmin->ape_superadmin }}</h1>
    <p>Tu usuario (cédula) es: {{ $superAdmin->documento_superadmin }}</p>
    <p>Tu contraseña es: {{ $password }}</p>
    <p>Gracias por unirte a nosotros.</p>
</body>
</html>
