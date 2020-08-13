<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Domain\Exception\ValueObject\NombreIsNotValid;
use Domain\ValueObject\Nombre;
use PHPUnit\Framework\TestCase;

use function str_repeat;

class NombreTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideForFromString
     */
    public function from_string(string $expectedNombre, string $nombre): void
    {
        $this->assertSame(
            $expectedNombre,
            Nombre::fromString($nombre)->asString()
        );
    }

    /**
     * @test
     */
    public function from_string_with_nombre_vacio_throws_exception(): void
    {
        $this->expectException(NombreIsNotValid::class);

        Nombre::fromString('  ');
    }

    /**
     * @test
     */
    public function from_string_with_nombre_demasiado_largo_throws_exception(): void
    {
        $this->expectException(NombreIsNotValid::class);

        Nombre::fromString(
            str_repeat(
                'a',
                Nombre::MAX_LONGITUD + 1
            )
        );
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(bool $expected, string $primerNombre, string $segundoNombre): void
    {
        $this->assertSame(
            $expected,
            Nombre::fromString($primerNombre)->equalsTo(
                Nombre::fromString($segundoNombre)
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
                'Platón',
                'Platón',
            ],
            'con espacio al principio' => [
                'Platón',
                ' Platón',
            ],
            'con espacio al final' => [
                'Platón',
                'Platón ',
            ],
            'con espacio al principio y al final' => [
                'Platón',
                ' Platón ',
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
                'Platón',
                'Platón',
            ],
            'iguales con espacio' => [
                true,
                'Platón ',
                '  Platón  ',
            ],
            'diferentes' => [
                false,
                'Platón',
                'Aristóteles',
            ],
        ];
    }
}
