<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Libro\Edicion;

use Domain\Exception\ValueObject\Libro\Edicion\FormatoIsNotValid;
use Domain\ValueObject\Libro\Edicion\Formato;
use PHPUnit\Framework\TestCase;

class FormatoTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideForFromCodigo
     */
    public function from_codigo(string $codigoAsString, string $expected): void
    {
        $codigo = Formato::fromCodigo($codigoAsString);

        $this->assertSame(
            $expected,
            $codigo->asString()
        );
    }

    /**
     * @test
     */
    public function from_codigo_with_invalid_codigo_throws_exception(): void
    {
        $this->expectException(FormatoIsNotValid::class);

        Formato::fromCodigo('not valid');
    }

    /**
     * @test
     */
    public function from_codigo_with_empty_codigo_throws_exception(): void
    {
        $this->expectException(FormatoIsNotValid::class);

        Formato::fromCodigo('  ');
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(bool $expected, string $firstCodigo, string $secondCodigo): void
    {
        $this->assertSame(
            $expected,
            Formato::fromCodigo($firstCodigo)->equalsTo(
                Formato::fromCodigo($secondCodigo)
            )
        );
    }

    public function provideForFromCodigo(): array
    {
        return [
            'manuscrito from constant' => [
                Formato::MANUSCRITO,
                Formato::MANUSCRITO,
            ],
            'manuscrito from string' => [
                '  MANUSCRITO ',
                Formato::MANUSCRITO,
            ],
            'incunable from constant' => [
                Formato::INCUNABLE,
                Formato::INCUNABLE,
            ],
            'incunable from string' => [
                '  INCUNABLE ',
                Formato::INCUNABLE,
            ],
            'tapa blanda from constant' => [
                Formato::TAPA_BLANDA,
                Formato::TAPA_BLANDA,
            ],
            'tapa blanda from string' => [
                '  TAPA_BLANDA ',
                Formato::TAPA_BLANDA,
            ],
            'tapa dura from constant' => [
                Formato::TAPA_DURA,
                Formato::TAPA_DURA,
            ],
            'tapa dura from string' => [
                '  TAPA_DURA ',
                Formato::TAPA_DURA,
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
                Formato::MANUSCRITO,
                Formato::MANUSCRITO,
            ],
            'not equals' => [
                false,
                Formato::MANUSCRITO,
                Formato::TAPA_BLANDA,
            ],
        ];
    }
}
