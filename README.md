# BookApp

BookApp es una plicación para la administración de inventario y préstamo de libros de una biblioteca. Incluye módulo de usuarios, roles, permisos, préstamos, multas, géneros, autores, libros, editoriales, ediciones y copias. Adicionalmente el sistema cuenta con dos entornos, uno para los lectores y el otro para los administradores/secretarios.

## Requerimientos
- PHP 8.1+
- MySQL 5.7+
- Memcached Extension

## Instalación

Clonar el repositorio

    git clone https://github.com/admontero/book-app.git

Cambiar a la carpeta del repositorio

    cd book-app

Instalar las dependencias de PHP usando composer

    composer install

Copia el archivo ejemplo de variables de entorno y haz las configuraciones requeridas en tu archivo .env

    cp .env.example .env

Genera una key para la aplicación

    php artisan key:generate

**NOTA:** Antes de ejecutar las migraciones asegurate de crear la base datos y que el nombre de esta coincida con el de la variable DB_DATABASE del archivo .env

Ejecuta las migraciones de la base de datos

    php artisan migrate

Ejecuta todos los seeders configurados para la aplicación

    php artisan db:seed

Instalar las dependencias de JavaScript usando npm

    npm install

Compila los paquetes en desarrollo

    npm run dev

Levanta el servidor de desarrollo

    php artisan serve

Ahora puedes acceder al servidor desde http://localhost:8000

**NOTA:** Esta aplicación hace uso de Redis para la gestión de colas y Memcached para la gestión de la caché, por lo que deberás también levantar el servidor para estas.

## Credenciales

Utiliza estas credenciales para ingresar al sistema como administrador:

**Email:** admin@test.com

**Contraseña:** password

## Dependencias

- [cviebrock/eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable) - Para la generación automática de slugs en modelos Eloquent.
- [laravel/jetstream](https://github.com/laravel/jetstream) - Provee de una estructura inicial para crear proyectos de laravel (autenticación, plantillas, etc).
- [livewire/livewire](https://github.com/livewire/livewire) - Un framework full-stack para la creación de interfaces dinámicas.
- [nnjeim/world](https://github.com/nnjeim/world) - Para proveer un listado de países, estados, ciudades, etc.
- [predis/predis](https://github.com/predis/predis) - Para interactuar con Redis.
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission) - Para la gestión de roles y permisos.
- [staudenmeir/eloquent-has-many-deep](https://github.com/staudenmeir/eloquent-has-many-deep) - Para la definición de relaciones Eloquent sin importar el nivel.

## Autor

[Andrés Montero](https://github.com/admontero)
