<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Idioma;

use Domain\Exception\ValueObject\Idioma\CodigoIdiomaIsNotValid;
use Domain\ValueObject\Idioma\CodigoIdioma;
use PHPUnit\Framework\TestCase;

class CodigoIdiomaTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideForFromCodigo
     */
    public function from_codigo(string $expected, string $codigo): void
    {
        $this->assertSame(
            $expected,
            CodigoIdioma::fromCodigo($codigo)->asString()
        );
    }

    /**
     * @test
     */
    public function from_codigo_with_codigo_vacio_throws_exception(): void
    {
        $this->expectException(CodigoIdiomaIsNotValid::class);

        CodigoIdioma::fromCodigo('  ');
    }

    /**
     * @test
     */
    public function from_codigo_with_codigo_corto_throws_exception(): void
    {
        $this->expectException(CodigoIdiomaIsNotValid::class);

        CodigoIdioma::fromCodigo('es');
    }

    /**
     * @test
     */
    public function from_codigo_with_codigo_largo_throws_exception(): void
    {
        $this->expectException(CodigoIdiomaIsNotValid::class);

        CodigoIdioma::fromCodigo('espa');
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(bool $expected, string $primerCodigo, string $segundoCodigo): void
    {
        $this->assertSame(
            $expected,
            CodigoIdioma::fromCodigo($primerCodigo)->equalsTo(
                CodigoIdioma::fromCodigo($segundoCodigo)
            )
        );
    }

    /**
     * @return string[][]
     */
    public function provideForFromCodigo(): array
    {
        return [
            'codigo sin espacios' => [
                'cat',
                'cat',
            ],
            'codigo con espacios' => [
                'cat',
                ' cat ',
            ],
            'codigo con espacios y mayúsculas' => [
                'cat',
                ' CAT ',
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function provideForEqualsTo(): array
    {
        return [
            'equals' => [
                true,
                'cat',
                'cat',
            ],
            'not equals' => [
                false,
                'eng',
                'cat',
            ],
        ];
    }
}
