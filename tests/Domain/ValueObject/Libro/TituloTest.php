<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Libro;

use Domain\Exception\ValueObject\Libro\TituloIsNotValid;
use Domain\Exception\ValueObject\Libro\TituloIsVacio;
use Domain\ValueObject\Libro\Titulo;
use PHPUnit\Framework\TestCase;

use function str_repeat;

class TituloTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideForFromString
     */
    public function from_string(string $expectedTitulo, string $titulo): void
    {
        $this->assertSame(
            $expectedTitulo,
            Titulo::fromString($titulo)->asString()
        );
    }

    /**
     * @test
     */
    public function from_string_with_titulo_vacio_throws_exception(): void
    {
        $this->expectException(TituloIsVacio::class);

        Titulo::fromString('  ');
    }

    /**
     * @test
     */
    public function from_string_with_titulo_demasiado_largo_throws_exception(): void
    {
        $this->expectException(TituloIsNotValid::class);

        Titulo::fromString(
            str_repeat(
                'a',
                Titulo::MAX_LONGITUD + 1
            )
        );
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(bool $expected, string $primerTitulo, string $segundoTitulo): void
    {
        $this->assertSame(
            $expected,
            Titulo::fromString($primerTitulo)->equalsTo(
                Titulo::fromString($segundoTitulo)
            )
        );
    }

    /**
     * @return string[][]
     */
    public function provideForFromString(): array
    {
        return [
            'sin espacios' => [
                'República',
                'República',
            ],
            'con espacio al principio' => [
                'República',
                ' República',
            ],
            'con espacio al final' => [
                'República',
                'República ',
            ],
            'con espacio al principio y al final' => [
                'República',
                ' República ',
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function provideForEqualsTo(): array
    {
        return [
            'iguales' => [
                true,
                'República',
                'República',
            ],
            'iguales con espacio' => [
                true,
                'República ',
                '  República  ',
            ],
            'diferentes' => [
                false,
                'República',
                'Metafísica',
            ],
        ];
    }
}
