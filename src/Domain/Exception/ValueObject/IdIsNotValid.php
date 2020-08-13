<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject;

use Exception;

use function Safe\sprintf;

final class IdIsNotValid extends Exception
{
    public static function withFormat(string $id): self
    {
        return new self(
            sprintf(
                'Id "%s" does not have a valid format',
                $id
            )
        );
    }
}
