<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Autor;

use Domain\Exception\ValueObject\Autor\ApelativoIsNotValid;
use Domain\Exception\ValueObject\NombreIsNotValid;
use Domain\ValueObject\Autor\Apelativo;
use Domain\ValueObject\Nombre;
use PHPUnit\Framework\TestCase;

use function str_repeat;

class ApelativoTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideForFromParts
     */
    public function from_parts(
        Nombre $expectedAlias,
        ?Nombre $expectedNombre,
        ?Nombre $expectedApellidos,
        string $alias,
        ?string $nombre,
        ?string $apellidos
    ): void {
        $apelativo = Apelativo::fromParts(
            $alias,
            $nombre,
            $apellidos
        );

        $this->assertAlias($apelativo, $expectedAlias);
        $this->assertNombre($apelativo, $expectedNombre);
        $this->assertApellidos($apelativo, $expectedApellidos);
    }

    /**
     * @test
     */
    public function from_parts_with_alias_as_string_vacio_throws_exception(): void
    {
        $this->expectException(ApelativoIsNotValid::class);

        Apelativo::fromParts(' ', 'Caterina', 'Albert');
    }

    /**
     * @test
     */
    public function from_parts_with_alias_as_null_throws_exception(): void
    {
        $this->expectException(ApelativoIsNotValid::class);

        Apelativo::fromParts(null, 'Caterina', 'Albert');
    }

    /**
     * @test
     */
    public function from_parts_with_alias_too_large_throws_nombre_is_not_valid_exception(): void
    {
        $this->expectException(NombreIsNotValid::class);

        Apelativo::fromParts(
            str_repeat('a', Nombre::MAX_LONGITUD + 1),
            'Caterina',
            'Albert'
        );
    }

    /**
     * @test
     */
    public function from_parts_with_nombre_too_large_throws_nombre_is_not_valid_exception(): void
    {
        $this->expectException(NombreIsNotValid::class);

        Apelativo::fromParts(
            'Víctor Català',
            str_repeat('a', Nombre::MAX_LONGITUD + 1),
            'Albert'
        );
    }

    /**
     * @test
     */
    public function from_parts_with_apellidos_too_large_throws_nombre_is_not_valid_exception(): void
    {
        $this->expectException(NombreIsNotValid::class);

        Apelativo::fromParts(
            'Víctor Català',
            'Caterina',
            str_repeat('a', Nombre::MAX_LONGITUD + 1),
        );
    }

    /**
     * @test
     * @dataProvider provideForFromComponents
     */
    public function from_components(
        Nombre $expectedAlias,
        ?Nombre $expectedNombre,
        ?Nombre $expectedApellidos,
        Nombre $alias,
        ?Nombre $nombre,
        ?Nombre $apellidos
    ): void {
        $apelativo = Apelativo::fromComponents(
            $alias,
            $nombre,
            $apellidos
        );

        $this->assertAlias($apelativo, $expectedAlias);
        $this->assertNombre($apelativo, $expectedNombre);
        $this->assertApellidos($apelativo, $expectedApellidos);
    }

    /**
     * @test
     */
    public function from_alias(): void
    {
        $alias     = Nombre::fromString('Aristóteles');
        $apelativo = Apelativo::fromAlias($alias->asString());

        $this->assertAlias($apelativo, $alias);
        $this->assertNombre($apelativo, null);
        $this->assertApellidos($apelativo, null);
    }

    /**
     * @test
     */
    public function from_alias_with_empty_alias_throws_exception(): void
    {
        $this->expectException(ApelativoIsNotValid::class);

        Apelativo::fromAlias('  ');
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(bool $expected, Apelativo $primerApelativo, Apelativo $segundoApelativo): void
    {
        $this->assertSame(
            $expected,
            $primerApelativo->equalsTo($segundoApelativo)
        );
    }

    /**
     * @return array[]
     */
    public function provideForFromParts(): array
    {
        return [
            'con alias, nombre y apellidos' => [
                Nombre::fromString('Victor Català'),
                Nombre::fromString('Caterina'),
                Nombre::fromString('Albert'),
                'Victor Català',
                'Caterina',
                'Albert',
            ],

            'con alias, nombre y sin apellidos (as string)' => [
                Nombre::fromString('Platón'),
                Nombre::fromString('Aristócles de Atenas'),
                null,
                'Platón',
                'Aristócles de Atenas',
                '  ',
            ],
            'con alias, nombre y sin apellidos (as null)' => [
                Nombre::fromString('Platón'),
                Nombre::fromString('Aristócles de Atenas'),
                null,
                'Platón',
                'Aristócles de Atenas',
                null,
            ],

            'con alias, sin nombre y con apellidos (as string)' => [
                Nombre::fromString('Lorca'),
                null,
                Nombre::fromString('García Lorca'),
                'Lorca',
                '  ',
                'García Lorca',
            ],
            'con alias, sin nombre y con apellidos (as null)' => [
                Nombre::fromString('Lorca'),
                null,
                Nombre::fromString('García Lorca'),
                'Lorca',
                null,
                'García Lorca',
            ],

            'con alias, sin nombre y sin apellidos (as string)' => [
                Nombre::fromString('Homero'),
                null,
                null,
                'Homero',
                '  ',
                '  ',
            ],
            'con alias, sin nombre y sin apellidos (as null)' => [
                Nombre::fromString('Homero'),
                null,
                null,
                'Homero',
                null,
                null,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function provideForFromComponents(): array
    {
        return [
            'con alias, con nombre y apellidos' => [
                Nombre::fromString('Victor Català'),
                Nombre::fromString('Caterina'),
                Nombre::fromString('Albert'),
                Nombre::fromString('Victor Català'),
                Nombre::fromString('Caterina'),
                Nombre::fromString('Albert'),
            ],
            'con alias, nombre y sin apellidos' => [
                Nombre::fromString('Platón'),
                Nombre::fromString('Aristócles de Atenas'),
                null,
                Nombre::fromString('Platón'),
                Nombre::fromString('Aristócles de Atenas'),
                null,
            ],
            'con alias, sin nombre y con apellidos' => [
                Nombre::fromString('Lorca'),
                null,
                Nombre::fromString('García Lorca'),
                Nombre::fromString('Lorca'),
                null,
                Nombre::fromString('García Lorca'),
            ],
            'con alias, sin nombre y sin apellidos (as string)' => [
                Nombre::fromString('Homero'),
                null,
                null,
                Nombre::fromString('Homero'),
                null,
                null,
            ],
        ];
    }

    public function provideForEqualsTo(): array
    {
        return [
            'equals: only alias' => [
                true,
                Apelativo::fromAlias('Aristóteles'),
                Apelativo::fromAlias('Aristóteles'),
            ],
            'equals: only alias y nombre' => [
                true,
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    null,
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    null,
                ),
            ],
            'equals: only alias y apellido' => [
                true,
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    'García Lorca',
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    'García Lorca',
                ),
            ],
            'equals: complete' => [
                true,
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    'García Lorca',
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    'García Lorca',
                ),
            ],
            'not equals: only alias' => [
                false,
                Apelativo::fromAlias('García Lorca'),
                Apelativo::fromAlias('Lorca'),
            ],
            'not equals: same alias, first with nombre, second without' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    null,
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    null,
                ),
            ],
            'not equals: same alias, first without nombre, second with' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    null,
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    null,
                ),
            ],
            'not equals: same alias, different nombre' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    'Fede',
                    null,
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    null,
                ),
            ],
            'not equals: same alias, different nombre, with apellido' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    'Fede',
                    'García Lorca',
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    'García Lorca',
                ),
            ],
            'not equals: same alias, first with apellido, second without' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    'García Lorca',
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    null,
                ),
            ],
            'not equals: same alias, first without apellido, second with' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    null,
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    'García Lorca',
                ),
            ],
            'not equals: same alias, different apellido' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    'García Lorca',
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    null,
                    'Lorca',
                ),
            ],
            'not equals: same alias, different apellido, with nombre' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    'García Lorca',
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    'Lorca',
                ),
            ],
            'not equals: same alias, different apellido, different nombre' => [
                false,
                Apelativo::fromParts(
                    'García Lorca',
                    'Fede',
                    'García Lorca',
                ),
                Apelativo::fromParts(
                    'García Lorca',
                    'Federico',
                    'Lorca',
                ),
            ],
        ];
    }

    private function assertAlias(Apelativo $apelativo, Nombre $expectedAlias): void
    {
        $this->assertTrue(
            $expectedAlias->equalsTo(
                $apelativo->alias()
            )
        );
    }

    private function assertNombre(Apelativo $apelativo, ?Nombre $expectedNombre): void
    {
        if ($expectedNombre === null) {
            $this->assertNull(
                $apelativo->nombre()
            );

            return;
        }

        $this->assertTrue(
            $expectedNombre->equalsTo(
                $apelativo->nombre()
            )
        );
    }

    private function assertApellidos(Apelativo $apelativo, ?Nombre $expectedApellidos): void
    {
        if ($expectedApellidos === null) {
            $this->assertNull(
                $apelativo->apellidos()
            );

            return;
        }

        $this->assertTrue(
            $expectedApellidos->equalsTo(
                $apelativo->apellidos()
            )
        );
    }
}
