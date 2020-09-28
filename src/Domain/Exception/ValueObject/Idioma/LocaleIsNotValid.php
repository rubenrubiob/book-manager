<?php

declare(strict_types=1);

namespace Domain\Exception\ValueObject\Idioma;

use Domain\ValueObject\Idioma\Locale;
use Exception;

use function implode;
use function Safe\sprintf;

final class LocaleIsNotValid extends Exception
{
    public static function withCodigo(string $codigo): self
    {
        return new self(
            sprintf(
                'El locale no es válido. Se ha recibido "%s". Sólo son válidos los códigos "%s"',
                $codigo,
                implode(
                    ', ',
                    Locale::LOCALE_MAP
                )
            )
        );
    }
}
