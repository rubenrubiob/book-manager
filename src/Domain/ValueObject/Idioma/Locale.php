<?php

declare(strict_types=1);

namespace Domain\ValueObject\Idioma;

use Domain\Exception\ValueObject\Idioma\LocaleIsNotValid;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

use function strtolower;
use function trim;

/**
 * @psalm-immutable
 */
final class Locale
{
    private string $codigo;

    private function __construct(string $codigo)
    {
        $this->codigo = $codigo;
    }

    public static function fromCodigo(string $codigo): self
    {
        return new self(
            self::parseAndValidateCodigo($codigo)
        );
    }

    public function asString(): string
    {
        return $this->codigo;
    }

    public function equalsTo(Locale $anotherLocale): bool
    {
        return $this->codigo === $anotherLocale->codigo;
    }

    /**
     * @throws LocaleIsNotValid
     */
    private static function parseAndValidateCodigo(string $codigo): string
    {
        $parsedCodigo = strtolower(
            trim(
                $codigo
            )
        );

        try {
            Assert::regex($parsedCodigo, '/^[a-z]{2}$/');
        } catch (InvalidArgumentException $e) {
            throw LocaleIsNotValid::withCodigo($codigo);
        }

        return $parsedCodigo;
    }
}
