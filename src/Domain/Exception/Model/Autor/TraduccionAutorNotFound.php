<?php

declare(strict_types=1);

namespace Domain\Exception\Model\Autor;

use Domain\ValueObject\Idioma\Locale;
use Exception;

use function Safe\sprintf;

final class TraduccionAutorNotFound extends Exception
{
    public static function withLocale(Locale $locale): self
    {
        return new self(
            sprintf(
                'No se ha encontrado la traducción en idioma "%s"',
                $locale->asString(),
            )
        );
    }
}
