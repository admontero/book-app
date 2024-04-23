<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VER_USUARIOS = 'ver usuarios';
    case CREAR_USUARIOS = 'crear usuarios';
    case EDITAR_USUARIOS = 'editar usuarios';
    case VER_ROLES = 'ver roles';
    case ASIGNAR_ROLES_A_USUARIOS = 'asignar roles a usuarios';
    case VER_PERMISOS = 'ver permisos';
    case ASIGNAR_PERMISOS_A_ROLES = 'asignar permisos a roles';
    case ASIGNAR_PERMISOS_A_USUARIOS = 'asignar permisos a usuarios';
    case VER_GENEROS = 'ver géneros';
    case CREAR_GENEROS = 'crear géneros';
    case EDITAR_GENEROS = 'editar géneros';
    case VER_AUTORES = 'ver autores';
    case CREAR_AUTORES = 'crear autores';
    case EDITAR_AUTORES = 'editar autores';
    case VER_LIBROS = 'ver libros';
    case CREAR_LIBROS = 'crear libros';
    case EDITAR_LIBROS = 'editar libros';
    case VER_EDITORIALES = 'ver editoriales';
    case CREAR_EDITORIALES = 'crear editoriales';
    case EDITAR_EDITORIALES = 'editar editoriales';
    case VER_EDICIONES = 'ver ediciones';
    case CREAR_EDICIONES = 'crear ediciones';
    case EDITAR_EDICIONES = 'editar ediciones';
    case VER_COPIAS = 'ver copias';
    case CREAR_COPIAS = 'crear copias';
    case EDITAR_COPIAS = 'editar copias';
    case VER_PRESTAMOS = 'ver prestamos';
    case CREAR_PRESTAMOS = 'crear prestamos';
    case EDITAR_PRESTAMOS = 'editar prestamos';
    case EDITAR_ESTADO_PRESTAMOS = 'editar estado de prestamos';

    public function label(): string
    {
        return match($this) {
            static::VER_USUARIOS => 'Ver usuarios',
            static::CREAR_USUARIOS => 'Crear usuarios',
            static::EDITAR_USUARIOS => 'Editar usuarios',
            static::VER_ROLES => 'Ver roles',
            static::ASIGNAR_ROLES_A_USUARIOS => 'Asignar roles a usuarios',
            static::VER_PERMISOS => 'Ver permisos',
            static::ASIGNAR_PERMISOS_A_ROLES => 'Asignar permisos a roles',
            static::ASIGNAR_PERMISOS_A_USUARIOS => 'Asignar permisos a usuarios',
            static::VER_GENEROS => 'Ver géneros',
            static::CREAR_GENEROS => 'Crear géneros',
            static::EDITAR_GENEROS => 'Editar géneros',
            static::VER_AUTORES => 'Ver autores',
            static::CREAR_AUTORES => 'Crear autores',
            static::EDITAR_AUTORES => 'Editar autores',
            static::VER_LIBROS => 'Ver libros',
            static::CREAR_LIBROS => 'Crear libros',
            static::EDITAR_LIBROS => 'Editar libros',
            static::VER_EDITORIALES => 'Ver editoriales',
            static::CREAR_EDITORIALES => 'Crear editoriales',
            static::EDITAR_EDITORIALES => 'Editar editoriales',
            static::VER_EDICIONES => 'Ver ediciones',
            static::CREAR_EDICIONES => 'Crear ediciones',
            static::EDITAR_EDICIONES => 'Editar ediciones',
            static::VER_COPIAS => 'Ver copias',
            static::CREAR_COPIAS => 'Crear copias',
            static::EDITAR_COPIAS => 'Editar copias',
            static::VER_PRESTAMOS => 'Ver prestamos',
            static::CREAR_PRESTAMOS => 'Crear prestamos',
            static::EDITAR_PRESTAMOS => 'Editar prestamos',
            static::EDITAR_ESTADO_PRESTAMOS => 'Editar estado de prestamos',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $permission) => [
                $permission->value => $permission->label(),
            ])
            ->toArray();
    }
}
