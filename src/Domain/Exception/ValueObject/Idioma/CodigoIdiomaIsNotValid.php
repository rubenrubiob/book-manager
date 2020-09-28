<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Idioma;

use Exception;

use function Safe\sprintf;

final class CodigoIdiomaIsNotValid extends Exception
{
    public static function withCodigo(string $codigo): self
    {
        return new self(
            sprintf(
                'El código de idioma debe tener 3 caracteres. Se ha recibido "%s"',
                $codigo
            )
        );
    }
}
