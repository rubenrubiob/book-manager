<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject\Autor;

use Domain\Exception\ValueObject\Autor\BiografiaIsNotValid;
use Domain\ValueObject\Anyo;
use Domain\ValueObject\Autor\Biografia;
use PHPUnit\Framework\TestCase;

class BiografiaTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideForFromAnyoNacimientoYMuerte
     *
     * @param Anyo            $expectedAnyoNacimiento
     * @param Anyo            $expectedAnyoMuerte
     * @param string|int|null $anyoNacimiento
     * @param string|int|null $anyoMuerte
     */
    public function from_anyo_nacimiento_y_muerte(
        Anyo $expectedAnyoNacimiento,
        Anyo $expectedAnyoMuerte,
        $anyoNacimiento,
        $anyoMuerte
    ) : void {
        $biografia = Biografia::fromAnyoNacimientoYMuerte($anyoNacimiento, $anyoMuerte);

        $this->assertTrue(
            $expectedAnyoNacimiento->equalsTo(
                $biografia->anyoNacimiento()
            )
        );
        $this->assertTrue(
            $expectedAnyoMuerte->equalsTo(
                $biografia->anyoMuerte()
            )
        );
    }

    /**
     * @test
     * @dataProvider provideForFromAnyoNacimientoYMuerteVivo
     *
     * @param Anyo            $expectedAnyoNacimiento
     * @param string|int|null $anyoNacimiento
     * @param string|int|null $anyoMuerte
     */
    public function from_anyo_nacimiento_y_muerte_vivo(
        Anyo $expectedAnyoNacimiento,
        $anyoNacimiento,
        $anyoMuerte
    ) : void {
        $biografia = Biografia::fromAnyoNacimientoYMuerte($anyoNacimiento, $anyoMuerte);

        $this->assertTrue(
            $expectedAnyoNacimiento->equalsTo(
                $biografia->anyoNacimiento()
            )
        );

        $this->assertNull(
            $biografia->anyoMuerte()
        );
    }

    /**
     * @test
     * @dataProvider provideForFromAnyos
     *
     * @param Anyo $expectedAnyoNacimiento
     * @param Anyo $expectedAnyoMuerte
     * @param Anyo $anyoNacimiento
     * @param Anyo $anyoMuerte
     */
    public function from_anyos(
        Anyo $expectedAnyoNacimiento,
        Anyo $expectedAnyoMuerte,
        Anyo $anyoNacimiento,
        Anyo $anyoMuerte
    ) : void {
        $biografia = Biografia::fromAnyos($anyoNacimiento, $anyoMuerte);

        $this->assertTrue(
            $expectedAnyoNacimiento->equalsTo(
                $biografia->anyoNacimiento()
            )
        );
        $this->assertTrue(
            $expectedAnyoMuerte->equalsTo(
                $biografia->anyoMuerte()
            )
        );
    }

    /**
     * @test
     */
    public function from_anyos_vivo() : void
    {
        $anyoNacimiento = Anyo::fromValue(1940);

        $biografia = Biografia::fromAnyos($anyoNacimiento, null);

        $this->assertTrue(
            $anyoNacimiento->equalsTo(
                $biografia->anyoNacimiento()
            )
        );

        $this->assertNull(
            $biografia->anyoMuerte()
        );
    }

    /**
     * @test
     */
    public function from_anyo_nacimiento_y_muerte_con_fecha_muerte_anterior_a_fecha_nacimiento_throws_exception() : void
    {
        $this->expectException(BiografiaIsNotValid::class);

        Biografia::fromAnyoNacimientoYMuerte(
            1936,
            1900,
        );
    }

    /**
     * @test
     * @dataProvider providerForEqualsTo
     */
    public function equals_to(bool $expected, Biografia $primeraBiografia, Biografia $segundaBiografia) : void
    {
        $this->assertSame(
            $expected,
            $primeraBiografia->equalsTo(
                $segundaBiografia
            )
        );
    }

    /**
     * @return array[]
     */
    public function provideForFromAnyoNacimientoYMuerte(): array
    {
        return [
            'con año nacimiento y muerte d.C. (con string)' => [
                Anyo::fromValue(1898),
                Anyo::fromValue(1936),
                '1898',
                '1936',
            ],
            'con año nacimiento y muerte d.C. (con int)' => [
                Anyo::fromValue(1898),
                Anyo::fromValue(1936),
                1898,
                1936,
            ],
            'con año nacimiento y muerte a.C. (con string)' => [
                Anyo::fromValue(-385),
                Anyo::fromValue(-323),
                '-385',
                '-323',
            ],
            'con año nacimiento y muerte a.C. (con int)' => [
                Anyo::fromValue(-385),
                Anyo::fromValue(-323),
                -385,
                -323,
            ],
            'con año nacimiento a.C. y muerte d.C. (con string)' => [
                Anyo::fromValue(-4),
                Anyo::fromValue(65),
                '-4',
                '65',
            ],
            'con año nacimiento a.C. y muerte d.C. (con int)' => [
                Anyo::fromValue(-4),
                Anyo::fromValue(65),
                -4,
                65,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function provideForFromAnyos(): array
    {
        return [
            'con año nacimiento y muerte d.C.' => [
                Anyo::fromValue(1898),
                Anyo::fromValue(1936),
                Anyo::fromValue(1898),
                Anyo::fromValue(1936),
            ],
            'con año nacimiento y muerte a.C.' => [
                Anyo::fromValue(-385),
                Anyo::fromValue(-323),
                Anyo::fromValue(-385),
                Anyo::fromValue(-323),
            ],
            'con año nacimiento a.C. y muerte d.C.' => [
                Anyo::fromValue(-4),
                Anyo::fromValue(65),
                Anyo::fromValue(-4),
                Anyo::fromValue(65),
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function provideForFromAnyoNacimientoYMuerteVivo() : array
    {
        return [
            'vivo (con string)' => [
                Anyo::fromValue(1940),
                1940,
                '  ',
            ],
            'vivo (con null)' => [
                Anyo::fromValue(1940),
                1940,
                null,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function providerForEqualsTo(): array
    {
        return [
            'equals: nacimiento y muerte a.C.' => [
                true,
                Biografia::fromAnyos(
                    Anyo::fromValue(-385),
                    Anyo::fromValue(-323),
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(-385),
                    Anyo::fromValue(-323),
                ),
            ],
            'not equals: nacimiento y muerte a.C.' => [
                false,
                Biografia::fromAnyos(
                    Anyo::fromValue(-385),
                    Anyo::fromValue(-323),
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(-386),
                    Anyo::fromValue(-323),
                ),
            ],

            'equals: nacimiento a.C. y muerte d.C.' => [
                true,
                Biografia::fromAnyos(
                    Anyo::fromValue(-4),
                    Anyo::fromValue(65),
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(-4),
                    Anyo::fromValue(65),
                ),
            ],
            'not equals: nacimiento a.C. y muerte d.C.' => [
                false,
                Biografia::fromAnyos(
                    Anyo::fromValue(-4),
                    Anyo::fromValue(65),
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(-5),
                    Anyo::fromValue(65),
                ),
            ],

            'equals: nacimiento y muerte d.C.' => [
                true,
                Biografia::fromAnyos(
                    Anyo::fromValue(1898),
                    Anyo::fromValue(1936),
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(1898),
                    Anyo::fromValue(1936),
                ),
            ],
            'not equals: nacimiento y muerte d.C.' => [
                false,
                Biografia::fromAnyos(
                    Anyo::fromValue(1898),
                    Anyo::fromValue(1936),
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(1898),
                    Anyo::fromValue(1937),
                ),
            ],

            'equals: vivo' => [
                true,
                Biografia::fromAnyos(
                    Anyo::fromValue(1940),
                    null,
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(1940),
                    null,
                ),
            ],
            'not equals: vivo' => [
                false,
                Biografia::fromAnyos(
                    Anyo::fromValue(1940),
                    null,
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(1941),
                    null,
                ),
            ],
            'not equals: vivo y muerto' => [
                false,
                Biografia::fromAnyos(
                    Anyo::fromValue(1940),
                    null,
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(1940),
                    Anyo::fromValue(1999),
                ),
            ],
            'not equals: muerto y vivo' => [
                false,
                Biografia::fromAnyos(
                    Anyo::fromValue(1940),
                    Anyo::fromValue(1999),
                ),
                Biografia::fromAnyos(
                    Anyo::fromValue(1940),
                    null,
                ),
            ],
        ];
    }
}
