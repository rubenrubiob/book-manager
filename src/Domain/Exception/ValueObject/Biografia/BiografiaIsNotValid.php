<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Biografia;

use Domain\ValueObject\Anyo;
use Exception;

final class BiografiaIsNotValid extends Exception
{
    public static function withAnyoMuerteAnteriorAAnyoNacimiento(Anyo $nacimiento, Anyo $muerte): self
    {
        return new self(
            \Safe\sprintf(
                'El año de nacimiento (%s) debe ser anterior al año de muerte (%s)',
                $nacimiento->asInt(),
                $muerte->asInt()
            )
        );
    }
}
