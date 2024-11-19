<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido a GestaWeb</title>
</head>
<body>
    <h1>Bienvenido al sistema, {{ $usuario->nom_usuario }} {{ $usuario->ape_usuario }}</h1>
    <p>Tu usuario (cédula) es: {{ $usuario->documento_usuario }}</p>
    <p>Tu contraseña es: {{ $password }}</p>
    <p>Gracias por unirte a nosotros.</p>
</body>
</html>
