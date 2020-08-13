<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\ValueObject\NombreIsVacio;
use Domain\Exception\ValueObject\NombreIsNotValid;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

use function trim;

/**
 * @psalm-immutable
 */
final class Nombre
{
    public const MAX_LONGITUD = 255;

    private string $nombre;

    private function __construct(string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @throws NombreIsNotValid
     * @throws NombreIsVacio
     */
    public static function fromString(string $nombre): self
    {
        return new self(
            self::parseAndValidate($nombre)
        );
    }

    public function asString(): string
    {
        return $this->nombre;
    }

    public function equalsTo(Nombre $anotherNombre): bool
    {
        return $this->nombre === $anotherNombre->nombre;
    }

    /**
     * @throws NombreIsNotValid
     * @throws NombreIsVacio
     */
    private static function parseAndValidate(string $nombre): string
    {
        $nombre = trim($nombre);

        try {
            Assert::stringNotEmpty($nombre);
        } catch (InvalidArgumentException $e) {
            throw NombreIsVacio::crear();
        }

        try {
            Assert::maxLength($nombre, self::MAX_LONGITUD);
        } catch (InvalidArgumentException $e) {
            throw NombreIsNotValid::withNombreDemasiadoLargo($nombre);
        }

        return $nombre;
    }
}
