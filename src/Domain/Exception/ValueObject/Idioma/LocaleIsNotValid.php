<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Idioma;

use Exception;

use function Safe\sprintf;

final class LocaleIsNotValid extends Exception
{
    public static function withCodigo(string $codigo): self
    {
        return new self(
            sprintf(
                'El locale debe tener 2 caracteres. Se ha recibido "%s"',
                $codigo
            )
        );
    }
}
