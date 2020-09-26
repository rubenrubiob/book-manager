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
    public const CA = 'ca';
    public const ES = 'es';
    public const EN = 'en';

    public const LOCALE_MAP = [
        self::CA => self::CA,
        self::ES => self::ES,
        self::EN => self::EN,
    ];

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

    public static function ca(): self
    {
        return new self(self::CA);
    }

    public static function es(): self
    {
        return new self(self::ES);
    }

    public static function en(): self
    {
        return new self(self::EN);
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
            Assert::keyExists(self::LOCALE_MAP, $parsedCodigo);
        } catch (InvalidArgumentException $e) {
            throw LocaleIsNotValid::withCodigo($codigo);
        }

        return $parsedCodigo;
    }
}
