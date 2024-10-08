<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Migraciones Realizadas el 20 y 21 de Agosto 2024 by NarenFlopi.

Creé las migraciones para las siguientes tablas.

- regimen, 
- departamento,
- tipo de documento,
- poblacion diferencial,
- metodo fracaso,
- riesgo,
- tipo dm,
- biologico,
- hemoclasificacion,
- antibiograma,
- ips,
- municipio,
- superadmin,
- admin,
- operador,
- departamentoxips,
- usuario,
- operadorxusuario,
- control prenatal,
- primera consulta,
- vacunacion,
- laboratorio i trimestre,
- laboratorio ii trimestre

Con sus respectivas relaciones.

## Migraciones Faltantes Realizadas by DarwinR

Se crean las migraciones de las siguientes tablas:

- laboratorio iii trimestre,
- prueba no treponemica VDRL,
- prueba no treponemica RPR,
- ITS,
- numero de controles, 
- diagnostico nutricional consulta del mes,
- forma de medicion de edad gestacional,
- seguimiento consulta mensual, 
- numero de sesiones preparacion maternidad y paternidad,
- seguimientos complementarios,
- micronutrientes, 
- terminacion de la gestacion,
- finalizacion de la gestacion,
- laboratorios intraparto de la gestante,
- metodo anticonceptivo, 
- seguimiento gestante post evento obstetrico,
- mortalidad perinatal,
- datos del recien nacido, 
- prueba no treponemica recien nacido,
- tamizacion neonatal, 
- estudio hipotiroidismo congenito, 
- ruta PYMS.

Todas las tablas fueron creadas con sus respectivas relaciones.

## Implementación del laravel-passport "^10.0" y la creación del AuthController, modelo Usuario y rutas de login 26 Agosto 2024.

- Se agregó al archivo composer.json el "laravel/passport": "^10.0".
- Modelo Usuario con todos sus campos (Sin relaciones entre tablas).
- Ruta API para login dentro de prefijo (auth).
- Controlador API AuthController con datos de login solo (email_usuario por ahora).
- Ajuste al archivo auth.php (hace referencia a la tabla usuario y no a la por defecto users).
- Ajuste al archivo AuthServiceProvider (implementar el passport y el uso de rutas).

## 27/08/2024 Implementacion controlador SuperAdmin, semillas y modelos

Se crea el controlador del superadmin, los modelos implicados y se corrigen algunas migraciones. Se montan las semillas de departamento, municipio y roles. Se implementa y configura el envio de correos.

## Implementación de autenticación para SuperAdmin 28 Agosto 2024

Archivos modificados 

- AuthController (Autenticación del SuperAdmin y traer informacion relaciona con el user).
- SuperAdminController (Se le agregó validación de autenticación y verificación de rol del usuario).
- Creación del Controlador UsuarioController (Solo el metodo Store).

## Implementación de autenticación para Admin e Ips 28 Agosto 2024

Archivos modificados 

- AuthController (Autenticación de Admin).
- AdminController (Se le agregó la verificación de autenticación, la creación de Admin solo a SuperAdmin o la creación de admin a admin solo si es de la misma Ips).   Ajuste para que valide primero la ips si existe antes de pasar a la creación para que no tenga que pasar a la creación del admin.
- IpsController (Se le agregó la verificacion de autenticación, y solo la creación de Ips a SuperAdmin).