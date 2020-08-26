<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Libro;

use Domain\ValueObject\Libro\Titulo;
use Exception;

use function Safe\sprintf;

final class TituloIsNotValid extends Exception
{
    public static function withTituloDemasiadoLargo(string $nombre): self
    {
        return new self(
            sprintf(
                'El título "%s" es demasiado largo. El límite son "%s" carácteres',
                $nombre,
                Titulo::MAX_LONGITUD
            )
        );
    }
}
