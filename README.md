# SteamChat

Es un proyecto que busca mejorar el chat de steam, los principales cambios son: El usuario podra acceder a chat rooms de un juego determinado, podrá enviar, editar y borrar sus propios mensajes. Lo que buscamos es sobretodo mejorar la comunicación entre los jugadores.

## Construido con 🛠️

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework"  alt="License"></a>
</p>

<p align="center">
    <a href="https://getcomposer.org">
        <img src="https://getcomposer.org/img/logo-composer-transparent.png" width="200" alt="Composer">
    </a>
</p>

<p align="center">
    <a href="https://www.php.net/">
        <img src="https://www.php.net/images/logos/php-logo.svg" width="200" alt="Php">
    </a>
</p>

## Wiki 📖

A continuación se explicaran los pasos a seguir para poder utilizar nuestra aplicación.

### Pre - requisitos

-   Tener instalado PHP
-   Tener instalado Composer
-   Tener un proyecto vacio de laravel
-   Tener instalado POSTMAN

### Instalación

-   Haz un pull de nuestro repositorio.
-   Cuando tengas hecha la copia realiza un `composer install`.
-   Crea el archivo `.env` y dentro cambia los valores que necesites.
-   Cuando tengas todo lo anterior,ahora ejecuta el comando `php sertisan serve ` de esta forma le indicamos a laravel que se levante.

### Base de datos

-   Ejecuta el comando `php artisan migrate`, de esta forma crearas la base de datos y las tablas que vamos a utilizar.
-   Hemos creado unos seeder para usarlo ejecuta el comando `php artisan db:seed` esto creara registros en todas las tablas.

Usuario de prueba: `` admin@admin.com `` 
Contrasela: `` password ``

### Endpoints
A continuación te mostraremos una tabla con los endpoints de la aplicación y los datos que deben proporcionar para su correcto funcionamiento.

| Endpoint        | Método | Datos de entrada                          |
| --------------- | ------ | ----------------------------------------- |
| `/api/register` | POST   | {"name": "", "email": "", "password": ""} |
| `/api/login`    | POST   | {"email": "", "password": ""}             |

## Equipo

Este proyecto se ha realizado con:

<div align="center">
  <a href="https://github.com/AlinPetrisorCiobanu">
    <img src="https://avatars.githubusercontent.com/u/126453796?v=4" alt="Nombre del Colaborador" width="100" style="border-radius:50%" class="circle">
  </a>
  <br>
  <a href="https://github.com/AlinPetrisorCiobanu">Alin Petrisor Ciobanu</a>
</div>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

