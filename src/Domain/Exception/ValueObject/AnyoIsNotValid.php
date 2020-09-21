<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject;

use Exception;

use function gettype;
use function Safe\sprintf;

final class AnyoIsNotValid extends Exception
{
    public static function withAnyoCero(): self
    {
        return new self(
            'El año "0" no existe'
        );
    }

    public static function withFormat(string $anyo): self
    {
        return new self(
            sprintf(
                '"%s" no tiene un formato de año válido',
                $anyo
            )
        );
    }

    /**
     * @param mixed $type
     */
    public static function withType($type): self
    {
        return new self(
            sprintf(
                'El tipo "%s" no es válido',
                gettype($type)
            )
        );
    }
}
