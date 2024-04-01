<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'administrador';
    case SECRETARIO = 'secretario';
    case LECTOR = 'lector';

    public function label(): string
    {
        return match($this) {
            static::ADMIN => 'Administrador',
            static::SECRETARIO => 'Secretario',
            static::LECTOR => 'Lector',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $role) => [
                $role->value => $role->label(),
            ])
            ->toArray();
    }
}
