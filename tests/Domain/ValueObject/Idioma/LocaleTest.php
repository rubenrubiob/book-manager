<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Idioma;

use Domain\Exception\ValueObject\Idioma\LocaleIsNotValid;
use Domain\ValueObject\Idioma\Locale;
use PHPUnit\Framework\TestCase;

class LocaleTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideForFromCodigo
     */
    public function from_codigo(string $expected, string $codigo): void
    {
        $this->assertSame(
            $expected,
            Locale::fromCodigo($codigo)->asString()
        );
    }

    /**
     * @test
     */
    public function from_codigo_with_codigo_vacio_throws_exception(): void
    {
        $this->expectException(LocaleIsNotValid::class);

        Locale::fromCodigo('  ');
    }

    /**
     * @test
     */
    public function from_codigo_with_codigo_corto_throws_exception(): void
    {
        $this->expectException(LocaleIsNotValid::class);

        Locale::fromCodigo('e');
    }

    /**
     * @test
     */
    public function from_codigo_with_codigo_largo_throws_exception(): void
    {
        $this->expectException(LocaleIsNotValid::class);

        Locale::fromCodigo('spa');
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(bool $expected, string $primerCodigo, string $segundoCodigo): void
    {
        $this->assertSame(
            $expected,
            Locale::fromCodigo($primerCodigo)->equalsTo(
                Locale::fromCodigo($segundoCodigo)
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
                'ca',
                'ca',
            ],
            'codigo con espacios' => [
                'ca',
                ' ca ',
            ],
            'codigo con espacios y mayúsculas' => [
                'ca',
                ' CA ',
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
                'ca',
                'ca',
            ],
            'not equals' => [
                false,
                'en',
                'ca',
            ],
        ];
    }
}
