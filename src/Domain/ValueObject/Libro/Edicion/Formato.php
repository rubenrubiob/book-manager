<?php

declare(strict_types=1);

namespace Domain\ValueObject\Libro\Edicion;

use Domain\Exception\ValueObject\Libro\Edicion\FormatoIsNotValid;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

use function strtolower;
use function trim;

/**
 * @psalm-immutable
 */
final class Formato
{
    public const MANUSCRITO  = 'manuscrito';
    public const INCUNABLE   = 'incunable';
    public const TAPA_BLANDA = 'tapa_blanda';
    public const TAPA_DURA   = 'tapa_dura';

    private const VALID_CODIGOS = [
        self::MANUSCRITO  => self::MANUSCRITO,
        self::INCUNABLE   => self::INCUNABLE,
        self::TAPA_BLANDA => self::TAPA_BLANDA,
        self::TAPA_DURA => self::TAPA_DURA,
    ];

    private string $codigo;

    private function __construct(string $codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @throws FormatoIsNotValid
     */
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

    public function equalsTo(Formato $anotherFormato): bool
    {
        return $this->codigo === $anotherFormato->codigo;
    }

    /**
     * @throws FormatoIsNotValid
     */
    private static function parseAndValidateCodigo(string $input): string
    {
        $codigo = strtolower(
            trim(
                $input
            )
        );

        try {
            Assert::keyExists(self::VALID_CODIGOS, $codigo);
        } catch (InvalidArgumentException $e) {
            throw FormatoIsNotValid::withCodigo($input);
        }

        return $codigo;
    }
}
