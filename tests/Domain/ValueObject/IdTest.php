<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Domain\Exception\ValueObject\IdIsNotValid;
use Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Rfc4122\Validator;

class IdTest extends TestCase
{
    /**
     * @test
     */
    public function generate(): void
    {
        $this->assertTrue(
            (new Validator())->validate(
                Id::generate()->asString()
            )
        );
    }

    /**
     * @test
     */
    public function from_string(): void
    {
        $idAsString = 'accbfed6-2a47-486e-b5e8-89e9616cb445';

        $id = Id::fromString($idAsString);

        $this->assertSame(
            $idAsString,
            $id->asString()
        );
    }

    /**
     * @test
     */
    public function from_string_with_invalid_id_throws_exception(): void
    {
        $this->expectException(IdIsNotValid::class);

        Id::fromString('this-is-not-a-valid-id');
    }

    /**
     * @test
     */
    public function from_string_with_empty_id_throws_exception(): void
    {
        $this->expectException(IdIsNotValid::class);

        Id::fromString('  ');
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(string $firstId, string $secondId, bool $expected): void
    {
        $this->assertSame(
            $expected,
            Id::fromString($firstId)->equalsTo(
                Id::fromString($secondId)
            )
        );
    }

    /**
     * @return array[]
     */
    public function provideForEqualsTo(): array
    {
        return [
            'equals' => [
                'c12327ef-9af5-4da6-b4a7-d9c434239100',
                'c12327ef-9af5-4da6-b4a7-d9c434239100',
                true,
            ],
            'not equals' => [
                'c12327ef-9af5-4da6-b4a7-d9c434239100',
                '44be2055-768b-4d79-9149-18b806cf7f94',
                false,
            ],
        ];
    }
}
