<?php

namespace App\Enums;

enum LoanStatusEnum: string
{
    case EN_CURSO = 'en curso';

    case CANCELADO = 'cancelado';

    case COMPLETADO = 'completado';

    public function label(): string
    {
        return match($this) {
            static::EN_CURSO => 'En curso',
            static::CANCELADO => 'Cancelado',
            static::COMPLETADO => 'Completado',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [
                $status->value => $status->label(),
            ])
            ->toArray();
    }
}
