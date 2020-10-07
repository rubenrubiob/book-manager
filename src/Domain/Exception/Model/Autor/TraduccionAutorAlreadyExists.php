<?php

declare(strict_types=1);

namespace Domain\Exception\Model\Autor;

use Domain\ValueObject\Id;
use Domain\ValueObject\Idioma\Locale;
use Exception;

use function Safe\sprintf;

final class TraduccionAutorAlreadyExists extends Exception
{
    public static function withLocale(Id $id, Locale $locale): self
    {
        return new self(
            sprintf(
                'Ya existe la traducción en idioma "%s" para el autor con id "%s"',
                $locale->asString(),
                $id->asString(),
            )
        );
    }
}
