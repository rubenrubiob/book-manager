<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Domain\Exception\ValueObject\AnyoIsNotValid;
use Domain\ValueObject\Anyo;
use PHPUnit\Framework\TestCase;

class AnyoTest extends TestCase
{
    /**
     * @param int|string $value
     *
     * @test
     * @dataProvider provideForFromValue
     */
    public function from_value($value, int $expectedAsInt) : void
    {
        $anyo = Anyo::fromValue($value);

        $this->assertSame(
            $anyo->asInt(),
            $expectedAsInt
        );
    }

    /**
     * @test
     */
    public function from_value_with_cero_as_int() : void
    {
        $this->expectException(AnyoIsNotValid::class);
        $this->expectExceptionMessage('El año "0" no existe');

        Anyo::fromValue(0);
    }

    /**
     * @test
     */
    public function from_value_with_cero_as_string() : void
    {
        $this->expectException(AnyoIsNotValid::class);
        $this->expectExceptionMessage('El año "0" no existe');

        Anyo::fromValue('0');
    }

    /**
     * @test
     */
    public function from_value_with_invalid_string_format() : void
    {
        $this->expectException(AnyoIsNotValid::class);
        $this->expectExceptionMessage('"this is not valid" no tiene un formato de año válido');

        Anyo::fromValue('this is not valid');
    }

    /**
     * @test
     */
    public function from_value_with_invalid_data_type() : void
    {
        $this->expectException(AnyoIsNotValid::class);
        $this->expectExceptionMessage('El tipo "array" no es válido');

        Anyo::fromValue([]);
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(int $firstAnyo, int $secondAnyo, bool $expected) : void
    {
        $this->assertSame(
            $expected,
            Anyo::fromValue($firstAnyo)->equalsTo(
                Anyo::fromValue($secondAnyo)
            )
        );
    }

    /**
     * @return array[]
     */
    public function provideForFromValue() : array
    {
        return [
            'int positive' => [
                1900,
                1900,
            ],
            'int negative' => [
                -1900,
                -1900,
            ],
            'string positive' => [
                '1900',
                1900,
            ],
            'string negative' => [
                '-1900',
                -1900,
            ],
            'string with dot as separator positive' => [
                '1.900',
                1900,
            ],
            'string with dot as separator negative' => [
                '-1.900',
                -1900,
            ],
            'string with comma as separator positive' => [
                '1,900',
                1900,
            ],
            'string with comma as separator negative' => [
                '-1,900',
                -1900,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function provideForEqualsTo() : array
    {
        return [
            'equal anyo' => [
                1900,
                1900,
                true,
            ],
            'different anyo' => [
                1900,
                -1900,
                false,
            ],
        ];
    }
}
