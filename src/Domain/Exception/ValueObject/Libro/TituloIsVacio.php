<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Libro;

use Exception;

final class TituloIsVacio extends Exception
{
    public static function crear(): self
    {
        return new self(
            'El título está vacío'
        );
    }
}
