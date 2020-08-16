<?php

declare(strict_types=1);

namespace Domain\ValueObject\Idioma;

use Domain\Exception\ValueObject\Idioma\CodigoIdiomaIsNotValid;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

use function mb_strtolower;
use function trim;

/**
 * @psalm-immutable
 */
final class CodigoIdioma
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

    public function equalsTo(CodigoIdioma $anotherCodigoIdioma): bool
    {
        return $this->codigo === $anotherCodigoIdioma->codigo;
    }

    /**
     * @throws CodigoIdiomaIsNotValid
     */
    private static function parseAndValidateCodigo(string $codigo): string
    {
        $parsedCodigo = strtolower(
            trim(
                $codigo
            )
        );

        try {
            Assert::regex($parsedCodigo, '/^[a-z]{3}$/');
        } catch (InvalidArgumentException $e) {
            throw CodigoIdiomaIsNotValid::withCodigo($codigo);
        }

        return $parsedCodigo;
    }
}
