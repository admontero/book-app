<?php

namespace App\Enums;

enum PayUResponseStatusEnum: int
{
    case APROBADO = 4;

    case PENDIENTE = 5;

    case DECLINADO = 6;

    case EXPIRADO = 7;

    case ERROR_INTERNO = 104;
}
