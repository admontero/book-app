<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_USERS = 'ver usuarios';
    case CREATE_USERS = 'crear usuarios';
    case UPDATE_USERS = 'actualizar usuarios';
    case DELETE_USERS = 'eliminar usuarios';

    case VIEW_ROLES = 'ver roles';
    case CREATE_ROLES = 'crear roles';
    case UPDATE_ROLES = 'actualizar roles';
    case DELETE_ROLES = 'eliminar roles';

    case VIEW_PERMISSIONS = 'ver permisos';

    public function label(): string
    {
        return match($this) {
            static::VIEW_USERS => 'Ver usuarios',
            static::CREATE_USERS => 'Crear usuarios',
            static::UPDATE_USERS => 'Actualizar usuarios',
            static::DELETE_USERS => 'Eliminar usuarios',
            static::VIEW_ROLES => 'Ver roles',
            static::CREATE_ROLES => 'Crear roles',
            static::UPDATE_ROLES => 'Actualizar roles',
            static::DELETE_ROLES => 'Eliminar roles',
            static::VIEW_PERMISSIONS => 'Ver permisos',
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
