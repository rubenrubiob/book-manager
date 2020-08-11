<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\ValueObject\IdIsNotValid;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class Id
{
    private string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function generate() : self
    {
        return new self(
            Uuid::uuid4()->toString()
        );
    }

    /**
     * @throws IdIsNotValid
     */
    public static function fromString(string $id) : self
    {
        self::validate($id);

        return new self($id);
    }

    public function asString() : string
    {
        return $this->id;
    }

    public function equalsTo(Id $anotherId) : bool
    {
        return $this->id === $anotherId->id;
    }

    /**
     * @throws IdIsNotValid
     */
    private static function validate(string $id) : void
    {
        try {
            Assert::uuid($id);
        } catch (InvalidArgumentException $e) {
            throw IdIsNotValid::withFormat($id);
        }
    }
}
