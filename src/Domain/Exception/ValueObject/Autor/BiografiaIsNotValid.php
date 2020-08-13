<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Autor;

use Domain\ValueObject\Anyo;
use Exception;

use function Safe\sprintf;

final class BiografiaIsNotValid extends Exception
{
    public static function withAnyoMuerteAnteriorAAnyoNacimiento(Anyo $nacimiento, Anyo $muerte): self
    {
        return new self(
            sprintf(
                'El año de nacimiento (%s) debe ser anterior al año de muerte (%s)',
                $nacimiento->asInt(),
                $muerte->asInt()
            )
        );
    }
}
