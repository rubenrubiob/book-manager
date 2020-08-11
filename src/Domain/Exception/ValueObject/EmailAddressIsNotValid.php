<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject;

use Exception;
use function Safe\sprintf;

final class EmailAddressIsNotValid extends Exception
{
    public static function withFormat(string $emailAddress) : self
    {
        return new self(
            sprintf(
                '"%s" is not a valid email address',
                $emailAddress
            )
        );
    }
}
