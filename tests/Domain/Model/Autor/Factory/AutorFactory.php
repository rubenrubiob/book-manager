<?php

declare(strict_types=1);

namespace Tests\Domain\Model\Autor\Factory;

use Domain\Model\Autor\Autor;
use Domain\ValueObject\Autor\Apelativo;
use Domain\ValueObject\Autor\Biografia;
use Domain\ValueObject\Id;
use Domain\ValueObject\Idioma\Locale;

final class AutorFactory
{
    public static function completo(): Autor
    {
        $autor = self::basico();

        $autor->anadirTraduccion(
            Id::fromString('33903e0c-5907-4041-be10-55bb38545881'),
            Locale::ca(),
            Apelativo::fromAlias('Aristòtil')
        );

        $autor->anadirTraduccion(
            Id::fromString('464f95c6-af2a-4fe1-a4f6-314dfba579f0'),
            Locale::en(),
            Apelativo::fromAlias('Aristotle')
        );

        return $autor;
    }

    public static function basico(): Autor
    {
        return Autor::crear(
            Id::fromString('20db13c8-c29b-4be0-8c04-788a525fd8da'),
            Biografia::fromAnyoNacimientoYMuerte(-384, -322),
            Id::fromString('a300cc24-d463-4547-9509-f0125212c982'),
            Locale::es(),
            Apelativo::fromAlias('Aristóteles')
        );
    }
}
