<?php

namespace App\Enums;

enum FineStatusEnum: string
{
    case PENDIENTE = 'pendiente';

    case PAGADA = 'pagada';

    case DESESTIMADA = 'desestimada';

    public function label(): string
    {
        return match($this) {
            static::PENDIENTE => 'Pendiente',
            static::PAGADA => 'Pagada',
            static::DESESTIMADA => 'Desestimada',
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
