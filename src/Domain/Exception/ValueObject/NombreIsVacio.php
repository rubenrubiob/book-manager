<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject;

use Exception;

final class NombreIsVacio extends Exception
{
    public static function crear(): self
    {
        return new self(
            'El nombre está vacío'
        );
    }
}
