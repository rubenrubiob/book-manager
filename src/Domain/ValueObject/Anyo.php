<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\ValueObject\AnyoIsNotValid;
use InvalidArgumentException;
use Webmozart\Assert\Assert;
use function is_int;
use function is_string;
use function str_replace;

/**
 * @psalm-immutable
 */
final class Anyo
{
    private const ZERO = 0;

    private const THOUSAND_SEPARATOR = [',', '.'];

    private int $anyo;

    private function __construct(int $anyo)
    {
        $this->anyo = $anyo;
    }

    /**
     * @param mixed $value
     *
     * @return Anyo
     *
     * @throws AnyoIsNotValid
     */
    public static function fromValue($value) : self
    {
        if (is_int($value)) {
            return self::fromInt($value);
        }

        if (is_string($value)) {
            return self::fromString($value);
        }

        throw AnyoIsNotValid::withType($value);
    }

    public function asInt() : int
    {
        return $this->anyo;
    }

    public function equalsTo(Anyo $anotherAnyo) : bool
    {
        return $this->anyo === $anotherAnyo->anyo;
    }

    /**
     * @throws AnyoIsNotValid
     */
    private static function fromInt(int $value) : self
    {
        if ($value === self::ZERO) {
            throw AnyoIsNotValid::withAnyoCero();
        }

        return new self($value);
    }

    /**
     * @throws AnyoIsNotValid
     */
    private static function fromString(string $value) : self
    {
        $value = str_replace(self::THOUSAND_SEPARATOR, '', $value);

        try {
            Assert::integerish($value);
        } catch (InvalidArgumentException $e) {
            throw AnyoIsNotValid::withFormat($value);
        }

        return self::fromInt((int) $value);
    }
}
