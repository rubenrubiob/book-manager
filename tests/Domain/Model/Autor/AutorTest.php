<?php

declare(strict_types=1);

namespace Tests\Domain\Model\Autor;

use Domain\Exception\Model\Autor\TraduccionAutorAlreadyExists;
use Domain\Model\Autor\Autor;
use Domain\Model\Traduccion\Autor\TraduccionAutor;
use Domain\ValueObject\Autor\Apelativo;
use Domain\ValueObject\Autor\Biografia;
use Domain\ValueObject\Id;
use Domain\ValueObject\Idioma\Locale;
use PHPUnit\Framework\TestCase;
use Tests\Domain\Model\Autor\Factory\AutorFactory;

class AutorTest extends TestCase
{
    /**
     * @test
     */
    public function crear(): void
    {
        $id        = Id::fromString('20db13c8-c29b-4be0-8c04-788a525fd8da');
        $biografia = Biografia::fromAnyoNacimientoYMuerte(-384, -322);

        $traduccionId = Id::fromString('a300cc24-d463-4547-9509-f0125212c982');
        $locale       = Locale::es();
        $apelativo    = Apelativo::fromAlias('Aristóteles');

        $autor = Autor::crear(
            $id,
            $biografia,
            $traduccionId,
            $locale,
            $apelativo
        );

        $traduccion = $autor->traducciones()->ofLocale(Locale::es());

        $this->assertAutor($autor, $id, $biografia);
        $this->assertTraduccion($traduccion, $traduccionId, $locale, $apelativo);
    }

    /**
     * @test
     */
    public function crear_con_todas_traducciones(): void
    {
        $id        = Id::fromString('20db13c8-c29b-4be0-8c04-788a525fd8da');
        $biografia = Biografia::fromAnyoNacimientoYMuerte(-384, -322);

        $traduccionIdEs = Id::fromString('a300cc24-d463-4547-9509-f0125212c982');
        $localeEs       = Locale::es();
        $apelativoEs    = Apelativo::fromAlias('Aristóteles');

        $traduccionIdCa = Id::fromString('24d1d8e1-a3b5-4fc1-8c88-975f03dbd8f3');
        $localeCa       = Locale::ca();
        $apelativoCa    = Apelativo::fromAlias('Aristòtil');

        $traduccionIdEn = Id::fromString('a65e09f7-076d-4849-bfd1-249d439d2a25');
        $localeEn       = Locale::en();
        $apelativoEn    = Apelativo::fromAlias('Aristotle');

        $autor = Autor::crear(
            $id,
            $biografia,
            $traduccionIdEs,
            $localeEs,
            $apelativoEs
        );
        $autor->anadirTraduccion(
            $traduccionIdCa,
            $localeCa,
            $apelativoCa
        );
        $autor->anadirTraduccion(
            $traduccionIdEn,
            $localeEn,
            $apelativoEn
        );

        $traducciones = $autor->traducciones();

        $this->assertAutor($autor, $id, $biografia);
        $this->assertTraduccion(
            $traducciones->ofLocale(Locale::es()),
            $traduccionIdEs,
            $localeEs,
            $apelativoEs
        );
        $this->assertTraduccion(
            $traducciones->ofLocale(Locale::ca()),
            $traduccionIdCa,
            $localeCa,
            $apelativoCa
        );
        $this->assertTraduccion(
            $traducciones->ofLocale(Locale::en()),
            $traduccionIdEn,
            $localeEn,
            $apelativoEn
        );
    }

    /**
     * @test
     */
    public function anadir_traduccion_ya_existente_throws_exception(): void
    {
        $this->expectException(TraduccionAutorAlreadyExists::class);

        $autor = AutorFactory::basico();

        $autor->anadirTraduccion(
            Id::fromString('c96d28c7-4e92-475b-b2d3-712a9e02d802'),
            Locale::es(),
            Apelativo::fromAlias('Aristóteles')
        );
    }

    private function assertAutor(Autor $autor, Id $id, Biografia $biografia): void
    {
        $this->assertTrue(
            $id->equalsTo($autor->id())
        );
        $this->assertTrue(
            $biografia->equalsTo($autor->biografia())
        );
    }

    public function assertTraduccion(TraduccionAutor $traduccion, Id $traduccionId, Locale $locale, Apelativo $apelativo): void
    {
        $this->assertTrue(
            $traduccionId->equalsTo($traduccion->id())
        );
        $this->assertTrue(
            $locale->equalsTo($traduccion->locale())
        );
        $this->assertTrue(
            $apelativo->equalsTo($traduccion->apelativo())
        );
    }
}
