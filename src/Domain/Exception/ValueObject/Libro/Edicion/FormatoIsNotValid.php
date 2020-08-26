<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Libro\Edicion;

use Exception;

use function Safe\sprintf;

final class FormatoIsNotValid extends Exception
{
    public static function withCodigo(string $codigo): self
    {
        return new self(
            sprintf(
                'El formato de edición "%s" no es válido',
                $codigo
            )
        );
    }
}
