<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'administrador';
    case SECRETARY = 'secretario';
    case READER = 'lector';

    public function label(): string
    {
        return match($this) {
            static::ADMIN => 'Administrador',
            static::SECRETARY => 'Secretario',
            static::READER => 'Lector',
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
