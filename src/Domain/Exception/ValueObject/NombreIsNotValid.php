<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject;

use Domain\ValueObject\Nombre;
use Exception;

use function Safe\sprintf;

final class NombreIsNotValid extends Exception
{
    public static function withNombreDemasiadoLargo(string $nombre): self
    {
        return new self(
            sprintf(
                'El nombre "%s" es demasiado largo. El límite son "%s" carácteres',
                $nombre,
                Nombre::MAX_LONGITUD
            )
        );
    }
}
