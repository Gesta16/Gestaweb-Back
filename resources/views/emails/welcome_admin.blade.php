<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido a GestaWeb</title>
</head>
<body>
    <h1>Bienvenido al sistema, {{ $Admin->nom_admin }} {{ $Admin->ape_admin }}</h1>
    <p>Tu usuario (cédula) es: {{ $Admin->documento_admin }}</p>
    <p>Tu contraseña es: {{ $password }}</p>
    <p>Gracias por unirte a nosotros.</p>
</body>
</html>
