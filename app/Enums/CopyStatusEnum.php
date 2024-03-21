<?php

namespace App\Enums;

enum CopyStatusEnum: string
{
    case DISPONIBLE = 'disponible';

    case OCUPADA = 'ocupada';

    case RETIRADA = 'retirada';

    public function label(): string
    {
        return match($this) {
            static::DISPONIBLE => 'Disponible',
            static::OCUPADA => 'Ocupada',
            static::RETIRADA => 'Retirada',
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
