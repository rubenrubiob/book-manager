<?php
declare(strict_types=1);

namespace Tests\Domain\Collection\Model\Autor;

use Domain\Collection\Model\Autor\TraduccionAutorCollection;
use Domain\Exception\Collection\Model\Autor\TraduccionAutorCollectionIsNotValid;
use Domain\Exception\Model\Autor\TraduccionAutorNotFound;
use Domain\ValueObject\Idioma\Locale;
use PHPUnit\Framework\TestCase;
use Tests\Domain\Model\Autor\Factory\AutorFactory;

class TraduccionAutorCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function from_elements_with_empty_collection(): void
    {
        $collection = TraduccionAutorCollection::fromElements([]);

        $this->assertCount(
            0,
            $collection
        );
    }

    /**
     * @test
     */
    public function from_elements_with_full_collection(): void
    {
        $collection = AutorFactory::completo()->traducciones();

        $this->assertCount(
            3,
            $collection
        );

        $this->assertTrue(
            Locale::es()->equalsTo(
                $collection->ofLocale(Locale::es())->locale()
            )
        );

        $this->assertTrue(
            Locale::ca()->equalsTo(
                $collection->ofLocale(Locale::ca())->locale()
            )
        );

        $this->assertTrue(
            Locale::en()->equalsTo(
                $collection->ofLocale(Locale::en())->locale()
            )
        );
    }

    /**
     * @test
     */
    public function of_locale_with_missing_locale_throws_exception(): void
    {
        $this->expectException(TraduccionAutorNotFound::class);

        AutorFactory::basico()
                    ->traducciones()
                    ->ofLocale(Locale::ca())
        ;
    }

    /**
     * @test
     */
    public function from_elements_with_invalid_type_throws_exception(): void
    {
        $this->expectException(TraduccionAutorCollectionIsNotValid::class);

        TraduccionAutorCollection::fromElements(
            [
                'string',
            ]
        );
    }
}
