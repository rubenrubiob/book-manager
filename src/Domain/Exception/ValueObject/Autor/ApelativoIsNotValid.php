<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Autor;

use Exception;

final class ApelativoIsNotValid extends Exception
{
    public static function withAliasVacio(): self
    {
        return new self(
            'El alias está vacío'
        );
    }
}
