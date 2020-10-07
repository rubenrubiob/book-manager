<?php

declare(strict_types=1);

namespace Domain\Exception\Collection\Model\Autor;

use Exception;

final class TraduccionAutorCollectionIsNotValid extends Exception
{
    public static function withInvalidElementType(): self
    {
        return new self(
            'Collection contains invalid element types'
        );
    }
}
