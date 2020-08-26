<?php

declare(strict_types=1);

namespace Domain\ValueObject\Libro;

use Domain\Exception\ValueObject\Libro\TituloIsNotValid;
use Domain\Exception\ValueObject\Libro\TituloIsVacio;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class Titulo
{
    public const MAX_LONGITUD = 255;

    private string $titulo;

    private function __construct(string $titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @throws TituloIsNotValid
     * @throws TituloIsVacio
     */
    public static function fromString(string $titulo): self
    {
        return new self(
            self::parseAndValidate($titulo)
        );
    }

    public function asString(): string
    {
        return $this->titulo;
    }

    public function equalsTo(Titulo $anotherTitulo): bool
    {
        return $this->titulo === $anotherTitulo->titulo;
    }

    /**
     * @throws TituloIsNotValid
     * @throws TituloIsVacio
     */
    private static function parseAndValidate(string $titulo): string
    {
        $titulo = trim($titulo);

        try {
            Assert::stringNotEmpty($titulo);
        } catch (InvalidArgumentException $e) {
            throw TituloIsVacio::crear();
        }

        try {
            Assert::maxLength($titulo, self::MAX_LONGITUD);
        } catch (InvalidArgumentException $e) {
            throw TituloIsNotValid::withTituloDemasiadoLargo($titulo);
        }

        return $titulo;
    }
}
